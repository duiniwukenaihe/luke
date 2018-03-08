<?php
## Relate Field:
## Configurable Field Settings
$dictionary['Lead']['fields']['coop_broker']['name']  = 'coop_broker';
$dictionary['Lead']['fields']['coop_broker']['vname'] = 'LBL_COOP_BROKER';

$dictionary['Lead']['fields']['coop_broker']['ext2'] = 'Contacts';
$dictionary['Lead']['fields']['coop_broker']['module'] = 'Contacts';
$dictionary['Lead']['fields']['coop_broker']['id_name'] = 'related_contact_id';


## Defines the Field
$dictionary['Lead']['fields']['coop_broker']['type'] = 'relate';
$dictionary['Lead']['fields']['coop_broker']['len'] = 255;
$dictionary['Lead']['fields']['coop_broker']['size'] = '20';
$dictionary['Lead']['fields']['coop_broker']['rname'] = 'name';
$dictionary['Lead']['fields']['coop_broker']['source'] = 'non-db';



## Global Settings
$dictionary['Lead']['fields']['coop_broker']['unified_search'] = false;
$dictionary['Lead']['fields']['coop_broker']['duplicate_merge'] = 'enabled';
$dictionary['Lead']['fields']['coop_broker']['duplicate_merge_dom_value'] = 1;
$dictionary['Lead']['fields']['coop_broker']['merge_filter'] = 'disabled';
$dictionary['Lead']['fields']['coop_broker']['quicksearch'] = 'enabled';
$dictionary['Lead']['fields']['coop_broker']['studio'] = 'visible';
$dictionary['Lead']['fields']['coop_broker']['merge_filter'] = 'disabled';
$dictionary['Lead']['fields']['coop_broker']['no_default'] = false;
$dictionary['Lead']['fields']['coop_broker']['massupdate'] = false;
$dictionary['Lead']['fields']['coop_broker']['calculated'] = false;

## Configurable General Settings

$dictionary['Lead']['fields']['coop_broker']['reportable'] = true;
$dictionary['Lead']['fields']['coop_broker']['required'] = false;
$dictionary['Lead']['fields']['coop_broker']['dependency'] = '';
$dictionary['Lead']['fields']['coop_broker']['importable'] = 'true';
$dictionary['Lead']['fields']['coop_broker']['comments'] = '';
$dictionary['Lead']['fields']['coop_broker']['help'] = '';
$dictionary['Lead']['fields']['coop_broker']['audited'] = false;



## Related ID Field:
## Configurable Field Settings
$dictionary['Lead']['fields']['related_contact_id']['name'] = 'related_contact_id';
$dictionary['Lead']['fields']['related_contact_id']['vname'] = 'LBL_COOP_BROKER_CONTACT_ID';

## Defines the Field
$dictionary['Lead']['fields']['related_contact_id']['type'] = 'id';
$dictionary['Lead']['fields']['related_contact_id']['len'] = 36;
$dictionary['Lead']['fields']['related_contact_id']['size'] = '20';

## Global Settings
$dictionary['Lead']['fields']['related_contact_id']['massupdate'] = false;
$dictionary['Lead']['fields']['related_contact_id']['no_default'] = false;
$dictionary['Lead']['fields']['related_contact_id']['duplicate_merge'] = 'enabled';
$dictionary['Lead']['fields']['related_contact_id']['duplicate_merge_dom_value'] = 1;
$dictionary['Lead']['fields']['related_contact_id']['unified_search'] = false;
$dictionary['Lead']['fields']['related_contact_id']['merge_filter'] = 'disabled';
$dictionary['Lead']['fields']['related_contact_id']['calculated'] = false;


## Configurable General Settings
$dictionary['Lead']['fields']['related_contact_id']['comments'] = '';
$dictionary['Lead']['fields']['related_contact_id']['help'] = '';
$dictionary['Lead']['fields']['related_contact_id']['importable'] = 'true';
$dictionary['Lead']['fields']['related_contact_id']['audited'] = false;
$dictionary['Lead']['fields']['related_contact_id']['reportable'] = false;
$dictionary['Lead']['fields']['related_contact_id']['required'] = false;

