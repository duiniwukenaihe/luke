<?php
$viewdefs['DP_DoucumentsPackets']['base']['layout']['subpanels']['components'][] = array (
  'layout' => 'subpanel',
  'label' => 'LBL_DP_DOUCUMENTSPACKETS_ATTACHMENTS_FROM_ATTACHMENTS_TITLE',
  'context' => 
  array (
    'link' => 'dp_doucumentspackets_attachments',
  ),
);
$viewdefs['DP_DoucumentsPackets']['base']['layout']['subpanels']['components'][]['override_subpanel_list_view'] = array (
  'link' => 'm_cams_mv_attachments',
  'view' => 'subpanel-for-dp_doucumentspackets-dp_doucumentspackets_attachments',
);