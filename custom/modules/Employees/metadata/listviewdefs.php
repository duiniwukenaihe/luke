<?php
// created: 2017-12-22 04:20:32
$listViewDefs['Employees'] = array (
  'name' => 
  array (
    'width' => '20',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'last_name',
      1 => 'first_name',
    ),
    'orderBy' => 'last_name',
    'default' => true,
  ),
  'department' => 
  array (
    'width' => '10',
    'label' => 'LBL_DEPARTMENT',
    'link' => true,
    'default' => true,
  ),
  'title' => 
  array (
    'width' => '15',
    'label' => 'LBL_TITLE',
    'link' => true,
    'default' => true,
  ),
  'reports_to_name' => 
  array (
    'width' => '15',
    'label' => 'LBL_LIST_REPORTS_TO_NAME',
    'link' => true,
    'sortable' => false,
    'default' => true,
  ),
  'email' => 
  array (
    'width' => '15',
    'label' => 'LBL_LIST_EMAIL',
    'link' => true,
    'customCode' => '{$EMAIL_LINK}{$EMAIL}</a>',
    'default' => true,
    'sortable' => false,
  ),
  'phone_work' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PHONE',
    'link' => true,
    'default' => true,
  ),
  'employee_status' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_EMPLOYEE_STATUS',
    'link' => false,
    'default' => true,
  ),
  'date_entered' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
  'dropbox_access_token_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DROPBOX_ACCESS_TOKEN_C',
    'width' => '10',
    'default' => false,
  ),
  'messenger_type' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_MESSENGER_TYPE',
    'width' => '10',
    'default' => false,
  ),
  'messenger_id' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MESSENGER_ID',
    'width' => '10',
    'default' => false,
  ),
  'show_on_employees' => 
  array (
    'type' => 'bool',
    'default' => false,
    'studio' => 
    array (
      'formula' => false,
    ),
    'label' => 'LBL_SHOW_ON_EMPLOYEES',
    'width' => '10',
  ),
  'address_postalcode' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_POSTALCODE',
    'width' => '10',
    'default' => false,
  ),
  'address_country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_COUNTRY',
    'width' => '10',
    'default' => false,
  ),
  'address_city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_CITY',
    'width' => '10',
    'default' => false,
  ),
  'address_state' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_STATE',
    'width' => '10',
    'default' => false,
  ),
  'address_street' => 
  array (
    'type' => 'text',
    'label' => 'LBL_ADDRESS_STREET',
    'sortable' => false,
    'width' => '10',
    'default' => false,
  ),
  'phone_fax' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_FAX_PHONE',
    'width' => '10',
    'default' => false,
  ),
  'phone_other' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_OTHER_PHONE',
    'width' => '10',
    'default' => false,
  ),
  'phone_mobile' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_MOBILE_PHONE',
    'width' => '10',
    'default' => false,
  ),
  'phone_home' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_HOME_PHONE',
    'width' => '10',
    'default' => false,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'related' => false,
      'formula' => false,
      'rollup' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_CREATED_BY_NAME',
    'id' => 'CREATED_BY',
    'width' => '10',
    'default' => false,
  ),
  'last_login' => 
  array (
    'type' => 'datetime',
    'readonly' => true,
    'label' => 'LBL_LAST_LOGIN',
    'width' => '10',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'editview' => false,
      'quickcreate' => false,
      'wirelesseditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10',
    'default' => false,
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10',
    'default' => false,
  ),
  'full_name' => 
  array (
    'type' => 'fullname',
    'studio' => 
    array (
      'formula' => false,
    ),
    'label' => 'LBL_NAME',
    'width' => '10',
    'default' => false,
  ),
  'last_name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_LAST_NAME',
    'width' => '10',
    'default' => false,
  ),
  'first_name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_FIRST_NAME',
    'width' => '10',
    'default' => false,
  ),
  'pwd_last_changed' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'formula' => false,
    ),
    'label' => 'LBL_PSW_MODIFIED',
    'width' => '10',
    'default' => false,
  ),
  'user_name' => 
  array (
    'type' => 'username',
    'studio' => 
    array (
      'no_duplicate' => true,
      'editview' => false,
      'detailview' => true,
      'quickcreate' => false,
      'basic_search' => false,
      'advanced_search' => false,
      'wirelesseditview' => false,
      'wirelessdetailview' => true,
      'wirelesslistview' => false,
      'wireless_basic_search' => false,
      'wireless_advanced_search' => false,
      'rollup' => false,
    ),
    'label' => 'LBL_USER_NAME',
    'width' => '10',
    'default' => false,
  ),
);