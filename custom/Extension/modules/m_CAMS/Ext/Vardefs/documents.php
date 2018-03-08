<?php

    $dictionary['m_CAMS']['fields']['documents'] = array(
        'name' => 'documents',
        'type' => 'link',
        'relationship' => 'documents_m_cams',
        'module' => 'Documents',
        'bean_name' => 'Documents',
        'source' => 'non-db',
        'vname' => 'LBL_DOCUMENTS',
    );

    $dictionary['m_CAMS']['relationships']['documents_m_cams'] = array(
        'lhs_module' => 'm_CAMS',
        'lhs_table' => 'm_cams',
        'lhs_key' => 'id',
        'rhs_module' => 'Documents',
        'rhs_table' => 'documents',
        'rhs_key' => 'm_cam_id',
        'relationship_type' => 'one-to-many',
    );
?>