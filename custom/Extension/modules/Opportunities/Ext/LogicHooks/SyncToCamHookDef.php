<?php
$hook_array['after_relationship_add'][] = Array(
    1,
    'Flow data from Opp to CAM',
    'custom/modules/Opportunities/SyncDataToCam.php',
    'DataSync',
    'after_relationship_add_method'
);

$hook_array['after_save'][] = Array(
    1,
    'Flow data from Opp to CAM',
    'custom/modules/Opportunities/SyncDataToCam.php',
    'DataSync',
    'after_save_method'
);