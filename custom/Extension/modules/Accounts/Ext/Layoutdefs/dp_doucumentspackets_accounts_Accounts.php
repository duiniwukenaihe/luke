<?php
 // created: 2015-09-18 04:41:52
$layout_defs["Accounts"]["subpanel_setup"]['dp_doucumentspackets_accounts'] = array (
  'order' => 100,
  'module' => 'DP_DoucumentsPackets',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DP_DOUCUMENTSPACKETS_ACCOUNTS_FROM_DP_DOUCUMENTSPACKETS_TITLE',
  'get_subpanel_data' => 'dp_doucumentspackets_accounts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
