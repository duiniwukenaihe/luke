<?php


class SetWarrantyExp
{
	
	function before_save($opportunity, $event, $args)
	{
		if(self::emptyCloseDate($opportunity)){
			return false;
		}

		$timedate = new TimeDate();
		$closeDate = $timedate->fromDbDate($opportunity->date_closed);

		if(is_null($closeDate)){
			return false;
		}

		$adjusted = $closeDate->modify("+365 days");

		$opportunity->warranty_exp = $adjusted->asDbDate();

	}

	protected static function emptyCloseDate($opp)
	{
		return  empty($opp->date_closed);
	}
}