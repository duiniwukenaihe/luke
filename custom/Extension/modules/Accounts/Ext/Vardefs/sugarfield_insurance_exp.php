<?php

$dictionary['Account']['fields']['insurance_exp']['name'] = 'insurance_exp';
$dictionary['Account']['fields']['insurance_exp']['vname'] = 'LBL_INSURANCE_EXP';

$dictionary['Account']['fields']['insurance_exp']['type'] = 'date';
$dictionary['Account']['fields']['insurance_exp']['options'] = 'date_range_search_dom';


$dictionary['Account']['fields']['insurance_exp']['full_text_search'] = ['enabled' => true,'searchable' => false];
$dictionary['Account']['fields']['insurance_exp']['enable_range_search'] = true;
$dictionary['Account']['fields']['insurance_exp']['duplicate_merge'] = 'enabled';
$dictionary['Account']['fields']['insurance_exp']['duplicate_merge_dom_value'] = 1;
$dictionary['Account']['fields']['insurance_exp']['merge_filter'] = 'disabled';

$dictionary['Account']['fields']['insurance_exp']['importable'] = true;
$dictionary['Account']['fields']['insurance_exp']['required'] = false;
$dictionary['Account']['fields']['insurance_exp']['comments'] = '';
$dictionary['Account']['fields']['insurance_exp']['massupdate'] = true;
$dictionary['Account']['fields']['insurance_exp']['audited'] = true;
$dictionary['Account']['fields']['insurance_exp']['reportable'] = true;
