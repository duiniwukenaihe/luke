<?php

require_once('include/utils.php');
/**
 * Copyright (c) 2015 Rolustech
 * All rights reserved. 
 **/
 
class DocuSign_Creadientials
{
    
    public $integrator_key;
    public $email;
    public $password;
    public $version;
    public $environment;
    public $accountId;
    public $baseurl;
    public $notificationurl;
	public $sugarlicencekey;
	public $docusign_authentication_type;
	public $docusign_sugar_crm_userid;
	public $config_status;
	public $Is_current_user_admin;
    
	/**
		This function will return saved credentials of 
		@param mode 
	*/
    public function getSavedCredientials($send_user_id=null)
    {
		if(isset ($_SESSION['user_id']))
		{
			$current_user = BeanFactory::getBean('Users',$_SESSION['user_id']);
		}
		else 
		{
			
			if(is_null ($send_user_id))
			{
				$current_user = BeanFactory::getBean('Users','1');
				
			}
			else 
			{
				/*$bean=BeanFactory::getBean('DP_DoucumentsPackets';
				$bean->retrieve_by_string_fields(array(
						'docusignenvelopeid' => $send_user_id
				));*/
				$current_user = BeanFactory::getBean('Users',$send_user_id);
			}
		}
		$this->Is_current_user_admin=$current_user->is_admin;
		
        $focus = BeanFactory::getBean('RT_DocuSign');
		// first we try to  get the admin configurations.
        $focus->retrieve_by_string_fields(array(
            'docusign_sugar_crm_userid' => 1
        ));
		
		
		// to check if admin has save configuration or not.
		if((isset ($focus->docusign_authentication_type))&&(isset ($focus->docusign_username))&&(isset ($focus->docusign_integrationkey)))
		{
			// now we check whether he has set global authentication or user based authentication
			if($focus->docusign_authentication_type=='global')
			{				
				// if admin has set global then we return his own credentials
				$this->email           = $focus->docusign_username;
				$key                   = blowfishGetKey("RT_DocuSign");
				$decrypt               = blowfishDecode($key, $focus->docusign_password);
				$this->password        = $decrypt;
				$this->integrator_key  = $focus->docusign_integrationkey;
				$this->environment     = $focus->docusign_connection_envoirnment;
				$this->baseurl         = $focus->docusign_base_url;
				$this->accountId       = $focus->docusign_accountid;
				$this->notificationurl = $focus->docusign_notification_url;
				$this->version         = "v2";
				$this->sugarlicencekey = $focus->docusign_sugar_licence_key;
				$this->docusign_authentication_type       = $focus->docusign_authentication_type;
				$this->docusign_sugar_crm_userid 		  = $focus->docusign_sugar_crm_userid;
				return $this;
			}
			else if ($focus->docusign_authentication_type=='user')
			{					
				// if he has set docusign_authentication_type='user' then we will return current user's configurations.
				$current_user_configs = BeanFactory::getBean('RT_DocuSign');
				if(isset($_SESSION['user_id']))
				{
					$current_user_configs->retrieve_by_string_fields(array(
						'docusign_sugar_crm_userid' => $_SESSION['user_id']
					));
				}
				else 
				{
					if(is_null($send_user_id))
					{
						$current_user_configs->retrieve_by_string_fields(array(
							'docusign_sugar_crm_userid' => '1'
						));
						
					}
					else 
					{
						/*$bean=BeanFactory::getBean('DP_DoucumentsPackets';
						$bean->retrieve_by_string_fields(array(
								'docusignenvelopeid' => $send_user_id
						));*/
						$current_user_configs->retrieve_by_string_fields(array(
							'docusign_sugar_crm_userid' => $send_user_id
						));
					}
				}
				if((isset ($current_user_configs->docusign_authentication_type))&&(isset ($current_user_configs->docusign_username))&&(isset ($current_user_configs->docusign_integrationkey))){
					$this->email           = $current_user_configs->docusign_username;
					$key                   = blowfishGetKey("RT_DocuSign");
					$decrypt               = blowfishDecode($key, $current_user_configs->docusign_password);
					$this->password        = $decrypt;
					$this->integrator_key  = $current_user_configs->docusign_integrationkey;
					$this->environment     = $current_user_configs->docusign_connection_envoirnment;
					$this->baseurl         = $current_user_configs->docusign_base_url;
					$this->accountId       = $current_user_configs->docusign_accountid;
					$this->notificationurl = $current_user_configs->docusign_notification_url;
					$this->version         = "v2";
					$this->sugarlicencekey = $current_user_configs->docusign_sugar_licence_key;
					$this->docusign_authentication_type       = $current_user_configs->docusign_authentication_type;
					$this->docusign_sugar_crm_userid 		  = $current_user_configs->docusign_sugar_crm_userid;
					return $this;
				}
				else {
					$this->config_status=translate('LBL_RT_DOCUSIGN_USER_CONFIG_NOT_SET', 'RT_DocuSign');
					return $this;
				}
			}
		}
		else {
			// when admin user has not configured.			
			$this->config_status=translate('LBL_RT_DOCUSIGN_ADMIN_CONFIG_NOT_SET', 'RT_DocuSign');
			return $this;
		}
        
    }
	public function getAdminConfigurations(){
		
		$focus = BeanFactory::getBean('RT_DocuSign');
		// first we try to  get the admin configurations.
        $focus->retrieve_by_string_fields(array(
            'docusign_sugar_crm_userid' => 1
        ));
		$this->email           = $focus->docusign_username;
		$key                   = blowfishGetKey("RT_DocuSign");
		$decrypt               = blowfishDecode($key, $focus->docusign_password);
		$this->password        = $decrypt;
		$this->integrator_key  = $focus->docusign_integrationkey;
		$this->environment     = $focus->docusign_connection_envoirnment;
		$this->baseurl         = $focus->docusign_base_url;
		$this->accountId       = $focus->docusign_accountid;
		$this->notificationurl = $focus->docusign_notification_url;
		$this->version         = "v2";
		$this->sugarlicencekey = $focus->docusign_sugar_licence_key;
		$this->docusign_authentication_type       = $focus->docusign_authentication_type;
		$this->docusign_sugar_crm_userid 		  = $focus->docusign_sugar_crm_userid;
		return $this;
		
	}
}

?>