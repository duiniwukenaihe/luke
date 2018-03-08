<?php
$viewdefs['Accounts'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'account_type',
                'comment' => 'The Company is of this type',
                'label' => 'LBL_TYPE',
              ),
              1 => 
              array (
                'name' => 'phone_alternate',
                'comment' => 'An alternate phone number',
                'label' => 'LBL_PHONE_ALT',
              ),
              2 => 'phone_office',
              3 => 
              array (
                'name' => 'website',
                'displayParams' => 
                array (
                  'type' => 'link',
                ),
              ),
              4 => 
              array (
                'name' => 'phone_fax',
                'comment' => 'The fax phone number of this company',
                'label' => 'LBL_FAX',
              ),
              5 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
              ),
              6 => 'team_name',
              7 => 
              array (
                'name' => 'shipping_address_street',
                'comment' => 'The street address used for for shipping purposes',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET',
              ),
              8 => 
              array (
                'name' => 'shipping_address_city',
                'comment' => 'The city used for the shipping address',
                'label' => 'LBL_SHIPPING_ADDRESS_CITY',
              ),
              9 => 
              array (
                'name' => 'shipping_address_state',
                'comment' => 'The state used for the shipping address',
                'label' => 'LBL_SHIPPING_ADDRESS_STATE',
              ),
              10 => 
              array (
                'name' => 'shipping_address_postalcode',
                'comment' => 'The zip code used for the shipping address',
                'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
              ),
              11 => 
              array (
                'name' => 'shipping_address_country',
                'comment' => 'The country used for the shipping address',
                'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
              ),
              12 => 'assigned_user_name',
              13 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              14 => 
              array (
                'name' => 'tag',
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
                'label' => 'LBL_TAGS',
              ),
              15 => 
              array (
                'name' => 'market',
                'label' => 'LBL_MARKET',
              ),
              16 => 
              array (
                'name' => 'ccb_num',
                'studio' => true,
                'label' => 'LBL_CCB_NUM',
              ),
              17 => 
              array (
                'name' => 'ccb_expiration_date',
                'label' => 'LBL_CCB_EXPIRATION_DATE',
              ),
              18 => 
              array (
                'name' => 'tin',
                'studio' => true,
                'label' => 'LBL_TIN',
              ),
              19 => 
              array (
                'name' => 'insurance_exp',
                'label' => 'LBL_INSURANCE_EXP',
              ),
              20 => 
              array (
                'name' => 'date_modified',
                'comment' => 'Date record last modified',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_MODIFIED',
              ),
              21 => 
              array (
                'name' => 'date_entered',
                'comment' => 'Date record created',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_ENTERED',
              ),
              22 => 
              array (
                'span' => 12,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
