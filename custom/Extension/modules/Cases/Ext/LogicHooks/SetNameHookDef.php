<?php
$hook_array['after_save'][] = Array(
	1,
	'Set the Name field properly',
	'custom/modules/Cases/SetName.php',
	'SetName',
	'after_save_method'
);
// custom/Extension/modules/Cases/Ext/LogicHooks/NAME.php