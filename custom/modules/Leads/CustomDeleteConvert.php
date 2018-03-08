<?php
/********************************************************************************************************
	 * Description : Delete the lead after conversion
	 * Created by  : Mohammed Jhosawa @ BHEA.
	 * Date Created : 16th September, 2017.
	 * Copyright (C) SugarCRM Inc. All rights reserved.
 *******************************************************************************************************/
require_once('modules/Campaigns/utils.php');
class CustomDeleteConvert {
	
	public function __construct($leadId)
    {
		$this->deleteConvertLead($leadId);
	}
	
	/** @BHEA
	* Delete  the Converted Lead 
	*/
	public function deleteConvertLead($args)
	{
		
		$this->lead = BeanFactory::getBean('Leads', $args, array('strict_retrieve' => true));
	   
		if (empty($this->lead)) {
            $errorMessage = string_format('Could not find record: {0} in module: Leads', $args);
            throw new Exception($errorMessage);
        }else{        
			// mark the lead deleted after conversion
			$this->lead->mark_deleted($this->lead->id);
		}
	
	}
}


