<?php
$module_name = 'm_CAMS';
$viewdefs[$module_name] = 
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'actual_hard_lot_costs',
                'label' => 'LBL_ACTUAL_HARD_LOT_COSTS',
                'enabled' => true,
                'default' => false,
              ),
              2 => 
              array (
                'name' => 'actual_hard_costs',
                'label' => 'LBL_ACTUAL_HARD_COSTS',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              3 => 
              array (
                'name' => 'actual_lot_cost',
                'label' => 'LBL_ACTUAL_LOT_COST',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              4 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              5 => 
              array (
                'name' => 'books_closed',
                'label' => 'LBL_BOOKS_CLOSED',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'budget_created',
                'label' => 'LBL_BUDGET_CREATED',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'primary_address_city',
                'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'closing_date',
                'label' => 'LBL_CLOSING_DATE',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'const_finish_date',
                'label' => 'LBL_CONST_FINISH_DATE',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'construction_note',
                'label' => 'LBL_CONSTRUCTION_NOTE',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'construction_stage',
                'label' => 'LBL_CONSTRUCTION_STAGE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'const_start_date',
                'label' => 'LBL_CONST_START_DATE',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'contract_price',
                'label' => 'LBL_CONTRACT_PRICE',
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
                'name' => 'cost_variance_budget',
                'label' => 'LBL_COST_VARIANCE_BUDGET',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'primary_address_country',
                'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'dri_workflow_template_name',
                'label' => 'LBL_DRI_WORKFLOW_TEMPLATE',
                'enabled' => true,
                'id' => 'DRI_WORKFLOW_TEMPLATE_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              20 => 
              array (
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'default' => false,
                'name' => 'date_modified',
                'readonly' => true,
              ),
              21 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              22 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'equity_requirement_c',
                'label' => 'LBL_EQUITY_REQUIREMENT',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'estimate_errors',
                'label' => 'LBL_ESTIMATE_ERRORS',
                'enabled' => true,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
                'enabled' => true,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'gcpf',
                'label' => 'LBL_GCPF',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              28 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              29 => 
              array (
                'name' => 'gross_margin',
                'label' => 'LBL_GROSS_MARGIN',
                'enabled' => true,
                'default' => false,
              ),
              30 => 
              array (
                'name' => 'hard_cost_per_sales',
                'label' => 'LBL_HARD_COST_PER_SALES',
                'enabled' => true,
                'default' => false,
              ),
              31 => 
              array (
                'name' => 'job_cost_margin_notes',
                'label' => 'LBL_JOB_COST_MARGIN_NOTES',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              32 => 
              array (
                'name' => 'job_number',
                'label' => 'LBL_JOB_NUMBER',
                'enabled' => true,
                'default' => false,
              ),
              33 => 
              array (
                'name' => 'primary_address_street_4',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_4',
                'enabled' => true,
                'default' => false,
              ),
              34 => 
              array (
                'name' => 'last_activity_time',
                'label' => 'LBL_LAST_ACTIVITY_TIME',
                'enabled' => true,
                'default' => false,
              ),
              35 => 
              array (
                'name' => 'lender',
                'label' => 'LBL_LENDER',
                'enabled' => true,
                'default' => false,
              ),
              36 => 
              array (
                'name' => 'list_price_c',
                'label' => 'LBL_LIST_PRICE',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              37 => 
              array (
                'name' => 'list_price_by_name_c',
                'label' => 'LBL_LIST_PRICE_BY_NAME',
                'enabled' => true,
                'default' => false,
              ),
              38 => 
              array (
                'name' => 'list_price_date_c',
                'label' => 'LBL_LIST_PRICE_DATE',
                'enabled' => true,
                'default' => false,
              ),
              39 => 
              array (
                'name' => 'loan_balance_current',
                'label' => 'LBL_LOAN_BALANCE_CURRENT',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              40 => 
              array (
                'name' => 'loan_balance_remaining',
                'label' => 'LBL_LOAN_BALANCE_REMAINING',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              41 => 
              array (
                'name' => 'loan_closed_date',
                'label' => 'LBL_LOAN_CLOSED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              42 => 
              array (
                'name' => 'loan_comment',
                'label' => 'LBL_LOAN_COMMENT',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              43 => 
              array (
                'name' => 'loan_maturity_date',
                'label' => 'LBL_LOAN_MATURITY_DATE',
                'enabled' => true,
                'default' => false,
              ),
              44 => 
              array (
                'name' => 'loan_max',
                'label' => 'LBL_LOAN_MAX',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => false,
              ),
              45 => 
              array (
                'name' => 'loan_number',
                'label' => 'LBL_LOAN_NUMBER',
                'enabled' => true,
                'default' => false,
              ),
              46 => 
              array (
                'name' => 'loan_status',
                'label' => 'LBL_LOAN_STATUS',
                'enabled' => true,
                'default' => false,
              ),
              47 => 
              array (
                'name' => 'lot_cost_percent',
                'label' => 'LBL_LOT_COST_PERCENT',
                'enabled' => true,
                'default' => false,
              ),
              48 => 
              array (
                'name' => 'lot_inventory_note',
                'label' => 'LBL_LOT_INVENTORY_NOTE',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              49 => 
              array (
                'name' => 'lot_purchase_addendum',
                'label' => 'LBL_LOT_PURCHASE_ADDENDUM',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              50 => 
              array (
                'name' => 'lot_purchase_opportunity',
                'label' => 'LBL_LOT_PURCHASE_OPPORTUNITY',
                'enabled' => true,
                'id' => 'OPPORTUNITY_ID1_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              51 => 
              array (
                'name' => 'mgr_walk_close_days',
                'label' => 'LBL_MGR_WALK_CLOSE_DAYS',
                'enabled' => true,
                'default' => false,
              ),
              52 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              53 => 
              array (
                'name' => 'm_cams_opportunities_1_name',
                'label' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
                'enabled' => true,
                'id' => 'M_CAMS_OPPORTUNITIES_1OPPORTUNITIES_IDB',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              54 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
                'enabled' => true,
                'default' => false,
              ),
              55 => 
              array (
                'name' => 'permit_issued_date',
                'label' => 'LBL_PERMIT_ISSUED_DATE',
                'enabled' => true,
                'default' => false,
              ),
              56 => 
              array (
                'name' => 'permit_number',
                'label' => 'LBL_PERMIT_NUMBER',
                'enabled' => true,
                'default' => false,
              ),
              57 => 
              array (
                'name' => 'permit_status_note',
                'label' => 'LBL_PERMIT_STATUS_NOTE',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              58 => 
              array (
                'name' => 'permit_total_days',
                'label' => 'LBL_PERMIT_TOTAL_DAYS',
                'enabled' => true,
                'default' => false,
              ),
              59 => 
              array (
                'name' => 'permit_upload_date',
                'label' => 'LBL_PERMIT_UPLOAD_DATE',
                'enabled' => true,
                'default' => false,
              ),
              60 => 
              array (
                'name' => 'permits_paid_date',
                'label' => 'LBL_PERMITS_PAID_DATE',
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
                'name' => 'primary_address_postalcode',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'enabled' => true,
                'default' => false,
              ),
              63 => 
              array (
                'name' => 'pre_start_status_c',
                'label' => 'LBL_PRE_START_STATUS',
                'enabled' => true,
                'default' => false,
              ),
              64 => 
              array (
                'name' => 'price_per_foot',
                'label' => 'LBL_PRICE_PER_FOOT',
                'enabled' => true,
                'default' => false,
              ),
              65 => 
              array (
                'name' => 'primary_address_street_2',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_2',
                'enabled' => true,
                'default' => false,
              ),
              66 => 
              array (
                'name' => 'primary_address_street_3',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET_3',
                'enabled' => true,
                'default' => false,
              ),
              67 => 
              array (
                'name' => 'projected_close_date',
                'label' => 'LBL_PROJECTED_CLOSE_DATE',
                'enabled' => true,
                'default' => false,
              ),
              68 => 
              array (
                'name' => 'projected_margin_c',
                'label' => 'LBL_PROJECTED_MARGIN',
                'enabled' => true,
                'default' => false,
              ),
              69 => 
              array (
                'name' => 'projected_start_date',
                'label' => 'LBL_PROJECTED_START_DATE',
                'enabled' => true,
                'default' => false,
              ),
              70 => 
              array (
                'name' => 'sale_type',
                'label' => 'LBL_SALE_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              71 => 
              array (
                'name' => 'sales_stage',
                'label' => 'LBL_SALES_STAGE',
                'enabled' => true,
                'default' => false,
              ),
              72 => 
              array (
                'name' => 'spec_dom',
                'label' => 'LBL_SPEC_DOM',
                'enabled' => true,
                'default' => false,
              ),
              73 => 
              array (
                'name' => 'square_footage',
                'label' => 'LBL_SQUARE_FOOTAGE',
                'enabled' => true,
                'default' => false,
              ),
              74 => 
              array (
                'name' => 'primary_address_state',
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'enabled' => true,
                'default' => false,
              ),
              75 => 
              array (
                'name' => 'primary_address_street',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              76 => 
              array (
                'name' => 'superintendent',
                'label' => 'LBL_SUPERINTENDENT',
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
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              79 => 
              array (
                'name' => 'total_build_days',
                'label' => 'LBL_TOTAL_BUILD_DAYS',
                'enabled' => true,
                'default' => false,
              ),
              80 => 
              array (
                'name' => 'warranty_exp',
                'label' => 'LBL_WARRANTY_EXP',
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
