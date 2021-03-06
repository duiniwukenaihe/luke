<?php
$module_name = 'DRI_Workflow_Templates';
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
                'name' => 'active',
                'label' => 'LBL_ACTIVE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'available_modules',
                'label' => 'LBL_AVAILABLE_MODULES',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'related_activities',
                'label' => 'LBL_RELATED_ACTIVITIES',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'points',
                'label' => 'LBL_POINTS',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9',
                'default' => false,
                'enabled' => true,
              ),
              8 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
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
                'name' => 'assignee_rule',
                'label' => 'LBL_ASSIGNEE_RULE',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'target_assignee',
                'label' => 'LBL_TARGET_ASSIGNEE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'copied_template_name',
                'label' => 'LBL_COPIED_TEMPLATE',
                'enabled' => true,
                'id' => 'COPIED_TEMPLATE_ID',
                'link' => true,
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
