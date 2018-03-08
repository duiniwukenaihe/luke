<?php

$dictionary['ProspectList']['fields']['mailchimp_list'] = array(
    'name' => 'mailchimp_list',
    'vname' => 'LBL_MAILCHIMP_LIST',
    'type' => 'enum',
    'comment' => 'mailchimp lists dom',
    'len' => 100,
    'size' => 20,
    'function' => 'MailChimpLists',
);

$dictionary['ProspectList']['fields']['last_sync_date'] = array(
    'name' => 'last_sync_date',
    'vname' => 'LBL_LAST_SYNC_DATE',
    'type' => 'datetime',
    'readonly' => true,
    'comment' => 'last sync date',
);
