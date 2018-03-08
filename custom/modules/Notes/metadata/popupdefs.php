<?php
$popupMeta = array (
    'moduleMain' => 'Notes',
    'varName' => 'Notes',
    'orderBy' => 'notes.name',
    'whereClauses' => array (
  'name' => 'notes.name',
  'description' => 'notes.description',
  'file_url' => 'notes.file_url',
  'created_by_name' => 'notes.created_by_name',
  'modified_by_name' => 'notes.modified_by_name',
  'date_modified' => 'notes.date_modified',
  'favorites_only' => 'notes.favorites_only',
  'team_name' => 'notes.team_name',
  'assigned_user_name' => 'notes.assigned_user_name',
  'tag' => 'notes.tag',
  'my_favorite' => 'notes.my_favorite',
  'contact_name' => 'notes.contact_name',
  'parent_name' => 'notes.parent_name',
  'filename' => 'notes.filename',
  'date_entered' => 'notes.date_entered',
  0 => 'notes.0',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'description',
  5 => 'file_url',
  6 => 'created_by_name',
  7 => 'modified_by_name',
  8 => 'date_modified',
  9 => 'favorites_only',
  10 => 'team_name',
  11 => 'assigned_user_name',
  12 => 'tag',
  13 => 'my_favorite',
  14 => 'contact_name',
  15 => 'parent_name',
  16 => 'filename',
  17 => 'date_entered',
),
    'searchdefs' => array (
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
    'name' => 'description',
  ),
  'file_url' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FILE_URL',
    'width' => 10,
    'name' => 'file_url',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => 10,
    'name' => 'created_by_name',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => 10,
    'name' => 'modified_by_name',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'name' => 'date_modified',
  ),
  'favorites_only' => 
  array (
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => 10,
    'name' => 'favorites_only',
  ),
  'team_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'label' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'name' => 'team_name',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'name' => 'assigned_user_name',
  ),
  'tag' => 
  array (
    'type' => 'tag',
    'link' => 'tag_link',
    'studio' => 
    array (
      'portal' => false,
      'base' => 
      array (
        'popuplist' => false,
      ),
      'mobile' => 
      array (
        'wirelesseditview' => true,
        'wirelessdetailview' => true,
      ),
    ),
    'sortable' => false,
    'label' => 'LBL_TAGS',
    'width' => 10,
    'name' => 'tag',
  ),
  'my_favorite' => 
  array (
    'type' => 'bool',
    'studio' => 
    array (
      'list' => false,
      'recordview' => false,
      'basic_search' => false,
      'advanced_search' => false,
    ),
    'link' => 'favorite_link',
    'label' => 'LBL_FAVORITE',
    'width' => 10,
    'name' => 'my_favorite',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10',
  ),
  'contact_name' => 
  array (
    'type' => 'name',
    'link' => 'contact',
    'label' => 'LBL_CONTACT_NAME',
    'width' => '10',
    'name' => 'contact_name',
  ),
  'parent_name' => 
  array (
    'type' => 'parent',
    'label' => 'LBL_RELATED_TO',
    'width' => '10',
    'name' => 'parent_name',
  ),
  'filename' => 
  array (
    'type' => 'name',
    'name' => 'filename',
    'width' => '10',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10',
    'name' => 'date_entered',
  ),
  0 => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'CONTACT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_CONTACT',
    'link' => true,
    'id' => 'CONTACT_ID',
    'module' => 'Contacts',
    'default' => true,
    'ACLTag' => 'CONTACT',
    'related_fields' => 
    array (
      0 => 'contact_id',
    ),
    'name' => 'contact_name',
  ),
  'PARENT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_RELATED_TO',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'link' => true,
    'default' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
    'name' => 'parent_name',
  ),
  'FILENAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_FILENAME',
    'default' => true,
    'type' => 'file',
    'related_fields' => 
    array (
      0 => 'file_url',
      1 => 'id',
    ),
    'displayParams' => 
    array (
      'module' => 'Notes',
    ),
    'name' => 'filename',
  ),
),
);
