<?php
 // created: 2017-10-09 16:35:23
$dictionary['Case']['fields']['name']['len']='255';
$dictionary['Case']['fields']['name']['massupdate']=false;
$dictionary['Case']['fields']['name']['comments']='The short description of the bug';
$dictionary['Case']['fields']['name']['importable']='false';
$dictionary['Case']['fields']['name']['duplicate_merge']='disabled';
$dictionary['Case']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['name']['merge_filter']='disabled';
$dictionary['Case']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.53',
  'searchable' => true,
);
$dictionary['Case']['fields']['name']['calculated']='true';
$dictionary['Case']['fields']['name']['formula']='ifElse(
	equal(related($opportunities_cases_1,"name"),""),
	concat(	$customer_address_street_c," ",$customer_address_city_c,", ",$customer_address_state_c),
	concat(	toString($case_number)," - ",related($opportunities_cases_1,"community")," - ",related($opportunities_cases_1,"job_code"))
)';
$dictionary['Case']['fields']['name']['enforced']=true;

 ?>