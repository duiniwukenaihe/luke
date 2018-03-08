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

$dictionary['DP_DoucumentsPackets'] = array(
    'table' => 'dp_doucumentspackets',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array ( 
  'packetstatus' => 
  array (
    'required' => false,
    'name' => 'packetstatus',
    'vname' => 'LBL_PACKETSTATUS',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'boost' => '0',
      'enabled' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'sendinguserid' => 
  array (
    'required' => false,
    'name' => 'sendinguserid',
    'vname' => 'LBL_SENDINGUSERID',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'boost' => '0',
      'enabled' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'docusignenvelopeid' => 
  array (
    'required' => false,
    'name' => 'docusignenvelopeid',
    'vname' => 'LBL_DOCUSIGNENVELOPEID',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'boost' => '0',
      'enabled' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'deliveredcontacts' => 
  array (
    'required' => false,
    'name' => 'deliveredcontacts',
    'vname' => 'LBL_DELIVEREDCONTACTS',
    'type' => 'text',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'boost' => '0',
      'enabled' => false,
    ),
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
    'rows' => '',
    'cols' => '',
  ),
  'completedcontacts' => 
  array (
    'required' => false,
    'name' => 'completedcontacts',
    'vname' => 'LBL_COMPLETEDCONTACTS',
    'type' => 'text',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'boost' => '0',
      'enabled' => false,
    ),
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
    'rows' => '',
    'cols' => '',
  ),  
  'document_id_c' => 
    array (
      'required' => false,
      'name' => 'document_id_c',
      'vname' => 'LBL_DOCUMENTPACKETPDF_DOCUMENT_ID',
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
    'documentpacketpdf_c' => 
    array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'documentpacketpdf_c',
      'vname' => 'LBL_DP_DOUCUMENTSPACKETS_DOCUMENT_PACKET_PDF',
      'type' => 'relate',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'full_text_search' => 
      array (
        'boost' => '0',
        'enabled' => false,
      ),
      'calculated' => false,
      'len' => '255',
      'size' => '20',
      'id_name' => 'document_id_c',
      'ext2' => 'Documents',
      'module' => 'Documents',
      'rname' => 'document_name',
      'quicksearch' => 'enabled',
      'studio' => 'visible',
    ),
	'parent_name' => 
    array (
      'name' => 'parent_name',
      'parent_type' => 'record_type_display',
      'type_name' => 'parent_type',
      'id_name' => 'parent_id',
      'vname' => 'LBL_RELATED_TO',
      'type' => 'parent',
      'source' => 'non-db',
      'options' => 'record_type_display_notes',
      'studio' => true,
    ),
	 'parent_type' => 
    array (
      'name' => 'parent_type',
      'vname' => 'LBL_PARENT_TYPE',
      'type' => 'parent_type',
      'dbType' => 'varchar',
      'group' => 'parent_name',
      'options' => 'parent_type_display',
      'len' => '255',
      'studio' => 
      array (
        'wirelesslistview' => false,
      ),
      'comment' => 'Sugar module the Note is associated with',
    ),
    'parent_id' => 
    array (
      'name' => 'parent_id',
      'vname' => 'LBL_PARENT_ID',
      'type' => 'id',
      'required' => false,
      'reportable' => true,
      'comment' => 'The ID of the Sugar item specified in parent_type',
    ),
	
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
);

if (!class_exists('VardefManager')){
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('DP_DoucumentsPackets','DP_DoucumentsPackets', array('basic','team_security','assignable'));