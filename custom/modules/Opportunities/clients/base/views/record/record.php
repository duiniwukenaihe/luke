<?php
$viewdefs['Opportunities'] = 
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
                'acl_module' => 'Opportunities',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:historical_summary_button:click',
                'name' => 'historical_summary_button',
                'label' => 'LBL_HISTORICAL_SUMMARY',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              9 => 
              array (
                'type' => 'divider',
              ),
              10 => 
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
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'related_fields' => 
                array (
                  0 => 'total_revenue_line_items',
                  1 => 'closed_revenue_line_items',
                  2 => 'included_revenue_line_items',
                ),
              ),
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
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
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'job_code',
                'studio' => true,
                'label' => 'LBL_JOB_CODE',
              ),
              1 => 
              array (
                'name' => 'amount',
                'type' => 'currency',
                'label' => 'LBL_LIKELY',
                'related_fields' => 
                array (
                  0 => 'amount',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'span' => 6,
              ),
              2 => 
              array (
                'name' => 'pending_date',
                'label' => 'LBL_PENDING_DATE',
              ),
              3 => 
              array (
                'name' => 'date_closed',
                'related_fields' => 
                array (
                  0 => 'date_closed_timestamp',
                ),
              ),
              4 => 
              array (
                'name' => 'account_name',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
              ),
              5 => 
              array (
                'name' => 'warranty_exp',
                'label' => 'LBL_WARRANTY_EXP',
              ),
              6 => 
              array (
                'name' => 'sales_stage',
              ),
              7 => 
              array (
                'name' => 'selling_side',
                'label' => 'LBL_SELLING_SIDE',
              ),
              8 => 
              array (
                'name' => 'sale_fail_date_c',
                'label' => 'LBL_SALE_FAIL_DATE_C',
                'span' => 12,
              ),
              9 => 
              array (
                'name' => 'opportunity_type',
              ),
              10 => 
              array (
                'name' => 'assigned_user_name',
              ),
              11 => 
              array (
                'name' => 'address',
                'type' => 'fieldset',
                'comment' => 'The street address used for for primary purposes',
                'label' => 'LBL_ADDRESS',
                'css_class' => 'address',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'address_street',
                    'css_class' => 'address_street',
                    'placeholder' => 'LBL_ADDRESS_STREET',
                  ),
                  1 => 
                  array (
                    'name' => 'address_city',
                    'css_class' => 'address_city',
                    'placeholder' => 'LBL_ADDRESS_CITY',
                  ),
                  2 => 
                  array (
                    'name' => 'address_state',
                    'css_class' => 'address_state',
                    'placeholder' => 'LBL_ADDRESS_STATE',
                  ),
                  3 => 
                  array (
                    'name' => 'address_postalcode',
                    'css_class' => 'address_zip',
                    'placeholder' => 'LBL_ADDRESS_POSTALCODE',
                  ),
                  4 => 
                  array (
                    'name' => 'address_country',
                    'css_class' => 'address_country',
                    'placeholder' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                  ),
                ),
              ),
              12 => 
              array (
                'name' => 'team_name',
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
                'name' => 'builder',
                'label' => 'LBL_BUILDER',
              ),
              1 => 
              array (
                'name' => 'm_cams_opportunities_1_name',
                'label' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE',
              ),
              2 => 
              array (
                'name' => 'community',
                'label' => 'LBL_COMMUNITY',
              ),
              3 => 
              array (
                'name' => 'phase',
                'label' => 'LBL_PHASE',
              ),
              4 => 
              array (
                'name' => 'floor_plan',
                'label' => 'LBL_FLOOR_PLAN',
              ),
              5 => 
              array (
                'name' => 'elevation',
                'label' => 'LBL_ELEVATION',
              ),
              6 => 
              array (
                'name' => 'square_ft',
                'studio' => true,
                'label' => 'LBL_SQUARE_FT',
              ),
              7 => 
              array (
                'name' => 'garage_type',
                'label' => 'LBL_GARAGE_TYPE',
              ),
              8 => 
              array (
                'name' => 'cam_const_finish_mgr_c',
                'label' => 'LBL_CAM_CONST_FINISH_MGR',
              ),
              9 => 
              array (
                'name' => 'cam_permit_num_c',
                'label' => 'LBL_CAM_PERMIT_NUM',
              ),
              10 => 
              array (
                'name' => 'cam_construction_stage_c',
                'label' => 'LBL_CAM_CONSTRUCTION_STAGE',
              ),
              11 => 
              array (
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'precon',
                'label' => 'LBL_PRECON',
              ),
              1 => 
              array (
                'name' => 'orientation',
                'label' => 'LBL_ORIENTATION',
              ),
              2 => 
              array (
                'name' => 'inspection',
                'label' => 'LBL_INSPECTION',
              ),
              3 => 
              array (
                'name' => 'seller_concessions',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_SELLER_CONCESSIONS',
              ),
              4 => 
              array (
                'name' => 'financing',
                'label' => 'LBL_FINANCING',
              ),
              5 => 
              array (
                'name' => 'proof_of_funds',
                'label' => 'LBL_PROOF_OF_FUNDS',
              ),
              6 => 
              array (
                'name' => 'mls_id',
                'studio' => true,
                'label' => 'LBL_MLS_ID',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'contigent_offer',
                'label' => 'LBL_CONTIGENT_OFFER',
              ),
              8 => 
              array (
                'name' => 'contingency_expiration',
                'label' => 'LBL_CONTINGENCY_EXPIRATION',
              ),
              9 => 
              array (
                'name' => 'contingency_notes',
                'label' => 'LBL_CONTINGENCY_NOTES',
                'span' => 12,
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => true,
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
                'name' => 'em_due',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_EM_DUE',
              ),
              1 => 
              array (
                'name' => 'em_received_date',
                'label' => 'LBL_EM_RECEIVED_DATE',
              ),
              2 => 
              array (
                'name' => 'em_comments',
                'label' => 'LBL_EM_COMMENTS',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'total_upgrades',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_TOTAL_UPGRADES',
              ),
              4 => 
              array (
                'name' => 'upgrades_received_date',
                'label' => 'LBL_UPGRADES_RECEIVED_DATE',
              ),
              5 => 
              array (
                'name' => 'upgrades_due',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_UPGRADES_DUE',
              ),
              6 => 
              array (
                'name' => 'upgrades_received',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_UPGRADES_RECEIVED',
              ),
              7 => 
              array (
                'name' => 'upgrades_comments',
                'label' => 'LBL_UPGRADES_COMMENTS',
                'span' => 12,
              ),
            ),
          ),
          5 => 
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
                'name' => 'listing_commission_percent',
                'label' => 'LBL_LISTING_COMMISSION_PERCENT',
              ),
              1 => 
              array (
                'name' => 'listing_firm_comm',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LISTING_FIRM_COMM',
              ),
              2 => 
              array (
                'name' => 'commission_percent',
                'label' => 'LBL_COMMISSION_PERCENT',
              ),
              3 => 
              array (
                'name' => 'selling_broker_comm',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_SELLING_BROKER_COMM',
              ),
              4 => 
              array (
                'name' => 'commission_note',
                'label' => 'LBL_COMMISSION_NOTE',
                'span' => 12,
              ),
              5 => 
              array (
                'name' => 'early_comm_payout',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_EARLY_COMM_PAYOUT',
              ),
              6 => 
              array (
                'name' => 'early_comm_date',
                'label' => 'LBL_EARLY_COMM_DATE',
              ),
            ),
          ),
          6 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL6',
            'label' => 'LBL_RECORDVIEW_PANEL6',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'lead_source',
              1 => 
              array (
                'name' => 'customer_age',
                'label' => 'LBL_CUSTOMER_AGE',
              ),
              2 => 
              array (
                'name' => 'other_builders',
                'label' => 'LBL_OTHER_BUILDERS',
              ),
              3 => 
              array (
                'name' => 'rental',
                'label' => 'LBL_RENTAL',
              ),
              4 => 
              array (
                'name' => 'relocating',
                'label' => 'LBL_RELOCATING',
              ),
              5 => 
              array (
                'name' => 'relocating_from',
                'label' => 'LBL_RELOCATING_FROM',
              ),
              6 => 
              array (
                'name' => 'buy_sell_12mo',
                'label' => 'LBL_BUY_SELL_12MO',
              ),
              7 => 
              array (
                'name' => 'promotion',
                'label' => 'LBL_PROMOTION',
              ),
              8 => 
              array (
                'name' => 'differentiator',
                'label' => 'LBL_DIFFERENTIATOR',
                'span' => 12,
              ),
              9 => 
              array (
                'name' => 'marketing_notes',
                'label' => 'LBL_MARKETING_NOTES',
                'span' => 12,
              ),
            ),
          ),
          7 => 
          array (
            'newTab' => true,
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
                'name' => 'transaction_id',
                'label' => 'LBL_TRANSACTION_ID',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'modified_by_name',
                'readonly' => true,
                'label' => 'LBL_MODIFIED',
              ),
              3 => 
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
              4 => 
              array (
                'name' => 'created_by_name',
                'readonly' => true,
                'label' => 'LBL_CREATED',
              ),
              5 => 
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
              6 => 
              array (
                'name' => 'tag',
                'span' => 6,
              ),
              7 => 
              array (
                'name' => 'overall_sales_duration',
                'studio' => true,
                'label' => 'LBL_OVERALL_SALES_DURATION',
                'span' => 6,
              ),
              8 => 
              array (
                'name' => 'lead_conversion_time',
                'studio' => true,
                'label' => 'LBL_LEAD_CONVERSION_TIME',
              ),
              9 => 
              array (
                'name' => 'sales_cycle_duration',
                'studio' => true,
                'label' => 'LBL_SALES_CYCLE_DURATION',
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
