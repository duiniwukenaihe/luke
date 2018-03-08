<?php

// created: 2018-01-23 17:41:33
    $dictionary["DP_DoucumentsPackets"]["fields"]["dp_doucumentspackets_mv_attachments_1"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1',
        'type' => 'link',
        'relationship' => 'dp_doucumentspackets_mv_attachments_1',
        'source' => 'non-db',
        'module' => 'mv_Attachments',
        'bean_name' => 'mv_Attachments',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_MV_ATTACHMENTS_TITLE',
        'id_name' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
        'readonly' => true,
    );
    $dictionary["DP_DoucumentsPackets"]["fields"]["dp_doucumentspackets_mv_attachments_1_name"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1_name',
        'type' => 'relate',
        'source' => 'non-db',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_MV_ATTACHMENTS_TITLE',
        'save' => true,
        'id_name' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
        'link' => 'dp_doucumentspackets_mv_attachments_1',
        'table' => 'mv_attachments',
        'module' => 'mv_Attachments',
        'rname' => 'document_name',
        'readonly' => true,
    );
    $dictionary["DP_DoucumentsPackets"]["fields"]["dp_doucumentspackets_mv_attachments_1mv_attachments_idb"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
        'type' => 'id',
        'source' => 'non-db',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_MV_ATTACHMENTS_TITLE',
        'id_name' => 'dp_doucumentspackets_mv_attachments_1mv_attachments_idb',
        'link' => 'dp_doucumentspackets_mv_attachments_1',
        'table' => 'mv_attachments',
        'module' => 'mv_Attachments',
        'rname' => 'id',
        'reportable' => false,
        'side' => 'left',
        'massupdate' => false,
        'duplicate_merge' => 'disabled',
        'hideacl' => true,
        'readonly' => true,
    );
    