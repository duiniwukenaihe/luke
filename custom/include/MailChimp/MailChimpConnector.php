<?php

require_once 'custom/include/MailChimp/MailChimpLogger.php';
require_once 'custom/include/MailChimp/sync/Lists.php';
require_once 'custom/include/MailChimp/sync/Campaigns.php';

class MailChimpConnector {

    /**
     * $settings settings from config table
     * @var array
     */
    private $settings = array();

    /**
     * @var string
     */
    public $level = 'debug';

    /**
     * @var object MailChimpLogger
     */
    public $print;

    /**
     * @var object Lists
     */
    private $list;

    /**
     * @var object Campaigns
     */
    private $campaign;

    /**
     * @var bool
     */
    private $callback = false;

    /**
     * @var array
     */
    private $targetModules = array('Contacts', 'Leads', 'Prospects');

    /**
     * $address_field_sub_field_names names of sub fields in mailchimp for address type field
     * @var array
     */
    private $_address_field_sub_field_names = array('addr1', 'addr2', 'city', 'state', 'zip', 'country');

    /**
     * @var associative array
     */
    private $default = array(
        'field_mapping' => array(
            'subscriber_hash' => 'id',
            'last_sync_date' => '',
            'email1' => 'email_address'
        ),
        'merge_keys' => array(
            'stats' => array(
                'name',
                'list_rating',
                'member_rating',
                'status'
            ),
        ),
        'merge_fields' => array(
            "tag",
            "name",
            "type"
        ),
        'list_fields' => array(
            "name",
            "stats",
            "list_rating"
        ),
        'member_fields' => array(
            "id",
            "email_address",
            "status",
            "merge_fields",
        ),
        'campaign_fields' => array(
            "id",
            "recipients.recipient_count",
            "settings.title",
        ),
        'webhook' => array(
            'rest_url' => 'rest/v10/mailchimp',
            'events' => array(
                "subscribe" => true,
                "unsubscribe" => true,
                "profile" => true,
                "cleaned" => false,
                "upemail" => true,
                "campaign" => true
            ),
            'sources' => array(
                "user" => true,
                "admin" => true,
                "api" => false
            ),
        ),
    );

    /**
     * MailChimpConnector constructor.
     * @param array $params
     */
    public function __construct($params = array()) {
        $this->list = new Lists();
        $this->campaign = new Campaigns();
        $this->print = new MailChimpLogger();
        $admin = new Administration();
        $admin->retrieveSettings('mailchimp', true);
        $this->settings = $admin->settings;
        if(!empty($params)) {
            foreach ($params as $param => $value) {
                $this->$param = $value;
            }
        }
    }

    /**
     * syncLists sync lists
     * Main function that syncs mailchimp and sugarcrm lists and subscribers.
     */
    public function syncLists() {
        $module = 'ProspectLists';
        $targetLists = $this->getTargetLists();
        foreach($targetLists as $targetList) {
            $list_id = $targetList['mailchimp_list'];
            $targetListId = $targetList['id'];
            $date_modified = $targetList['date_modified'];
            $last_sync_date = $targetList['last_sync_date'];
            //Sync New list from Sugar to MailChimp
            if(!empty($list_id)) {
                //Do fetch mailchimp details in crm for initial sync
                if(empty($last_sync_date) || strtotime($date_modified) > strtotime($last_sync_date)) {
                    //Check if callback webhook is present in mailchimp otherwise create one
                    $this->checkWebhookAvailability($list_id);
                    //Sync New subscriber from Mailchimp to Sugar
                    $this->syncMailChimpSubscribers($list_id);

                    $this->update('', array('id' => $targetListId, 'module' => $module));
                }
                //Sync New subscriber from Sugar to MailChimp
                $subscribers = $this->getTargetListSubscribers($targetListId);
                if(!empty($subscribers)) {
                    $listConfig = !is_array($this->settings['mailchimp_'.$list_id]) ? json_decode($this->settings['mailchimp_'.$list_id]) : (object) $this->settings['mailchimp_'.$list_id];
                    if(!empty($listConfig)) {
                        foreach($subscribers as $subscriber) {
                            $table_name = $subscriber->table_name;
                            $field_mapping = $listConfig->$table_name;
                            if(!empty($field_mapping)) {
                                $data = array();
                                $subscriber_hash = $subscriber->subscriber_hash;
                                $mergeFields = $this->prepareMergeFields($field_mapping, $subscriber);
                                if(empty($subscriber_hash) || empty($subscriber->last_sync_date)) {
                                    //Create new member from sugar to mailchimp
                                    $data = $this->parseResponse($this->list->createMember($list_id, $subscriber->email1, $mergeFields));
                                } else {
                                    //Check if subscriber is not in the list
                                    $response = $this->list->members($list_id, $subscriber_hash, array('id'));
                                    if(empty($response['id'])) {
                                        //Handle same subscriber to be added in multiple lists
                                        //Create new member from sugar to mailchimp
                                        $data = $this->parseResponse($this->list->createMember($list_id, $subscriber->email1, $mergeFields));
                                    } else {
                                        //Update existing member from sugar to mailchimp
                                        $data = $this->parseResponse($this->list->updateMember($list_id, $subscriber_hash, $subscriber->email1, $mergeFields));
                                    }
                                }
                                //Update responses in table
                                $this->update($subscriber, $data);
                            } else {
                                $this->print->log($this->level, "Missing field mapping for list: ".$list_id." and subscriber: " . $subscriber->name . ". Please set field mapping in admin section.");
                            }
                        }
                    } else {
                        $this->print->log($this->level, "Unable to sync because field mapping not found for list: ".$list_id.". Please set field mapping in admin section.");
                    }
                }
            }
        }
    }

    /**
     * syncMailChimpSubscribers Fetch mailchimp list members and create in SugarCRM under mapped Target List
     * @param string $list_id
     */
    public function syncMailChimpSubscribers($list_id) {
        global $timedate;
        $member = $this->list->members($list_id, '', $this->default['member_fields']);
        if(isset($member['total_items']) && $member['total_items'] > 0) {
            $members = $member['members'];
            $listConfig = !is_array($this->settings['mailchimp_'.$list_id]) ? json_decode($this->settings['mailchimp_'.$list_id]) : (object) $this->settings['mailchimp_'.$list_id];
            $syncModule = $listConfig->sync_module;
            $syncModuleToLower = strtolower($syncModule);
            $field_mapping = $listConfig->$syncModuleToLower;
            if($syncModule && $field_mapping) {
                foreach($members as $item) {
                    $subscriber_id = $item['id'];
                    $merge_fields = $item['merge_fields'];
                    $bean = $this->getRelatedSubscriber($subscriber_id, $syncModule, $list_id);
                    //Dont fetch those records that are already present in sugarcrm
                    if(empty($bean->id) || $bean->module_dir != $syncModule) {
                        $data = $this->parseResponse($item);
                        $bean = BeanFactory::newBean($syncModule);
                        foreach($data as $field=>$value) {
                            if(isset($bean->field_defs[$field])) {
                                if($field == 'stats') {
                                    $value = json_encode($value);
                                }
                                $bean->$field = $value;
                            }
                        }
                        $bean = $this->prepareMergeFields($field_mapping, $bean, $merge_fields);
                        $bean->last_sync_date = $timedate->nowDb();
                        $bean->save();
                        // For new record build its relationship with list
                        if($bean->load_relationship('prospect_lists')) {
                            $bean->prospect_lists->add($this->getTargetListId($list_id));
                        }
                    } else {
                        if($bean->load_relationship('prospect_lists')) {
                            $bean->prospect_lists->add($this->getTargetListId($list_id));
                        }
                    }
                }
            } else {
                $this->print->log($this->level, "Unable to sync because sync module or field mapping is not set for list: ".$list_id.". Please set sync module and field mapping in admin section.");
            }
        }
    }

    /**
     * getMailChimpCampaigns get MailChimp Campaigns
     * @return array|bool
     */
    public function getMailChimpCampaigns() {
        $result = $this->campaign->getCampaigns($this->default['campaign_fields']);
        if($result) {
            $count = $result['total_items'];
            if($count > 0) {
                return $result['campaigns'];
            }
        }
        return false;
    }

    /**
     * send MailChimp subscriber or campaigns activity in dashlet, handle runtime mailchimp api requests
     * @param array $args
     * @return array|bool
     */
    public function handleDashletData($args = array()) {
        $activity_type = isset($args['activity_type']) ? $args['activity_type'] : '';
        if($activity_type == 'subscriber') {
            //Return subscriber activities in Leads, Contacts or Prospect dashlets
            $list_id = $args['list_id'];
            $subscriber_hash = $args['subscriber_hash'];
            $result = $this->list->memberActivity($list_id, $subscriber_hash);
            if($result) {
                $count = $result['total_items'];
                if($count > 0) {
                    $activities = $result['activity'];
                    foreach($activities as $key => $value) {
                        $camaign_id = $value['campaign_id'];
                        $response = $this->campaign->getEepURL($camaign_id);
                        if($response) {
                            $activities[$key]['eepurl'] = $response['eepurl'];
                        }
                    }
                    return $activities;
                }
            }
        } else if($activity_type == 'campaign') {
            //Return mailchimp campaign report on Home dashlet
            $campaign_id = $args['campaign_id'];
            $result = $this->campaign->campaignReport($campaign_id);
            if($result) {
                $count = 0;
                $res = $this->list->getList($result['list_id'], array("stats.member_count"));
                if($res) {
                    $count = $res['stats']['member_count'];
                }
                $result['recipient_count'] = $count;
                return $result;
            }
        } else if($activity_type == 'campaign-list') {
            //Return mailchimp campaign list on Home dashlet
            return $this->getMailChimpCampaigns();
        } else if($activity_type == 'targetlist') {
            $list_id = $args['list_id'];
            $result = $this->list->getList($list_id, $this->default['list_fields']);
            if($result) {
                return $result;
            }
        } else if($activity_type == 'mailchimp-lists') {
            //Return mailchimp list in Leads, Contacts or Prospect dashlets
            $response_data = array();
            $list_ids = $args['list_ids'];
            if(!empty($list_ids) && is_array($list_ids) && count($list_ids) > 0) {
                foreach($list_ids as $list_id) {
                    $listConfig = !is_array($this->settings['mailchimp_'.$list_id]) ? json_decode($this->settings['mailchimp_'.$list_id]) : (object) $this->settings['mailchimp_'.$list_id];
                    if(!empty($listConfig)) {
                        $response_data[$list_id] = $listConfig->mailchimp_list_name;
                    }
                }
            }
            return $response_data;
        }
        return false;
    }

    /**
     * Api endpoint utilize this function to recieve changes from mailchimp
     * Sugar Dashlet also uses this function to get runtime activities
     *
     * @param array $args
     * @return null|bool
     */
    public function syncMailChimpChanges($args = array()) {
        global $timedate;
        if(!isset($args['type']) || empty($args['type'])) {
            return false;
        }
        $type = $args['type'];
        if($type == 'mailchimp-lists') {
            $modules = array('' => 'Please select', 'Contacts' => 'Contacts', 'Leads' => 'Leads', 'Prospects' => 'Targets');
            $lists = $this->getLists();
            array_unshift($lists, array('id' => '', 'name' => 'Please select'));
            return array('modules' => $modules, 'lists' => $lists);
        } else if($type == 'dashlet') {
            return $this->handleDashletData($args);
        } else {
            $list_id = $args['data']['list_id'];
            $listConfig = !is_array($this->settings['mailchimp_'.$list_id]) ? json_decode($this->settings['mailchimp_'.$list_id]) : (object) $this->settings['mailchimp_'.$list_id];
            $syncModule = $listConfig->sync_module;
            //When email is updated in MailChimp then both profile and then upemail triggers will call in two different requests
            if($type == 'upemail') {
                //email update
                $new_email = $args['data']['new_email'];
                $new_subscriber_hash = md5($args['data']['new_email']);
                $old_subscriber_hash = md5($args['data']['old_email']);
                $bean = $this->getRelatedSubscriber($old_subscriber_hash, $syncModule, $list_id);
                //Copy new bean over old bean and soft delete new bean in case of email update.
                if(!empty($bean->id)) {
                    $bean->email1 = $new_email;
                    $bean->subscriber_hash = $new_subscriber_hash;
                    $bean->last_sync_date = $timedate->nowDb();
                    $bean->save();
                }
                //delete existing
            } else {
                $email = $args['data']['email'];
                $subscriber_hash = md5($email);
                //profile update or subscribe
                if($type == 'profile' || $type == 'subscribe') {
                    $data = $args['data']['merges'];
                    $bean = $this->getRelatedSubscriber($subscriber_hash, $syncModule, $list_id);
                    if(!empty($bean)) {
                        $table_name = $bean->table_name;
                        $field_mapping = $listConfig->$table_name;
                        if($field_mapping) {
                            $beanId = !empty($bean->id) ? $bean->id : '';
                            if($type == 'profile' && empty($beanId)) {
                                //Ignore the update if profile is updated but bean id is not found - refered as email update.
                                return false;
                            }
                            $bean = $this->prepareMergeFields($field_mapping, $bean, $data);
                            $bean->subscriber_hash = $subscriber_hash;
                            $bean->email1 = $email;
                            $bean->last_sync_date = $timedate->nowDb();
                            if(!empty($this->settings['mailchimp_user_id'])) {
                                $user_id = substr($this->settings['mailchimp_user_id'], 1, -1);
                            }
                            $GLOBALS['current_user'] = isset($user_id) ? BeanFactory::getBean("Users", $user_id) : BeanFactory::getBean("Users", 1);
                            $bean->assigned_user_id = $GLOBALS['current_user']->id;
                            $bean->save();
                            // In case of new record build its relationship with list
                            if($bean->load_relationship('prospect_lists') && empty($beanId)) {
                                $bean->prospect_lists->add($this->getTargetListId($list_id));
                            }
                        }
                    }
                }
                // unsubscribe
                if($type == 'unsubscribe') {
                    $bean = $this->getRelatedSubscriber($subscriber_hash, $syncModule, $list_id);
                    if($bean) {
                        //Unlink related record when deleted from MailChimp
                        global $db;
                        $link = $bean->module_dir;
                        $targetListId = $this->getTargetListId($list_id);
                        $db->query("UPDATE prospect_lists_prospects SET deleted='1', date_modified = '" . $timedate->nowDb() . "' WHERE prospect_list_id = '" . $targetListId . "' AND related_id = '" . $bean->id . "' AND related_type='" . $link . "'");
                    }
                }
            }
        }
        return true;
    }

    /**
     * Fetch mailchimp list and their related merge fields
     * @param bool $get_fields
     * @param string $list_id
     * @param array $fields
     * @return array|bool
     */
    public function getLists($get_fields = false, $list_id = '', $fields = array('id', 'name')) {
        $response = $this->list->getList($list_id, $fields);
        if($response) {
            $listsData = isset($response['lists']) ? $response['lists'] : $response;
            if($get_fields) {
                return $this->prepareListFields($listsData);
            }
            return $listsData;
        }
        return false;
    }

    /**
     * Parse api response and prepare key value array to be saved in database
     * @param array $data
     * @param string $dataKey
     * @return array|bool
     */
    private function parseResponse($data = array(), $dataKey = '') {
        if(!empty($data) && is_array($data)) {
            $res = array();
            foreach ($this->default['field_mapping'] as $key => $label) {
                //merge keys are used to prepare single json by adding non json fields in it, only for stats
                if (array_key_exists($label, $this->default['merge_keys'])) {
                    $mergeArray = $this->default['merge_keys'][$label];
                    foreach($mergeArray as $field) {
                        if(isset($data[$field])) {
                            $data[$label][$field] = $data[$field];
                        }
                    }
                }
                if(isset($data[$label]) && !empty($data[$label])) {
                    $res[$key] = $data[$label];
                }
            }
            return $res;
        }
        return false;
    }

    /**
     * Return sugar record id of target list from mailchimp list id
     * @param string $list_id
     * @return mixed
     */
    private function getTargetListId($list_id) {
        $where = array(
            'equals' => array(
                'mailchimp_list' => $list_id
            )
        );
        $result = $this->runSugarQuery('ProspectLists', array('id'), $where, 1);
        if($result) {
            return $result[0]['id'];
        }
        return false;
    }

    /**
     * Find related record in sugar in leads, contacts or targets. If not found then will return new bean using list config sync_module
     * @param string $subscriber_id
     * @param string $syncModule
     * @param array $params
     * @return bool| object New SugarBean | object Existing SugarBean
     */
    private function getRelatedSubscriber($subscriber_id, $syncModule = '', $list_id = '') {
        $bean = null;
        $where = array(
            'equals' => array(
                'subscriber_hash' => $subscriber_id
            )
        );
        $target_list_id = $this->getTargetListId($list_id);
        //find related bean from the module specified in admin section against that list
        if(!empty($syncModule)) {
            $results = $this->runSugarQuery($syncModule, array('*'), $where);
            if(!empty($results)) {
                foreach($results as $result) {
                    $bean = BeanFactory::getBean($syncModule, $result['id'], array('disable_row_level_security' => true));
                    if($bean->load_relationship('prospect_lists')) {
                        $is_relationship = $bean->prospect_lists->get();
                        if(!empty($is_relationship[0]) && in_array($target_list_id, $is_relationship)) {
                            return $bean;
                        }
                    }
                }
            }
        } else {
            $this->print->log($this->level, "Unable to sync because sync module is not set for list. Please set sync module in admin section.");
            return false;
        }
        //If related bean is not found or sync module is not set then find blindly in all the target modules otherwise return new bean
        foreach($this->targetModules as $module) {
            $results = $this->runSugarQuery($module, array('id'), $where);
            if($results) {
                foreach($results as $result) {
                    $bean = BeanFactory::getBean($module, $result['id'], array('disable_row_level_security' => true));
                    if($bean->load_relationship('prospect_lists')) {
                        $is_relationship = $bean->prospect_lists->get();
                        if(!empty($is_relationship[0]) && in_array($target_list_id, $is_relationship)) {
                            return $bean;
                        }
                    }
                }
            }
        }
        return !empty($bean->id) ? $bean : BeanFactory::newBean($syncModule);
    }

    /**
     * @param string $list_id
     * @return array
     */
    public function getListFields($list_id) {
        $result = $this->list->getField($list_id, $this->default['merge_fields']);
        if($result) {
            $fieldData = $result['merge_fields'];
            $fieldCount = $result['total_items'];
            if($fieldCount > 0) {
                return $fieldData;
            }
        }
        return array();
    }

    /**
     * Return all the related leads, contacts or targets against provided sugar target list
     * @param string $targetListId
     * @param bool $count
     * @return array|int
     */
    public function getTargetListSubscribers($targetListId, $count = false) {
        $module = 'ProspectLists';
        $subscribers = array();
        $targetList = BeanFactory::getBean($module, $targetListId);
        foreach($this->targetModules as $module) {
            $link = strtolower($module);
            if ($targetList->load_relationship($link)) {
                $relatedBeans = $targetList->$link->getBeans();
                $subscribers = array_merge($subscribers, $relatedBeans);
            }
        }
        if($count) {
            return count($subscribers);
        }
        return $subscribers;
    }

    /**
     * Return all the sugar target lists that are mapped with some lists on mailchimp side
     * @return array
     */
    public function getTargetLists() {
        $result = $this->runSugarQuery('ProspectLists', array('id', 'mailchimp_list', 'date_modified', 'last_sync_date'), array('isNotEmpty' => 'mailchimp_list'));
        if($result) {
            return $result;
        }
        return array();
    }

    /**
     * Update existing sugar records by splitting key value array prepared earlier
     *
     * @param object $bean
     * @param array $args
     */
    private function update($bean, $args = array()) {
        global $timedate;
            if(!empty($args['module']) && !empty($args['id'])) {
                $bean = BeanFactory::getBean($args['module'], $args['id']);
            }
            if(!empty($args) && is_array($args) && count($args)) {
                foreach($args as $key=>$value) {
                    if(!empty($bean->field_defs[$key]) && !in_array($key, array('id', 'module'))) {
                        $bean->$key = $value;
                    }
                }
            }
            $bean->last_sync_date = $timedate->nowDb();
            $bean->save();
    }

    /**
     * @param array $listData
     * @return array
     */
    private function prepareListFields($listData = array()) {
        $listArray = array();
        foreach ($listData as $list) {
            $fieldData = $this->getListFields($list['id']);
            $list['merge_fields'] = $fieldData;
            $listArray[] = $list;
        }
        return $listArray;
    }

    /**
     * Prepare key value mapping from field mapping in config table or set bean keys instead
     * @param array $field_mapping
     * @param object $bean
     * @param string $data
     * @return array
     */
    public function prepareMergeFields($field_mapping = array(), $bean, $data = '') {
        $mergeFields = array();
        foreach($field_mapping as $key=>$name) {
            if(!empty($key) && !empty($name)) {
                if(isset($bean->field_defs[$name])) {
                    if(empty($data)) {
                        //In case of sugar to mailchimp
                        if (strpos($key, '.') !== false) {
                            list($main, $sub) = explode('.', $key);
                            if(in_array($sub, $this->_address_field_sub_field_names)) {
                                // In case of address field
                                if($sub == 'addr1') {
                                    $street_info = explode(PHP_EOL, $bean->$name);
                                    if(count($street_info) > 1){
                                        $mergeFields[$main][$sub] = $street_info[0];
                                        $mergeFields[$main]['addr2'] = $street_info[1];
                                    } else {
                                        $mergeFields[$main][$sub] = $bean->$name;
                                    }
                                } else if($sub != 'addr2') {
                                    $mergeFields[$main][$sub] = $bean->$name;
                                }
                            } else {
                                $mergeFields[$key] = $bean->$name;
                            }
                        } else {
                            $mergeFields[$key] = $bean->$name;
                        }
                    } else {
                        //In case of mailchimp to sugar
                        if (empty($data[$key]) && strpos($key, '.') !== false) {
                            list($main, $sub) = explode('.', $key);
                            if(in_array($sub, $this->_address_field_sub_field_names)) {
                                // In case of address field
                                $bean->$name = $data[$main][$sub];
                            } else {
                                $bean->$name = $data[$key];
                            }
                        } else {
                            $bean->$name = $data[$key];
                        }
                    }
                }
            }
        }
        return empty($data) ? $mergeFields : $bean;
    }

    /**
     * Set new webhhok against mailchimp list to send changes to sugar
     * @param string $list_id
     */
    public function checkWebhookAvailability($list_id) {
        global $sugar_config;
        $found = false;
        $callbackUrl = $sugar_config['site_url'] . "/" . $this->default['webhook']['rest_url'];
        $webhook = $this->list->webhooks($list_id);
        //Check webhook for list updates
        if($webhook['total_items'] > 0) {
            $webhooks = $webhook['webhooks'];
            foreach($webhooks as $key=>$value) {
                if($value['url'] == $callbackUrl) {
                    $found = true;
                    break;
                }
            }
        }
        //Create webhook for list updates
        if(!$found) {
            $this->list->webhookAdd($list_id, $callbackUrl);
        }
    }

    /**
     * update last_sync_date as null to when Sugar target list is remapped in order to sync it with new mailchimp list
     * unlink converted lead from sugar target list in case of leads
     * Manage workflow logics
     *
     * @param object $bean
     * @param string $event
     * @param array $arguments
     */
    function beforeSave($bean, $event, $arguments) {
        $link = "prospect_lists";
        if($bean->module_dir == 'Leads') {
            $leads_list_id = $this->settings['mailchimp_Leads'];
            if($bean->converted == 1 && $bean->converted != $bean->fetched_row['converted']) {
                //Remove lead from all target lists when it is converted
                if($bean->load_relationship($link)) {
                    $bean->$link->delete($bean->id, $leads_list_id);
                }
            } else if($bean->id != $bean->fetched_row['id']) {
                if($bean->load_relationship($link)) {
                    $bean->$link->add($leads_list_id);
                }
            }
        } else if($bean->module_dir == 'Contacts') {
            $account_type = '';
            if($bean->account_id) {
                $account = BeanFactory::getBean('Accounts', $bean->account_id);
                $account_type = $account->account_type;
            }
            if(!empty($account_type)) {
                $contacts_lists = !is_array(base64_decode($this->settings['mailchimp_Contacts'])) ? json_decode(base64_decode($this->settings['mailchimp_Contacts'])) : (object) base64_decode($this->settings['mailchimp_Contacts']);
                if(!empty($contacts_lists->$account_type) && is_array($contacts_lists->$account_type) && count($contacts_lists->$account_type) > 0) {
                    $contacts_list_ids = $contacts_lists->$account_type;
                    if($bean->load_relationship($link)) {
                        foreach($contacts_list_ids as $list_id) {
                            $bean->$link->add($list_id);
                        }
                    }
                }
            }
        } else {
            if(!empty($bean->fetched_row['id']) && $bean->mailchimp_list != $bean->fetched_row['mailchimp_list']) {
                $bean->last_sync_date = null;
            }
        }
    }

    /**
     * @param object $bean
     * @param string $event
     * @param array $arguments
     */
    function afterRelationshipDelete($bean, $event, $arguments)
    {
        global $db;
        $module = $arguments['module'];
        $link = ucfirst($arguments['link']);
        $related_id = $arguments['related_id'];
        $list_id = isset($bean->mailchimp_list) ? $bean->mailchimp_list : '';
        if($module == 'ProspectLists' && !empty($list_id) && !empty($link) && in_array($link, $this->targetModules)) {
            $where = array(
                'equals' => array(
                    'id' => $related_id
                )
            );
            $result = $this->runSugarQuery($link, array('subscriber_hash'), $where, 1);
            if(!empty($result) && !empty($result[0]) && !empty($result[0]['subscriber_hash'])) {
                $this->list->deleteMember($list_id, $result[0]['subscriber_hash']);
            }
        }
    }

    /**
     * @param $module
     * @param array $select
     * @param array $where
     * @param bool|int $limit
     * @return array|bool
     */
    private function runSugarQuery($module, $select = array(), $where = array(), $limit = false) {
        if(!empty($module)) {
            $bean = BeanFactory::newBean($module);
            $SugarQuery = new SugarQuery();
            $SugarQuery->from($bean, array('team_security' => false));
            if(!empty($select)) {
                $SugarQuery->select($select);
            }
            if(!empty($where)) {
                $this->prepareSugarQueryWhere($SugarQuery, $where);
            }
            if($limit) {
                $SugarQuery->limit($limit);
            }
            $result = $SugarQuery->execute();
            $count = count($result);
            if($count > 0) {
                return $result;
            }
        }
        return false;
    }

    /**
     * @param object $SugarQuery
     * @param array $where
     */
    private function prepareSugarQueryWhere($SugarQuery, $where = array()) {
        foreach($where as $expression=>$field) {
            if($expression == 'equals') {
              foreach($field as $key=>$value) {
                    $SugarQuery->where()->equals($key, $value);
                }
            } else if($expression == 'isNotEmpty') {
                $SugarQuery->where()->isNotEmpty($field);
            }
        }
    }
}

?>