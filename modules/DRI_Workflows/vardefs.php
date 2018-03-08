<?php

$dictionary['DRI_Workflow'] = array (
    'table' => 'dri_workflows',
    'audited' => true,
    'unified_search' => true,
    'duplicate_merge' => true,
    'comment' => 'DRI_Workflow',
    'fields' => array (),
    'relationships' => array (),
    'indices' => array (),
    'optimistic_lock' => true,
    'uses' => array (
        'default',
        'assignable',
        'team_security',
    ),
);

VardefManager::createVardef(
    'DRI_Workflows',
    'DRI_Workflow'
);

require_once 'modules/DRI_Workflows/VardefManager.php';

DRI_Workflows\VardefManager::addParent(array (
    'module_name' => 'Accounts',
    'object_name' => 'Account',
    'table_name' => 'accounts',
    'rank' => 0,
));

DRI_Workflows\VardefManager::addParent(array (
    'module_name' => 'Contacts',
    'object_name' => 'Contact',
    'table_name' => 'contacts',
    'rank' => 10,
));

DRI_Workflows\VardefManager::addParent(array (
    'module_name' => 'Leads',
    'object_name' => 'Lead',
    'table_name' => 'leads',
    'rank' => 20,
));

DRI_Workflows\VardefManager::addParent(array (
    'module_name' => 'Opportunities',
    'object_name' => 'Opportunity',
    'table_name' => 'opportunities',
    'rank' => 30,
));

DRI_Workflows\VardefManager::addParent(array (
    'module_name' => 'Cases',
    'object_name' => 'Case',
    'bean_name' => 'aCase',
    'table_name' => 'cases',
    'rank' => 40,
));
