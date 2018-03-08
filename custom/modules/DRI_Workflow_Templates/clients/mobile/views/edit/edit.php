<?php
$module_name = 'DRI_Workflow_Templates';
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
                'name' => 'copied_template_name',
                'label' => 'LBL_COPIED_TEMPLATE',
              ),
              1 => 
              array (
                'name' => 'available_modules',
                'label' => 'LBL_AVAILABLE_MODULES',
              ),
              2 => 
              array (
                'name' => 'active',
                'label' => 'LBL_ACTIVE',
              ),
              3 => 
              array (
                'name' => 'assignee_rule',
                'label' => 'LBL_ASSIGNEE_RULE',
              ),
              4 => 
              array (
                'name' => 'target_assignee',
                'label' => 'LBL_TARGET_ASSIGNEE',
              ),
              5 => 
              array (
                'name' => 'points',
                'readonly' => true,
                'label' => 'LBL_POINTS',
              ),
              6 => 
              array (
                'name' => 'related_activities',
                'readonly' => true,
                'label' => 'LBL_RELATED_ACTIVITIES',
              ),
              7 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              8 => 
              array (
                'name' => 'date_entered',
                'comment' => 'Date record created',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_ENTERED',
              ),
              9 => 
              array (
                'name' => 'date_modified',
                'comment' => 'Date record last modified',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_MODIFIED',
              ),
              10 => 'team_name',
              11 => 
              array (
                'name' => 'tag',
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
                'label' => 'LBL_TAGS',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
