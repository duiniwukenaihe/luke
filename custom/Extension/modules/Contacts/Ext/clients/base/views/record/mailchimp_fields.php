<?php

$viewdefs['Contacts']['base']['view']['record']['panels'][1]['fields'][] = array(
    'name' => 'last_sync_date',
    'related_fields' => array('subscriber_hash')
);