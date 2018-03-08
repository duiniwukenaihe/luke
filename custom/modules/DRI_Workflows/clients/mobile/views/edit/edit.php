<?php
$module_name = 'DRI_Workflows';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'readonly' => true,
                'label' => 'LBL_NAME',
              ),
              1 => 'dri_workflow_template_name',
              2 => 'available_modules',
              3 => 
              array (
                'name' => 'progress',
                'type' => 'cj_progress_bar',
              ),
              4 => 'assignee_rule',
              5 => 'target_assignee',
              6 => 'current_stage_name',
              7 => 'parent_name',
              8 => 'score',
              9 => 
              array (
                'span' => 12,
              ),
              10 => 
              array (
                'span' => 12,
              ),
              11 => 'state',
              12 => 'account_name',
              13 => 'contact_name',
              14 => 'lead_name',
              15 => 'opportunity_name',
              16 => 'case_name',
              17 => 'points',
              18 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
              19 => 'team_name',
              20 => 'assigned_user_name',
              21 => 'date_modified',
              22 => 'modified_by_name',
              23 => 'date_entered',
              24 => 
              array (
                'name' => 'tag',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
