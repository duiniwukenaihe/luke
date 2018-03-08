<?php
 // created: 2017-09-29 11:51:32
$dictionary['Case']['fields']['square_feet_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['square_feet_c']['labelValue']='Square Feet';
$dictionary['Case']['fields']['square_feet_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['square_feet_c']['calculated']='true';
$dictionary['Case']['fields']['square_feet_c']['formula']='related($opportunities_cases_1,"square_ft")';
$dictionary['Case']['fields']['square_feet_c']['enforced']='true';
$dictionary['Case']['fields']['square_feet_c']['dependency']='';

 ?>