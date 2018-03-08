<?php

$admin_option_defs = array();

$admin_option_defs['Administration']['mailchimp_configuration'] = array('Administration', 'LBL_MAILCHIMP_CONFIGURATION_PANEL_LINK', 'LBL_MAILCHIMP_CONFIGURATION_INFO', './index.php?module=Administration&action=mailChimpConfiguration');

$admin_option_defs['Administration']['mailchimp_fields_mapping'] = array('Administration', 'LBL_MAILCHIMP_FIELDS_MAPPING_PANEL_LINK', 'LBL_MAILCHIMP_FIELDS_MAPPING_INFO', './index.php?module=Administration&action=mailChimpFieldsMapping');

$admin_option_defs['Administration']['mailchimp_modules_mapping'] = array('Administration', 'LBL_MAILCHIMP_MODULES_MAPPING_PANEL_LINK', 'LBL_MAILCHIMP_MODULES_MAPPING_INFO', './index.php?module=Administration&action=mailChimpModulesMapping');

$admin_group_header[] = array('LBL_MAILCHIMP_CONFIGURATION_PANEL', '', false, $admin_option_defs, '');
