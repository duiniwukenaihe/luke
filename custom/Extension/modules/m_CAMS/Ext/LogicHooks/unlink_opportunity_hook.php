<?php
$hook_array['after_relationship_delete'][] = Array(
    1,
    'if we unlink opportunity from the cam module then account should also be deleted',
    'custom/modules/m_CAMS/LogicHooks/unlink_opportunity.php',
    'unlink_opportunity',
    'unlink_account'
);
