<?php
 // created: 2017-09-29 11:52:12
$dictionary['Case']['fields']['community_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['community_c']['labelValue']='Community';
$dictionary['Case']['fields']['community_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['community_c']['calculated']='true';
$dictionary['Case']['fields']['community_c']['formula']='related($opportunities_cases_1,"community")';
$dictionary['Case']['fields']['community_c']['enforced']='true';
$dictionary['Case']['fields']['community_c']['dependency']='';

 ?>