<?php
// created: 2017-05-06 15:26:06
$dictionary["jckl_FilterDeployments"]["fields"]["jckl_filtertemplates_jckl_filterdeployments"] = array (
  'name' => 'jckl_filtertemplates_jckl_filterdeployments',
  'type' => 'link',
  'relationship' => 'jckl_filtertemplates_jckl_filterdeployments',
  'source' => 'non-db',
  'module' => 'jckl_FilterTemplates',
  'bean_name' => 'jckl_FilterTemplates',
  'side' => 'right',
  'vname' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERDEPLOYMENTS_FROM_JCKL_FILTERDEPLOYMENTS_TITLE',
  'id_name' => 'jckl_filtertemplates_ida',
  'link-type' => 'one',
);
$dictionary["jckl_FilterDeployments"]["fields"]["jckl_filtertemplates_jckl_filterdeployments_name"] = array (
  'name' => 'jckl_filtertemplates_jckl_filterdeployments_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERDEPLOYMENTS_FROM_JCKL_FILTERTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'jckl_filtertemplates_ida',
  'link' => 'jckl_filtertemplates_jckl_filterdeployments',
  'table' => 'jckl_filtertemplates',
  'module' => 'jckl_FilterTemplates',
  'rname' => 'name',
);
$dictionary["jckl_FilterDeployments"]["fields"]["jckl_filtertemplates_ida"] = array (
  'name' => 'jckl_filtertemplates_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_JCKL_FILTERTEMPLATES_JCKL_FILTERDEPLOYMENTS_FROM_JCKL_FILTERDEPLOYMENTS_TITLE_ID',
  'id_name' => 'jckl_filtertemplates_ida',
  'link' => 'jckl_filtertemplates_jckl_filterdeployments',
  'table' => 'jckl_filtertemplates',
  'module' => 'jckl_FilterTemplates',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
