<?php
$popupMeta = array (
    'moduleMain' => 'Bug',
    'varName' => 'BUG',
    'orderBy' => 'bugs.name',
    'whereClauses' => array (
  'name' => 'bugs.name',
  'bug_number' => 'bugs.bug_number',
),
    'searchdefs' => array (
  0 => 'bug_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
  4 => 'type',
  5 => 'product_category',
  6 => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
  ),
),
    'listviewdefs' => array (
  'BUG_NUMBER' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_NUMBER',
    'link' => true,
    'default' => true,
    'name' => 'bug_number',
  ),
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_SUBJECT',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'STATUS' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
    'name' => 'status',
  ),
  'TYPE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_TYPE',
    'default' => true,
    'name' => 'type',
  ),
),
);
