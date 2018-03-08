<?php
// created: 2018-02-06 21:28:03
$dictionary["m_cams_activities_1_emails"] = array (
  'relationships' => 
  array (
    'm_cams_activities_1_emails' => 
    array (
      'lhs_module' => 'm_CAMS',
      'lhs_table' => 'm_cams',
      'lhs_key' => 'id',
      'rhs_module' => 'Emails',
      'rhs_table' => 'emails',
      'relationship_role_column_value' => 'm_CAMS',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'emails_beans',
      'join_key_rhs' => 'email_id',
      'join_key_lhs' => 'bean_id',
      'relationship_role_column' => 'bean_module',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);