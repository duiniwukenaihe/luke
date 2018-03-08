<?php
$popupMeta = array (
    'moduleMain' => 'Account',
    'varName' => 'ACCOUNT',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'accounts.name',
  'phone_office' => 'accounts.phone_office',
  'website' => 'accounts.website',
  'email' => 'accounts.email',
  'assigned_user_id' => 'accounts.assigned_user_id',
  'market' => 'accounts.market',
  'ccb_num' => 'accounts.ccb_num',
  'ccb_expiration_date' => 'accounts.ccb_expiration_date',
  'vip' => 'accounts.vip',
  'employees' => 'accounts.employees',
  'ownership' => 'accounts.ownership',
  'phone_alternate' => 'accounts.phone_alternate',
  'rating' => 'accounts.rating',
  'parent_name' => 'accounts.parent_name',
  'tag' => 'accounts.tag',
  'assigned_user_name' => 'accounts.assigned_user_name',
  'tin' => 'accounts.tin',
  'insurance_exp' => 'accounts.insurance_exp',
  'team_name' => 'accounts.team_name',
  'phone_fax' => 'accounts.phone_fax',
  'annual_revenue' => 'accounts.annual_revenue',
  'industry' => 'accounts.industry',
  'account_type' => 'accounts.account_type',
  'googleplus' => 'accounts.googleplus',
  'twitter' => 'accounts.twitter',
  'facebook' => 'accounts.facebook',
  'description' => 'accounts.description',
  'created_by_name' => 'accounts.created_by_name',
  'modified_by_name' => 'accounts.modified_by_name',
  'date_modified' => 'accounts.date_modified',
  'date_entered' => 'accounts.date_entered',
  'shipping_address_country' => 'accounts.shipping_address_country',
  'shipping_address_postalcode' => 'accounts.shipping_address_postalcode',
  'shipping_address_state' => 'accounts.shipping_address_state',
  'shipping_address_city' => 'accounts.shipping_address_city',
  'shipping_address_street_4' => 'accounts.shipping_address_street_4',
  'shipping_address_street_3' => 'accounts.shipping_address_street_3',
  'shipping_address_street_2' => 'accounts.shipping_address_street_2',
  'shipping_address_street' => 'accounts.shipping_address_street',
),
    'searchInputs' => array (
  0 => 'name',
  2 => 'phone_office',
  3 => 'website',
  6 => 'email',
  7 => 'assigned_user_id',
  8 => 'market',
  9 => 'ccb_num',
  10 => 'ccb_expiration_date',
  11 => 'vip',
  12 => 'employees',
  13 => 'ownership',
  14 => 'phone_alternate',
  15 => 'rating',
  20 => 'parent_name',
  23 => 'tag',
  24 => 'assigned_user_name',
  25 => 'tin',
  26 => 'insurance_exp',
  27 => 'team_name',
  30 => 'phone_fax',
  31 => 'annual_revenue',
  32 => 'industry',
  33 => 'account_type',
  34 => 'googleplus',
  35 => 'twitter',
  36 => 'facebook',
  37 => 'description',
  38 => 'created_by_name',
  39 => 'modified_by_name',
  40 => 'date_modified',
  41 => 'date_entered',
  42 => 'shipping_address_country',
  43 => 'shipping_address_postalcode',
  44 => 'shipping_address_state',
  45 => 'shipping_address_city',
  46 => 'shipping_address_street_4',
  47 => 'shipping_address_street_3',
  48 => 'shipping_address_street_2',
  49 => 'shipping_address_street',
),
    'create' => array (
  'formBase' => 'AccountFormBase.php',
  'formBaseClass' => 'AccountFormBase',
  'getFormBodyParams' => 
  array (
    0 => '',
    1 => '',
    2 => 'AccountSave',
  ),
  'createButton' => 'LNK_NEW_ACCOUNT',
),
    'searchdefs' => array (
  'employees' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EMPLOYEES',
    'width' => '10',
    'name' => 'employees',
  ),
  'shipping_address_country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'width' => '10',
    'name' => 'shipping_address_country',
  ),
  'shipping_address_postalcode' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'width' => '10',
    'name' => 'shipping_address_postalcode',
  ),
  'shipping_address_state' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'width' => '10',
    'name' => 'shipping_address_state',
  ),
  'shipping_address_city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'width' => '10',
    'name' => 'shipping_address_city',
  ),
  'shipping_address_street_4' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET_4',
    'width' => '10',
    'name' => 'shipping_address_street_4',
  ),
  'shipping_address_street_3' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET_3',
    'width' => '10',
    'name' => 'shipping_address_street_3',
  ),
  'shipping_address_street_2' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET_2',
    'width' => '10',
    'name' => 'shipping_address_street_2',
  ),
  'shipping_address_street' => 
  array (
    'type' => 'text',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'sortable' => false,
    'width' => '10',
    'name' => 'shipping_address_street',
  ),
  'ownership' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OWNERSHIP',
    'width' => '10',
    'name' => 'ownership',
  ),
  'phone_alternate' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_PHONE_ALT',
    'width' => '10',
    'name' => 'phone_alternate',
  ),
  'rating' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RATING',
    'width' => '10',
    'name' => 'rating',
  ),
  'parent_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MEMBER_OF',
    'id' => 'PARENT_ID',
    'width' => '10',
    'name' => 'parent_name',
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
    'width' => '10',
    'name' => 'tag',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10',
    'name' => 'assigned_user_name',
  ),
  'tin' => 
  array (
    'type' => 'int',
    'studio' => true,
    'label' => 'LBL_TIN',
    'width' => '10',
    'name' => 'tin',
  ),
  'insurance_exp' => 
  array (
    'type' => 'date',
    'label' => 'LBL_INSURANCE_EXP',
    'width' => '10',
    'name' => 'insurance_exp',
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
    'width' => '10',
    'name' => 'team_name',
  ),
  'phone_fax' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_FAX',
    'width' => '10',
    'name' => 'phone_fax',
  ),
  'annual_revenue' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ANNUAL_REVENUE',
    'width' => '10',
    'name' => 'annual_revenue',
  ),
  'industry' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_INDUSTRY',
    'width' => '10',
    'name' => 'industry',
  ),
  'account_type' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE',
    'width' => '10',
    'name' => 'account_type',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10',
  ),
  'googleplus' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_GOOGLEPLUS',
    'width' => '10',
    'name' => 'googleplus',
  ),
  'twitter' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TWITTER',
    'width' => '10',
    'name' => 'twitter',
  ),
  'facebook' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FACEBOOK',
    'width' => '10',
    'name' => 'facebook',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10',
    'name' => 'description',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10',
    'name' => 'created_by_name',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'readonly' => true,
    'label' => 'LBL_MODIFIED',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10',
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
    'width' => '10',
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
    'width' => '10',
    'name' => 'date_entered',
  ),
  'market' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_MARKET',
    'width' => '10',
    'name' => 'market',
  ),
  'ccb_num' => 
  array (
    'type' => 'int',
    'studio' => true,
    'label' => 'LBL_CCB_NUM',
    'width' => '10',
    'name' => 'ccb_num',
  ),
  'ccb_expiration_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CCB_EXPIRATION_DATE',
    'width' => '10',
    'name' => 'ccb_expiration_date',
  ),
  'phone_office' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_PHONE_OFFICE',
    'width' => '10',
    'name' => 'phone_office',
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => '10',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
  'website' => 
  array (
    'type' => 'url',
    'label' => 'LBL_WEBSITE',
    'width' => '10',
    'name' => 'website',
  ),
  'vip' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_VIP',
    'width' => '10',
    'name' => 'vip',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_CITY',
    'default' => true,
    'name' => 'billing_address_city',
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'width' => 10,
    'label' => 'LBL_COUNTRY',
    'default' => true,
    'name' => 'billing_address_country',
  ),
  'PHONE_OFFICE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_PHONE',
    'default' => true,
    'name' => 'phone_office',
  ),
),
);
