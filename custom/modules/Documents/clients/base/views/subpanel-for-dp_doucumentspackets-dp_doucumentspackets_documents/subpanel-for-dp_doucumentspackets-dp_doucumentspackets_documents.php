<?php
// created: 2015-10-09 16:09:42
$viewdefs['Documents']['base']['view']['subpanel-for-dp_doucumentspackets-dp_doucumentspackets_documents'] = array (
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
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'filename',
          'label' => 'LBL_LIST_FILENAME',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        2 => 
        array (
          'name' => 'doc_type',
          'label' => 'LBL_LIST_DOC_TYPE',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
		// 3 => 
  //       array (
  //         'name' => 'id',
		//   'type' => 'relationship_status',
  //         'label' => 'LBL_DP_DOUCUMENTSPACKETS_DOCUMENTS_DOCUMENT_STATUS',
  //         'enabled' => true,
  //         'default' => true,
  //         'readonly' => true,
  //       ),
      ),
    ),
  ),
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'name' => 'edit_button',
        'icon' => 'icon-pencil',
        'label' => 'LBL_EDIT_BUTTON',
        'event' => 'list:editrow:fire',
        'acl_action' => 'edit',
        'allow_bwc' => true,
      ),
      1 => 
      array (
        'type' => 'unlink-action',
        'icon' => 'icon-unlink',
        'label' => 'LBL_UNLINK_BUTTON',
      ),
    ),
  ),
  'type' => 'subpanel-list',
);