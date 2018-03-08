<?php
$module_name = 'jckl_FilterSelections';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
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
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              2 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'jckl_filtertemplates_jckl_filterselections_name',
                'label' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERSELECTIONS_FROM_JCKL_FILTERTEMPLATES_TITLE',
                'enabled' => true,
                'id' => 'JCKL_FILTERTEMPLATES_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'filter_options',
                'label' => 'LBL_FILTER_OPTIONS',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'filter_module',
                'label' => 'LBL_FILTER_MODULE',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'filter_name',
                'label' => 'LBL_FILTER_NAME',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'filter_id',
                'label' => 'LBL_FILTER_ID',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'selected_from_user',
                'label' => 'LBL_SELECTED_FROM_USER',
                'enabled' => true,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
