<?php
// created: 2017-10-11 00:56:13
$viewdefs['Notes']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'filters' => 
  array (
    0 => 
    array (
      'id' => 'created_by_me',
      'name' => 'LBL_CREATED_BY_ME',
      'filter_definition' => 
      array (
        '$creator' => '',
      ),
      'editable' => false,
    ),
  ),
  'fields' => 
  array (
    'contact_name' => 
    array (
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
    'parent_name' => 
    array (
    ),
    'name' => 
    array (
    ),
    'tag' => 
    array (
    ),
    'team_name' => 
    array (
    ),
  ),
);