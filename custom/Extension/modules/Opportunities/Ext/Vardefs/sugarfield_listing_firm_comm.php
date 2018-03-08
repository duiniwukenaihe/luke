<?php
 // created: 2017-08-17 15:18:21
$dictionary['Opportunity']['fields']['listing_firm_comm']['name']='listing_firm_comm';
$dictionary['Opportunity']['fields']['listing_firm_comm']['vname']='LBL_LISTING_FIRM_COMM';
$dictionary['Opportunity']['fields']['listing_firm_comm']['type']='currency';
$dictionary['Opportunity']['fields']['listing_firm_comm']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);
$dictionary['Opportunity']['fields']['listing_firm_comm']['no_default']=false;
$dictionary['Opportunity']['fields']['listing_firm_comm']['len']=26;
$dictionary['Opportunity']['fields']['listing_firm_comm']['size']='20';
$dictionary['Opportunity']['fields']['listing_firm_comm']['precision']=6;
$dictionary['Opportunity']['fields']['listing_firm_comm']['importable']='false';
$dictionary['Opportunity']['fields']['listing_firm_comm']['duplicate_merge']='disabled';
$dictionary['Opportunity']['fields']['listing_firm_comm']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['listing_firm_comm']['unified_search']=false;
$dictionary['Opportunity']['fields']['listing_firm_comm']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['listing_firm_comm']['enable_range_search']=false;
$dictionary['Opportunity']['fields']['listing_firm_comm']['comments']='';
$dictionary['Opportunity']['fields']['listing_firm_comm']['massupdate']=false;
$dictionary['Opportunity']['fields']['listing_firm_comm']['audited']=true;
$dictionary['Opportunity']['fields']['listing_firm_comm']['reportable']=true;
$dictionary['Opportunity']['fields']['listing_firm_comm']['required']=false;
$dictionary['Opportunity']['fields']['listing_firm_comm']['calculated']='1';
$dictionary['Opportunity']['fields']['listing_firm_comm']['enforced']=true;
$dictionary['Opportunity']['fields']['listing_firm_comm']['formula']='multiply(subtract($amount,$seller_concessions),divide($listing_commission_percent,100))';

 ?>