<?php
// created: 2017-09-19 14:11:42
$dictionary["m_CAMS"]["fields"]["m_cams_opportunities_1"] = array (
  'name' => 'm_cams_opportunities_1',
  'type' => 'link',
  'relationship' => 'm_cams_opportunities_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'm_cams_opportunities_1opportunities_idb',
);
$dictionary["m_CAMS"]["fields"]["m_cams_opportunities_1_name"] = array (
  'name' => 'm_cams_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'm_cams_opportunities_1opportunities_idb',
  'link' => 'm_cams_opportunities_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["m_CAMS"]["fields"]["m_cams_opportunities_1opportunities_idb"] = array (
  'name' => 'm_cams_opportunities_1opportunities_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE_ID',
  'id_name' => 'm_cams_opportunities_1opportunities_idb',
  'link' => 'm_cams_opportunities_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
