<?php

$dictionary['m_CAMS']['fields']['account_name'] = array(
    'source' => 'non-db',
    'name' => 'account_name',
    'vname' => 'LBL_ACCOUNT_NAME',
    'type' => 'relate',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 255,
    'size' => '20',
    'id_name' => 'account_id',
    'module' => 'Accounts',
    'table' => 'accounts',
    'rname' => 'name',
    'quicksearch' => 'enabled',
    'readonly' => true,
);

$dictionary['m_CAMS']['fields']['account_id'] = array(
    'name' => 'account_id',
    'vname' => 'LBL_ACCOUNT_NAME_ACCOUNT_ID',
    'type' => 'id',
    'dbType' => 'id',
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
);

$dictionary['m_CAMS']['fields']['accounts'] = array(
    'name' => 'accounts',
    'vname' => 'LBL_Account',
    'source' => 'non-db',
    'type' => 'link',
    'bean_name' => 'Account',
    'relationship' => 'account_cams_relation',
    'module' => 'Accounts',
);
$dictionary['m_CAMS']['relationships']['account_cams_relation'] = array(
    'name' => 'account_cams_relation',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'm_CAMS',
    'rhs_table' => 'm_cams',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
);