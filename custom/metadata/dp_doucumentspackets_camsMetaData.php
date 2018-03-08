<?php
$dictionary["dp_doucumentspackets_m_cams"] = array (
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
        array (
            'dp_doucumentspackets_m_cams' =>
                array (
                    'lhs_module' => 'DP_DoucumentsPackets',
                    'lhs_table' => 'dp_doucumentspackets',
                    'lhs_key' => 'id',
                    'rhs_module' => 'm_CAMS',
                    'rhs_table' => 'm_cams',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'dp_doucumentspackets_m_cams',
                    'join_key_lhs' => 'dp_doucumentspackets_m_camsdp_doucumentspackets_ida',
                    'join_key_rhs' => 'dp_doucumentspackets_m_camsm_cams_idb',
                ),
        ),
    'table' => 'dp_doucumentspackets_m_cams',
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
            'dp_doucumentspackets_m_camsdp_doucumentspackets_ida' =>
                array (
                    'name' => 'dp_doucumentspackets_m_camsdp_doucumentspackets_ida',
                    'type' => 'id',
                ),
            'dp_doucumentspackets_m_camsm_cams_idb' =>
                array (
                    'name' => 'dp_doucumentspackets_m_camsm_cams_idb',
                    'type' => 'id',
                ),
        ),
    'indices' =>
        array (
            0 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_m_cams_pk',
                    'type' => 'primary',
                    'fields' =>
                        array (
                            0 => 'id',
                        ),
                ),
            1 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_m_cams_ida1_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_m_camsdp_doucumentspackets_ida',
                            1 => 'deleted',
                        ),
                ),
            2 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_m_cams_idb2_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_m_camsm_cams_idb',
                            1 => 'deleted',
                        ),
                ),
            3 =>
                array (
                    'name' => 'dp_doucumentspackets_m_cams_alt',
                    'type' => 'alternate_key',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_m_camsdp_doucumentspackets_ida',
                            1 => 'dp_doucumentspackets_m_camsm_cams_idb',
                        ),
                ),
        ),
);