<?php
$viewdefs['Calls'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
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
              0 => 
              array (
                'name' => 'name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 'date_start',
              2 => 
              array (
                'name' => 'date_end',
                'comment' => 'Date is which call is scheduled to (or did) end',
                'studio' => 
                array (
                  'recordview' => false,
                  'wirelesseditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_CALENDAR_END_DATE',
              ),
              3 => 'description',
              4 => 'parent_name',
              5 => 'assigned_user_name',
              6 => 'team_name',
              7 => 
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
              8 => 
              array (
                'name' => 'dri_workflow_sort_order',
                'label' => 'LBL_DRI_WORKFLOW_SORT_ORDER',
              ),
              9 => 
              array (
                'name' => 'customer_journey_points',
                'label' => 'LBL_CUSTOMER_JOURNEY_POINTS',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
