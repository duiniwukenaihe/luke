<?php

$dictionary['Account']['fields']['ccb_expiration_date']['name'] = 'ccb_expiration_date';
$dictionary['Account']['fields']['ccb_expiration_date']['vname'] = 'LBL_CCB_EXPIRATION_DATE';

$dictionary['Account']['fields']['ccb_expiration_date']['type'] = 'date';
$dictionary['Account']['fields']['ccb_expiration_date']['options'] = 'date_range_search_dom';


$dictionary['Account']['fields']['ccb_expiration_date']['full_text_search'] = ['enabled' => true,'searchable' => false];
$dictionary['Account']['fields']['ccb_expiration_date']['enable_range_search'] = true;
$dictionary['Account']['fields']['ccb_expiration_date']['duplicate_merge'] = 'enabled';
$dictionary['Account']['fields']['ccb_expiration_date']['duplicate_merge_dom_value'] = 1;
$dictionary['Account']['fields']['ccb_expiration_date']['merge_filter'] = 'disabled';

$dictionary['Account']['fields']['ccb_expiration_date']['importable'] = true;
$dictionary['Account']['fields']['ccb_expiration_date']['required'] = false;
$dictionary['Account']['fields']['ccb_expiration_date']['comments'] = '';
$dictionary['Account']['fields']['ccb_expiration_date']['massupdate'] = true;
$dictionary['Account']['fields']['ccb_expiration_date']['audited'] = true;
$dictionary['Account']['fields']['ccb_expiration_date']['reportable'] = true;