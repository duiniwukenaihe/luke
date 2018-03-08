<?php
$viewdefs['Contacts'] = 
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
              0 => 'account_name',
              1 => 
              array (
                'name' => 'first_name',
                'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="15" maxlength="25" type="text" value="{$fields.first_name.value}">',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              2 => 
              array (
                'name' => 'last_name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              3 => 'title',
              4 => 'phone_mobile',
              5 => 'phone_home',
              6 => 'email',
              7 => 'phone_work',
              8 => 
              array (
                'name' => 'phone_other',
                'comment' => 'Other phone number for the contact',
                'label' => 'LBL_OTHER_PHONE',
              ),
              9 => 
              array (
                'name' => 'phone_fax',
                'comment' => 'Contact fax number',
                'label' => 'LBL_FAX_PHONE',
              ),
              10 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              11 => 
              array (
                'name' => 'subcontractor_email_group_c',
                'label' => 'LBL_SUBCONTRACTOR_EMAIL_GROUP_C',
              ),
              12 => 
              array (
                'name' => 'campaign_name',
                'comment' => 'The first campaign name for Contact (Meta-data only)',
                'label' => 'LBL_CAMPAIGN',
              ),
              13 => 
              array (
                'name' => 'report_to_name',
                'label' => 'LBL_REPORTS_TO',
              ),
              14 => 
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
              15 => 
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
              16 => 'assigned_user_name',
              17 => 'team_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
