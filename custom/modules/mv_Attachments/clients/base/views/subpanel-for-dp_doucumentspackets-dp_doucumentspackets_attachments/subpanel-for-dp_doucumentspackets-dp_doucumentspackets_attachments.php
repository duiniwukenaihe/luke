<?php
// created: 2018-01-23 18:42:13
$viewdefs['mv_Attachments']['base']['view']['subpanel-for-dp_doucumentspackets-dp_doucumentspackets_attachments'] = array (
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
          'name' => 'uploadfile',
          'type' => 'cstm-file',
          'label' => 'LBL_FILE_UPLOAD',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'category_id',
          'label' => 'LBL_SF_CATEGORY',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'status_id',
          'label' => 'LBL_DOC_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
          'enabled' => true,
          'id' => 'ASSIGNED_USER_ID',
          'link' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'created_by_name',
          'label' => 'LBL_CREATED',
          'enabled' => true,
          'readonly' => true,
          'id' => 'CREATED_BY',
          'link' => true,
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'active_date',
          'label' => 'LBL_DOC_ACTIVE_DATE',
          'enabled' => true,
          'default' => true,
        ),
        8 => 
        array (
          'name' => 'exp_date',
          'label' => 'LBL_DOC_EXP_DATE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);