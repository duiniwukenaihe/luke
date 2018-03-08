<?php
$viewdefs['Opportunities'] = 
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
          'useTabs' => true,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 
              array (
                'name' => 'job_code',
                'studio' => true,
                'label' => 'LBL_JOB_CODE',
              ),
              2 => 'amount',
              3 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
              ),
              4 => 'date_closed',
              5 => 
              array (
                'name' => 'sale_fail_date_c',
                'label' => 'LBL_SALE_FAIL_DATE_C',
              ),
              6 => 
              array (
                'name' => 'warranty_exp',
                'readonly' => true,
                'label' => 'LBL_WARRANTY_EXP',
              ),
              7 => 'account_name',
              8 => 'sales_stage',
              9 => 
              array (
                'name' => 'selling_side',
                'label' => 'LBL_SELLING_SIDE',
              ),
              10 => 
              array (
                'name' => 'opportunity_type',
                'comment' => 'Type of opportunity (ex: Existing, New)',
                'label' => 'LBL_TYPE',
              ),
              11 => 'assigned_user_name',
              12 => 'team_name',
              13 => 
              array (
                'name' => 'address_street',
                'studio' => 'visible',
                'label' => 'LBL_ADDRESS_STREET',
              ),
              14 => 
              array (
                'name' => 'address_city',
                'label' => 'LBL_ADDRESS_CITY',
              ),
              15 => 
              array (
                'name' => 'address_state',
                'label' => 'LBL_ADDRESS_STATE',
              ),
              16 => 
              array (
                'name' => 'address_country',
                'label' => 'LBL_ADDRESS_COUNTRY',
              ),
              17 => 
              array (
                'name' => 'address_postalcode',
                'label' => 'LBL_ADDRESS_POSTALCODE',
              ),
              18 => 
              array (
                'name' => 'builder',
                'label' => 'LBL_BUILDER',
              ),
              19 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
              ),
              20 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
              ),
              21 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
              ),
              22 => 
              array (
                'name' => 'phase',
                'label' => 'LBL_PHASE',
              ),
              23 => 
              array (
                'name' => 'square_ft',
                'studio' => true,
                'label' => 'LBL_SQUARE_FT',
              ),
              24 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
              ),
              25 => 
              array (
                'name' => 'precon',
                'label' => 'LBL_PRECON',
              ),
              26 => 
              array (
                'name' => 'orientation',
                'label' => 'LBL_ORIENTATION',
              ),
              27 => 
              array (
                'name' => 'seller_concessions',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_SELLER_CONCESSIONS',
              ),
              28 => 
              array (
                'name' => 'financing',
                'label' => 'LBL_FINANCING',
              ),
              29 => 
              array (
                'name' => 'proof_of_funds',
                'label' => 'LBL_PROOF_OF_FUNDS',
              ),
              30 => 
              array (
                'name' => 'contigent_offer',
                'label' => 'LBL_CONTIGENT_OFFER',
              ),
              31 => 
              array (
                'name' => 'contingency_expiration',
                'label' => 'LBL_CONTINGENCY_EXPIRATION',
              ),
              32 => 
              array (
                'name' => 'mls_id',
                'studio' => true,
                'label' => 'LBL_MLS_ID',
              ),
              33 => 
              array (
                'name' => 'inspection',
                'label' => 'LBL_INSPECTION',
              ),
              34 => 
              array (
                'name' => 'contingency_notes',
                'label' => 'LBL_CONTINGENCY_NOTES',
              ),
              35 => 
              array (
                'name' => 'em_due',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_EM_DUE',
              ),
              36 => 
              array (
                'name' => 'em_received_date',
                'label' => 'LBL_EM_RECEIVED_DATE',
              ),
              37 => 
              array (
                'name' => 'em_comments',
                'label' => 'LBL_EM_COMMENTS',
              ),
              38 => 
              array (
                'name' => 'total_upgrades',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_TOTAL_UPGRADES',
              ),
              39 => 
              array (
                'name' => 'upgrades_received_date',
                'label' => 'LBL_UPGRADES_RECEIVED_DATE',
              ),
              40 => 
              array (
                'name' => 'upgrades_due',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_UPGRADES_DUE',
              ),
              41 => 
              array (
                'name' => 'upgrades_received',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_UPGRADES_RECEIVED',
              ),
              42 => 
              array (
                'name' => 'upgrades_comments',
                'label' => 'LBL_UPGRADES_COMMENTS',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
