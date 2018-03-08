<?php
$viewdefs['Leads'] = 
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
                'default' => true,
                'enabled' => true,
                'link' => true,
                'related_fields' => 
                array (
                  0 => 'first_name',
                  1 => 'last_name',
                  2 => 'salutation',
                ),
              ),
              1 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_OFFICE_PHONE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'email',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO',
                'enabled' => true,
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'refered_by',
                'label' => 'LBL_REFERED_BY',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_ACCOUNT_NAME',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'buy_sell_home',
                'label' => 'LBL_BUY_SELL_HOME',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'coop_broker',
                'label' => 'LBL_COOP_BROKER',
                'enabled' => true,
                'id' => 'RELATED_CONTACT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'do_not_call',
                'label' => 'LBL_DO_NOT_CALL',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'facebook',
                'label' => 'LBL_FACEBOOK',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'googleplus',
                'label' => 'LBL_GOOGLEPLUS',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'first_name',
                'label' => 'LBL_FIRST_NAME',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'last_name',
                'label' => 'LBL_LAST_NAME',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'lead_source',
                'label' => 'LBL_LEAD_SOURCE',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'phone_mobile',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_OTHER_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'phone_home',
                'enabled' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'primary_address_street',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'primary_address_street_2',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'primary_address_street_3',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'primary_address_city',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'primary_address_state',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'primary_address_postalcode',
                'enabled' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'primary_address_country',
                'enabled' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'contacts_leads_1_name',
                'label' => 'LBL_CONTACTS_LEADS_1_FROM_CONTACTS_TITLE',
                'enabled' => true,
                'id' => 'CONTACTS_LEADS_1CONTACTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'salutation',
                'label' => 'LBL_SALUTATION',
                'enabled' => true,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'status_description',
                'label' => 'LBL_STATUS_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAMS',
                'enabled' => true,
                'id' => 'TEAM_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'title',
                'label' => 'LBL_TITLE',
                'enabled' => true,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'twitter',
                'label' => 'LBL_TWITTER',
                'enabled' => true,
                'default' => false,
              ),
              37 => 
              array (
                'name' => 'website',
                'label' => 'LBL_WEBSITE',
                'enabled' => true,
                'default' => false,
              ),
              38 => 
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
