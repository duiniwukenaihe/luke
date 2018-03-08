<?php
$module_name = 'docus_DocuSign_Configuration';
$viewdefs[$module_name]['base']['layout']['edit'] = array(
    'type' => 'edit',
    'components' => array(
        array(
            'view' => 'subnavedit',
        ),
        array(
            'view' => 'edit',
        )
    ),
);