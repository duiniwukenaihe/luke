<?php

global $sugar_version, $admin_group_header;

if (!is_array($smartsheet_options_defs)) {
    $smartsheet_options_defs = array();
}

$smartsheet_options_defs['Administration']['smartsheet_config'] = array(
    'Administration',
    'LBL_SMARTSHEET_TITLE',
    'LBL_SMARTSHEET_DESCRIPTION',
    './index.php?module=Administration&action=smartSheetConfig'
);

$smartsheet_options_defs['Administration']['syn_sugar_tosmartsheet'] = array(
    'Administration',
    'LBL_SYN_SUGAR_TOSMARTSHEET',
    'LBL_SYN_SUGAR_TOSMARTSHEET_DESCRIPTION',
    './index.php?module=Administration&action=validatesmartsheetkey'
);

/*
  //Sugar to smartsheet
  $smartsheet_options_defs['Administration']['sugar_to_smartsheet_sync'] = array(
  'Administration',
  'LBL_SUGAR_TO_SMARTSHEET_ADMIN_BTN',
  'LBL_SUGAR_TO_SMARTSHEET_DESCRIPTION_ADMIN_BTN',
  './index.php?entryPoint=test?mode=a'
  );

  //smartsheet to sugar
  $smartsheet_options_defs['Administration']['smartsheet_to_sugar_sync'] = array(
  'Administration',
  'LBL_SMARTSHEET_TO_SUGAR_ADMIN_BTN',
  'LBL_SMARTSHEET_TO_SUGAR_DESCRIPTION_ADMIN_BTN',
  './index.php?entryPoint=test?mode=b'
  );
 */
//main header
$admin_group_header['smartsheet_header'] = array(
    'LBL_SMARTSHEET_HEADER',
    '',
    'false',
    $smartsheet_options_defs,
    'LBL_SMARTSHEET_DESCRIPTION',
);
