<?php
// created: 2015-09-18 04:41:52
//$dictionary["dp_doucumentspackets_accounts"] = array (
//  'true_relationship_type' => 'many-to-many',
//  'relationships' =>
//  array (
//    'dp_doucumentspackets_accounts' =>
//    array (
//      'lhs_module' => 'DP_DoucumentsPackets',
//      'lhs_table' => 'dp_doucumentspackets',
//      'lhs_key' => 'id',
//      'rhs_module' => 'Accounts',
//      'rhs_table' => 'accounts',
//      'rhs_key' => 'id',
//      'relationship_type' => 'many-to-many',
//      'join_table' => 'dp_doucumentspackets_accounts_c',
//      'join_key_lhs' => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
//      'join_key_rhs' => 'dp_doucumentspackets_accountsaccounts_idb',
//    ),
//  ),
//  'table' => 'dp_doucumentspackets_accounts_c',
//  'fields' =>
//  array (
//    0 =>
//    array (
//      'name' => 'id',
//      'type' => 'id',
//    ),
//    1 =>
//    array (
//      'name' => 'date_modified',
//      'type' => 'datetime',
//    ),
//    2 =>
//    array (
//      'name' => 'deleted',
//        'type' => 'bool',
//        'default' => 0,
//    ),
//    3 =>
//    array (
//      'name' => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
//        'type' => 'id',
//    ),
//    4 =>
//    array (
//      'name' => 'dp_doucumentspackets_accountsaccounts_idb',
//        'type' => 'id',
//    ),
//  ),
//  'indices' =>
//  array (
//    0 =>
//    array (
//      'name' => 'dp_doucumentspackets_accountsspk',
//      'type' => 'primary',
//      'fields' =>
//      array (
//        0 => 'id',
//      ),
//    ),
//    1 =>
//    array (
//      'name' => 'dp_doucumentspackets_accounts_alt',
//      'type' => 'alternate_key',
//      'fields' =>
//      array (
//        0 => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
//        1 => 'dp_doucumentspackets_accountsaccounts_idb',
//      ),
//    ),
//  ),
//);

////////////////////////////////////


$dictionary["dp_doucumentspackets_accounts"] = array (
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
        array (
            'dp_doucumentspackets_accounts' =>
                array (
                    'lhs_module' => 'DP_DoucumentsPackets',
                    'lhs_table' => 'dp_doucumentspackets',
                    'lhs_key' => 'id',
                    'rhs_module' => 'Accounts',
                    'rhs_table' => 'accounts',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'dp_doucumentspackets_accounts_c',
                    'join_key_lhs' => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
                    'join_key_rhs' => 'dp_doucumentspackets_accountsaccounts_idb',
                ),
        ),
    'table' => 'dp_doucumentspackets_accounts_c',
    'fields' =>
        array (
            'id' =>
                array (
                    'name' => 'id',
                    'type' => 'id',
                ),
            'date_modified' =>
                array (
                    'name' => 'date_modified',
                    'type' => 'datetime',
                ),
            'deleted' =>
                array (
                    'name' => 'deleted',
                    'type' => 'bool',
                    'default' => 0,
                ),
            'dp_doucumentspackets_accountsdp_doucumentspackets_ida' =>
                array (
                    'name' => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
                    'type' => 'id',
                ),
            'dp_doucumentspackets_accountsaccounts_idb' =>
                array (
                    'name' => 'dp_doucumentspackets_accountsaccounts_idb',
                    'type' => 'id',
                ),
        ),
    'indices' =>
        array (
            0 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_accounts_pk',
                    'type' => 'primary',
                    'fields' =>
                        array (
                            0 => 'id',
                        ),
                ),
            1 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_accounts_ida1_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
                            1 => 'deleted',
                        ),
                ),
            2 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_accounts_idb2_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_accountsaccounts_idb',
                            1 => 'deleted',
                        ),
                ),
            3 =>
                array (
                    'name' => 'dp_doucumentspackets_accounts_alt',
                    'type' => 'alternate_key',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_accountsdp_doucumentspackets_ida',
                            1 => 'dp_doucumentspackets_accountsaccounts_idb',
                        ),
                ),
        ),
);