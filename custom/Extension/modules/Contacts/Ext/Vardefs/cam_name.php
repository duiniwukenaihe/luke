<?php

    $dictionary['Contact']['fields']['m_cam_name'] = array(
        'required' => false,
        'source' => 'non-db',
        'name' => 'm_cam_name',
        'vname' => 'LBL_M_CAM_NAME',
        'type' => 'relate',
        'rname' => 'name',
        'id_name' => 'm_cam_id',
        'join_name' => 'm_cams',
        'link' => 'm_cams',
        'table' => 'm_cams',
        'isnull' => 'true',
        'module' => 'm_CAMS',
    );

    $dictionary['Contact']['fields']['m_cam_id'] = array(
        'name' => 'm_cam_id',
        'rname' => 'id',
        'vname' => 'LBL_M_CAM_ID',
        'type' => 'id',
        'table' => 'm_cams',
        'isnull' => 'true',
        'module' => 'm_CAMS',
        'dbType' => 'id',
        'reportable' => false,
        'massupdate' => false,
        'duplicate_merge' => 'disabled',
    );

    $dictionary['Contact']['fields']['m_cams'] = array(
        'name' => 'm_cams',
        'type' => 'link',
        'relationship' => 'contacts_m_cams',
        'module' => 'm_CAMS',
        'bean_name' => 'm_CAMS',
        'source' => 'non-db',
        'vname' => 'LBL_M_CAM',
    );


?>