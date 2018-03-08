<?php
$popupMeta = array (
    'moduleMain' => 'DRI_Workflow_Template',
    'varName' => 'DRI_Workflow_Template',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'dri_workflow_templates.name',
),
    'searchInputs' => array (
  0 => 'name',
),
    'searchdefs' => array (
  0 => 'name',
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'TEAM_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'label' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
),
);
