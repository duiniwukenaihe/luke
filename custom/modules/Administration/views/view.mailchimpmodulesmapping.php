<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AdministrationViewMailChimpModulesMapping extends SugarView {
    
    /**
     * render page if loggged in user is admin
     */
    public function preDisplay() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        parent::preDisplay();
    }

    /**
     * display the form
     */
    public function display() {
        $this->ss->display('custom/modules/Administration/tpls/mailchimp_modules_mapping.tpl');
    }
}