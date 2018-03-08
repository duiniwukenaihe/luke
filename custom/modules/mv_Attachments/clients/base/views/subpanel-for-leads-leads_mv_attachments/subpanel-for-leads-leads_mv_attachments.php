<?php
// created: 2018-01-23 18:43:01
$viewdefs['mv_Attachments']['base']['view']['subpanel-for-leads-leads_mv_attachments'] = array (
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
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'signed_copy',
          'label' => 'LBL_SIGNED_COPY',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'dp_doucumentspackets_mv_attachments_1_name',
          'label' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_DP_DOUCUMENTSPACKETS_TITLE',
          'enabled' => true,
          'readonly' => true,
          'id' => 'DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1DP_DOUCUMENTSPACKETS_IDA',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'active_date',
          'label' => 'LBL_DOC_ACTIVE_DATE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);