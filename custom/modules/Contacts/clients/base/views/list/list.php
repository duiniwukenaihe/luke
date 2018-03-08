<?php
$viewdefs['Contacts'] = 
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
                'name' => 'full_name',
                'type' => 'fullname',
                'fields' => 
                array (
                  0 => 'salutation',
                  1 => 'first_name',
                  2 => 'last_name',
                ),
                'link' => true,
                'label' => 'LBL_LIST_NAME',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'title',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'account_name',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'email',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'phone_work',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'id' => 'ASSIGNED_USER_ID',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              8 => 
              array (
                'name' => 'alt_address_city',
                'label' => 'LBL_ALT_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'alt_address_country',
                'label' => 'LBL_ALT_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'alt_address_postalcode',
                'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'alt_address_state',
                'label' => 'LBL_ALT_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'alt_address_street_2',
                'label' => 'LBL_ALT_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'alt_address_street_3',
                'label' => 'LBL_ALT_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'alt_address_street',
                'label' => 'LBL_ALT_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'assistant_phone',
                'label' => 'LBL_ASSISTANT_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'assistant',
                'label' => 'LBL_ASSISTANT',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'birthdate',
                'label' => 'LBL_BIRTHDATE',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'dri_workflow_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
                'enabled' => true,
                'id' => 'DRI_WORKFLOW_TEMPLATE_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'department',
                'label' => 'LBL_DEPARTMENT',
                'enabled' => true,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'do_not_call',
                'label' => 'LBL_DO_NOT_CALL',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'first_name',
                'label' => 'LBL_FIRST_NAME',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'phone_home',
                'label' => 'LBL_HOME_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'preferred_language',
                'label' => 'LBL_PREFERRED_LANGUAGE',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'last_name',
                'label' => 'LBL_LAST_NAME',
                'enabled' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'mkto_lead_score',
                'label' => 'LBL_MKTO_LEAD_SCORE',
                'enabled' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'lead_source',
                'label' => 'LBL_LEAD_SOURCE',
                'enabled' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'phone_mobile',
                'label' => 'LBL_MOBILE_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'email_and_name1',
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_OTHER_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'portal_active',
                'label' => 'LBL_PORTAL_ACTIVE',
                'enabled' => true,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'portal_app',
                'label' => 'LBL_PORTAL_APP',
                'enabled' => true,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'portal_name',
                'label' => 'LBL_PORTAL_NAME',
                'enabled' => true,
                'default' => false,
              ),
              37 => 
              array (
                'name' => 'primary_address_city',
                'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              38 => 
              array (
                'name' => 'primary_address_country',
                'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              39 => 
              array (
                'name' => 'primary_address_postalcode',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              40 => 
              array (
                'name' => 'primary_address_state',
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              41 => 
              array (
                'name' => 'primary_address_street_2',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              42 => 
              array (
                'name' => 'primary_address_street_3',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              43 => 
              array (
                'name' => 'primary_address_street',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              44 => 
              array (
                'name' => 'report_to_name',
                'label' => 'LBL_REPORTS_TO',
                'enabled' => true,
                'id' => 'REPORTS_TO_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              45 => 
              array (
                'name' => 'salutation',
                'label' => 'LBL_SALUTATION',
                'enabled' => true,
                'default' => false,
              ),
              46 => 
              array (
                'name' => 'subcontractor_email_group_c',
                'label' => 'LBL_SUBCONTRACTOR_EMAIL_GROUP_C',
                'enabled' => true,
                'default' => false,
              ),
              47 => 
              array (
                'name' => 'sync_contact',
                'label' => 'LBL_SYNC_CONTACT',
                'enabled' => true,
                'default' => false,
              ),
              48 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              49 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAMS',
                'enabled' => true,
                'id' => 'TEAM_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              50 => 
              array (
                'name' => 'lead_source_description',
                'label' => 'LBL_LEAD_SOURCE_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
