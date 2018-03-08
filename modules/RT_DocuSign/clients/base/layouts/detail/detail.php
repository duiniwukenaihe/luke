<?php
$module_name = 'RT_DocuSign';
$viewdefs[$module_name]['base']['layout']['detail'] = array(
    'type' => 'detail',
    'components' => array(
        array(
            'view' => 'subnavdetail',
        ),
        array(
            'view' => 'detail',
        ),
    ),
);