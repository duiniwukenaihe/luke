<?php
$viewdefs['Accounts'] = 
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
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'link' => true,
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'enabled' => true,
                'default' => true,
                'width' => 'xlarge',
              ),
              1 => 
              array (
                'name' => 'account_type',
                'label' => 'LBL_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'phone_office',
                'label' => 'LBL_LIST_PHONE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'email',
                'label' => 'LBL_EMAIL_ADDRESS',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'market',
                'label' => 'LBL_MARKET',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'id' => 'ASSIGNED_USER_ID',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'phone_alternate',
                'label' => 'LBL_PHONE_ALT',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'billing_address_country',
                'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'ccb_num',
                'label' => 'LBL_CCB_NUM',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'ccb_expiration_date',
                'label' => 'LBL_CCB_EXPIRATION_DATE',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'billing_address_city',
                'label' => 'LBL_LIST_CITY',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'date_entered',
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => false,
                'readonly' => true,
              ),
              14 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'facebook',
                'label' => 'LBL_FACEBOOK',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'googleplus',
                'label' => 'LBL_GOOGLEPLUS',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'insurance_exp',
                'label' => 'LBL_INSURANCE_EXP',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'sic_code',
                'label' => 'LBL_SIC_CODE',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'shipping_address_city',
                'label' => 'LBL_SHIPPING_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'shipping_address_postalcode',
                'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'shipping_address_state',
                'label' => 'LBL_SHIPPING_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'shipping_address_street_2',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'shipping_address_street_3',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'shipping_address_street_4',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_4',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'shipping_address_street',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
                'enabled' => true,
                'id' => 'PARENT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'tin',
                'label' => 'LBL_TIN',
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
                'label' => 'LBL_TEAMS',
                'enabled' => true,
                'id' => 'TEAM_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'twitter',
                'label' => 'LBL_TWITTER',
                'enabled' => true,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'vip',
                'label' => 'LBL_VIP',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'website',
                'label' => 'LBL_WEBSITE',
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
