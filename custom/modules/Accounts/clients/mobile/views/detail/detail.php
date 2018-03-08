<?php
$viewdefs['Accounts'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
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
              1 => 'email',
              2 => 'phone_office',
              3 => 
              array (
                'name' => 'phone_alternate',
                'comment' => 'An alternate phone number',
                'label' => 'LBL_PHONE_ALT',
              ),
              4 => 
              array (
                'name' => 'website',
                'displayParams' => 
                array (
                  'type' => 'link',
                ),
              ),
              5 => 
              array (
                'name' => 'phone_fax',
                'comment' => 'The fax phone number of this company',
                'label' => 'LBL_FAX',
              ),
              6 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
              ),
              7 => 'team_name',
              8 => 'shipping_address_street',
              9 => 'shipping_address_city',
              10 => 'shipping_address_state',
              11 => 'shipping_address_postalcode',
              12 => 'shipping_address_country',
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
              20 => 'assigned_user_name',
              21 => 
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
              22 => 
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
              23 => 
              array (
                'span' => 12,
              ),
              24 => 
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
