<?php

// created: 2018-01-23 17:41:33
    $dictionary["dp_doucumentspackets_mv_attachments_1"] = array(
        'true_relationship_type' => 'one-to-one',
        'from_studio' => true,
        'relationships' =>
        array(
            'dp_doucumentspackets_mv_attachments_1' =>
            array(
                'lhs_module' => 'DP_DoucumentsPackets',
                'lhs_table' => 'dp_doucumentspackets',
                'lhs_key' => 'id',
                'rhs_module' => 'mv_Attachments',
                'rhs_table' => 'mv_attachments',
                'rhs_key' => 'id',
                'relationship_type' => 'many-to-many',
                'join_table' => 'dp_doucumentspackets_mv_attachments_1_c',
                'join_key_lhs' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
                'join_key_rhs' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
            ),
        ),
        'table' => 'dp_doucumentspackets_mv_attachments_1_c',
        'fields' =>
        array(
            'id' =>
            array(
                'name' => 'id',
                'type' => 'id',
            ),
            'date_modified' =>
            array(
                'name' => 'date_modified',
                'type' => 'datetime',
            ),
            'deleted' =>
            array(
                'name' => 'deleted',
                'type' => 'bool',
                'default' => 0,
            ),
            'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida' =>
            array(
                'name' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
                'type' => 'id',
            ),
            'dp_doucumentspackets_mv_attachments_1mv_attachments_idb' =>
            array(
                'name' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
                'type' => 'id',
            ),
        ),
        'indices' =>
        array(
            0 =>
            array(
                'name' => 'idx_dp_doucumentspackets_mv_attachments_1_pk',
                'type' => 'primary',
                'fields' =>
                array(
                    0 => 'id',
                ),
            ),
            1 =>
            array(
                'name' => 'idx_dp_doucumentspackets_mv_attachments_1_ida1_deleted',
                'type' => 'index',
                'fields' =>
                array(
                    0 => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
                    1 => 'deleted',
                ),
            ),
            2 =>
            array(
                'name' => 'idx_dp_doucumentspackets_mv_attachments_1_idb2_deleted',
                'type' => 'index',
                'fields' =>
                array(
                    0 => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
                    1 => 'deleted',
                ),
            ),
        ),
    );
    