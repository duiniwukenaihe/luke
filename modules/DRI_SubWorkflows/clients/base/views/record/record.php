<?php
// created: 2016-08-03 14:44:52
$viewdefs['DRI_SubWorkflows']['base']['view']['record'] = array (
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
          'label' => 'LBL_NAME',
          'related_fields' => 
          array (
            0 => 'label',
          ),
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
          'name' => 'dri_workflow_name',
          'label' => 'LBL_DRI_WORKFLOW',
        ),
        1 => 
        array (
          'name' => 'dri_subworkflow_template_name',
          'label' => 'LBL_DRI_SUBWORKFLOW_TEMPLATE',
        ),
        2 => 
        array (
          'name' => 'progress',
          'label' => 'LBL_PROGRESS',
          'type' => 'cj_progress_bar',
        ),
        3 => 
        array (
          'name' => 'sort_order',
          'label' => 'LBL_SORT_ORDER',
        ),
        4 => 
        array (
          'name' => 'scoring',
          'inline' => true,
          'readonly' => true,
          'type' => 'fieldset',
          'label' => 'LBL_SCORING',
          'fields' => 
          array (
            0 => 'score',
            1 => 
            array (
              'type' => 'label',
              'default_value' => ' / ',
            ),
            2 => 'points',
          ),
        ),
        5 => 
        array (
          'name' => 'state',
          'label' => 'LBL_STATE',
        ),
        6 => 
        array (
          'name' => 'description',
          'comment' => 'Full text of the note',
          'label' => 'LBL_DESCRIPTION',
          'span' => 12,
        ),
        7 => 'team_name',
        8 => 'assigned_user_name',
        9 => 
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
        ),
        10 => 
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
        ),
        11 => 
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
);