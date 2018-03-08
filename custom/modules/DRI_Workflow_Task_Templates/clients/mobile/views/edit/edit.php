<?php
$module_name = 'DRI_Workflow_Task_Templates';
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
                'name' => 'blocked_by_name',
                'label' => 'LBL_BLOCKED_BY',
              ),
              1 => 
              array (
                'name' => 'sort_order',
                'label' => 'LBL_SORT_ORDER',
              ),
              2 => 
              array (
                'name' => 'points',
                'label' => 'LBL_POINTS',
              ),
              3 => 
              array (
                'name' => 'activity_type',
                'label' => 'LBL_ACTIVITY_TYPE',
              ),
              4 => 
              array (
                'name' => 'type',
                'label' => 'LBL_TYPE',
              ),
              5 => 
              array (
                'name' => 'task_due_date_type',
                'label' => 'LBL_TASK_DUE_DATE_TYPE',
              ),
              6 => 
              array (
                'name' => 'priority',
                'label' => 'LBL_PRIORITY',
              ),
              7 => 
              array (
                'name' => 'task_due_days',
                'label' => 'LBL_TASK_DUE_DAYS',
              ),
              8 => 
              array (
                'name' => 'direction',
                'label' => 'LBL_DIRECTION',
              ),
              9 => 
              array (
                'name' => 'time_of_day',
                'label' => 'LBL_TIME_OF_DAY',
              ),
              10 => 
              array (
                'name' => 'duration_hours',
                'label' => 'LBL_DURATION_HOURS',
              ),
              11 => 
              array (
                'name' => 'duration_minutes',
                'label' => 'LBL_DURATION_MINUTES',
              ),
              12 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              13 => 
              array (
                'name' => 'send_invites',
                'label' => 'LBL_SEND_INVITES',
              ),
              14 => 
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
              15 => 
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
              16 => 'team_name',
              17 => 
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
