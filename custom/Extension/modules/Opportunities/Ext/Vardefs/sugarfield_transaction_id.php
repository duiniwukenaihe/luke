<?php
$dictionary['Opportunity']['fields']['transaction_id']['name'] = 'transaction_id';
$dictionary['Opportunity']['fields']['transaction_id']['vname'] = 'LBL_TRANSACTION_ID';

$dictionary['Opportunity']['fields']['transaction_id']['type'] = 'varchar';
$dictionary['Opportunity']['fields']['transaction_id']['len'] = 100;

$dictionary['Opportunity']['fields']['transaction_id']['full_text_search'] = ['enabled' => true,'searchable' => true,'boost' => 0.5];
$dictionary['Opportunity']['fields']['transaction_id']['merge_filter'] = 'enabled';
$dictionary['Opportunity']['fields']['transaction_id']['importable'] = true;

$dictionary['Opportunity']['fields']['transaction_id']['comments'] = '';
$dictionary['Opportunity']['fields']['transaction_id']['massupdate'] = true;
$dictionary['Opportunity']['fields']['transaction_id']['audited'] = true;
$dictionary['Opportunity']['fields']['transaction_id']['reportable'] = true;


?>
