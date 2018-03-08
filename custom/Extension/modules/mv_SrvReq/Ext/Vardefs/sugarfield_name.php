<?php
 // created: 2017-09-19 12:16:00
$dictionary['mv_SrvReq']['fields']['name']['len']='255';
$dictionary['mv_SrvReq']['fields']['name']['audited']=false;
$dictionary['mv_SrvReq']['fields']['name']['massupdate']=false;
$dictionary['mv_SrvReq']['fields']['name']['importable']='false';
$dictionary['mv_SrvReq']['fields']['name']['duplicate_merge']='disabled';
$dictionary['mv_SrvReq']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['mv_SrvReq']['fields']['name']['merge_filter']='disabled';
$dictionary['mv_SrvReq']['fields']['name']['unified_search']=false;
$dictionary['mv_SrvReq']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['mv_SrvReq']['fields']['name']['calculated']='true';
$dictionary['mv_SrvReq']['fields']['name']['formula']='concat(related($cases_mv_srvreq_1,"name")," - ",$category)';
$dictionary['mv_SrvReq']['fields']['name']['enforced']=true;

 ?>
