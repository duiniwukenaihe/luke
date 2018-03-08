<?php
// created: 2015-10-01 14:45:37
//$dictionary["dp_doucumentspackets_opportunities_1"] = array (
//  'true_relationship_type' => 'many-to-many',
//  'from_studio' => true,
//  'relationships' =>
//  array (
//    'dp_doucumentspackets_opportunities_1' =>
//    array (
//      'lhs_module' => 'DP_DoucumentsPackets',
//      'lhs_table' => 'dp_doucumentspackets',
//      'lhs_key' => 'id',
//      'rhs_module' => 'Opportunities',
//      'rhs_table' => 'opportunities',
//      'rhs_key' => 'id',
//      'relationship_type' => 'many-to-many',
//      'join_table' => 'dp_doucumentspackets_opportunities_1_c',
//      'join_key_lhs' => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
//      'join_key_rhs' => 'dp_doucumentspackets_opportunities_1opportunities_idb',
//    ),
//  ),
//  'table' => 'dp_doucumentspackets_opportunities_1_c',
//  'fields' =>
//  array (
//    0 =>
//    array (
//      'name' => 'id',
//      'type' => 'varchar',
//      'len' => 36,
//    ),
//    1 =>
//    array (
//      'name' => 'date_modified',
//      'type' => 'datetime',
//    ),
//    2 =>
//    array (
//      'name' => 'deleted',
//      'type' => 'bool',
//      'len' => '1',
//      'default' => '0',
//      'required' => true,
//    ),
//    3 =>
//    array (
//      'name' => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
//      'type' => 'varchar',
//      'len' => 36,
//    ),
//    4 =>
//    array (
//      'name' => 'dp_doucumentspackets_opportunities_1opportunities_idb',
//      'type' => 'varchar',
//      'len' => 36,
//    ),
//  ),
//  'indices' =>
//  array (
//    0 =>
//    array (
//      'name' => 'dp_doucumentspackets_opportunities_1spk',
//      'type' => 'primary',
//      'fields' =>
//      array (
//        0 => 'id',
//      ),
//    ),
//    1 =>
//    array (
//      'name' => 'dp_doucumentspackets_opportunities_1_alt',
//      'type' => 'alternate_key',
//      'fields' =>
//      array (
//        0 => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
//        1 => 'dp_doucumentspackets_opportunities_1opportunities_idb',
//      ),
//    ),
//  ),
//);
////////////////////////////////////////
$dictionary["dp_doucumentspackets_opportunities_1"] = array (
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
        array (
            'dp_doucumentspackets_opportunities_1' =>
                array (
                    'lhs_module' => 'DP_DoucumentsPackets',
                    'lhs_table' => 'dp_doucumentspackets',
                    'lhs_key' => 'id',
                    'rhs_module' => 'Opportunities',
                    'rhs_table' => 'opportunities',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'dp_doucumentspackets_opportunities_1_c',
                    'join_key_lhs' => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
                    'join_key_rhs' => 'dp_doucumentspackets_opportunities_1opportunities_idb',
                ),
        ),
    'table' => 'dp_doucumentspackets_opportunities_1_c',
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
            'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida' =>
                array (
                    'name' => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
                    'type' => 'id',
                ),
            'dp_doucumentspackets_opportunities_1opportunities_idb' =>
                array (
                    'name' => 'dp_doucumentspackets_opportunities_1opportunities_idb',
                    'type' => 'id',
                ),
        ),
    'indices' =>
        array (
            0 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_opportunities_1_pk',
                    'type' => 'primary',
                    'fields' =>
                        array (
                            0 => 'id',
                        ),
                ),
            1 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_opportunities_1_ida1_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
                            1 => 'deleted',
                        ),
                ),
            2 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_opportunities_1_idb2_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_opportunities_1opportunities_idb',
                            1 => 'deleted',
                        ),
                ),
            3 =>
                array (
                    'name' => 'dp_doucumentspackets_opportunities_1_alt',
                    'type' => 'alternate_key',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_opportunities_1dp_doucumentspackets_ida',
                            1 => 'dp_doucumentspackets_opportunities_1opportunities_idb',
                        ),
                ),
        ),
);