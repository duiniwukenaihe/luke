<?php
// created: 2017-05-02 13:51:35
$viewdefs['jckl_FilterSelections']['base']['view']['subpanel-list'] = array (
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
          'name' => 'selected_from_user',
          'label' => 'LBL_SELECTED_FROM_USER',
          'enabled' => true,
          'id' => 'USER_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'filter_name',
          'label' => 'LBL_FILTER_NAME',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'name',
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
);