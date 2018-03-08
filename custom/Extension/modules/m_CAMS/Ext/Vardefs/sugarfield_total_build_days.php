<?php
 // created: 2017-10-04 16:43:44
$dictionary['m_CAMS']['fields']['total_build_days']['importable']='false';
$dictionary['m_CAMS']['fields']['total_build_days']['duplicate_merge']='disabled';
$dictionary['m_CAMS']['fields']['total_build_days']['duplicate_merge_dom_value']=0;
$dictionary['m_CAMS']['fields']['total_build_days']['calculated']='1';
$dictionary['m_CAMS']['fields']['total_build_days']['formula']='abs(daysBetween($const_finish_date,$permits_paid_date))';
$dictionary['m_CAMS']['fields']['total_build_days']['enforced']=true;
$dictionary['m_CAMS']['fields']['total_build_days']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['m_CAMS']['fields']['total_build_days']['min']=false;
$dictionary['m_CAMS']['fields']['total_build_days']['max']=false;
$dictionary['m_CAMS']['fields']['total_build_days']['disable_num_format']='';

 ?>