<?php
 // created: 2018-01-27 22:07:02
$dictionary['Opportunity']['fields']['proof_of_funds']['name']='proof_of_funds';
$dictionary['Opportunity']['fields']['proof_of_funds']['vname']='LBL_PROOF_OF_FUNDS';
$dictionary['Opportunity']['fields']['proof_of_funds']['type']='enum';
$dictionary['Opportunity']['fields']['proof_of_funds']['options']='yes_no_na_list';
$dictionary['Opportunity']['fields']['proof_of_funds']['dependency']=false;
$dictionary['Opportunity']['fields']['proof_of_funds']['len']=100;
$dictionary['Opportunity']['fields']['proof_of_funds']['comments']='';
$dictionary['Opportunity']['fields']['proof_of_funds']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['proof_of_funds']['audited']=false;
$dictionary['Opportunity']['fields']['proof_of_funds']['reportable']=true;
$dictionary['Opportunity']['fields']['proof_of_funds']['unified_search']=false;
$dictionary['Opportunity']['fields']['proof_of_funds']['importable']='true';
$dictionary['Opportunity']['fields']['proof_of_funds']['massupdate']=true;
$dictionary['Opportunity']['fields']['proof_of_funds']['duplicate_merge']='enabled';
$dictionary['Opportunity']['fields']['proof_of_funds']['duplicate_merge_dom_value']='1';
$dictionary['Opportunity']['fields']['proof_of_funds']['calculated']=false;
$dictionary['Opportunity']['fields']['proof_of_funds']['required']=false;
$dictionary['Opportunity']['fields']['proof_of_funds']['visibility_grid']=array (
  'trigger' => 'financing',
  'values' => 
  array (
    '' => 
    array (
      0 => '',
    ),
    'Conventional' => 
    array (
      0 => 'na',
    ),
    'FHS' => 
    array (
      0 => 'na',
    ),
    'FHA' => 
    array (
      0 => 'na',
    ),
    'USDA' => 
    array (
      0 => 'na',
    ),
    'VA' => 
    array (
      0 => 'na',
    ),
    'Cash' => 
    array (
      0 => 'yes',
      1 => 'no',
    ),
    '1031 Exchange' => 
    array (
      0 => 'yes',
      1 => 'no',
    ),
    'Construction Loan' => 
    array (
      0 => 'na',
    ),
    'Other' => 
    array (
      0 => '',
      1 => 'yes',
      2 => 'no',
      3 => 'na',
    ),
  ),
);

 ?>