<?php
$viewdefs['Contacts'] = 
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
              0 => 'account_name',
              1 => 
              array (
                'name' => 'first_name',
                'comment' => 'First name of the contact',
                'label' => 'LBL_FIRST_NAME',
              ),
              2 => 
              array (
                'name' => 'last_name',
                'comment' => 'Last name of the contact',
                'label' => 'LBL_LAST_NAME',
              ),
              3 => 'title',
              4 => 'phone_mobile',
              5 => 'phone_home',
              6 => 'email',
              7 => 'phone_work',
              8 => 
              array (
                'name' => 'phone_fax',
                'comment' => 'Contact fax number',
                'label' => 'LBL_FAX_PHONE',
              ),
              9 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              10 => 
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
