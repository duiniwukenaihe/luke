<?php

$moduleName = 'DRI_SubWorkflow_Templates';
$objectName = 'DRI_SubWorkflow_Template';

$viewdefs[$moduleName]['base']['layout']['subpanels'] = array (
    'components' => array (
        array (
            'layout' => 'subpanel',
            'label' => 'LBL_DRI_WORKFLOW_TASK_TEMPLATES',
            'context' => array(
                'link' => 'dri_workflow_task_templates',
            ),
        ),
    ),
    'type' => 'subpanels',
    'span' => 12,
);
