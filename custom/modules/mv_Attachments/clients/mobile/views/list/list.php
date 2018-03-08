<?php
$module_name = 'mv_Attachments';
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
                'name' => 'document_name',
                'label' => 'LBL_NAME',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              1 => 
              array (
                'name' => 'category_id',
                'label' => 'LBL_LIST_CATEGORY',
                'default' => true,
                'enabled' => true,
              ),
              2 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'sortable' => false,
                'default' => true,
                'enabled' => true,
              ),
              3 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => true,
                'sortable' => false,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'active_date',
                'label' => 'LBL_LIST_ACTIVE_DATE',
                'default' => true,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'exp_date',
                'label' => 'LBL_LIST_EXP_DATE',
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED_USER',
                'module' => 'Users',
                'id' => 'USERS_ID',
                'default' => false,
                'sortable' => false,
                'related_fields' => 
                array (
                  0 => 'modified_user_id',
                ),
                'enabled' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
