<?php
// created: 2017-05-06 15:26:05
$dictionary["jckl_filtertemplates_jckl_filterselections"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'jckl_filtertemplates_jckl_filterselections' => 
    array (
      'lhs_module' => 'jckl_FilterTemplates',
      'lhs_table' => 'jckl_filtertemplates',
      'lhs_key' => 'id',
      'rhs_module' => 'jckl_FilterSelections',
      'rhs_table' => 'jckl_filterselections',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'jckl_filtertemplates_jckl_filterselections_c',
      'join_key_lhs' => 'jckl_filtertemplates_ida',
      'join_key_rhs' => 'jckl_filterselections_idb',
    ),
  ),
  'table' => 'jckl_filtertemplates_jckl_filterselections_c',
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
    'jckl_filtertemplates_ida' =>
    array (
      'name' => 'jckl_filtertemplates_ida',
      'type' => 'id',
    ),
    'jckl_filterselections_idb' =>
    array (
      'name' => 'jckl_filterselections_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'jckl_filtertemplates_jckl_filterselectionsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'jckl_filtertemplates_jckl_filterselections_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'jckl_filtertemplates_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'jckl_filtertemplates_jckl_filterselections_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'jckl_filterselections_idb',
      ),
    ),
  ),
);