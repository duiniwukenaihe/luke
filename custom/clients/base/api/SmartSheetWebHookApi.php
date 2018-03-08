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

/**
 * Mail Chimp API calls
 *
 */
class SmartSheetWebHookApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getSmartSheetUpdates' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('smartsheetwebhook'),
                'pathVars' => array(''),
                'method' => 'getSmartSheetUpdates',
                'shortHelp' => 'Recieve smartsheet updates in sugarcrm',
                'longHelp' => '',
            ),
            'syncCamRecord' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('synccamrecord'),
                'pathVars' => array(''),
                'method' => 'syncCamRecord',
                'shortHelp' => 'Sync cam record to shartsheet',
                'longHelp' => '',
            ),
            
            'saveSmartSheetConfig' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('savesmartsheetconfig'),
                'pathVars' => array(''),
                'method' => 'saveSmartSheetConfig',
                'shortHelp' => 'save smartsheet config',
                'longHelp' => '',
            ),
            
            'getSmartSheetFieldMapping' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('getsmartsheetfieldmapping'),
                'pathVars' => array(''),
                'method' => 'getSmartSheetFieldMapping',
                'shortHelp' => 'get smartsheet field mapping',
                'longHelp' => '',
            ),
            'testSmartSheetApiConnection' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('testsmartsheetapi'),
                'pathVars' => array(''),
                'method' => 'testSmartSheetApiConnection',
                'shortHelp' => 'test smartsheet api connection',
                'longHelp' => '',
            ),
            'saveSmartSheetApiKey' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('savesmartsheetapikey'),
                'pathVars' => array(''),
                'method' => 'saveSmartSheetApiKey',
                'shortHelp' => 'test smartsheet api connection',
                'longHelp' => '',
            ),
            'getFieldOptions' => array(
                'reqType' => array('GET','POST','PUT','PATCH','DELETE'),
                'noLoginRequired' => true,
                'path' => array('getfieldoptions'),
                'pathVars' => array(''),
                'method' => 'getFieldOptions',
                'shortHelp' => 'test smartsheet api connection',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Bulk API call
     * @param ServiceBase $api
     * @param array $args
     * @throws SugarApiExceptionMissingParameter
     * @return array
     */
    public function getSmartSheetUpdates(ServiceBase $api, array $args)
    {
            $header_array=getallheaders();
            $hook_response_id=$header_array['Smartsheet-Hook-Challenge'];
            header("HTTP status: 200 OK");
            header("Smartsheet-Hook-Response: $hook_response_id");
        
    }
    
    public function syncCamRecord(ServiceBase $api, array $args) {
        
        require_once 'custom/include/Helpers/SmartSheets/smartSheetSynchronizer.php';
        
        $admin = new Administration();
        $admin->retrieveSettings();
        $sheet_id=$admin->settings['smartsheet_id'];
                
        $smart_sheet= new smartSheetSynchronizer($sheet_id);
        $job_number=$args['job_number'];
                
        if(!empty($job_number))
            $smart_sheet->syncSugarToSmartSheet(" sync_cam_to_smartsheet='1' AND job_number ='$job_number' ",true);
        
        return true;
        
    }
    
    public function saveSmartSheetConfig(ServiceBase $api, array $args) {

        $dropdown_fields_for_additional_menu = array(
            'construction_stage'
        );
        

        require_once('modules/Administration/Administration.php');

        $sheet_id = $args['selected_sheet_id']; //'2622275372509060';//$_REQUEST['sheet_dropdown'];
        if (!empty($sheet_id)) {
            $row_count = count($args['row_data_smartsheet_field']);

            $sheet_config = array();
            for ($row = 0; $row < $row_count; $row++) {
                $data = array();
                $sugar_field_name=$args['row_data_sugarfield'][$row];
                $sugar_field_direction=$args['row_data_direction'][$row];
                $smart_sheet_col_id=$args['row_data_smartsheet_field'][$row];
                $data['name'] = $sugar_field_name;
                $data['direction'] = $sugar_field_direction;
                $sheet_config[$smart_sheet_col_id] = $data;
            }
            
            foreach ($args['sugar_option'] as $sugar_field_option) {
                $int = intval(preg_replace('/[^0-9]+/', '', $sugar_field_option['name']), 10);
                $sheet_config[$args['row_data_smartsheet_field'][$int]]['option']=$sugar_field_option['value'];
            }
            
            //$GLOBALS['log']->fatal("saved settings encodeed", $sheet_config);
            $admin = new Administration();
            $admin->saveSetting('smart_sheet', 'smart_sheet_' . $sheet_id, json_encode($sheet_config));
            return true;
        }
        
        return false;

    }
    
    public function getSmartSheetFieldMapping(ServiceBase $api, array $args) {
                
        require_once 'custom/modules/Administration/views/view.smartsheetconfig.php';

        $sheet_id = $args['sheet_id'];
                
        if (!empty($sheet_id)) {
            $customview = new AdministrationViewSmartSheetConfig();
            return $customview->prepareRowData($sheet_id, 'm_CAMS', true);
        }
        
        return false;
        
    }
    
    public function testSmartSheetApiConnection(ServiceBase $api, array $args) {
        
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $admin = new Administration();
        $admin->retrieveSettings();
        if (!empty($args['ss_api_key'])) {
            require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';
            $smarthelper = new SmartSheetApiHelper();
            $sheet_url = $smarthelper->base_url . "/sheets/";
            $ping = $smarthelper->validateSmartSheetKey($sheet_url, $args['ss_api_key']);
            if (!empty($ping->totalCount) && $ping->totalCount > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function saveSmartSheetApiKey(ServiceBase $api, array $args) {
        
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $admin = new Administration();
        $admin->retrieveSettings();
        
        
        if (!empty($args['ss_api_key'])) {
            require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';
            $smarthelper = new SmartSheetApiHelper();
            $sheet_url = $smarthelper->base_url . "/sheets/";
            $ping = $smarthelper->validateSmartSheetKey($sheet_url, $args['ss_api_key']);
            if (!empty($ping->totalCount) && $ping->totalCount > 0) {
                $admin->saveSetting("smartsheet", 'api_key', $args['ss_api_key']);
                $admin->saveSetting("smartsheet", 'id', $args['ss_id']);
                $admin->saveSetting("smartsheet", 'webhook_id', $args['ss_webhook_id']);
                $admin->saveSetting("smartsheet", 'email_id', $args['ss_email_id']);
            }
        }
        //SugarApplication::redirect('index.php?module=Administration&action=index');
    }
    
    public function getFieldOptions(ServiceBase $api, array $args) {
        
        require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';

        $module = $args['c_module'];
        $field_name = $args['c_field_name'];
        $id_name_count = $args['c_id_name_count'];
        $selected = $args['c_selected'];

        $helper = new SmartSheetApiHelper();
        return $helper->getFieldOptionsFromMoldule($module, $field_name, $id_name_count, $selected);
        
    }
    
}
