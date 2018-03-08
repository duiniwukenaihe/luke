<?php
 // created: 2017-10-02 13:54:05
$dictionary['Opportunity']['fields']['cam_permit_num_c']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['cam_permit_num_c']['labelValue']='CAM Permit Num';
$dictionary['Opportunity']['fields']['cam_permit_num_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['cam_permit_num_c']['calculated']='1';
$dictionary['Opportunity']['fields']['cam_permit_num_c']['formula']='related($m_cams_opportunities_1,"permit_number")';
$dictionary['Opportunity']['fields']['cam_permit_num_c']['enforced']='1';

 ?>