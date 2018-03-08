<?php
$viewdefs['Leads'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'selection-list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
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
                'name' => 'status',
                'label' => 'LBL_LIST_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'enabled' => true,
                'default' => true,
                'related_fields' => 
                array (
                  0 => 'account_id',
                  1 => 'converted',
                ),
              ),
              3 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_LIST_PHONE',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'buy_sell_home',
                'label' => 'LBL_BUY_SELL_HOME',
                'enabled' => true,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'coop_broker',
                'label' => 'LBL_COOP_BROKER',
                'enabled' => true,
                'id' => 'RELATED_CONTACT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => false,
                'readonly' => true,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'department',
                'label' => 'LBL_DEPARTMENT',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'email',
                'label' => 'LBL_LIST_EMAIL_ADDRESS',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'facebook',
                'label' => 'LBL_FACEBOOK',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'first_name',
                'label' => 'LBL_FIRST_NAME',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'googleplus',
                'label' => 'LBL_GOOGLEPLUS',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'phone_home',
                'label' => 'LBL_HOME_PHONE',
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
                'name' => 'lead_rating',
                'label' => 'LBL_LEAD_RATING',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'lead_source',
                'label' => 'LBL_LEAD_SOURCE',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'phone_mobile',
                'label' => 'LBL_MOBILE_PHONE',
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_OTHER_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'primary_address_city',
                'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'primary_address_country',
                'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'primary_address_postalcode',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'primary_address_state',
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'primary_address_street',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_FLEX_RELATE',
                'enabled' => true,
                'id' => 'PARENT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'refered_by',
                'label' => 'LBL_REFERED_BY',
                'enabled' => true,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
                'enabled' => true,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAMS',
                'enabled' => true,
                'id' => 'TEAM_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'title',
                'label' => 'LBL_TITLE',
                'enabled' => true,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'twitter',
                'label' => 'LBL_TWITTER',
                'enabled' => true,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_USER',
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
