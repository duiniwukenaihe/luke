<?php
// created: 2017-12-06 19:57:55
$viewdefs['Opportunities']['base']['view']['subpanel-for-emails'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'default' => true,
          'label' => 'LBL_LIST_OPPORTUNITY_NAME',
          'enabled' => true,
          'link' => true,
          'type' => 'name',
        ),
        1 => 
        array (
          'target_record_key' => 'account_id',
          'target_module' => 'Accounts',
          'default' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'account_name',
          'link' => true,
          'type' => 'relate',
        ),
        2 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_SALES_STAGE',
          'enabled' => true,
          'name' => 'sales_stage',
        ),
        3 => 
        array (
          'type' => 'int',
          'default' => true,
          'label' => 'LBL_PROBABILITY',
          'enabled' => true,
          'name' => 'probability',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);