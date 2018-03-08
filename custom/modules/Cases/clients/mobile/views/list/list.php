<?php
$viewdefs['Cases'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_SUBJECT',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              1 => 
              array (
                'name' => 'customer_name_c',
                'label' => 'LBL_CUSTOMER_NAME',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'case_number',
                'label' => 'LBL_NUMBER',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              3 => 
              array (
                'name' => 'opportunities_cases_1_name',
                'label' => 'LBL_OPPORTUNITIES_CASES_1_FROM_OPPORTUNITIES_TITLE',
                'enabled' => true,
                'id' => 'OPPORTUNITIES_CASES_1OPPORTUNITIES_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'default' => true,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_USER',
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_ACCOUNT_NAME',
                'enabled' => true,
                'id' => 'ACCOUNT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'community_c',
                'label' => 'LBL_COMMUNITY',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'customer_phone_c',
                'label' => 'LBL_CUSTOMER_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'customer_email_c',
                'label' => 'LBL_CUSTOMER_EMAIL',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'service_cons_reminder_c',
                'label' => 'LBL_SERVICE_CONS_REMINDER',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'service_call_reminder_c',
                'label' => 'LBL_SERVICE_CALL_REMINDER',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'elevation_c',
                'label' => 'LBL_ELEVATION',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'floor_plan_c',
                'label' => 'LBL_FLOOR_PLAN',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'garage_type_c',
                'label' => 'LBL_GARAGE_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'job_code_c',
                'label' => 'LBL_JOB_CODE',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'service_date_c',
                'label' => 'LBL_SERVICE_DATE',
                'enabled' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'service_call_duration_c',
                'label' => 'LBL_SERVICE_CALL_DURATION',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'consultation_date_c',
                'label' => 'LBL_CONSULTATION_DATE',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'request_completed_date_c',
                'label' => 'LBL_REQUEST_COMPLETED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'square_feet_c',
                'label' => 'LBL_SQUARE_FEET',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              28 => 
              array (
                'name' => 'total_cost_c',
                'label' => 'LBL_TOTAL_COST',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'days_to_complete_c',
                'label' => 'LBL_DAYS_TO_COMPLETE',
                'enabled' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'warranty_exp_date_c',
                'label' => 'LBL_WARRANTY_EXP_DATE',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
