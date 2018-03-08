<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class m_CAMSLogicHookClass {

    function beforeSave($bean, $event, $arguments) {
        if(!$bean->sugar_to_smartsheet_sync)
            $bean->has_synchronized=false;
        
        if(!$bean->smart_sheet_write_log)
            $bean->smart_sheet_write_log='';
    }
}