<?php
$childObject = "mv_Attachments";
$childModule = "mv_Attachments";
$childTable = "mv_attachments";




$parentObject = "Account";
$parentModule = "Accounts";
$parentTable = "accounts";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Case";
$parentModule = "Cases";
$parentTable = "Cases";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Contact";
$parentModule = "Contacts";
$parentTable = "contacts";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Lead";
$parentModule = "Leads";
$parentTable = "leads";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "m_CAMS";
$parentModule = "m_CAMS";
$parentTable = "m_cams";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Meeting";
$parentModule = "Meetings";
$parentTable = "meetings";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "mv_SrvReq";
$parentModule = "mv_SrvReq";
$parentTable = "mv_srvreq";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Note";
$parentModule = "Notes";
$parentTable = "notes";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Opportunity";
$parentModule = "Opportunities";
$parentTable = "opportunities";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];

$parentObject = "Task";
$parentModule = "Tasks";
$parentTable = "tasks";
$relationship = strtolower($parentModule . "_" . $childModule);
$label2 = strtoupper("LBL_$parentModule");

$GLOBALS["dictionary"][$childObject]['fields'][$relationship] = [
  'name' => $relationship,
  'type' => 'link',
  'relationship' => $relationship,
  'source' => 'non-db',
  'vname' => $label2,
];
