<?php
$popupMeta = array (
    'moduleMain' => 'Case',
    'varName' => 'CASE',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'cases.name',
  'case_number' => 'cases.case_number',
  'account_name' => 'accounts.name',
  'resolution' => 'cases.resolution',
  'type' => 'cases.type',
  'description' => 'cases.description',
  'created_by_name' => 'cases.created_by_name',
  'opportunities_cases_1_name' => 'cases.opportunities_cases_1_name',
  'customer_name_c' => 'cases_cstm.customer_name_c',
  'consultation_date_c' => 'cases_cstm.consultation_date_c',
  'customer_phone_c' => 'cases_cstm.customer_phone_c',
  'warranty_exp_date_c' => 'cases_cstm.warranty_exp_date_c',
  'customer_email_c' => 'cases_cstm.customer_email_c',
  'community_c' => 'cases_cstm.community_c',
  'customer_address_postalcode_c' => 'cases_cstm.customer_address_postalcode_c',
  'square_feet_c' => 'cases_cstm.square_feet_c',
  'customer_address_street_c' => 'cases_cstm.customer_address_street_c',
  'job_code_c' => 'cases_cstm.job_code_c',
  'customer_address_city_c' => 'cases_cstm.customer_address_city_c',
  'garage_type_c' => 'cases_cstm.garage_type_c',
  'customer_address_state_c' => 'cases_cstm.customer_address_state_c',
  'floor_plan_c' => 'cases_cstm.floor_plan_c',
  'customer_address_country_c' => 'cases_cstm.customer_address_country_c',
  'elevation_c' => 'cases_cstm.elevation_c',
  'service_date_c' => 'cases_cstm.service_date_c',
  'days_to_complete_c' => 'cases_cstm.days_to_complete_c',
  'request_completed_date_c' => 'cases_cstm.request_completed_date_c',
  'service_call_duration_c' => 'cases_cstm.service_call_duration_c',
  'total_cost_c' => 'cases_cstm.total_cost_c',
  'team_name' => 'cases.team_name',
  'assigned_user_name' => 'cases.assigned_user_name',
  'tag' => 'cases.tag',
  'my_favorite' => 'cases.my_favorite',
  'modified_by_name' => 'cases.modified_by_name',
  'date_modified' => 'cases.date_modified',
  'date_entered' => 'cases.date_entered',
  'priority' => 'cases.priority',
  'status' => 'cases.status',
  'assigned_user_id' => 'cases.assigned_user_id',
),
    'searchInputs' => array (
  0 => 'resolution',
  1 => 'type',
  2 => 'description',
  3 => 'created_by_name',
  4 => 'opportunities_cases_1_name',
  5 => 'customer_name_c',
  6 => 'consultation_date_c',
  7 => 'customer_phone_c',
  8 => 'warranty_exp_date_c',
  9 => 'customer_email_c',
  10 => 'community_c',
  11 => 'customer_address_postalcode_c',
  12 => 'square_feet_c',
  13 => 'customer_address_street_c',
  14 => 'job_code_c',
  15 => 'customer_address_city_c',
  16 => 'garage_type_c',
  17 => 'customer_address_state_c',
  18 => 'floor_plan_c',
  19 => 'customer_address_country_c',
  20 => 'elevation_c',
  21 => 'service_date_c',
  22 => 'days_to_complete_c',
  23 => 'request_completed_date_c',
  24 => 'service_call_duration_c',
  25 => 'total_cost_c',
  26 => 'team_name',
  27 => 'assigned_user_name',
  28 => 'tag',
  29 => 'my_favorite',
  30 => 'modified_by_name',
  31 => 'date_modified',
  32 => 'date_entered',
  33 => 'case_number',
  34 => 'name',
  35 => 'account_name',
  36 => 'priority',
  37 => 'status',
  38 => 'assigned_user_id',
),
    'searchdefs' => array (
  'resolution' => 
  array (
    'type' => 'text',
    'label' => 'LBL_RESOLUTION',
    'sortable' => false,
    'width' => 10,
    'name' => 'resolution',
  ),
  'type' => 
  array (
    'type' => 'enum',
    'sortable' => true,
    'label' => 'LBL_TYPE',
    'width' => 10,
    'name' => 'type',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
    'name' => 'description',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => 10,
    'name' => 'created_by_name',
  ),
  'opportunities_cases_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_OPPORTUNITIES_CASES_1_FROM_OPPORTUNITIES_TITLE',
    'id' => 'OPPORTUNITIES_CASES_1OPPORTUNITIES_IDA',
    'width' => 10,
    'name' => 'opportunities_cases_1_name',
  ),
  'customer_name_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_NAME',
    'width' => 10,
    'name' => 'customer_name_c',
  ),
  'consultation_date_c' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_CONSULTATION_DATE',
    'width' => 10,
    'name' => 'consultation_date_c',
  ),
  'customer_phone_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_PHONE',
    'width' => 10,
    'name' => 'customer_phone_c',
  ),
  'warranty_exp_date_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_WARRANTY_EXP_DATE',
    'width' => 10,
    'name' => 'warranty_exp_date_c',
  ),
  'customer_email_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_EMAIL',
    'width' => 10,
    'name' => 'customer_email_c',
  ),
  'community_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COMMUNITY',
    'width' => 10,
    'name' => 'community_c',
  ),
  'customer_address_postalcode_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_ADDRESS_POSTALCODE',
    'width' => 10,
    'name' => 'customer_address_postalcode_c',
  ),
  'square_feet_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SQUARE_FEET',
    'width' => 10,
    'name' => 'square_feet_c',
  ),
  'customer_address_street_c' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_CUSTOMER_ADDRESS_STREET',
    'sortable' => false,
    'width' => 10,
    'name' => 'customer_address_street_c',
  ),
  'job_code_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_JOB_CODE',
    'width' => 10,
    'name' => 'job_code_c',
  ),
  'customer_address_city_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_ADDRESS_CITY',
    'width' => 10,
    'name' => 'customer_address_city_c',
  ),
  'garage_type_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_GARAGE_TYPE',
    'width' => 10,
    'name' => 'garage_type_c',
  ),
  'customer_address_state_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_ADDRESS_STATE',
    'width' => 10,
    'name' => 'customer_address_state_c',
  ),
  'floor_plan_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FLOOR_PLAN',
    'width' => 10,
    'name' => 'floor_plan_c',
  ),
  'customer_address_country_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_ADDRESS_COUNTRY',
    'width' => 10,
    'name' => 'customer_address_country_c',
  ),
  'elevation_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ELEVATION',
    'width' => 10,
    'name' => 'elevation_c',
  ),
  'service_date_c' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_SERVICE_DATE',
    'width' => 10,
    'name' => 'service_date_c',
  ),
  'days_to_complete_c' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DAYS_TO_COMPLETE',
    'width' => 10,
    'name' => 'days_to_complete_c',
  ),
  'request_completed_date_c' => 
  array (
    'type' => 'date',
    'label' => 'LBL_REQUEST_COMPLETED_DATE',
    'width' => 10,
    'name' => 'request_completed_date_c',
  ),
  'service_call_duration_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_SERVICE_CALL_DURATION',
    'width' => 10,
    'name' => 'service_call_duration_c',
  ),
  'total_cost_c' => 
  array (
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST',
    'currency_format' => true,
    'width' => 10,
    'name' => 'total_cost_c',
  ),
  'team_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'label' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'name' => 'team_name',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'name' => 'assigned_user_name',
  ),
  'tag' => 
  array (
    'type' => 'tag',
    'link' => 'tag_link',
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
    'sortable' => false,
    'label' => 'LBL_TAGS',
    'width' => 10,
    'name' => 'tag',
  ),
  'my_favorite' => 
  array (
    'type' => 'bool',
    'studio' => 
    array (
      'list' => false,
      'recordview' => false,
      'basic_search' => false,
      'advanced_search' => false,
    ),
    'link' => 'favorite_link',
    'label' => 'LBL_FAVORITE',
    'width' => 10,
    'name' => 'my_favorite',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => 10,
    'name' => 'modified_by_name',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'name' => 'date_modified',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'name' => 'date_entered',
  ),
  'case_number' => 
  array (
    'name' => 'case_number',
    'width' => 10,
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
  ),
  'account_name' => 
  array (
    'name' => 'account_name',
    'displayParams' => 
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
    'width' => 10,
  ),
  'priority' => 
  array (
    'name' => 'priority',
    'width' => 10,
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => 10,
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'CASE_NUMBER' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_NUMBER',
    'default' => true,
    'name' => 'case_number',
  ),
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'link' => true,
    'default' => true,
    'ACLTag' => 'ACCOUNT',
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
    'name' => 'account_name',
  ),
  'OPPORTUNITIES_CASES_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_OPPORTUNITIES_CASES_1_FROM_OPPORTUNITIES_TITLE',
    'id' => 'OPPORTUNITIES_CASES_1OPPORTUNITIES_IDA',
    'width' => 10,
    'default' => true,
    'name' => 'opportunities_cases_1_name',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
),
);
