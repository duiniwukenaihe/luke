<?php
// created: 2017-09-19 14:11:42
$dictionary["Opportunity"]["fields"]["m_cams_opportunities_1"] = array (
  'name' => 'm_cams_opportunities_1',
  'type' => 'link',
  'relationship' => 'm_cams_opportunities_1',
  'source' => 'non-db',
  'module' => 'm_CAMS',
  'bean_name' => 'm_CAMS',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE',
  'id_name' => 'm_cams_opportunities_1m_cams_ida',
);
$dictionary["Opportunity"]["fields"]["m_cams_opportunities_1_name"] = array (
  'name' => 'm_cams_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE',
  'save' => true,
  'id_name' => 'm_cams_opportunities_1m_cams_ida',
  'link' => 'm_cams_opportunities_1',
  'table' => 'm_cams',
  'module' => 'm_CAMS',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["m_cams_opportunities_1m_cams_ida"] = array (
  'name' => 'm_cams_opportunities_1m_cams_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_M_CAMS_OPPORTUNITIES_1_FROM_M_CAMS_TITLE_ID',
  'id_name' => 'm_cams_opportunities_1m_cams_ida',
  'link' => 'm_cams_opportunities_1',
  'table' => 'm_cams',
  'module' => 'm_CAMS',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
