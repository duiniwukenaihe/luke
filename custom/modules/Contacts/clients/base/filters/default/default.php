<?php
// created: 2017-11-27 22:51:01
$viewdefs['Contacts']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'fields' => 
  array (
    'account_name' => 
    array (
    ),
    'assigned_user_name' => 
    array (
    ),
    'assistant' => 
    array (
    ),
    'birthdate' => 
    array (
    ),
    'campaign_name' => 
    array (
    ),
    'address_city' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_city',
        1 => 'alt_address_city',
      ),
      'vname' => 'LBL_CITY',
      'type' => 'text',
    ),
    'address_country' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_country',
        1 => 'alt_address_country',
      ),
      'vname' => 'LBL_COUNTRY',
      'type' => 'text',
    ),
    'created_by_name' => 
    array (
    ),
    'date_entered' => 
    array (
    ),
    'date_modified' => 
    array (
    ),
    'description' => 
    array (
    ),
    'do_not_call' => 
    array (
    ),
    'email' => 
    array (
    ),
    'first_name' => 
    array (
    ),
    'phone_home' => 
    array (
    ),
    'last_name' => 
    array (
    ),
    'lead_source' => 
    array (
    ),
    'modified_by_name' => 
    array (
    ),
    '$favorite' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),
    '$owner' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
    ),
    'opportunity_role' => 
    array (
    ),
    'phone' => 
    array (
      'dbFields' => 
      array (
        0 => 'phone_mobile',
        1 => 'phone_work',
        2 => 'phone_other',
        3 => 'phone_fax',
        4 => 'assistant_phone',
      ),
      'type' => 'phone',
      'vname' => 'LBL_PHONE',
    ),
    'address_postalcode' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_postalcode',
        1 => 'alt_address_postalcode',
      ),
      'vname' => 'LBL_POSTAL_CODE',
      'type' => 'text',
    ),
    'report_to_name' => 
    array (
    ),
    'address_state' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_state',
        1 => 'alt_address_state',
      ),
      'vname' => 'LBL_STATE',
      'type' => 'text',
    ),
    'address_street' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_street',
        1 => 'alt_address_street',
      ),
      'vname' => 'LBL_STREET',
      'type' => 'text',
    ),
    'subcontractor_email_group_c' => 
    array (
    ),
    'tag' => 
    array (
    ),
    'team_name' => 
    array (
    ),
    'title' => 
    array (
    ),
  ),
);