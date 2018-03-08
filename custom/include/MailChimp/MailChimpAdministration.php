<?php

class MailChimpAdministration {

    /**
     * $settings config table settings 
     * @var array
     */
    private $settings = array();

    /**
     * $action assign API action name for each request and unset from $args array
     * @var null
     */
    private $action = null;

    /**
     * $exclude_fields exclude fields from available in modules dropdowns by name
     * @var array
     */
    private $exclude_field_names = array('email1', 'team_id', 'date_entered', 'date_modified', 'deleted', 'opportunity_role', 'opportunity_role_id', 'my_favorite', 'following', 'subscriber_hash', 'last_sync_date');

    /**
     * $exclude_field_types exclude fields from available in modules dropdowns by type
     * @var array
     */
    private $exclude_field_types = array('id', 'fullname', 'image', 'assigned_user_name', 'relate', 'link');

    /**
     * __construct MailChimpAdministration constructor
     */
    public function __construct() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $admin = new Administration();
        $admin->retrieveSettings();
        $this->settings = $admin->settings;
    }

    /**
     * mailChimpAdministration 
     * @param  array  $args
     * @return mixed
     */
    public function mailChimpAdministration($args = array()) {
        if(isset($args['action'])){
            $this->action = $args['action'];
            unset($args['action']);
        }
        if(!empty($this->action)) {
            switch($this->action) {
                case 'get-api-key':
                    return $this->_getMailChimpAPIKey();
                break;
                case 'save-api-key':
                    return $this->_saveMailChimpAPIKey($args);
                break;
                case 'test-connection':
                    return $this->_testMailChimpConnection($args);
                break;
                case 'get-fields-mapping':
                    return $this->_getFieldsMapping($args);
                break;
                case 'save-fields-mapping':
                    return $this->_saveFieldsMapping($args);
                break;
                case 'get-modules-mapping':
                    return $this->_getModulesMapping($args);
                break;
                case 'save-modules-mapping':
                    return $this->_saveModulesMapping($args);
                break;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    /**
     * _getMailChimpAPIKey Get MailChimp API Key from config table
     * @return bool
     */
    private function _getMailChimpAPIKey() {
        $mailchimp_api_key = !empty($this->settings['mailchimp_api_key']) ? $this->settings['mailchimp_api_key']: '';
        $connected = false;
        if(!empty($mailchimp_api_key)) {
            require_once('custom/include/MailChimp/MailChimp.php');
            $mailchimp = new MailChimp();
            $ping = $mailchimp->call('get', 'ping');
            if(!empty($ping['health_status']) && $ping['health_status'] == "Everything's Chimpy!") {
                $connected = true;
            }
        }
        return array('mailchimp_key' => $mailchimp_api_key, 'connected' => $connected);
    }

    /**
     * _saveMailChimpAPIKey Save MailChimp API Key in config table only if API key is valid
     * @param  array $data POST data sent in API call
     * @return bool
     */
    private function _saveMailChimpAPIKey($data = array()) {
        $admin = new Administration();
        $admin->retrieveSettings();
        if(!empty($data['mc_api_key'])) {
            require_once('custom/include/MailChimp/MailChimp.php');
            $mailchimp = new MailChimp($data['mc_api_key']);
            $ping = $mailchimp->call('get', 'ping');
            if(!empty($ping['health_status']) && $ping['health_status'] == "Everything's Chimpy!") {
                $admin->saveSetting("mailchimp", 'api_key', $data['mc_api_key']);
                return true;
            }
        }
        return false;
    }

    /**
     * _testMailChimpConnection Validate MailChimp API Key
     * @param  array $data POST data sent in API call
     * @return bool
     */
    private function _testMailChimpConnection($data = array()) {
        if(!empty($data['mc_api_key'])) {
            require_once('custom/include/MailChimp/MailChimp.php');
            $mailchimp = new MailChimp($data['mc_api_key']);
            $ping = $mailchimp->call('get', 'ping');
            if(!empty($ping['health_status']) && $ping['health_status'] == "Everything's Chimpy!") {
                return true;
            }
        }
        return false;
    }

    /**
     * _getFieldsMapping Get MailChimp Fields Mapping
     * @param  array $data POST data sent in API call
     * @return array
     */
    private function _getFieldsMapping($data = array()) {
        $contact = BeanFactory::getBean('Contacts');
        $contacts = $this->_clean($contact->field_defs);

        $lead = BeanFactory::getBean('Leads');
        $leads = $this->_clean($lead->field_defs);

        $prospect = BeanFactory::getBean('Prospects');
        $prospects = $this->_clean($prospect->field_defs);

        $mailchimp = array();
        $old = array('sync_mailchimp_list' => '', 'sync_module' => '', 'contacts' => array(), 'leads' => array(), 'prospects' => array());
        
        if(!empty($data['mailchimp_list_id'])) {
            $mailchimp_list_id = $data['mailchimp_list_id'];
            require_once('custom/include/MailChimp/MailChimpConnector.php');
            $mailchimp_connector = new MailChimpConnector;
            $list_fields = $mailchimp_connector->getListFields($mailchimp_list_id);
            if(!empty($this->settings['mailchimp_'.$mailchimp_list_id])) {
                $old = json_decode($this->settings['mailchimp_'.$mailchimp_list_id]);
            }
            if(!empty($list_fields) && is_array($list_fields) && count($list_fields) > 0) {
                foreach($list_fields as $field) {
                    if($field['type'] == 'address') {
                        $mailchimp[] = array($field['tag']. '.addr1' => $field['name'].'.addr1');
                        $mailchimp[] = array($field['tag']. '.addr2' => $field['name'].'.addr2');
                        $mailchimp[] = array($field['tag']. '.city' => $field['name'].'.city');
                        $mailchimp[] = array($field['tag']. '.state' => $field['name'].'.state');
                        $mailchimp[] = array($field['tag']. '.zip' => $field['name'].'.zip');
                        $mailchimp[] = array($field['tag']. '.country' => $field['name'].'.country');
                    } else {
                        $mailchimp[] = array($field['tag'] => $field['name']);
                    }
                }
            }
        }
        return array('mailchimp' => $mailchimp, 'contacts' => $contacts, 'leads' => $leads, 'prospects' => $prospects, 'old' => $old);
    }

    /**
     * _saveFieldsMapping Save MailChimp Fields Mapping
     * @param  array $data POST data sent in API call
     * @return bool
     */
    private function _saveFieldsMapping($data = array()) {
        if(!empty($data['sync_mailchimp_list'])) {
            if(isset($data['sync_mailchimp_list'])) {
                $list_id = $data['sync_mailchimp_list'];
                unset($data['sync_mailchimp_list']);
            }
            $admin = new Administration();
            $admin->retrieveSettings();
            $admin->saveSetting("mailchimp", $list_id, json_encode($data));
            return true;
        }
        return false;
    }

    /**
     * _getModulesMapping Get Module Mapping Information
     * @param  array $data POST data sent in API call
     * @return array
     */
    private function _getModulesMapping($data = array()) {
        global $app_list_strings;
        $old = array('user_id' => '', 'Leads' => '', 'Contacts' => array());
        $account_types = array('' => 'Please select');
        $admins = array('' => 'Please select');
        $lists = array('' => 'Please select');

        $sq_admins = new SugarQuery;
        $sq_admins->from(BeanFactory::getBean('Users'));
        $sq_admins->select(array('id', 'first_name', 'last_name'));
        $sq_admins->where()->equals('is_admin', 1);
        $sq_admins->where()->equals('status', 'Active');
        $sq_admins->orderBy('id', 'asc');
        $admins_result = $sq_admins->execute();
        if(!empty($admins_result) && is_array($admins_result) && count($admins_result) > 0) {
            foreach($admins_result as $admin) {
                $admins["'".$admin['id']."'"] = $admin['first_name'] . ' ' . $admin['last_name'];
            }
        }

        $sq_lists = new SugarQuery;
        $sq_lists->from(BeanFactory::getBean('ProspectLists'));
        $sq_lists->select(array('id', 'name'));
        $sq_lists->orderBy('date_entered', 'asc');
        $lists_result = $sq_lists->execute();
        if(!empty($lists_result) && is_array($lists_result) && count($lists_result) > 0) {
            foreach($lists_result as $list) {
                $lists[$list['id']] = $list['name'];
            }
        }

        $account_type_dom = $app_list_strings['account_type_dom'];
        if(!empty($account_type_dom) && is_array($account_type_dom) && count($account_type_dom) > 0) {
            foreach($account_type_dom as $key => $type) {
                if(!empty($key) && !empty($type)) {
                    $account_types[$key] = $type;
                }
            }
        }

        if(!empty($this->settings['mailchimp_user_id'])) {
            $old['user_id'] = $this->settings['mailchimp_user_id'];
        }
        
        if(!empty($this->settings['mailchimp_Leads'])) {
            $old['Leads'] = $this->settings['mailchimp_Leads'];
        }
        
        if(!empty($this->settings['mailchimp_Contacts'])) {
            $old['Contacts'] = json_decode(base64_decode($this->settings['mailchimp_Contacts']));
        }

        return array('admins' => $admins, 'lists' => $lists, 'account_types' => $account_types, 'old' => $old);
    }

    /**
     * _saveModulesMapping Save Modules Mappings Information
     * @param  array $data POST data sent in API call
     * @return bool
     */
    private function _saveModulesMapping($data = array()) {
        $admin = new Administration();
        $admin->retrieveSettings();
        $return = false;

        if(!empty($data['user_id'])) {
            $admin->saveSetting("mailchimp", 'user_id', $data['user_id']);
            $return = true;
        }
        
        if(!empty($data['Leads'])) {
            $admin->saveSetting("mailchimp", 'Leads', $data['Leads']);
            $return = true;
        }

        if(!empty($data['Contacts'])) {
            $contacts = array();
            foreach($data['Contacts'] as $key => $value) {
                if(!empty($key) && !empty($value)) {
                    $contacts[$key] = $value;
                }
            }
            $admin->saveSetting("mailchimp", 'Contacts', base64_encode(json_encode($contacts)));
            $return = true;
        }
        return $return;
    }

    /**
     * _clean will clean (removed undesired) fields before saving in database
     * @param  array $data data to be cleaned
     * @return array
     */
    private function _clean($data = array()) {
        $filtered_data = array('' => 'Do Not Sync');
        if(!empty($data) && is_array($data) && count($data) > 0) {
            foreach($data as $key => $row){
                if(!in_array($row['type'], $this->exclude_field_types) && !in_array($row['name'], $this->exclude_field_names)) {
                    $filtered_data[$key] = translate($row['vname'], 'Contacts') . ' ('.$row['name'].')';;
                }
            }
        }
        return $filtered_data;
    }

}