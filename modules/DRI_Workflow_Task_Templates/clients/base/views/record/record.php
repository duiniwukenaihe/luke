<?php
$viewdefs['DRI_Workflow_Task_Templates'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'link' => false,
              ),
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_PANEL_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 =>
              array (
                'name' => 'blocked_by',
                'label' => 'LBL_BLOCKED_BY',
                'type' => 'blocked_by',
                'span' => 12,
              ),
              2 => 
              array (
                'name' => 'sort_order',
                'label' => 'LBL_SORT_ORDER',
              ),
              3 => 'points',
              4 => 
              array (
                'name' => 'activity_type',
                'label' => 'LBL_ACTIVITY_TYPE',
              ),
              5 => 
              array (
                'name' => 'type',
                'label' => 'LBL_TYPE',
              ),
              6 => 
              array (
                'name' => 'task_due_date_type',
                'label' => 'LBL_TASK_DUE_DATE_TYPE',
              ),
              7 => 
              array (
                'name' => 'priority',
                'label' => 'LBL_PRIORITY',
              ),
              8 => 
              array (
                'name' => 'task_due_days',
                'label' => 'LBL_TASK_DUE_DAYS',
              ),
              9 => 'direction',
              10 => 
              array (
                'name' => 'time_of_day',
                'type' => 'cj_time',
              ),
              11 => 
              array (
                'name' => 'duration',
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DURATION',
                'fields' => 
                array (
                  0 => 'duration_hours',
                  1 => 'duration_minutes',
                ),
              ),
              12 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
                'span' => 6,
              ),
              13 => 
              array (
                'name' => 'send_invites',
                'label' => 'LBL_SEND_INVITES',
                'span' => 6,
              ),
              14 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
                'span' => 6,
              ),
              15 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
                'span' => 6,
              ),
              16 => 
              array (
                'name' => 'team_name',
                'span' => 12,
              ),
              17 => 
              array (
                'name' => 'tag',
                'span' => 12,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
