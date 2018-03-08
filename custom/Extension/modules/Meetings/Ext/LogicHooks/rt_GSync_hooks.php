<?php


$hook_array['after_relationship_delete'][] = Array(1, 'inviteeHandler for Meetings:Google Calendar Sync', 'custom/include/Google/google_hook.php', 'GoogleHook', 'inviteeHandler');
$hook_array['after_relationship_delete'][] = Array(2, 'Delete relationship of recurring meeting in sugarcrm', 'custom/include/Google/google_hook.php', 'GoogleHook', 'deleteRecurringEventContact');

$hook_array['before_save'][] = Array(100, 'Handling gevent_id for Meetings:Google Calendar Sync', 'custom/include/Google/google_hook.php', 'GoogleHook', 'geventHandler');

$hook_array['after_save'][] = Array(100, 'Sync all recurring meeting in sugarcrm', 'custom/include/Google/google_hook.php', 'GoogleHook', 'syncRecurringEvent');
?>