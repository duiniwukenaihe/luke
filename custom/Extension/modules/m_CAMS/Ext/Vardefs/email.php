<?php

// $dictionary['m_CAMS']['fields']['email'] = array(
//     'name' => 'email',
//     'type' => 'email',
//     'query_type' => 'default',
//     'source' => 'non-db',
//     'operator' => 'subquery',
//     'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
//     'db_field' => array (
//         0 => 'id',
//     ),
//     'vname' => 'LBL_ANY_EMAIL',
//     'studio' => array (
//         'visible' => true,
//         'searchview' => true,
//         'editview' => true,
//         'editField' => true,
//     ),
//     'duplicate_on_record_copy' => 'always',
//     'len' => 100,
//     'link' => 'email_addresses_primary',
//     'rname' => 'email_address',
//     'module' => 'EmailAddresses',
//     'full_text_search' => array(
//         'enabled' => true,
//         'searchable' => true,
//         'boost' => 1.95,
//     ),
// );

// $dictionary['m_CAMS']['fields']['email_addresses_primary'] = array(
//     'name' => 'email_addresses_primary',
//     'type' => 'link',
//     'relationship' => 'm_cams_email_addresses_primary',
//     'source' => 'non-db',
//     'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
//     'duplicate_merge' => 'disabled',
//     'primary_only' => true,
// );

// $dictionary['m_CAMS']['relationships']['m_cams_email_addresses_primary'] = array(
//     'lhs_module' => 'm_CAMS',
//     'lhs_table' => 'm_cams',
//     'lhs_key' => 'id',
//     'rhs_module' => 'EmailAddresses',
//     'rhs_table' => 'email_addresses',
//     'rhs_key' => 'id',
//     'relationship_type' => 'many-to-many',
//     'join_table' => 'email_addr_bean_rel',
//     'join_key_lhs' => 'bean_id',
//     'join_key_rhs' => 'email_address_id',
//     'relationship_role_column' => 'bean_module',
//     'relationship_role_column_value' => 'm_CAMS',
//     'primary_flag_column' => 'primary_address',
// );

?>