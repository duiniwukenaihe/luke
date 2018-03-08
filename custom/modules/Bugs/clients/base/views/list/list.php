<?php
$viewdefs['Bugs'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
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
                'name' => 'bug_number',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'enabled' => true,
                'default' => true,
                'link' => true,
              ),
              2 => 
              array (
                'name' => 'status',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'type',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'priority',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'fixed_in_release_name',
                'enabled' => true,
                'default' => true,
                'link' => false,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'product_category',
                'label' => 'LBL_PRODUCT_CATEGORY',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'release_name',
                'enabled' => true,
                'default' => false,
                'link' => false,
              ),
              13 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'resolution',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'portal_viewable',
                'label' => 'LBL_SHOW_IN_PORTAL',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'source',
                'label' => 'LBL_SOURCE',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'system_id',
                'label' => 'LBL_SYSTEM_ID',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'team_name',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'work_log',
                'label' => 'LBL_WORK_LOG',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
