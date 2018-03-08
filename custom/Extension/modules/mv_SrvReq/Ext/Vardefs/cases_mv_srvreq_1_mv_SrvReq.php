<?php
// created: 2017-09-19 11:48:09
$dictionary["mv_SrvReq"]["fields"]["cases_mv_srvreq_1"] = array (
  'name' => 'cases_mv_srvreq_1',
  'type' => 'link',
  'relationship' => 'cases_mv_srvreq_1',
  'source' => 'non-db',
  'module' => 'Cases',
  'bean_name' => 'Case',
  'side' => 'right',
  'vname' => 'LBL_CASES_MV_SRVREQ_1_FROM_MV_SRVREQ_TITLE',
  'id_name' => 'cases_mv_srvreq_1cases_ida',
  'link-type' => 'one',
);
$dictionary["mv_SrvReq"]["fields"]["cases_mv_srvreq_1_name"] = array (
  'name' => 'cases_mv_srvreq_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CASES_MV_SRVREQ_1_FROM_CASES_TITLE',
  'save' => true,
  'id_name' => 'cases_mv_srvreq_1cases_ida',
  'link' => 'cases_mv_srvreq_1',
  'table' => 'cases',
  'module' => 'Cases',
  'rname' => 'name',
  'importable' => 'true',
);
$dictionary["mv_SrvReq"]["fields"]["cases_mv_srvreq_1cases_ida"] = array (
  'name' => 'cases_mv_srvreq_1cases_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CASES_MV_SRVREQ_1_FROM_MV_SRVREQ_TITLE_ID',
  'id_name' => 'cases_mv_srvreq_1cases_ida',
  'link' => 'cases_mv_srvreq_1',
  'table' => 'cases',
  'module' => 'Cases',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
  'importable' => 'true',
);
