<?php

// created: 2018-01-23 17:41:33
    $dictionary["mv_Attachments"]["fields"]["dp_doucumentspackets_mv_attachments_1"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1',
        'type' => 'link',
        'relationship' => 'dp_doucumentspackets_mv_attachments_1',
        'source' => 'non-db',
        'module' => 'DP_DoucumentsPackets',
        'bean_name' => 'DP_DoucumentsPackets',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_DP_DOUCUMENTSPACKETS_TITLE',
        'id_name' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
        'readonly' => true,
    );
    $dictionary["mv_Attachments"]["fields"]["dp_doucumentspackets_mv_attachments_1_name"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1_name',
        'type' => 'relate',
        'source' => 'non-db',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_DP_DOUCUMENTSPACKETS_TITLE',
        'save' => true,
        'id_name' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
        'link' => 'dp_doucumentspackets_mv_attachments_1',
        'table' => 'dp_doucumentspackets',
        'module' => 'DP_DoucumentsPackets',
        'rname' => 'name',
        'readonly' => true,
    );
    $dictionary["mv_Attachments"]["fields"]["dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida"] = array(
        'name' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
        'type' => 'id',
        'source' => 'non-db',
        'vname' => 'LBL_DP_DOUCUMENTSPACKETS_MV_ATTACHMENTS_1_FROM_DP_DOUCUMENTSPACKETS_TITLE',
        'id_name' => 'dp_doucumentspackets_mv_attachments_1dp_doucumentspackets_ida',
        'link' => 'dp_doucumentspackets_mv_attachments_1',
        'table' => 'dp_doucumentspackets',
        'module' => 'DP_DoucumentsPackets',
        'rname' => 'id',
        'reportable' => false,
        'side' => 'left',
        'massupdate' => false,
        'duplicate_merge' => 'disabled',
        'hideacl' => true,
        'readonly' => true,
    );
    