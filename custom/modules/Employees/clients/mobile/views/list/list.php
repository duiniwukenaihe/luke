<?php
$viewdefs['Employees'] = 
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
                'label' => 'LBL_NAME',
                'link' => true,
                'orderBy' => 'last_name',
                'default' => true,
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'first_name',
                  1 => 'last_name',
                  2 => 'salutation',
                ),
              ),
              1 => 
              array (
                'name' => 'department',
                'label' => 'LBL_DEPARTMENT',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'title',
                'label' => 'LBL_TITLE',
                'default' => true,
                'enabled' => true,
              ),
              3 => 
              array (
                'name' => 'reports_to_name',
                'label' => 'LBL_REPORTS_TO_NAME',
                'enabled' => true,
                'id' => 'REPORTS_TO_ID',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'email',
                'label' => 'LBL_EMAIL',
                'sortable' => false,
                'link' => true,
                'customCode' => '{$EMAIL_LINK}{$EMAIL}</a>',
                'default' => true,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_OFFICE_PHONE',
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'employee_status',
                'label' => 'LBL_EMPLOYEE_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'readonly' => true,
                'enabled' => true,
              ),
              8 => 
              array (
                'name' => 'messenger_id',
                'label' => 'LBL_MESSENGER_ID',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'dropbox_access_token_c',
                'label' => 'LBL_DROPBOX_ACCESS_TOKEN_C',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'messenger_type',
                'label' => 'LBL_MESSENGER_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'address_country',
                'label' => 'LBL_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'show_on_employees',
                'label' => 'LBL_SHOW_ON_EMPLOYEES',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED_BY_NAME',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'last_login',
                'label' => 'LBL_LAST_LOGIN',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
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
                'name' => 'full_name',
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'last_name',
                'label' => 'LBL_LAST_NAME',
                'enabled' => true,
                'link' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'first_name',
                'label' => 'LBL_FIRST_NAME',
                'enabled' => true,
                'link' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'phone_home',
                'label' => 'LBL_HOME_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              21 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_WORK_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              22 => 
              array (
                'name' => 'address_street',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                'default' => false,
                'enabled' => true,
              ),
              23 => 
              array (
                'name' => 'phone_mobile',
                'label' => 'LBL_MOBILE_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              24 => 
              array (
                'name' => 'address_city',
                'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                'default' => false,
                'enabled' => true,
              ),
              25 => 
              array (
                'name' => 'picture',
                'label' => 'LBL_PICTURE_FILE',
                'enabled' => true,
                'default' => false,
                'width' => '42',
              ),
              26 => 
              array (
                'name' => 'address_state',
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'default' => false,
                'enabled' => true,
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
                'name' => 'address_postalcode',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'default' => false,
                'enabled' => true,
              ),
              29 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              30 => 
              array (
                'name' => 'pwd_last_changed',
                'label' => 'LBL_PSW_MODIFIED',
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
