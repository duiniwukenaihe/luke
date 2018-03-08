<?php
$popupMeta = array (
    'moduleMain' => 'mv_SrvReq',
    'varName' => 'mv_SrvReq',
    'orderBy' => 'mv_srvreq.name',
    'whereClauses' => array (
  'name' => 'mv_srvreq.name',
  'assigned_user_id' => 'mv_srvreq.assigned_user_id',
  'status' => 'mv_srvreq.status',
  'root_cause' => 'mv_srvreq.root_cause',
  'modified_by_name' => 'mv_srvreq.modified_by_name',
  'favorites_only' => 'mv_srvreq.favorites_only',
  'cases_mv_srvreq_1_name' => 'mv_srvreq.cases_mv_srvreq_1_name',
  'mv_srvreq_accounts_name' => 'mv_srvreq.mv_srvreq_accounts_name',
  'assigned_user_name' => 'mv_srvreq.assigned_user_name',
  'team_name' => 'mv_srvreq.team_name',
  'tag' => 'mv_srvreq.tag',
  'my_favorite' => 'mv_srvreq.my_favorite',
  'category' => 'mv_srvreq.category',
  'description' => 'mv_srvreq.description',
  'created_by_name' => 'mv_srvreq.created_by_name',
  'date_modified' => 'mv_srvreq.date_modified',
  'date_entered' => 'mv_srvreq.date_entered',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'assigned_user_id',
  5 => 'root_cause',
  6 => 'modified_by_name',
  7 => 'favorites_only',
  8 => 'cases_mv_srvreq_1_name',
  9 => 'mv_srvreq_accounts_name',
  10 => 'assigned_user_name',
  11 => 'team_name',
  12 => 'tag',
  13 => 'my_favorite',
  14 => 'category',
  15 => 'description',
  16 => 'created_by_name',
  17 => 'date_modified',
  18 => 'date_entered',
),
    'searchdefs' => array (
  'cases_mv_srvreq_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CASES_MV_SRVREQ_1_FROM_CASES_TITLE',
    'id' => 'CASES_MV_SRVREQ_1CASES_IDA',
    'width' => 10,
    'name' => 'cases_mv_srvreq_1_name',
  ),
  'mv_srvreq_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MV_SRVREQ_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'MV_SRVREQ_ACCOUNTSACCOUNTS_IDA',
    'width' => 10,
    'name' => 'mv_srvreq_accounts_name',
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
  'category' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_CATEGORY',
    'width' => 10,
    'name' => 'category',
  ),
  'description' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
    'name' => 'description',
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
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'name' => 'date_entered',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'width' => '10',
    'name' => 'status',
  ),
  'root_cause' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_ROOT_CAUSE',
    'width' => '10',
    'name' => 'root_cause',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10',
    'name' => 'modified_by_name',
  ),
  'favorites_only' => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => '10',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'TEAM_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_TEAM',
    'default' => true,
    'name' => 'team_name',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
    'name' => 'date_modified',
  ),
),
);
