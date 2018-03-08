<?php

class SetName
{
	
	function after_save_method($case, $event, $args)
	{
		if(self::isUpdate($args)){
			return false;
		}

		if(self::nameStartswithCaseNumber($case)){
			return true;
		}

		$databaseBean = BeanFactory::retrieveBean('Cases',$case->id, ['use_cache' => false]);
		$case->case_number = $databaseBean->case_number;
		$case->save();

		return;
	}

	protected static function isUpdate($args)
	{
		return $args['isUpdate'];
	}

	protected static function nameStartswithCaseNumber($case)
	{
		$name = $case->name;
		$number = $case->case_number;

		return stripos($name, $number) === 0;
	}
}