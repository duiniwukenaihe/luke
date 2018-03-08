<?php

use Sugarcrm\Sugarcrm\ProcessManager\Registry;
/**
* 
*/
class WorkflowHooks
{
	
	function clearTriggeredStartsRegistry($bean, $event, $arguments)
	{
		Registry\Registry::getInstance()->drop('triggered_starts');
	}
}