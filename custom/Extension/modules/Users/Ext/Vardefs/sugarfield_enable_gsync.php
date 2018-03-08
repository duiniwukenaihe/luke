<?php
//added for cleanup process
$dictionary["User"]["fields"]['enable_gsync'] = array(
    'name' => 'enable_gsync',
    'vname' => 'LBL_ENABLE_GSYNC',
    'type' => 'bool',
    'default' => '0',//by all users are disabled
    'reportable' => false,
    'massupdate' => false,
    'importable' => 'false',
    'studio' => false,
);