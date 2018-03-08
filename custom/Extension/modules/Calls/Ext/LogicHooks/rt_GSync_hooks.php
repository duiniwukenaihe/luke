<?php

$hook_array['before_save'][] = Array(100, 'Handling gevent_id for Calls:Google Calendar Sync', 'custom/include/Google/google_hook.php', 'GoogleHook', 'geventHandler');

$hook_array['after_relationship_delete'][] = Array(100, 'inviteeHandler for Calls:Google Calendar Sync', 'custom/include/Google/google_hook.php', 'GoogleHook', 'inviteeHandler');

?>