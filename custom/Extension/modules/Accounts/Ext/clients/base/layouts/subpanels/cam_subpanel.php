<?php

$viewdefs['Accounts']['base']['layout']['subpanels']['components'][] = array(
    'layout' => 'subpanel',
    'override_paneltop_view' => 'readonly-panel-top',
    'label' => 'LBL_CAM_SUBAPNEL',
    'context' =>
    array(
        'link' => 'm_cams',
    ),
);
$viewdefs['Accounts']['base']['layout']['subpanels']['components'][]['override_subpanel_list_view'] = array(
    'link' => 'm_cams',
    'view' => 'subpanel-for-accounts-cam',
);
