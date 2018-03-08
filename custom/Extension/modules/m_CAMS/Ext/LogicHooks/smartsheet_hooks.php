<?php

$hook_version = 1;
$hook_array = Array();

$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(
    //Processing index. For sorting the array.
    1,

    //Label. A string value to identify the hook.
    'smartsheet logic hooks',

    //The PHP file where your class is located.
    'custom/modules/m_CAMS/LogicHooks/m_CAMSLogicHookClass.php',

    //The class the method is in.
    'm_CAMSLogicHookClass',

    //The method to call.
    'beforeSave'
);