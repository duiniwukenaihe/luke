<?php
$viewdefs['Accounts'] = 
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
              ),
              1 => 
              array (
                'name' => 'billing_address_street',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'billing_address_city',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'billing_address_state',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'billing_address_postalcode',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'billing_address_country',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'phone_office',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO',
                'enabled' => true,
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'email',
                'enabled' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => true,
              ),
              10 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              11 => 
              array (
                'name' => 'market',
                'label' => 'LBL_MARKET',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'dri_workflow_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
                'enabled' => true,
                'id' => 'DRI_WORKFLOW_TEMPLATE_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'insurance_exp',
                'label' => 'LBL_INSURANCE_EXP',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'ccb_num',
                'label' => 'LBL_CCB_NUM',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'ccb_expiration_date',
                'label' => 'LBL_CCB_EXPIRATION_DATE',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'vip',
                'label' => 'LBL_VIP',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'account_type',
                'label' => 'LBL_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'annual_revenue',
                'label' => 'LBL_ANNUAL_REVENUE',
                'enabled' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'industry',
                'label' => 'LBL_INDUSTRY',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'tin',
                'label' => 'LBL_TIN',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'billing_address_street_2',
                'label' => 'LBL_BILLING_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'billing_address_street_3',
                'label' => 'LBL_BILLING_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'website',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              27 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'billing_address_street_4',
                'label' => 'LBL_BILLING_ADDRESS_STREET_4',
                'enabled' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'shipping_address_street',
                'enabled' => true,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'rating',
                'label' => 'LBL_RATING',
                'enabled' => true,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'phone_alternate',
                'label' => 'LBL_PHONE_ALT',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'ownership',
                'label' => 'LBL_OWNERSHIP',
                'enabled' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'employees',
                'label' => 'LBL_EMPLOYEES',
                'enabled' => true,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'ticker_symbol',
                'label' => 'LBL_TICKER_SYMBOL',
                'enabled' => true,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'campaign_name',
                'label' => 'LBL_CAMPAIGN',
                'enabled' => true,
                'id' => 'CAMPAIGN_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              37 => 
              array (
                'name' => 'shipping_address_street_2',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              38 => 
              array (
                'name' => 'shipping_address_street_3',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              39 => 
              array (
                'name' => 'shipping_address_street_4',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET_4',
                'enabled' => true,
                'default' => false,
              ),
              40 => 
              array (
                'name' => 'shipping_address_city',
                'enabled' => true,
                'default' => false,
              ),
              41 => 
              array (
                'name' => 'shipping_address_state',
                'enabled' => true,
                'default' => false,
              ),
              42 => 
              array (
                'name' => 'shipping_address_country',
                'enabled' => true,
                'default' => false,
              ),
              43 => 
              array (
                'name' => 'shipping_address_postalcode',
                'enabled' => true,
                'default' => false,
              ),
              44 => 
              array (
                'name' => 'sic_code',
                'label' => 'LBL_SIC_CODE',
                'enabled' => true,
                'default' => false,
              ),
              45 => 
              array (
                'name' => 'team_name',
                'enabled' => true,
                'default' => false,
              ),
              46 => 
              array (
                'name' => 'duns_num',
                'label' => 'LBL_DUNS_NUM',
                'enabled' => true,
                'default' => false,
              ),
              47 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
                'enabled' => true,
                'id' => 'PARENT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              48 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
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
