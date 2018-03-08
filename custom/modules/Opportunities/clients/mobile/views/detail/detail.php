<?php
$viewdefs['Opportunities'] = 
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
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'job_code',
                'studio' => true,
                'label' => 'LBL_JOB_CODE',
              ),
              1 => 'amount',
              2 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
              ),
              3 => 'date_closed',
              4 => 'account_name',
              5 => 
              array (
                'name' => 'warranty_exp',
                'readonly' => true,
                'label' => 'LBL_WARRANTY_EXP',
              ),
              6 => 'sales_stage',
              7 => 
              array (
                'name' => 'selling_side',
                'label' => 'LBL_SELLING_SIDE',
              ),
              8 => 
              array (
                'name' => 'opportunity_type',
                'comment' => 'Type of opportunity (ex: Existing, New)',
                'label' => 'LBL_TYPE',
              ),
              9 => 'assigned_user_name',
              10 => 'team_name',
              11 => 
              array (
                'name' => 'address_street',
                'studio' => 'visible',
                'label' => 'LBL_ADDRESS_STREET',
              ),
              12 => 
              array (
                'name' => 'address_city',
                'label' => 'LBL_ADDRESS_CITY',
              ),
              13 => 
              array (
                'name' => 'address_state',
                'label' => 'LBL_ADDRESS_STATE',
              ),
              14 => 
              array (
                'name' => 'address_country',
                'label' => 'LBL_ADDRESS_COUNTRY',
              ),
              15 => 
              array (
                'name' => 'address_postalcode',
                'label' => 'LBL_ADDRESS_POSTALCODE',
              ),
              16 => 
              array (
                'name' => 'builder',
                'label' => 'LBL_BUILDER',
              ),
              17 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
              ),
              18 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
              ),
              19 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
              ),
              20 => 
              array (
                'name' => 'phase',
                'label' => 'LBL_PHASE',
              ),
              21 => 
              array (
                'name' => 'square_ft',
                'studio' => true,
                'label' => 'LBL_SQUARE_FT',
              ),
              22 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
              ),
              23 => 
              array (
                'name' => 'cam_const_finish_mgr_c',
                'label' => 'LBL_CAM_CONST_FINISH_MGR',
              ),
              24 => 
              array (
                'name' => 'cam_construction_stage_c',
                'label' => 'LBL_CAM_CONSTRUCTION_STAGE',
              ),
              25 => 
              array (
                'name' => 'cam_permit_num_c',
                'label' => 'LBL_CAM_PERMIT_NUM',
              ),
              26 => 
              array (
                'name' => 'm_cams_opportunities_1_name',
                'label' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE',
              ),
              27 => 
              array (
                'name' => 'precon',
                'label' => 'LBL_PRECON',
              ),
              28 => 
              array (
                'name' => 'orientation',
                'label' => 'LBL_ORIENTATION',
              ),
              29 => 
              array (
                'name' => 'seller_concessions',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_SELLER_CONCESSIONS',
              ),
              30 => 
              array (
                'name' => 'financing',
                'label' => 'LBL_FINANCING',
              ),
              31 => 
              array (
                'name' => 'proof_of_funds',
                'label' => 'LBL_PROOF_OF_FUNDS',
              ),
              32 => 
              array (
                'name' => 'contigent_offer',
                'label' => 'LBL_CONTIGENT_OFFER',
              ),
              33 => 
              array (
                'name' => 'contingency_expiration',
                'label' => 'LBL_CONTINGENCY_EXPIRATION',
              ),
              34 => 
              array (
                'name' => 'mls_id',
                'studio' => true,
                'label' => 'LBL_MLS_ID',
              ),
              35 => 
              array (
                'name' => 'inspection',
                'label' => 'LBL_INSPECTION',
              ),
              36 => 
              array (
                'name' => 'contingency_notes',
                'label' => 'LBL_CONTINGENCY_NOTES',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
