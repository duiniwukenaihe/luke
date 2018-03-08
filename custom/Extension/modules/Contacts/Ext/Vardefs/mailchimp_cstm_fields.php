<?php

$dictionary['Contact']['fields']['subscriber_hash'] = array(
    'name' => 'subscriber_hash',
    'vname' => 'LBL_SUBSCRIBER_HASH',
    'type' => 'varchar',
    'len' => '200',
    'readonly' => true,
    'comment' => 'The MD5 hash of the lowercase version of the list member’s email address.',
);

$dictionary['Contact']['fields']['last_sync_date'] = array(
    'name' => 'last_sync_date',
    'vname' => 'LBL_LAST_SYNC_DATE',
    'type' => 'datetime',
    'readonly' => true,
    'comment' => 'last sync date',
);
