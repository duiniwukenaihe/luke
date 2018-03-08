<?php
 // created: 2017-08-17 12:15:31
$dictionary['Opportunity']['fields']['pending_month']['name']='pending_month';
$dictionary['Opportunity']['fields']['pending_month']['vname']='LBL_PENDING_MONTH';
$dictionary['Opportunity']['fields']['pending_month']['type']='varchar';
$dictionary['Opportunity']['fields']['pending_month']['len']='100';
$dictionary['Opportunity']['fields']['pending_month']['full_text_search']=array (
  'enabled' => true,
  'boost' => '0.5',
  'searchable' => true,
);
$dictionary['Opportunity']['fields']['pending_month']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['pending_month']['importable']='false';
$dictionary['Opportunity']['fields']['pending_month']['comments']='';
$dictionary['Opportunity']['fields']['pending_month']['massupdate']=false;
$dictionary['Opportunity']['fields']['pending_month']['audited']=false;
$dictionary['Opportunity']['fields']['pending_month']['reportable']=true;
$dictionary['Opportunity']['fields']['pending_month']['duplicate_merge']='disabled';
$dictionary['Opportunity']['fields']['pending_month']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['pending_month']['calculated']='true';
$dictionary['Opportunity']['fields']['pending_month']['formula']='monthofyear($pending_date)';
$dictionary['Opportunity']['fields']['pending_month']['enforced']=true;

 ?>