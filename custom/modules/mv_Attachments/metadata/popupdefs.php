<?php
$popupMeta = array (
    'moduleMain' => 'mv_Attachments',
    'varName' => 'mv_Attachments',
    'orderBy' => 'mv_attachments.name',
    'whereClauses' => array (
  'name' => 'mv_attachments.name',
),
    'searchInputs' => array (
  0 => 'mv_attachments_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'DOCUMENT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'document_name',
  ),
  'CATEGORY_ID' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_CATEGORY',
    'default' => true,
    'name' => 'category_id',
  ),
),
);
