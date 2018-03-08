<?php
$viewdefs['Leads'] = 
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
              0 => 'full_name',
              1 => 'title',
              2 => 'phone_mobile',
              3 => 'email',
              4 => 'phone_home',
              5 => 'phone_work',
              6 => 
              array (
                'name' => 'phone_other',
                'comment' => 'Other phone number for the contact',
                'label' => 'LBL_OTHER_PHONE',
              ),
              7 => 
              array (
                'name' => 'website',
                'comment' => 'URL of website for the company',
                'label' => 'LBL_WEBSITE',
              ),
              8 => 'team_name',
              9 => 'assigned_user_name',
              10 => 
              array (
                'name' => 'lead_source_description',
                'comment' => 'Description of the lead source',
                'label' => 'LBL_LEAD_SOURCE_DESCRIPTION',
              ),
              11 => 
              array (
                'span' => 12,
              ),
              12 => 
              array (
                'name' => 'coop_broker',
                'studio' => 'visible',
                'label' => 'LBL_COOP_BROKER',
              ),
              13 => 
              array (
                'name' => 'contacts_leads_1_name',
                'label' => 'LBL_CONTACTS_LEADS_1_FROM_CONTACTS_TITLE',
              ),
              14 => 
              array (
                'span' => 12,
              ),
              15 => 'primary_address_street',
              16 => 'primary_address_city',
              17 => 'primary_address_state',
              18 => 'primary_address_postalcode',
              19 => 'primary_address_country',
              20 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              21 => 
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
              22 => 
              array (
                'name' => 'do_not_call',
                'comment' => 'An indicator of whether contact can be called',
                'label' => 'LBL_DO_NOT_CALL',
              ),
              23 => 
              array (
                'name' => 'buy_sell_home',
                'comment' => '',
                'label' => 'LBL_BUY_SELL_HOME',
              ),
              24 => 
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
              25 => 
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
            ),
          ),
        ),
      ),
    ),
  ),
);
