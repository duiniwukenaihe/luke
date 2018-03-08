<?php

$dictionary['m_CAMS']['fields']['precon'] = array(
    'name' => 'precon',
    'vname' => 'LBL_PRECON',
    'type' => 'datetime',
    'options' => 'date_range_search_dom',
    'full_text_search' =>
    array(
        'enabled' => true,
        'searchable' => false,
    ),
    'enable_range_search' => true,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'merge_filter' => 'disabled',
    'importable' => true,
    'required' => false,
    'comments' => '',
    'massupdate' => true,
    'audited' => true,
    'reportable' => true,
);
