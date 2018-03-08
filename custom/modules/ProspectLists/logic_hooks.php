<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(99,'Unlink related targets, contacts or leads and sync members','custom/include/MailChimp/MailChimpConnector.php','MailChimpConnector','beforeSave',);
$hook_array['after_relationship_delete'] = Array(); 
$hook_array['after_relationship_delete'][] = Array(99,'Remove subscriber from mailchimp list when unlinked from sugarcrm','custom/include/MailChimp/MailChimpConnector.php','MailChimpConnector','afterRelationshipDelete',);



?>