<?php
$viewdefs['Meetings'] = 
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
              0 => 'name',
              1 => 
              array (
                'name' => 'date',
                'type' => 'fieldset',
                'related_fields' => 
                array (
                  0 => 'date_start',
                  1 => 'date_end',
                ),
                'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_start',
                  ),
                  1 => 
                  array (
                    'name' => 'date_end',
                    'required' => true,
                    'readonly' => false,
                  ),
                ),
              ),
              2 => 
              array (
                'name' => 'type',
                'comment' => 'Meeting type (ex: WebEx, Other)',
                'studio' => 
                array (
                  'wireless_basic_search' => false,
                ),
                'label' => 'LBL_TYPE',
              ),
              3 => 
              array (
                'name' => 'reminder',
                'type' => 'fieldset',
                'orientation' => 'horizontal',
                'related_fields' => 
                array (
                  0 => 'reminder_checked',
                  1 => 'reminder_time',
                ),
                'label' => 'LBL_REMINDER',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'reminder_checked',
                  ),
                  1 => 
                  array (
                    'name' => 'reminder_time',
                    'type' => 'enum',
                    'options' => 'reminder_time_options',
                  ),
                ),
              ),
              4 => 
              array (
                'name' => 'email_reminder',
                'type' => 'fieldset',
                'orientation' => 'horizontal',
                'related_fields' => 
                array (
                  0 => 'email_reminder_checked',
                  1 => 'email_reminder_time',
                ),
                'label' => 'LBL_EMAIL_REMINDER',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'email_reminder_checked',
                  ),
                  1 => 
                  array (
                    'name' => 'email_reminder_time',
                    'type' => 'enum',
                    'options' => 'reminder_time_options',
                  ),
                ),
              ),
              5 => 'description',
              6 => 'parent_name',
              7 => 
              array (
                'name' => 'location',
                'comment' => 'Meeting location',
                'label' => 'LBL_LOCATION',
              ),
              8 => 'status',
              9 => 
              array (
                'name' => 'modified_by_name',
                'readonly' => true,
                'label' => 'LBL_MODIFIED',
              ),
              10 => 'assigned_user_name',
              11 => 'team_name',
              12 => 
              array (
                'name' => 'dri_workflow_task_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TASK_TEMPLATE',
              ),
              13 => 
              array (
                'name' => 'customer_journey_blocked_by',
                'label' => 'LBL_CUSTOMER_JOURNEY_BLOCKED_BY',
              ),
              14 => 
              array (
                'name' => 'dri_workflow_sort_order',
                'label' => 'LBL_DRI_WORKFLOW_SORT_ORDER',
              ),
              15 => 
              array (
                'name' => 'customer_journey_parent_activity_type',
                'label' => 'LBL_CUSTOMER_JOURNEY_PARENT_ACTIVITY_TYPE',
              ),
              16 => 
              array (
                'name' => 'customer_journey_points',
                'label' => 'LBL_CUSTOMER_JOURNEY_POINTS',
              ),
              17 => 
              array (
                'name' => 'customer_journey_progress',
                'readonly' => true,
                'label' => 'LBL_CUSTOMER_JOURNEY_PROGRESS',
              ),
              18 => 
              array (
                'name' => 'customer_journey_score',
                'readonly' => true,
                'label' => 'LBL_CUSTOMER_JOURNEY_SCORE',
              ),
              19 => 
              array (
                'name' => 'dri_subworkflow_name',
                'label' => 'LBL_DRI_SUBWORKFLOW',
              ),
              20 => 
              array (
                'name' => 'dri_subworkflow_template_name',
                'label' => 'LBL_DRI_SUBWORKFLOW_TEMPLATE',
              ),
              21 => 
              array (
                'name' => 'dri_workflow_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
              ),
              22 => 
              array (
                'name' => 'is_customer_journey_activity',
                'label' => 'LBL_IS_CUSTOMER_JOURNEY_ACTIVITY',
              ),
              23 => 
              array (
                'name' => 'is_customer_journey_parent_activity',
                'label' => 'LBL_IS_CUSTOMER_JOURNEY_PARENT_ACTIVITY',
              ),
              24 => 
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
