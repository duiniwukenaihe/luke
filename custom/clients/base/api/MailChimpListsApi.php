<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

class MailChimpListsApi extends SugarApi {

    public function registerApiRest() {
        return array(
            'getMailchimpLists' => array(
                'reqType' => 'GET',
                'path' => array('get_mailchimp_lists', '?','?'),
                'pathVars' => array('', 'module', 'id'),
                'method' => 'getMailchimpLists',
            ),
        );
    }

    /**
     * This method returns the dropdown options of a given field
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function getMailchimpLists(ServiceBase $api, array $args) {
        if(isset($args['__sugar_url'])) {
            unset($args['__sugar_url']);
        }
        if(empty($args['id']) || empty($args['module'])){
            return array();
        }
        $id = $args['id'];
        $module = $args['module'];
        $list_ids = array();
        $bean = BeanFactory::retrieveBean($module, $id);
        if(!empty($bean)){
            if($bean->load_relationship('prospect_lists')) {
                $lists = $bean->prospect_lists->getBeans();
                if(!empty($lists)){
                    foreach ($lists as $list) {
                        if(!empty($list->fetched_row) && $list->fetched_row['mailchimp_list']) {
                            array_push($list_ids, $list->fetched_row['mailchimp_list']);
                        }
                    }
                }
                if(!empty($list_ids) && count($list_ids) > 0) {
                    $admin = new Administration();
                    $admin->retrieveSettings('mailchimp', true);
                    $lists = array();
                    if(!empty($list_ids) && is_array($list_ids) && count($list_ids) > 0) {
                        foreach($list_ids as $list_id) {
                            $listConfig = json_decode($admin->settings['mailchimp_'.$list_id]);
                            if(!empty($listConfig)) {
                                $lists[$list_id] = $listConfig->mailchimp_list_name;
                            }
                        }
                        return $lists;
                    }
                }
            }
        }
        return array();
    }
}
