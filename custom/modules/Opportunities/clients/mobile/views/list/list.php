<?php
$viewdefs['Opportunities'] = 
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
                'label' => 'LBL_LIST_OPPORTUNITY_NAME',
                'enabled' => true,
                'default' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'sales_stage',
                'label' => 'LBL_SALES_STAGE',
                'enabled' => true,
                'default' => true,
                'width' => '10',
              ),
              2 => 
              array (
                'name' => 'opportunity_type',
                'label' => 'LBL_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'amount',
                'label' => 'LBL_LIKELY',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'enabled' => true,
                'default' => true,
                'id' => 'ACCOUNT_ID',
                'link' => true,
                'sortable' => false,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'enabled' => true,
                'default' => true,
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              7 => 
              array (
                'name' => 'notice30_sent',
                'label' => 'LBL_NOTICE30_SENT',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'address_street',
                'label' => 'LBL_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'address_city',
                'label' => 'LBL_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'address_state',
                'label' => 'LBL_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'address_country',
                'label' => 'LBL_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'address_postalcode',
                'label' => 'LBL_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'amount_source',
                'label' => 'LBL_AMOUNT_SOURCE',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'best_case',
                'label' => 'LBL_BEST',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'builder',
                'label' => 'LBL_BUILDER',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'buy_sell_12mo',
                'label' => 'LBL_BUY_SELL_12MO',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'cam_const_finish_mgr_c',
                'label' => 'LBL_CAM_CONST_FINISH_MGR',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'cam_permit_num_c',
                'label' => 'LBL_CAM_PERMIT_NUM',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'm_cams_opportunities_1_name',
                'label' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE',
                'enabled' => true,
                'id' => 'M_CAMS_OPPORTUNITIES_1M_CAMS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'campaign_name',
                'label' => 'LBL_CAMPAIGN',
                'enabled' => true,
                'id' => 'CAMPAIGN_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              21 => 
              array (
                'name' => 'listing_firm_comm',
                'label' => 'LBL_LISTING_FIRM_COMM',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'selling_broker_comm',
                'label' => 'LBL_SELLING_BROKER_COMM',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'listing_commission_percent',
                'label' => 'LBL_LISTING_COMMISSION_PERCENT',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'commission_percent',
                'label' => 'LBL_COMMISSION_PERCENT',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'commission_note',
                'label' => 'LBL_COMMISSION_NOTE',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'contingency_expiration',
                'label' => 'LBL_CONTINGENCY_EXPIRATION',
                'enabled' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'contingency_notes',
                'label' => 'LBL_CONTINGENCY_NOTES',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'contigent_offer',
                'label' => 'LBL_CONTIGENT_OFFER',
                'enabled' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'default' => false,
                'readonly' => true,
                'enabled' => true,
              ),
              31 => 
              array (
                'name' => 'base_rate',
                'label' => 'LBL_CURRENCY_RATE',
                'enabled' => true,
                'readonly' => true,
                'sortable' => false,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'customer_age',
                'label' => 'LBL_CUSTOMER_AGE',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'differentiator',
                'label' => 'LBL_DIFFERENTIATOR',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'em_comments',
                'label' => 'LBL_EM_COMMENTS',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              37 => 
              array (
                'name' => 'em_due',
                'label' => 'LBL_EM_DUE',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              38 => 
              array (
                'name' => 'em_received',
                'label' => 'LBL_EM_RECEIVED',
                'enabled' => true,
                'default' => false,
              ),
              39 => 
              array (
                'name' => 'em_received_date',
                'label' => 'LBL_EM_RECEIVED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              40 => 
              array (
                'name' => 'early_comm_date',
                'label' => 'LBL_EARLY_COMM_DATE',
                'enabled' => true,
                'default' => false,
              ),
              41 => 
              array (
                'name' => 'early_comm_payout',
                'label' => 'LBL_EARLY_COMM_PAYOUT',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              42 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
                'enabled' => true,
                'default' => false,
              ),
              43 => 
              array (
                'name' => 'escrow_open',
                'label' => 'LBL_ESCROW_OPEN',
                'enabled' => true,
                'default' => false,
              ),
              44 => 
              array (
                'name' => 'financing',
                'label' => 'LBL_FINANCING',
                'enabled' => true,
                'default' => false,
              ),
              45 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
                'enabled' => true,
                'default' => false,
              ),
              46 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              47 => 
              array (
                'name' => 'inspection',
                'label' => 'LBL_INSPECTION',
                'enabled' => true,
                'default' => false,
              ),
              48 => 
              array (
                'name' => 'job_code',
                'label' => 'LBL_JOB_CODE',
                'enabled' => true,
                'default' => false,
              ),
              49 => 
              array (
                'name' => 'last_addendum',
                'label' => 'LBL_LAST_ADDENDUM',
                'enabled' => true,
                'default' => false,
              ),
              50 => 
              array (
                'name' => 'last_exhibit',
                'label' => 'LBL_LAST_EXHIBIT',
                'enabled' => true,
                'default' => false,
              ),
              51 => 
              array (
                'name' => 'lead_conversion_time',
                'label' => 'LBL_LEAD_CONVERSION_TIME',
                'enabled' => true,
                'default' => false,
              ),
              52 => 
              array (
                'name' => 'mls_id',
                'label' => 'LBL_MLS_ID',
                'enabled' => true,
                'default' => false,
              ),
              53 => 
              array (
                'name' => 'marketing_notes',
                'label' => 'LBL_MARKETING_NOTES',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              54 => 
              array (
                'name' => 'mkto_id',
                'label' => 'LBL_MKTO_ID',
                'enabled' => true,
                'default' => false,
              ),
              55 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'default' => false,
                'readonly' => true,
                'enabled' => true,
              ),
              56 => 
              array (
                'name' => 'orientation',
                'label' => 'LBL_ORIENTATION',
                'enabled' => true,
                'default' => false,
              ),
              57 => 
              array (
                'name' => 'other_builders',
                'label' => 'LBL_OTHER_BUILDERS',
                'enabled' => true,
                'default' => false,
              ),
              58 => 
              array (
                'name' => 'overall_sales_duration',
                'label' => 'LBL_OVERALL_SALES_DURATION',
                'enabled' => true,
                'default' => false,
              ),
              59 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
                'enabled' => true,
                'default' => false,
              ),
              60 => 
              array (
                'name' => 'pending_month',
                'label' => 'LBL_PENDING_MONTH',
                'enabled' => true,
                'default' => false,
              ),
              61 => 
              array (
                'name' => 'phase',
                'label' => 'LBL_PHASE',
                'enabled' => true,
                'default' => false,
              ),
              62 => 
              array (
                'name' => 'precon',
                'label' => 'LBL_PRECON',
                'enabled' => true,
                'default' => false,
              ),
              63 => 
              array (
                'name' => 'prequal',
                'label' => 'LBL_PREQUAL',
                'enabled' => true,
                'default' => false,
              ),
              64 => 
              array (
                'name' => 'promotion',
                'label' => 'LBL_PROMOTION',
                'enabled' => true,
                'default' => false,
              ),
              65 => 
              array (
                'name' => 'proof_of_funds',
                'label' => 'LBL_PROOF_OF_FUNDS',
                'enabled' => true,
                'default' => false,
              ),
              66 => 
              array (
                'name' => 'relocating',
                'label' => 'LBL_RELOCATING',
                'enabled' => true,
                'default' => false,
              ),
              67 => 
              array (
                'name' => 'relocating_from',
                'label' => 'LBL_RELOCATING_FROM',
                'enabled' => true,
                'default' => false,
              ),
              68 => 
              array (
                'name' => 'rental',
                'label' => 'LBL_RENTAL',
                'enabled' => true,
                'default' => false,
              ),
              69 => 
              array (
                'name' => 'sale_fail_date_c',
                'label' => 'LBL_SALE_FAIL_DATE_C',
                'enabled' => true,
                'default' => false,
              ),
              70 => 
              array (
                'name' => 'sales_cycle_duration',
                'label' => 'LBL_SALES_CYCLE_DURATION',
                'enabled' => true,
                'default' => false,
              ),
              71 => 
              array (
                'name' => 'seller_concessions',
                'label' => 'LBL_SELLER_CONCESSIONS',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              72 => 
              array (
                'name' => 'selling_side',
                'label' => 'LBL_SELLING_SIDE',
                'enabled' => true,
                'default' => false,
              ),
              73 => 
              array (
                'name' => 'signed_around',
                'label' => 'LBL_SIGNED_AROUND',
                'enabled' => true,
                'default' => false,
              ),
              74 => 
              array (
                'name' => 'spec_home_ar',
                'label' => 'LBL_SPEC_HOME_AR',
                'enabled' => true,
                'default' => false,
              ),
              75 => 
              array (
                'name' => 'square_ft',
                'label' => 'LBL_SQUARE_FT',
                'enabled' => true,
                'default' => false,
              ),
              76 => 
              array (
                'name' => 'mkto_sync',
                'label' => 'LBL_MKTO_SYNC',
                'enabled' => true,
                'default' => false,
              ),
              77 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              78 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              79 => 
              array (
                'name' => 'total_upgrades',
                'label' => 'LBL_TOTAL_UPGRADES',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              80 => 
              array (
                'name' => 'transaction_id',
                'label' => 'LBL_TRANSACTION_ID',
                'enabled' => true,
                'default' => false,
              ),
              81 => 
              array (
                'name' => 'upgrades_comments',
                'label' => 'LBL_UPGRADES_COMMENTS',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              82 => 
              array (
                'name' => 'upgrades_due',
                'label' => 'LBL_UPGRADES_DUE',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              83 => 
              array (
                'name' => 'upgrades_received',
                'label' => 'LBL_UPGRADES_RECEIVED',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              84 => 
              array (
                'name' => 'upgrades_received_date',
                'label' => 'LBL_UPGRADES_RECEIVED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              85 => 
              array (
                'name' => 'warranty_exp',
                'label' => 'LBL_WARRANTY_EXP',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              86 => 
              array (
                'name' => 'worst_case',
                'label' => 'LBL_WORST',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
