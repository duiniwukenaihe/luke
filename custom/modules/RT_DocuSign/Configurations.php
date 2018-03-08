<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

/**
 * Copyright (c) 2015 Rolustech
 * All rights reserved.
 **/

require_once 'custom/modules/RT_DocuSign/lib/src/DocuSign_Client.php';
require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_AccountService.php';
require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_LoginService.php';
require_once 'custom/modules/RT_DocuSign/DocuSign_Creadientials.php';
require_once('include/utils.php');

class Configurations
{
    
    public function getCredientials($send_user_id=null)
    {
        $cred     = new DocuSign_Creadientials();
        $cred_arr = (array) $cred->getSavedCredientials($send_user_id);
        return $cred_arr;
    }
    
    public function varifycredientials($email, $password, $integratorKey, $envoirment, $mode, $notifications = null, $sugarlicencekey = null, $ds_auth_type = null)
    {
        $cred                 = new DocuSign_Creadientials();
        $cred->email          = $email;
        $cred->password       = $password;
        $cred->integrator_key = $integratorKey;
        $cred->environment    = $envoirment;
        $cred->version        = "v2";
        
        $client = new DocuSign_Client((array) $cred);
        if ($client->hasError()) {
            return $client->errorMessage;
        }
        $login_service   = new DocuSign_LoginService($client);
        $login_rescource = new DocuSign_LoginResource($login_service);
        $logininfo       = $login_rescource->getLoginInformation();
        if (isset($logininfo)) {
            if ($mode == 1) {
                return translate('LBL_RT_DOCUSGIN_TEST_CONNECTION_SUCCESS', 'RT_DocuSign');
            } else {
                
                $baseurl   = "";
                $accountId = "";
                foreach ($logininfo->loginAccounts as &$loginfo) {
                    $baseurl   = $loginfo->baseUrl;
                    $accountId = $loginfo->accountId;
                }
                
                
                //echo "RT DocuSign is successfully Configured !";
                $record_id = $this->savecredientials($email, $password, $integratorKey, $envoirment, $accountId, $baseurl, $notifications, $sugarlicencekey, $ds_auth_type);
                if (isset($record_id)) {
                    return translate('LBL_RT_DOCUSGIN_SAVE_SUCCESS', 'RT_DocuSign');
                } else {
                    return translate('LBL_RT_DOCUSGIN_SAVE_ERROR', 'RT_DocuSign');
                }
            }
        } else {
            return translate('LBL_RT_DOCUSGIN_CONFIG_ERROR', 'RT_DocuSign');
        }
    }
    function savecredientials($email, $password, $integratorKey, $envoirment, $accountId, $baseUrl, $notifications, $sugarlicencekey, $ds_auth_type)
    {
        $focus = BeanFactory::getBean('RT_DocuSign');
        
        $focus->retrieve_by_string_fields(array(
            'docusign_sugar_crm_userid' => $_SESSION['user_id']
        ));
        $focus->name                            = 'RT_DocuSign';
        $focus->docusign_username               = $email;
        $key                                    = blowfishGetKey("RT_DocuSign");
        $encoded                                = blowfishEncode($key, $password);
        $focus->docusign_password               = $encoded;
        $focus->docusign_integrationkey         = $integratorKey;
        $focus->docusign_connection_envoirnment = $envoirment;
        $focus->docusign_accountid              = $accountId;
        $focus->docusign_base_url               = $baseUrl;
        $focus->docusign_notification_url       = $notifications;
        $focus->docusign_sugar_licence_key      = $sugarlicencekey;
        $focus->docusign_authentication_type    = $ds_auth_type;
        $focus->docusign_sugar_crm_userid       = $_SESSION['user_id'];
        $recid                                  = $focus->save();
        return $recid;
    }
    
}