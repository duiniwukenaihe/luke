<?php

    $dictionary['m_CAMS']['fields']['contacts'] = array(
        'name' => 'contacts',
        'type' => 'link',
        'relationship' => 'contacts_m_cams',
        'module' => 'Contacts',
        'bean_name' => 'Contacts',
        'source' => 'non-db',
        'vname' => 'LBL_CONTACTS',
    );
    $dictionary['m_CAMS']['relationships']['contacts_m_cams'] = array(
        'lhs_module' => 'm_CAMS',
        'lhs_table' => 'm_cams',
        'lhs_key' => 'id',
        'rhs_module' => 'Contacts',
        'rhs_table' => 'contacts',
        'rhs_key' => 'm_cam_id',
        'relationship_type' => 'one-to-many',
    );
?>