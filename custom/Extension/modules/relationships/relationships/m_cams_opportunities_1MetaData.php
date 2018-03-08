<?php
// created: 2017-09-19 14:11:42
$dictionary["m_cams_opportunities_1"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'm_cams_opportunities_1' => 
    array (
      'lhs_module' => 'm_CAMS',
      'lhs_table' => 'm_cams',
      'lhs_key' => 'id',
      'rhs_module' => 'Opportunities',
      'rhs_table' => 'opportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'm_cams_opportunities_1_c',
      'join_key_lhs' => 'm_cams_opportunities_1m_cams_ida',
      'join_key_rhs' => 'm_cams_opportunities_1opportunities_idb',
    ),
  ),
  'table' => 'm_cams_opportunities_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'm_cams_opportunities_1m_cams_ida' => 
    array (
      'name' => 'm_cams_opportunities_1m_cams_ida',
      'type' => 'id',
    ),
    'm_cams_opportunities_1opportunities_idb' => 
    array (
      'name' => 'm_cams_opportunities_1opportunities_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_m_cams_opportunities_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_m_cams_opportunities_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'm_cams_opportunities_1m_cams_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_m_cams_opportunities_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'm_cams_opportunities_1opportunities_idb',
        1 => 'deleted',
      ),
    ),
  ),
);