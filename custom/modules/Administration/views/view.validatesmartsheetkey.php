<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';

class ViewValidateSmartSheetKey extends SugarView {

    public function __construct($bean = null, $view_object_map = array(), \Sugarcrm\Sugarcrm\Security\InputValidation\Request $request = null) {
        $this->smart_sheet_helper = new SmartSheetApiHelper();
        parent::__construct($bean, $view_object_map, $request);
    }

    public function display() {
        $admin = new Administration();
        $admin->retrieveSettings();
        $this->ss->assign('smartsheet_api_key', $admin->settings['smartsheet_api_key']);
        $this->ss->assign('smartsheet_id', $admin->settings['smartsheet_id']);
        $this->ss->assign('smartsheet_webhook_id', $admin->settings['smartsheet_webhook_id']);
        $this->ss->assign('smartsheet_email_id', $admin->settings['smartsheet_email_id']);

        echo $this->ss->fetch('custom/modules/Administration/templates/validate_smartsheet_key.tpl');
        parent::display();
    }

}
