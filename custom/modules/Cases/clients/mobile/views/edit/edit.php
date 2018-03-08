<?php
$viewdefs['Cases'] = 
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
              0 => 
              array (
                'name' => 'name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 'status',
              2 => 
              array (
                'name' => 'case_number',
                'displayParams' => 
                array (
                  'required' => false,
                  'wireless_detail_only' => true,
                ),
              ),
              3 => 'assigned_user_name',
              4 => 
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
              5 => 
              array (
                'name' => 'warranty_exp_date_c',
                'label' => 'LBL_WARRANTY_EXP_DATE',
              ),
              6 => 
              array (
                'name' => 'request_completed_date_c',
                'label' => 'LBL_REQUEST_COMPLETED_DATE',
              ),
              7 => 
              array (
                'name' => 'opportunities_cases_1_name',
                'label' => 'LBL_OPPORTUNITIES_CASES_1_FROM_OPPORTUNITIES_TITLE',
              ),
              8 => 'account_name',
              9 => 
              array (
                'name' => 'customer_name_c',
                'label' => 'LBL_CUSTOMER_NAME',
              ),
              10 => 
              array (
                'name' => 'customer_email_c',
                'label' => 'LBL_CUSTOMER_EMAIL',
              ),
              11 => 
              array (
                'name' => 'customer_phone_c',
                'label' => 'LBL_CUSTOMER_PHONE',
              ),
              12 => 
              array (
                'name' => 'consultation_date_c',
                'label' => 'LBL_CONSULTATION_DATE',
              ),
              13 => 
              array (
                'name' => 'service_call_duration_c',
                'label' => 'LBL_SERVICE_CALL_DURATION',
              ),
              14 => 'team_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
