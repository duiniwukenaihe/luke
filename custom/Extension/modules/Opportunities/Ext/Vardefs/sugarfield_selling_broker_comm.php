<?php
 // created: 2018-01-22 17:45:50
$dictionary['Opportunity']['fields']['selling_broker_comm']['name']='selling_broker_comm';
$dictionary['Opportunity']['fields']['selling_broker_comm']['vname']='LBL_SELLING_BROKER_COMM';
$dictionary['Opportunity']['fields']['selling_broker_comm']['type']='currency';
$dictionary['Opportunity']['fields']['selling_broker_comm']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);
$dictionary['Opportunity']['fields']['selling_broker_comm']['no_default']=false;
$dictionary['Opportunity']['fields']['selling_broker_comm']['len']=26;
$dictionary['Opportunity']['fields']['selling_broker_comm']['size']='20';
$dictionary['Opportunity']['fields']['selling_broker_comm']['precision']=6;
$dictionary['Opportunity']['fields']['selling_broker_comm']['importable']='false';
$dictionary['Opportunity']['fields']['selling_broker_comm']['duplicate_merge']='disabled';
$dictionary['Opportunity']['fields']['selling_broker_comm']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['selling_broker_comm']['unified_search']=false;
$dictionary['Opportunity']['fields']['selling_broker_comm']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['selling_broker_comm']['enable_range_search']=false;
$dictionary['Opportunity']['fields']['selling_broker_comm']['comments']='';
$dictionary['Opportunity']['fields']['selling_broker_comm']['massupdate']=false;
$dictionary['Opportunity']['fields']['selling_broker_comm']['audited']=true;
$dictionary['Opportunity']['fields']['selling_broker_comm']['reportable']=true;
$dictionary['Opportunity']['fields']['selling_broker_comm']['required']=false;
$dictionary['Opportunity']['fields']['selling_broker_comm']['calculated']='1';
$dictionary['Opportunity']['fields']['selling_broker_comm']['enforced']=true;
$dictionary['Opportunity']['fields']['selling_broker_comm']['formula']='multiply(subtract($amount,$seller_concessions,$total_upgrades),divide($commission_percent,100))';

 ?>