<?php
$viewdefs['DRI_Workflows'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'selection-list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
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
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9',
                'default' => true,
                'enabled' => true,
              ),
              2 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '9',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              3 => 
              array (
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'default' => true,
                'name' => 'date_modified',
                'readonly' => true,
              ),
              4 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_ACCOUNT',
                'enabled' => true,
                'id' => 'ACCOUNT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'assignee_rule',
                'label' => 'LBL_ASSIGNEE_RULE',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'm_cams_name',
                'label' => 'LBL_M_CAMS',
                'enabled' => true,
                'id' => 'M_CAMS_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'contact_name',
                'label' => 'LBL_CONTACT',
                'enabled' => true,
                'id' => 'CONTACT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'current_stage_name',
                'label' => 'LBL_CURRENT_STAGE',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CURRENT_STAGE_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'dri_workflow_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
                'enabled' => true,
                'id' => 'DRI_WORKFLOW_TEMPLATE_ID',
                'link' => true,
                'sortable' => false,
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
                'name' => 'lead_name',
                'label' => 'LBL_LEAD',
                'enabled' => true,
                'id' => 'LEAD_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
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
                'name' => 'opportunity_name',
                'label' => 'LBL_OPPORTUNITY',
                'enabled' => true,
                'id' => 'OPPORTUNITY_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'target_assignee',
                'label' => 'LBL_TARGET_ASSIGNEE',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
