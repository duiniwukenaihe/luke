<?php
$module_name = 'mv_SrvReq';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'form' => 
          array (
            'buttons' => 
            array (
              0 => 'EDIT',
              1 => 'DUPLICATE',
              2 => 'DELETE',
            ),
          ),
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'name',
              1 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
              ),
              2 => 
              array (
                'name' => 'description',
                'comment' => 'Full text of the note',
                'studio' => 'visible',
                'label' => 'LBL_DESCRIPTION',
              ),
              3 => 
              array (
                'name' => 'category',
                'label' => 'LBL_CATEGORY',
              ),
              4 => 
              array (
                'name' => 'responsible_party',
                'studio' => 'visible',
                'label' => 'LBL_RESPONSIBLE_PARTY',
              ),
              5 => 
              array (
                'name' => 'root_cause',
                'label' => 'LBL_ROOT_CAUSE',
              ),
              6 => 
              array (
                'name' => 'cases_mv_srvreq_1_name',
                'label' => 'LBL_CASES_MV_SRVREQ_1_FROM_CASES_TITLE',
              ),
              7 => 'assigned_user_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
