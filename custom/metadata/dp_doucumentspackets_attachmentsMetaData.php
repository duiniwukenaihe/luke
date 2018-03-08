<?php

    $dictionary["dp_doucumentspackets_attachments"] = array(
        'true_relationship_type' => 'many-to-many',
        'relationships' =>
        array(
            'dp_doucumentspackets_attachments' =>
            array(
                'lhs_module' => 'DP_DoucumentsPackets',
                'lhs_table' => 'dp_doucumentspackets',
                'lhs_key' => 'id',
                'rhs_module' => 'mv_Attachments',
                'rhs_table' => 'mv_attachments',
                'rhs_key' => 'id',
                'relationship_type' => 'many-to-many',
                'join_table' => 'dp_doucumentspackets_attachments',
                'join_key_lhs' => 'packet_id',
                'join_key_rhs' => 'attachment_id',
            ),
        ),
        'table' => 'dp_doucumentspackets_attachments',
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
            'packet_id' =>
            array(
                'name' => 'packet_id',
                'type' => 'id',
            ),
            'attachment_id' =>
            array(
                'name' => 'attachment_id',
                'type' => 'id',
            ),
            'document_status' =>
            array(
                'name' => 'document_status',
                'type' => 'varchar',
            ),
        ),
        'indices' =>
        array(
            0 =>
            array(
                'name' => 'idx_dp_doucumentspackets_attachment_pk',
                'type' => 'primary',
                'fields' =>
                array(
                    0 => 'id',
                ),
            ),
            1 =>
            array(
                'name' => 'idx_dp_doucumentspackets_attachment_ida1_deleted',
                'type' => 'index',
                'fields' =>
                array(
                    0 => 'packet_id',
                    1 => 'deleted',
                ),
            ),
            2 =>
            array(
                'name' => 'idx_dp_doucumentspackets_attachment_idb2_deleted',
                'type' => 'index',
                'fields' =>
                array(
                    0 => 'attachment_id',
                    1 => 'deleted',
                ),
            ),
            3 =>
            array(
                'name' => 'dp_doucumentspackets_attachment_alt',
                'type' => 'alternate_key',
                'fields' =>
                array(
                    0 => 'packet_id',
                    1 => 'attachment_id',
                ),
            ),
        ),
    );
    