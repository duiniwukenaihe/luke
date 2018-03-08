<?php
// created: 2015-09-18 04:41:52
//$dictionary["dp_doucumentspackets_documents"] = array (
//  'true_relationship_type' => 'many-to-many',
//  'relationships' =>
//  array (
//    'dp_doucumentspackets_documents' =>
//    array (
//      'lhs_module' => 'DP_DoucumentsPackets',
//      'lhs_table' => 'dp_doucumentspackets',
//      'lhs_key' => 'id',
//      'rhs_module' => 'Documents',
//      'rhs_table' => 'documents',
//      'rhs_key' => 'id',
//      'relationship_type' => 'many-to-many',
//      'join_table' => 'dp_doucumentspackets_documents_c',
//      'join_key_lhs' => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
//      'join_key_rhs' => 'dp_doucumentspackets_documentsdocuments_idb',
//    ),
//  ),
//  'table' => 'dp_doucumentspackets_documents_c',
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
//      'name' => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
//      'type' => 'varchar',
//      'len' => 36,
//    ),
//    4 =>
//    array (
//      'name' => 'dp_doucumentspackets_documentsdocuments_idb',
//      'type' => 'varchar',
//      'len' => 36,
//    ),
//    5 =>
//    array (
//      'name' => 'document_revision_id',
//      'type' => 'varchar',
//      'len' => '36',
//    ),
//	6 =>
//    array (
//      'name' => 'document_status',
//      'type' => 'varchar',
//      'len' => '36',
//    ),
//  ),
//  'indices' =>
//  array (
//    0 =>
//    array (
//      'name' => 'dp_doucumentspackets_documentsspk',
//      'type' => 'primary',
//      'fields' =>
//      array (
//        0 => 'id',
//      ),
//    ),
//    1 =>
//    array (
//      'name' => 'dp_doucumentspackets_documents_alt',
//      'type' => 'alternate_key',
//      'fields' =>
//      array (
//        0 => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
//        1 => 'dp_doucumentspackets_documentsdocuments_idb',
//      ),
//    ),
//  ),
//);

//////////////////////////////////////


$dictionary["dp_doucumentspackets_documents"] = array (
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
        array (
            'dp_doucumentspackets_documents' =>
                array (
                    'lhs_module' => 'DP_DoucumentsPackets',
                    'lhs_table' => 'dp_doucumentspackets',
                    'lhs_key' => 'id',
                    'rhs_module' => 'Documents',
                    'rhs_table' => 'documents',
                    'rhs_key' => 'id',
                    'relationship_type' => 'many-to-many',
                    'join_table' => 'dp_doucumentspackets_documents_c',
                    'join_key_lhs' => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
                    'join_key_rhs' => 'dp_doucumentspackets_documentsdocuments_idb',
                ),
        ),
    'table' => 'dp_doucumentspackets_documents_c',
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
            'dp_doucumentspackets_documentsdp_doucumentspackets_ida' =>
                array (
                    'name' => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
                    'type' => 'id',
                ),
            'dp_doucumentspackets_documentsdocuments_idb' =>
                array (
                    'name' => 'dp_doucumentspackets_documentsdocuments_idb',
                    'type' => 'id',
                ),
            'document_revision_id' =>
                array (
                    'name' => 'document_revision_id',
                    'type' => 'id',
                ),
            'document_status' =>
                array (
                    'name' => 'document_status',
                    'type' => 'varchar',
                ),
        ),
    'indices' =>
        array (
            0 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_documents_pk',
                    'type' => 'primary',
                    'fields' =>
                        array (
                            0 => 'id',
                        ),
                ),
            1 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_documents_ida1_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
                            1 => 'deleted',
                        ),
                ),
            2 =>
                array (
                    'name' => 'idx_dp_doucumentspackets_documents_idb2_deleted',
                    'type' => 'index',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_documentsdocuments_idb',
                            1 => 'deleted',
                        ),
                ),
            3 =>
                array (
                    'name' => 'dp_doucumentspackets_documents_alt',
                    'type' => 'alternate_key',
                    'fields' =>
                        array (
                            0 => 'dp_doucumentspackets_documentsdp_doucumentspackets_ida',
                            1 => 'dp_doucumentspackets_documentsdocuments_idb',
                        ),
                ),
        ),
);