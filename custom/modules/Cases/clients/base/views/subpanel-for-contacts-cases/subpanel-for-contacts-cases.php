<?php
// created: 2017-10-07 13:24:28
$viewdefs['Cases']['base']['view']['subpanel-for-contacts-cases'] = array (
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
          'label' => 'LBL_LIST_NUMBER',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
          'name' => 'case_number',
        ),
        1 => 
        array (
          'label' => 'LBL_LIST_SUBJECT',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        2 => 
        array (
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
          'name' => 'status',
        ),
        3 => 
        array (
          'label' => 'LBL_LIST_DATE_CREATED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_entered',
        ),
        4 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'target_record_key' => 'account_id',
          'target_module' => 'Accounts',
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'account_name',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);