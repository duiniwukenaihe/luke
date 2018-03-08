<?php
// created: 2017-09-11 23:21:45
$subpanel_layout['list_fields'] = array (
  'document_name' => 
  array (
    'name' => 'document_name',
    'vname' => 'LBL_LIST_DOCUMENT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'filename' => 
  array (
    'name' => 'filename',
    'vname' => 'LBL_LIST_FILENAME',
    'width' => 10,
    'module' => 'Documents',
    'sortable' => false,
    'displayParams' => 
    array (
      'module' => 'Documents',
    ),
    'default' => true,
  ),
  'template_type' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_TEMPLATE_TYPE',
    'width' => 10,
    'default' => true,
  ),
  'category_id' => 
  array (
    'name' => 'category_id',
    'vname' => 'LBL_LIST_CATEGORY',
    'width' => 10,
    'default' => true,
  ),
  'doc_type' => 
  array (
    'name' => 'doc_type',
    'vname' => 'LBL_LIST_DOC_TYPE',
    'width' => 10,
    'default' => true,
  ),
  'status_id' => 
  array (
    'name' => 'status_id',
    'vname' => 'LBL_LIST_STATUS',
    'width' => 10,
    'default' => true,
  ),
  'active_date' => 
  array (
    'name' => 'active_date',
    'vname' => 'LBL_LIST_ACTIVE_DATE',
    'width' => 10,
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'document_revision_id' => 
  array (
    'name' => 'document_revision_id',
    'usage' => 'query_only',
  ),
);