<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$dictionary['jckl_FilterSelections'] = array(
    'table' => 'jckl_filterselections',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'user_id_c' => 
  array (
    'required' => true,
    'name' => 'user_id_c',
    'vname' => 'LBL_SELECTED_FROM_USER_USER_ID',
    'type' => 'id',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 36,
    'size' => '20',
  ),
  'selected_from_user' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'selected_from_user',
    'vname' => 'LBL_SELECTED_FROM_USER',
    'type' => 'relate',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'id_name' => 'user_id_c',
    'ext2' => 'Users',
    'module' => 'Users',
    'rname' => 'name',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
  ),
  'filter_id' => 
  array (
    'required' => false,
    'name' => 'filter_id',
    'vname' => 'LBL_FILTER_ID',
    'type' => 'varchar',
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '50',
    'size' => '20',
  ),
  'filter_name' => 
  array (
    'required' => false,
    'name' => 'filter_name',
    'vname' => 'LBL_FILTER_NAME',
    'type' => 'varchar',
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'dependency' => 'greaterThan(strlen($selected_from_user),2)',
  ),
  'filter_module' => 
  array (
    'required' => false,
    'name' => 'filter_module',
    'vname' => 'LBL_FILTER_MODULE',
    'type' => 'varchar',
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'filter_options' =>
      array (
          'name' => 'filter_options',
          'vname' => 'LBL_FILTER_OPTIONS',
          'type' => 'enum',
          'source' => 'non-db',
          'len' => 100,
          'options' => 'jckl_filter_options',
          'comment' => '',
          'required' => true,
          'importable' => 'true',
          'default' => '',
          'duplicate_on_record_copy' => 'no',
          'dependency' => 'greaterThan(strlen($selected_from_user),2)',
          'full_text_search' =>
              array('enabled' => '0',
                                      'boost' => '1',
                                      'searchable' => false,),
      ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,

);

if (!class_exists('VardefManager')){
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('jckl_FilterSelections','jckl_FilterSelections', array('basic','assignable','taggable'));