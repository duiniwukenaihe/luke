<?php
 // created: 2017-10-02 13:08:54
$dictionary['m_CAMS']['fields']['permit_total_days']['importable']='false';
$dictionary['m_CAMS']['fields']['permit_total_days']['duplicate_merge']='disabled';
$dictionary['m_CAMS']['fields']['permit_total_days']['duplicate_merge_dom_value']=0;
$dictionary['m_CAMS']['fields']['permit_total_days']['calculated']='1';
$dictionary['m_CAMS']['fields']['permit_total_days']['formula']='daysBetween($permit_issued_date,$permit_upload_date)';
$dictionary['m_CAMS']['fields']['permit_total_days']['enforced']=true;
$dictionary['m_CAMS']['fields']['permit_total_days']['precision']=0;

 ?>