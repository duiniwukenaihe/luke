<?php
 // created: 2017-09-29 11:50:54
$dictionary['Case']['fields']['job_code_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['job_code_c']['labelValue']='Job Code';
$dictionary['Case']['fields']['job_code_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['job_code_c']['calculated']='true';
$dictionary['Case']['fields']['job_code_c']['formula']='related($opportunities_cases_1,"job_code")';
$dictionary['Case']['fields']['job_code_c']['enforced']='true';
$dictionary['Case']['fields']['job_code_c']['dependency']='';

 ?>