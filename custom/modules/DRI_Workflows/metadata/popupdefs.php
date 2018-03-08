<?php
$popupMeta = array (
    'moduleMain' => 'DRI_Workflow',
    'varName' => 'DRI_Workflow',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'dri_workflows.name',
  'm_cams_name' => 'dri_workflows.m_cams_name',
  'current_stage_name' => 'dri_workflows.current_stage_name',
  'dri_workflow_template_name' => 'dri_workflows.dri_workflow_template_name',
  'parent_type' => 'dri_workflows.parent_type',
  'points' => 'dri_workflows.points',
  'score' => 'dri_workflows.score',
  'progress' => 'dri_workflows.progress',
  'target_assignee' => 'dri_workflows.target_assignee',
  'assignee_rule' => 'dri_workflows.assignee_rule',
  'state' => 'dri_workflows.state',
  'enabled_modules' => 'dri_workflows.enabled_modules',
  'available_modules' => 'dri_workflows.available_modules',
  'case_name' => 'dri_workflows.case_name',
  'opportunity_name' => 'dri_workflows.opportunity_name',
  'lead_name' => 'dri_workflows.lead_name',
  'contact_name' => 'dri_workflows.contact_name',
  'account_name' => 'dri_workflows.account_name',
  'team_name' => 'dri_workflows.team_name',
  'assigned_user_name' => 'dri_workflows.assigned_user_name',
  'tag' => 'dri_workflows.tag',
  'my_favorite' => 'dri_workflows.my_favorite',
  'description' => 'dri_workflows.description',
  'created_by_name' => 'dri_workflows.created_by_name',
  'modified_by_name' => 'dri_workflows.modified_by_name',
  'date_modified' => 'dri_workflows.date_modified',
  'date_entered' => 'dri_workflows.date_entered',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'm_cams_name',
  2 => 'current_stage_name',
  3 => 'dri_workflow_template_name',
  4 => 'parent_type',
  5 => 'points',
  6 => 'score',
  7 => 'progress',
  8 => 'target_assignee',
  9 => 'assignee_rule',
  10 => 'state',
  11 => 'enabled_modules',
  12 => 'available_modules',
  13 => 'case_name',
  14 => 'opportunity_name',
  15 => 'lead_name',
  16 => 'contact_name',
  17 => 'account_name',
  18 => 'team_name',
  19 => 'assigned_user_name',
  20 => 'tag',
  21 => 'my_favorite',
  22 => 'description',
  23 => 'created_by_name',
  24 => 'modified_by_name',
  25 => 'date_modified',
  26 => 'date_entered',
),
    'searchdefs' => array (
  'm_cams_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_M_CAMS',
    'id' => 'M_CAMS_ID',
    'width' => 10,
    'name' => 'm_cams_name',
  ),
  'current_stage_name' => 
  array (
    'type' => 'relate',
    'readonly' => true,
    'link' => true,
    'label' => 'LBL_CURRENT_STAGE',
    'id' => 'CURRENT_STAGE_ID',
    'width' => 10,
    'name' => 'current_stage_name',
  ),
  'dri_workflow_template_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
    'id' => 'DRI_WORKFLOW_TEMPLATE_ID',
    'width' => 10,
    'name' => 'dri_workflow_template_name',
  ),
  'parent_type' => 
  array (
    'type' => 'parent_type',
    'readonly' => true,
    'label' => 'LBL_PARENT_TYPE',
    'width' => 10,
    'name' => 'parent_type',
  ),
  'points' => 
  array (
    'type' => 'int',
    'readonly' => true,
    'label' => 'LBL_POINTS',
    'width' => 10,
    'name' => 'points',
  ),
  'score' => 
  array (
    'type' => 'int',
    'readonly' => true,
    'label' => 'LBL_SCORE',
    'width' => 10,
    'name' => 'score',
  ),
  'progress' => 
  array (
    'type' => 'float',
    'readonly' => true,
    'label' => 'LBL_PROGRESS',
    'width' => 10,
    'name' => 'progress',
  ),
  'target_assignee' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TARGET_ASSIGNEE',
    'width' => 10,
    'name' => 'target_assignee',
  ),
  'assignee_rule' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_ASSIGNEE_RULE',
    'width' => 10,
    'name' => 'assignee_rule',
  ),
  'state' => 
  array (
    'type' => 'enum',
    'readonly' => true,
    'label' => 'LBL_STATE',
    'width' => 10,
    'name' => 'state',
  ),
  'enabled_modules' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_ENABLED_MODULES',
    'width' => 10,
    'name' => 'enabled_modules',
  ),
  'available_modules' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_AVAILABLE_MODULES',
    'width' => 10,
    'name' => 'available_modules',
  ),
  'case_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CASE',
    'id' => 'CASE_ID',
    'width' => 10,
    'name' => 'case_name',
  ),
  'opportunity_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_OPPORTUNITY',
    'id' => 'OPPORTUNITY_ID',
    'width' => 10,
    'name' => 'opportunity_name',
  ),
  'lead_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_LEAD',
    'id' => 'LEAD_ID',
    'width' => 10,
    'name' => 'lead_name',
  ),
  'contact_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CONTACT',
    'id' => 'CONTACT_ID',
    'width' => 10,
    'name' => 'contact_name',
  ),
  'account_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID',
    'width' => 10,
    'name' => 'account_name',
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
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'name' => 'assigned_user_name',
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
  'description' => 
  array (
    'type' => 'text',
    'readonly' => true,
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
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => 10,
    'name' => 'modified_by_name',
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
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
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
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'TEAM_NAME' => 
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
    'width' => '9',
    'default' => true,
    'name' => 'team_name',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '9',
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
