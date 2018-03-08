<?php
$viewdefs['Notes'] = 
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
                'label' => 'LBL_LIST_SUBJECT',
                'link' => true,
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'contact_name',
                'label' => 'LBL_LIST_CONTACT',
                'link' => true,
                'id' => 'CONTACT_ID',
                'module' => 'Contacts',
                'enabled' => true,
                'default' => true,
                'ACLTag' => 'CONTACT',
                'related_fields' => 
                array (
                  0 => 'contact_id',
                ),
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
                'name' => 'filename',
                'label' => 'LBL_LIST_FILENAME',
                'enabled' => true,
                'default' => true,
                'type' => 'file',
                'related_fields' => 
                array (
                  0 => 'file_url',
                  1 => 'id',
                  2 => 'file_mime_type',
                ),
                'displayParams' => 
                array (
                  'module' => 'Notes',
                ),
              ),
              4 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO',
                'enabled' => true,
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'created_by_name',
                'type' => 'relate',
                'label' => 'LBL_CREATED_BY',
                'enabled' => true,
                'default' => false,
                'related_fields' => 
                array (
                  0 => 'created_by',
                ),
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'file_url',
                'label' => 'LBL_FILE_URL',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'contact_phone',
                'label' => 'LBL_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
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
