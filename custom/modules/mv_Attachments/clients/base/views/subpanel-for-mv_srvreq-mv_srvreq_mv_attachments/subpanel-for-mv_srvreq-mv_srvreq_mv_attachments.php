<?php
// created: 2017-10-07 12:57:38
$viewdefs['mv_Attachments']['base']['view']['subpanel-for-mv_srvreq-mv_srvreq_mv_attachments'] = array (
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
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'active_date',
          'label' => 'LBL_DOC_ACTIVE_DATE',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'category_id',
          'label' => 'LBL_SF_CATEGORY',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);