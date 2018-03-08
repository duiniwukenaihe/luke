<?php
 // created: 2018-02-13 04:04:15
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['duplicate_merge_dom_value']=0;
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['labelValue']='Slot to Actual Days';
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['calculated']='true';
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['formula']='abs(daysBetween($projected_start_date,$const_start_date))';
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['enforced']='true';
$dictionary['m_CAMS']['fields']['slot_to_actual_days_c']['dependency']='';

 ?>