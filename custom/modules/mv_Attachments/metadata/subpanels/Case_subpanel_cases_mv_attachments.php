<?php
// created: 2017-12-09 06:46:33
$subpanel_layout['list_fields'] = array (
  'document_name' => 
  array (
    'name' => 'document_name',
    'vname' => 'LBL_LIST_DOCUMENT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'category_id' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_SF_CATEGORY',
    'width' => 10,
    'default' => true,
  ),
  'uploadfile' => 
  array (
    'type' => 'file',
    'vname' => 'LBL_FILE_UPLOAD',
    'width' => 10,
    'default' => true,
  ),
  'parent_name' => 
  array (
    'type' => 'parent',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_FLEX_RELATE',
    'sortable' => false,
    'link' => true,
    'ACLTag' => 'PARENT',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
    'width' => 10,
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);