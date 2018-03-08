<?php
$viewdefs['Leads'] = 
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
                'name' => 'first_name',
                'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 
              array (
                'name' => 'last_name',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              2 => 'title',
              3 => 'phone_mobile',
              4 => 'email',
              5 => 'phone_home',
              6 => 'phone_work',
              7 => 
              array (
                'name' => 'phone_other',
                'comment' => 'Other phone number for the contact',
                'label' => 'LBL_OTHER_PHONE',
              ),
              8 => 
              array (
                'name' => 'website',
                'comment' => 'URL of website for the company',
                'label' => 'LBL_WEBSITE',
              ),
              9 => 'team_name',
              10 => 'assigned_user_name',
              11 => 'status',
              12 => 
              array (
                'name' => 'community',
                'comment' => '',
                'label' => 'LBL_COMMUNITY',
              ),
              13 => 
              array (
                'name' => 'lead_source',
                'comment' => 'Lead source (ex: Web, print)',
                'label' => 'LBL_LEAD_SOURCE',
              ),
              14 => 
              array (
                'name' => 'lead_rating',
                'comment' => '',
                'label' => 'LBL_LEAD_RATING',
              ),
              15 => 
              array (
                'name' => 'lead_source_description',
                'comment' => 'Description of the lead source',
                'label' => 'LBL_LEAD_SOURCE_DESCRIPTION',
              ),
              16 => 
              array (
                'name' => 'coop_broker',
                'studio' => 'visible',
                'label' => 'LBL_COOP_BROKER',
              ),
              17 => 
              array (
                'name' => 'contacts_leads_1_name',
                'label' => 'LBL_CONTACTS_LEADS_1_FROM_CONTACTS_TITLE',
              ),
              18 => 
              array (
                'span' => 12,
              ),
              19 => 'primary_address_street',
              20 => 'primary_address_city',
              21 => 'primary_address_state',
              22 => 'primary_address_postalcode',
              23 => 'primary_address_country',
              24 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              25 => 
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
              26 => 
              array (
                'name' => 'do_not_call',
                'comment' => 'An indicator of whether contact can be called',
                'label' => 'LBL_DO_NOT_CALL',
              ),
              27 => 
              array (
                'name' => 'buy_sell_home',
                'comment' => '',
                'label' => 'LBL_BUY_SELL_HOME',
              ),
              28 => 
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
              29 => 
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
