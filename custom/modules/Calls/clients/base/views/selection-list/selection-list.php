<?php
$viewdefs['Calls'] = 
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
                'label' => 'LBL_LIST_SUBJECT',
                'enabled' => true,
                'default' => true,
                'link' => true,
                'name' => 'name',
              ),
              1 => 
              array (
                'label' => 'LBL_STATUS',
                'enabled' => true,
                'default' => true,
                'name' => 'status',
                'type' => 'event-status',
                'css_class' => 'full-width',
              ),
              2 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_LIST_RELATED_TO',
                'dynamic_module' => 'PARENT_TYPE',
                'id' => 'PARENT_ID',
                'link' => true,
                'enabled' => true,
                'default' => true,
                'sortable' => false,
                'ACLTag' => 'PARENT',
                'related_fields' => 
                array (
                  0 => 'parent_id',
                  1 => 'parent_type',
                ),
              ),
              3 => 
              array (
                'label' => 'LBL_LIST_DATE',
                'enabled' => true,
                'default' => true,
                'name' => 'date_start',
              ),
              4 => 
              array (
                'name' => 'accept_status',
                'label' => 'LBL_ACCEPT_STATUS',
                'enabled' => true,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'target_record_key' => 'assigned_user_id',
                'target_module' => 'Employees',
                'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                'enabled' => true,
                'default' => false,
                'sortable' => false,
              ),
              6 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'email_reminder_time',
                'label' => 'LBL_EMAIL_REMINDER_TIME',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'label' => 'LBL_DATE_END',
                'enabled' => true,
                'default' => false,
                'name' => 'date_end',
              ),
              12 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'reminder_time',
                'label' => 'LBL_POPUP_REMINDER_TIME',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'send_invites',
                'label' => 'LBL_SEND_INVITES',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAMS',
                'enabled' => true,
                'id' => 'TEAM_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
