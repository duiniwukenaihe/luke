<?php
/*
 * overridden
 */
$module_name = 'rt_GSync';
$viewdefs[$module_name]['base']['layout']['list'] = array(
    'components' => array(
        array(
            'view' => 'record',
            'primary' => true,
        ),
    ),
);
