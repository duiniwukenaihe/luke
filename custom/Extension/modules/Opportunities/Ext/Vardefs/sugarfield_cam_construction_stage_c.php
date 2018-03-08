<?php
 // created: 2018-01-13 19:12:06
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['labelValue']='CAM Construction Stage';
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['calculated']='true';
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['formula']='related($m_cams_opportunities_1,"construction_stage")';
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['enforced']='true';
$dictionary['Opportunity']['fields']['cam_construction_stage_c']['dependency']='';

 ?>