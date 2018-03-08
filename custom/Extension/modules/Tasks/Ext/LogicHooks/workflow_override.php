<?php

$hook_array['after_save'][] = array (
    101,
    'Clear triggered starts registry to enable Adv Workflow to run more than once',
    'custom/include/Datasync/clearRegistryHook.php',
    'WorkflowHooks',
    'clearTriggeredStartsRegistry'
);