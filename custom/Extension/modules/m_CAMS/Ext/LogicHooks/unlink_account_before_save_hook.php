<?php

$hook_array['before_save'][] = Array(
    1,
    'if we unlink opportunity from the cam module before saving then account should also be deleted',
    'custom/modules/m_CAMS/LogicHooks/unlink_account_before_save.php',
    'unlink_account_before_save',
    'unlink_account_before_save'
);

