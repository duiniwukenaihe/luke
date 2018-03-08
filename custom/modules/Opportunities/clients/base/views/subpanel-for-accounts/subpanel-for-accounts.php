<?php
// created: 2017-12-06 19:57:55
$viewdefs['Opportunities']['base']['view']['subpanel-for-accounts'] = array (
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
          'name' => 'sales_stage',
          'default' => true,
          'label' => 'LBL_LIST_SALES_STAGE',
          'enabled' => true,
          'type' => 'enum',
        ),
        2 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_TYPE',
          'enabled' => true,
          'name' => 'opportunity_type',
        ),
        3 => 
        array (
          'name' => 'date_closed',
          'default' => true,
          'label' => 'LBL_DATE_CLOSED',
          'enabled' => true,
          'type' => 'date',
        ),
        4 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_LIKELY',
          'enabled' => true,
          'name' => 'amount',
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'default' => true,
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'link' => true,
          'type' => 'relate',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);