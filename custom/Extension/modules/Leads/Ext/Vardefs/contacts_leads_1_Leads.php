<?php
// created: 2017-10-02 11:16:42
$dictionary["Lead"]["fields"]["contacts_leads_1"] = array (
  'name' => 'contacts_leads_1',
  'type' => 'link',
  'relationship' => 'contacts_leads_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'side' => 'right',
  'vname' => 'LBL_CONTACTS_LEADS_1_FROM_LEADS_TITLE',
  'id_name' => 'contacts_leads_1contacts_ida',
  'link-type' => 'one',
);
$dictionary["Lead"]["fields"]["contacts_leads_1_name"] = array (
  'name' => 'contacts_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_LEADS_1_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'contacts_leads_1contacts_ida',
  'link' => 'contacts_leads_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Lead"]["fields"]["contacts_leads_1contacts_ida"] = array (
  'name' => 'contacts_leads_1contacts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_LEADS_1_FROM_LEADS_TITLE_ID',
  'id_name' => 'contacts_leads_1contacts_ida',
  'link' => 'contacts_leads_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
