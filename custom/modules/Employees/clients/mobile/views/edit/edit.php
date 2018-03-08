<?php
$viewdefs['Employees'] = 
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
                'name' => 'employee_status',
                'label' => 'LBL_EMPLOYEE_STATUS',
              ),
              1 => 
              array (
                'name' => 'picture',
                'label' => 'LBL_PICTURE_FILE',
              ),
              2 => 
              array (
                'name' => 'first_name',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              3 => 
              array (
                'name' => 'last_name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              4 => 
              array (
                'name' => 'title',
                'customCode' => '{if $EDIT_TITLE_DEPT}<input type="text" name="{$fields.title.name}" id="{$fields.title.name}" size="30" maxlength="50" value="{$fields.title.value}" title="" tabindex="t" >{else}{$fields.title.value}<input type="hidden" name="{$fields.title.name}" id="{$fields.title.name}" value="{$fields.title.value}">{/if}',
              ),
              5 => 'phone_work',
              6 => 
              array (
                'name' => 'department',
                'customCode' => '{if $EDIT_TITLE_DEPT}<input type="text" name="{$fields.department.name}" id="{$fields.department.name}" size="30" maxlength="50" value="{$fields.department.value}" title="" tabindex="t" >{else}{$fields.department.value}<input type="hidden" name="{$fields.department.name}" id="{$fields.department.name}" value="{$fields.department.value}">{/if}',
              ),
              7 => 'phone_mobile',
              8 => 
              array (
                'name' => 'reports_to_name',
                'label' => 'LBL_REPORTS_TO_NAME',
              ),
              9 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_OTHER_PHONE',
              ),
              10 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
              ),
              11 => 
              array (
                'name' => 'phone_home',
                'label' => 'LBL_HOME_PHONE',
              ),
              12 => 
              array (
                'name' => 'messenger_type',
                'label' => 'LBL_MESSENGER_TYPE',
              ),
              13 => 
              array (
                'name' => 'messenger_id',
                'label' => 'LBL_MESSENGER_ID',
              ),
              14 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
              ),
              15 => 
              array (
                'name' => 'dropbox_access_token_c',
                'label' => 'LBL_DROPBOX_ACCESS_TOKEN_C',
              ),
              16 => 
              array (
                'name' => 'address_street',
                'label' => 'LBL_ADDRESS_STREET',
              ),
              17 => 
              array (
                'name' => 'address_city',
                'label' => 'LBL_ADDRESS_CITY',
              ),
              18 => 
              array (
                'name' => 'address_state',
                'label' => 'LBL_ADDRESS_STATE',
              ),
              19 => 
              array (
                'name' => 'address_country',
                'label' => 'LBL_ADDRESS_COUNTRY',
              ),
              20 => 
              array (
                'name' => 'address_postalcode',
                'label' => 'LBL_ADDRESS_POSTALCODE',
              ),
              21 => 'email',
            ),
          ),
        ),
      ),
    ),
  ),
);
