<?php
// created: 2015-10-09 16:23:41
$viewdefs['Contacts']['base']['view']['subpanel-for-dp_doucumentspackets-dp_doucumentspackets_contacts'] = array (
  'type' => 'subpanel-list',
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
          'name' => 'full_name',
          'type' => 'fullname',
          'fields' => 
          array (
            0 => 'salutation',
            1 => 'first_name',
            2 => 'last_name',
          ),
          'link' => true,
          'css_class' => 'full-name',
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'account_name',
          'target_record_key' => 'account_id',
          'target_module' => 'Accounts',
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'email',
          'label' => 'LBL_LIST_EMAIL',
          'enabled' => true,
          'default' => true,
        ),
		// 3 => 
  //       array (
  //         'name' => 'id',
		//   'type' => 'relationship_status',
  //         'label' => 'Document Packet Status',
  //         'enabled' => true,
  //         'default' => true,
  //         'readonly' => true,
  //       ),
      ),
    ),
  ),
);