<?php
 // created: 2017-09-29 11:52:58
$dictionary['Case']['fields']['warranty_exp_date_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['warranty_exp_date_c']['labelValue']='Warranty Expiration Date';
$dictionary['Case']['fields']['warranty_exp_date_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['warranty_exp_date_c']['calculated']='true';
$dictionary['Case']['fields']['warranty_exp_date_c']['formula']='related($opportunities_cases_1,"warranty_exp")';
$dictionary['Case']['fields']['warranty_exp_date_c']['enforced']='true';
$dictionary['Case']['fields']['warranty_exp_date_c']['dependency']='';

 ?>