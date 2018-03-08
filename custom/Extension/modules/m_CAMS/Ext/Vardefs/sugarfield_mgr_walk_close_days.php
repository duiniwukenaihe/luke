<?php
 // created: 2017-10-04 16:43:17
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['importable']='false';
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['duplicate_merge']='disabled';
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['duplicate_merge_dom_value']=0;
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['calculated']='1';
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['formula']='abs(daysBetween($closing_date,$const_finish_date))';
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['enforced']=true;
$dictionary['m_CAMS']['fields']['mgr_walk_close_days']['precision']=0;

 ?>