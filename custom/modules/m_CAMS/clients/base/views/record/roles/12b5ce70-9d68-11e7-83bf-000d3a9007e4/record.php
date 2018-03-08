<?php
$module_name = 'm_CAMS';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'm_CAMS',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 'name',
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
            ),
          ),
          1 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL9',
            'label' => 'LBL_RECORDVIEW_PANEL9',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
              ),
              1 => 
              array (
                'name' => 'phase',
                'label' => 'LBL_PHASE',
              ),
              2 => 
              array (
                'name' => 'job_number',
                'label' => 'LBL_JOB_NUMBER',
              ),
              3 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
              ),
              4 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
              ),
              5 => 
              array (
                'name' => 'square_footage',
                'label' => 'LBL_SQUARE_FOOTAGE',
              ),
              6 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'primary_address',
                'type' => 'fieldset',
                'comment' => 'The street address used for for primary purposes',
                'label' => 'LBL_PRIMARY_ADDRESS',
                'css_class' => 'address',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'primary_address_street',
                    'css_class' => 'address_street',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_STREET',
                  ),
                  1 => 
                  array (
                    'name' => 'primary_address_city',
                    'css_class' => 'address_city',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_CITY',
                  ),
                  2 => 
                  array (
                    'name' => 'primary_address_state',
                    'css_class' => 'address_state',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_STATE',
                  ),
                  3 => 
                  array (
                    'name' => 'primary_address_postalcode',
                    'css_class' => 'address_zip',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                  ),
                  4 => 
                  array (
                    'name' => 'primary_address_country',
                    'css_class' => 'address_country',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                  ),
                ),
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'opportunity',
                'studio' => 'visible',
                'label' => 'LBL_OPPORTUNITY',
              ),
              1 => 
              array (
                'name' => 'contract_price',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_CONTRACT_PRICE',
              ),
              2 => 
              array (
                'name' => 'sales_stage',
                'label' => 'LBL_SALES_STAGE',
              ),
              3 => 
              array (
                'name' => 'closing_date',
                'label' => 'LBL_CLOSING_DATE',
              ),
              4 => 
              array (
                'name' => 'sale_type',
                'label' => 'LBL_SALE_TYPE',
              ),
              5 => 
              array (
                'name' => 'warranty_exp',
                'label' => 'LBL_WARRANTY_EXP',
              ),
              6 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
              ),
              7 => 
              array (
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL7',
            'label' => 'LBL_RECORDVIEW_PANEL7',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lender',
                'label' => 'LBL_LENDER',
              ),
              1 => 
              array (
                'name' => 'budget_created',
                'label' => 'LBL_BUDGET_CREATED',
              ),
              2 => 
              array (
                'name' => 'loan_status',
                'label' => 'LBL_LOAN_STATUS',
              ),
              3 => 
              array (
                'name' => 'loan_max',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LOAN_MAX',
              ),
              4 => 
              array (
                'name' => 'loan_closed_date',
                'label' => 'LBL_LOAN_CLOSED_DATE',
              ),
              5 => 
              array (
                'name' => 'loan_balance_current',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LOAN_BALANCE_CURRENT',
              ),
              6 => 
              array (
                'name' => 'loan_number',
                'label' => 'LBL_LOAN_NUMBER',
              ),
              7 => 
              array (
                'name' => 'loan_balance_remaining',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LOAN_BALANCE_REMAINING',
              ),
              8 => 
              array (
                'name' => 'loan_comment',
                'studio' => 'visible',
                'label' => 'LBL_LOAN_COMMENT',
              ),
              9 => 
              array (
                'name' => 'loan_maturity_date',
                'label' => 'LBL_LOAN_MATURITY_DATE',
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL6',
            'label' => 'LBL_RECORDVIEW_PANEL6',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'construction_stage',
                'label' => 'LBL_CONSTRUCTION_STAGE',
              ),
              1 => 
              array (
                'name' => 'const_start_date',
                'label' => 'LBL_CONST_START_DATE',
              ),
              2 => 
              array (
                'name' => 'superintendent',
                'label' => 'LBL_SUPERINTENDENT',
              ),
              3 => 
              array (
                'name' => 'const_finish_date',
                'label' => 'LBL_CONST_FINISH_DATE',
              ),
              4 => 
              array (
                'name' => 'construction_note',
                'studio' => 'visible',
                'label' => 'LBL_CONSTRUCTION_NOTE',
              ),
              5 => 
              array (
                'name' => 'total_build_days',
                'label' => 'LBL_TOTAL_BUILD_DAYS',
              ),
              6 => 
              array (
              ),
              7 => 
              array (
                'name' => 'mgr_walk_close_days',
                'label' => 'LBL_MGR_WALK_CLOSE_DAYS',
              ),
              8 => 
              array (
                'name' => 'permit_upload_date',
                'label' => 'LBL_PERMIT_UPLOAD_DATE',
              ),
              9 => 
              array (
                'name' => 'permit_issued_date',
                'label' => 'LBL_PERMIT_ISSUED_DATE',
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'projected_start_date',
                'label' => 'LBL_PROJECTED_START_DATE',
              ),
              1 => 
              array (
                'name' => 'projected_start_month',
                'label' => 'LBL_PROJECTED_START_MONTH',
              ),
              2 => 
              array (
                'name' => 'projected_close_date',
                'label' => 'LBL_PROJECTED_CLOSE_DATE',
              ),
              3 => 
              array (
                'name' => 'project_closing_month',
                'label' => 'LBL_PROJECT_CLOSING_MONTH',
              ),
            ),
          ),
          6 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL10',
            'label' => 'LBL_RECORDVIEW_PANEL10',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'permit_number',
                'label' => 'LBL_PERMIT_NUMBER',
              ),
              1 => 
              array (
                'name' => 'permits_paid_date',
                'label' => 'LBL_PERMITS_PAID_DATE',
              ),
              2 => 
              array (
                'name' => 'permit_total_days',
                'label' => 'LBL_PERMIT_TOTAL_DAYS',
              ),
              3 => 
              array (
              ),
              4 => 
              array (
                'name' => 'permit_status_note',
                'studio' => 'visible',
                'label' => 'LBL_PERMIT_STATUS_NOTE',
                'span' => 12,
              ),
            ),
          ),
          7 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL5',
            'label' => 'LBL_RECORDVIEW_PANEL5',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lot_cost_1',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LOT_COST_1',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'lot_purchase_opportunity',
                'studio' => 'visible',
                'label' => 'LBL_LOT_PURCHASE_OPPORTUNITY',
              ),
              3 => 
              array (
                'name' => 'lot_purchase_addendum',
                'studio' => 'visible',
                'label' => 'LBL_LOT_PURCHASE_ADDENDUM',
              ),
              4 => 
              array (
                'name' => 'lot_inventory_note',
                'studio' => 'visible',
                'label' => 'LBL_LOT_INVENTORY_NOTE',
                'span' => 12,
              ),
            ),
          ),
          8 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'books_closed',
                'label' => 'LBL_BOOKS_CLOSED',
              ),
              1 => 
              array (
                'name' => 'cost_variance_budget',
                'label' => 'LBL_COST_VARIANCE_BUDGET',
              ),
              2 => 
              array (
                'name' => 'gross_margin',
                'label' => 'LBL_GROSS_MARGIN',
              ),
              3 => 
              array (
                'name' => 'actual_hard_lot_costs',
                'label' => 'LBL_ACTUAL_HARD_LOT_COSTS',
              ),
              4 => 
              array (
                'name' => 'actual_hard_costs',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_ACTUAL_HARD_COSTS',
              ),
              5 => 
              array (
                'name' => 'hard_cost_per_sales',
                'label' => 'LBL_HARD_COST_PER_SALES',
              ),
              6 => 
              array (
                'name' => 'actual_lot_cost',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_ACTUAL_LOT_COST',
              ),
              7 => 
              array (
                'name' => 'lot_cost_percent',
                'label' => 'LBL_LOT_COST_PERCENT',
              ),
              8 => 
              array (
                'name' => 'spec_dom',
                'label' => 'LBL_SPEC_DOM',
              ),
              9 => 
              array (
                'name' => 'estimate_errors',
                'label' => 'LBL_ESTIMATE_ERRORS',
              ),
              10 => 
              array (
                'name' => 'job_cost_margin_notes',
                'studio' => 'visible',
                'label' => 'LBL_JOB_COST_MARGIN_NOTES',
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'gcpf',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_GCPF',
              ),
              12 => 
              array (
                'name' => 'price_per_foot',
                'label' => 'LBL_PRICE_PER_FOOT',
              ),
            ),
          ),
          9 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'assigned_user_name',
              1 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
              2 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              3 => 
              array (
                'name' => 'last_activity_time',
                'label' => 'LBL_LAST_ACTIVITY_TIME',
              ),
              4 => 
              array (
                'name' => 'mass_update',
                'label' => 'LBL_MASS_UPDATE',
              ),
              5 => 'team_name',
              6 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => true,
        ),
      ),
    ),
  ),
);
