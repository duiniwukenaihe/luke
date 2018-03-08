<?php
 // created: 2017-12-04 23:19:56
$dictionary['Case']['fields']['days_to_complete_c']['duplicate_merge_dom_value']=0;
$dictionary['Case']['fields']['days_to_complete_c']['labelValue']='Total Days To Complete';
$dictionary['Case']['fields']['days_to_complete_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Case']['fields']['days_to_complete_c']['calculated']='1';
$dictionary['Case']['fields']['days_to_complete_c']['formula']='abs(subtract(daysUntil($request_completed_date_c),daysUntil($date_entered)))';
$dictionary['Case']['fields']['days_to_complete_c']['enforced']='1';
$dictionary['Case']['fields']['days_to_complete_c']['dependency']='';

 ?>