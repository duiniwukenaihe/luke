<?php
 // created: 2017-09-29 11:50:00
$dictionary['Case']['fields']['garage_type_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['garage_type_c']['labelValue']='Garage Type';
$dictionary['Case']['fields']['garage_type_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['garage_type_c']['calculated']='true';
$dictionary['Case']['fields']['garage_type_c']['formula']='related($opportunities_cases_1,"garage_type")';
$dictionary['Case']['fields']['garage_type_c']['enforced']='true';
$dictionary['Case']['fields']['garage_type_c']['dependency']='';

 ?>