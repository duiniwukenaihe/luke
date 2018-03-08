<?php
$module_name = 'jckl_FilterSelections';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'form' => 
          array (
            'buttons' => 
            array (
              0 => 'EDIT',
              1 => 'DUPLICATE',
              2 => 'DELETE',
            ),
          ),
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
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
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'name',
              1 => 'assigned_user_name',
              2 => 
              array (
                'name' => 'selected_from_user',
                'studio' => 'visible',
                'label' => 'LBL_SELECTED_FROM_USER',
              ),
              3 => 
              array (
                'name' => 'filter_id',
                'label' => 'LBL_FILTER_ID',
              ),
              4 => 
              array (
                'name' => 'filter_module',
                'label' => 'LBL_FILTER_MODULE',
              ),
              5 => 
              array (
                'name' => 'filter_name',
                'label' => 'LBL_FILTER_NAME',
              ),
              6 => 
              array (
                'name' => 'jckl_filtertemplates_jckl_filterselections_name',
                'label' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERSELECTIONS_FROM_JCKL_FILTERTEMPLATES_TITLE',
              ),
              7 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'label' => 'LBL_DESCRIPTION',
              ),
              8 => 
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
              9 => 
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
            ),
          ),
        ),
      ),
    ),
  ),
);
