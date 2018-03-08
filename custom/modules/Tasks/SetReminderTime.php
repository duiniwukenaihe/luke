<?php

class SetReminderTime
{
	
	function before_save_method($bean, $event, $arguments)
	{
		if( $bean->remind_me_c AND $bean->duration_till_remind_c AND $bean->date_due){

			$timedate = new TimeDate();
			$datetime = $timedate->fromDb($bean->date_due);

			$adjusted = $datetime->modify("-{$bean->duration_till_remind_c} seconds");

			$bean->reminder_time_c = $adjusted->asDb();
		}
		
	}
}