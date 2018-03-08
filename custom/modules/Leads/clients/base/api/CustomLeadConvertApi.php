<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*******************************************************************************************************
	 * Description : Calling the Custom Lead Convert in Custom Lead Convert API
	 * Created by  : Mohammed Jhosawa @ BHEA.
	 * Date Created : 16th September, 2017.
	 * Copyright (C) SugarCRM Inc. All rights reserved.
 *******************************************************************************************************/
require_once('clients/base/api/ModuleApi.php');
require_once('modules/Leads/clients/base/api/LeadConvertApi.php');
require_once('modules/Leads/LeadConvert.php');
require_once('custom/modules/Leads/CustomDeleteConvert.php');

class CustomLeadConvertApi extends LeadConvertApi
{
   public function registerApiRest()
    {
        //in case we want to add additional endpoints
        return parent::registerApiRest();
    }
/*******************************************************************************************************
	* This method handles the /Lead/:id/convert REST endpoint
	* @param $api ServiceBase The API class of the request, used in cases where the API changes how the
	* fields are pulled from the args array.
	* @param $args array The arguments array passed in from the API
	* @return Array of worksheet data entries
	* @throws SugarApiExceptionNotAuthorized
	* Copyright (C) SugarCRM Inc. All rights reserved.
*******************************************************************************************************/
    public function convertLead($api, $args)
    {
        $leadConvert = new LeadConvert($args['leadId']);
        $modules = $this->loadModules($api, $leadConvert->getAvailableModules(), $args['modules']);

        $transferActivitiesModules =
            empty($args['transfer_activities_modules']) ? array() : $args['transfer_activities_modules'];
        $transferActivitiesAction =
            empty($args['transfer_activities_action']) ? '' : $args['transfer_activities_action'];

        $modules = $leadConvert->convertLead($modules, $transferActivitiesAction, $transferActivitiesModules);
        
        try{    
			// delete the converted lead    
			$deleteConvert = new CustomDeleteConvert($args['leadId']);
		}
		catch(Exception $e){
			throw new SugarApiException("Converted Lead couldn't delete", null, null, 424);
		}
		
        return array (
            'modules' => $this->formatBeans($api, $args, $modules)
        );
    }

  
}

