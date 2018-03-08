<?php
$viewdefs['Cases'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_LIST_SUBJECT',
                'link' => true,
                'default' => true,
                'enabled' => true,
                'width' => 'medium',
              ),
              1 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              2 => 
              array (
                'name' => 'customer_name_c',
                'label' => 'LBL_CUSTOMER_NAME',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'customer_phone_c',
                'label' => 'LBL_CUSTOMER_PHONE',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'id' => 'ASSIGNED_USER_ID',
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              5 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'enabled' => true,
                'readonly' => true,
                'width' => 'small',
              ),
              6 => 
              array (
                'name' => 'opportunities_cases_1_name',
                'label' => 'LBL_OPPORTUNITIES_CASES_1_FROM_OPPORTUNITIES_TITLE',
                'enabled' => true,
                'id' => 'OPPORTUNITIES_CASES_1OPPORTUNITIES_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'module' => 'Accounts',
                'id' => 'ACCOUNT_ID',
                'ACLTag' => 'ACCOUNT',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
                'link' => true,
                'default' => false,
                'enabled' => true,
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
                'name' => 'customer_address_city_c',
                'label' => 'LBL_CUSTOMER_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'customer_address_postalcode_c',
                'label' => 'LBL_CUSTOMER_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'customer_address_state_c',
                'label' => 'LBL_CUSTOMER_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'customer_address_street_c',
                'label' => 'LBL_CUSTOMER_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'customer_email_c',
                'label' => 'LBL_CUSTOMER_EMAIL',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'elevation_c',
                'label' => 'LBL_ELEVATION',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'floor_plan_c',
                'label' => 'LBL_FLOOR_PLAN',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'garage_type_c',
                'label' => 'LBL_GARAGE_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'job_code_c',
                'label' => 'LBL_JOB_CODE',
                'enabled' => true,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'case_number',
                'label' => 'LBL_LIST_NUMBER',
                'default' => false,
                'enabled' => true,
                'readonly' => true,
                'width' => 'xxsmall',
              ),
              23 => 
              array (
                'name' => 'service_date_c',
                'label' => 'LBL_SERVICE_DATE',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'service_call_duration_c',
                'label' => 'LBL_SERVICE_CALL_DURATION',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'consultation_date_c',
                'label' => 'LBL_CONSULTATION_DATE',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'service_cons_reminder_c',
                'label' => 'LBL_SERVICE_CONS_REMINDER',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'request_completed_date_c',
                'label' => 'LBL_REQUEST_COMPLETED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'square_feet_c',
                'label' => 'LBL_SQUARE_FEET',
                'enabled' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              31 => 
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
              32 => 
              array (
                'name' => 'days_to_complete_c',
                'label' => 'LBL_DAYS_TO_COMPLETE',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'warranty_exp_date_c',
                'label' => 'LBL_WARRANTY_EXP_DATE',
                'enabled' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'service_call_reminder_c',
                'label' => 'LBL_SERVICE_CALL_REMINDER',
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
