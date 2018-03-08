<?php
// created: 2017-08-30 16:15:14
$viewdefs['Contacts']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_CONTACT',
  'visible' => true,
  'order' => 2,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'contacts',
    ),
    1 => 
    array (
      'module' => 'Opportunities',
      'link' => 'contacts',
    ),
  ),
);