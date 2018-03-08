<?php

$dictionary["dp_doucumentspackets_cases"] = array (
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
        array (
            'dp_doucumentspackets_cases' =>
                array (
                    'lhs_module' => 'DP_DoucumentsPackets',
                    'lhs_table' => 'dp_doucumentspackets',
                    'lhs_key' => 'id',
                    'rhs_module' => 'Cases',
                    'rhs_table' => 'cases',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'dp_doucumentspackets_cases',
                    'join_key_lhs' => 'dp_doucumentspackets_casesdp_doucumentspackets_ida',
                    'join_key_rhs' => 'dp_doucumentspackets_casescases_idb',
                ),
        ),
    'table' => 'dp_doucumentspackets_cases',
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
            'dp_doucumentspackets_casesdp_doucumentspackets_ida' =>
                array (
                    'name' => 'dp_doucumentspackets_casesdp_doucumentspackets_ida',
                    'type' => 'id',
                ),
            'dp_doucumentspackets_casescases_idb' =>
                array (
                    'name' => 'dp_doucumentspackets_casescases_idb',
                    'type' => 'id',
                ),
        ),
    'indices' =>
        array (
            0 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_cases_pk',
                    'type' => 'primary',
                    'fields' =>
                        array (
                            0 => 'id',
                        ),
                ),
            1 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_cases_ida1_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_casesdp_doucumentspackets_ida',
                            1 => 'deleted',
                        ),
                ),
            2 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_cases_idb2_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_casescases_idb',
                            1 => 'deleted',
                        ),
                ),
            3 =>
                array (
                    'name' => 'dp_doucumentspackets_cases_alt',
                    'type' => 'alternate_key',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_casesdp_doucumentspackets_ida',
                            1 => 'dp_doucumentspackets_casescases_idb',
                        ),
                ),
        ),
);