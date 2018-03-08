<?php
$module_name = 'mv_SrvReq';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'category',
                'label' => 'LBL_CATEGORY',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'responsible_party',
                'label' => 'LBL_RESPONSIBLE_PARTY',
                'enabled' => true,
                'id' => 'ACCOUNT_ID',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'enabled' => true,
                'default' => false,
              ),
              4 => 
              array (
                'name' => 'cases_mv_srvreq_1_name',
                'label' => 'LBL_CASES_MV_SRVREQ_1_FROM_CASES_TITLE',
                'enabled' => true,
                'id' => 'CASES_MV_SRVREQ_1CASES_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              7 => 
              array (
                'name' => 'root_cause',
                'label' => 'LBL_ROOT_CAUSE',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
