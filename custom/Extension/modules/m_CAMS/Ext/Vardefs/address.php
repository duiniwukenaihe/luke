<?php

$dictionary['m_CAMS']['fields']['primary_address_street'] = array(
    'name' => 'primary_address_street',
    'vname' => 'LBL_PRIMARY_ADDRESS_STREET',
    'type' => 'text',
    'dbType' => 'varchar',
    'len' => 150,
    'group' => 'primary_address',
    'group_label' => 'LBL_PRIMARY_ADDRESS',
    'duplicate_on_record_copy' => 'always',
    'full_text_search' => array (
        'enabled' => true,
        'searchable' => true,
        'boost' => 0.34000000000000002,
    ),
    'comment' => 'The street address used for for primary purposes',
    'merge_filter' => 'enabled',
);
$dictionary['m_CAMS']['fields']['primary_address_street_2'] = array(
    'name' => 'primary_address_street_2',
    'vname' => 'LBL_PRIMARY_ADDRESS_STREET_2',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source' => 'non-db',
);
$dictionary['m_CAMS']['fields']['primary_address_street_3'] = array(
    'name' => 'primary_address_street_3',
    'vname' => 'LBL_PRIMARY_ADDRESS_STREET_3',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source' => 'non-db',
);
$dictionary['m_CAMS']['fields']['primary_address_street_4'] = array(
    'name' => 'primary_address_street_4',
    'vname' => 'LBL_PRIMARY_ADDRESS_STREET_4',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source' => 'non-db',
);
$dictionary['m_CAMS']['fields']['primary_address_city'] = array(
    'name' => 'primary_address_city',
    'vname' => 'LBL_PRIMARY_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => 100,
    'group' => 'primary_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The city used for the primary address',
    'merge_filter' => 'enabled',
);
$dictionary['m_CAMS']['fields']['primary_address_state'] = array(
    'name' => 'primary_address_state',
    'vname' => 'LBL_PRIMARY_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => 100,
    'group' => 'primary_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The state used for the primary address',
    'merge_filter' => 'disabled',
    'audited' => false,
    'massupdate' => true,
    'comments' => 'The state used for the primary address',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'calculated' => false,
    'dependency' => false,
);
$dictionary['m_CAMS']['fields']['primary_address_postalcode'] = array(
    'name' => 'primary_address_postalcode',
    'vname' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => 20,
    'group' => 'primary_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The zip code used for the primary address',
    'merge_filter' => 'enabled',
);
$dictionary['m_CAMS']['fields']['primary_address_country'] = array(
    'name' => 'primary_address_country',
    'vname' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group' => 'primary_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The country used for the primary address',
    'merge_filter' => 'enabled',
);

?>