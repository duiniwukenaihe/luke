<?php
$module_name = 'jckl_FilterSelections';
$subpanel_layout = 
array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'jckl_FilterSelections',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'selected_from_user' => 
    array (
      'type' => 'relate',
      'studio' => 'visible',
      'vname' => 'LBL_SELECTED_FROM_USER',
      'id' => 'USER_ID_C',
      'link' => true,
      'width' => '10%',
      'default' => true,
      'widget_class' => 'SubPanelDetailViewLink',
      'target_module' => 'Users',
      'target_record_key' => 'user_id_c',
    ),
    'filter_name' => 
    array (
      'type' => 'varchar',
      'default' => true,
      'vname' => 'LBL_FILTER_NAME',
      'width' => '10%',
    ),
    'filter_module' => 
    array (
      'type' => 'varchar',
      'default' => true,
      'vname' => 'LBL_FILTER_MODULE',
      'width' => '10%',
    ),
    'date_modified' => 
    array (
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => true,
    ),
    'edit_button' => 
    array (
      'vname' => 'LBL_EDIT_BUTTON',
      'widget_class' => 'SubPanelEditButton',
      'module' => 'jckl_FilterSelections',
      'width' => '4%',
    ),
    'remove_button' => 
    array (
      'vname' => 'LBL_REMOVE',
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'jckl_FilterSelections',
      'width' => '5%',
    ),
  ),
);
