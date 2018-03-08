<?php


if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('modules/RT_DocuSign/RT_DocuSign.php');
require_once('include/utils/encryption_utils.php');
require_once('custom/modules/RT_DocuSign/DocuSign_Creadientials.php');
require_once 'custom/modules/RT_DocuSign/Configurations.php';
require_once('include/utils.php');


class RT_DocuSignConfig extends SugarApi
{
    
    public function registerApiRest()
    {
        return array(
            //GET
            'MyGetMethod' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array(
                    'RT_DocuSign',
                    'retrieve'
                ),
                //endpoint variables
                'pathVars' => array(
                    '',
                    '',
                    'info'
                ),
                //method to call
                'method' => 'MyGetMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Some help text'
                //long help to be displayed in the help documentation
                //'longHelp' => '',
            ),
            'MySaveMethod' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array(
                    'RT_DocuSign',
                    'save'
                ),
                //endpoint variables
                'pathVars' => array(
                    '',
                    '',
                    'data'
                ),
                //method to call
                'method' => 'MySaveMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Some help text'
                //long help to be displayed in the help documentation
                //'longHelp' => '',
            ),
            'Test_credientials' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array(
                    'RT_DocuSign',
                    'test'
                ),
                //endpoint variables
                'pathVars' => array(
                    '',
                    '',
                    'data'
                ),
                //method to call
                'method' => 'Test_credientials',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Some help text'
                //long help to be displayed in the help documentation
                //'longHelp' => '',
            ),
            'Test_Schedular' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array(
                    'RT_DocuSign',
                    'testschedular'
                ),
                //endpoint variables
                'pathVars' => array(
                    '',
                    '',
                    'data'
                ),
                //method to call
                'method' => 'Test_Schedular',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Some help text'
                //long help to be displayed in the help documentation
                //'longHelp' => '',
            ),
            'ValidateLicense' => array(
                'reqType' => 'GET',
                'path' => array(
                    'RT_DocuSign',
                    'validate',
                    '?'
                ),
                'pathVars' => array(
                    '',
                    '',
                    'key'
                ),
                'method' => 'validate',
                'shortHelp' => 'This method validates SugarOutfitter key',
                'longHelp' => ''
            ),
            'validateModuleLicense' => array(
                'reqType' => 'GET',
                'path' => array(
                    'RT_DocuSign',
                    'prefs'
                ),
                'pathVars' => array(
                    '',
                    ''
                ),
                'method' => 'validateModule',
                'shortHelp' => 'This method is used for validating license for modules',
                'longHelp' => ''
            ),
            'IncreaseLicense' => array(
                'reqType' => 'GET',
                'path' => array(
                    'RT_DocuSign',
                    'change',
                    '?'
                ),
                'pathVars' => array(
                    '',
                    '',
                    'key'
                ),
                'method' => 'change',
                'shortHelp' => 'This method boost user count for GSync',
                'longHelp' => ''
            ),
            'getAdminConfig' => array(
                'reqType' => 'GET',
                'path' => array(
                    'RT_DocuSign',
                    'getadmin'
                ),
                'pathVars' => array(
                    '',
                    '',
                    'data'
                ),
                'method' => 'getLicenceFromAdminConfig',
                'shortHelp' => 'This method boost user count for GSync',
                'longHelp' => ''
            )
            
        );
    }
    
    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function MyGetMethod($api, $args)
    {
        $cred     = new DocuSign_Creadientials();
        $response = $cred->getSavedCredientials();
        return $response;
    }
    
    public function MySaveMethod($api, $args)
    {
        $email           = $args['email'];
        $password        = $args['password'];
        $integratorKey   = $args['integrationkey'];
        $envoirment      = $args['envoirnment'];
        $notifications   = $args['notifications'];
        $sugarlicencekey = $args['sugarlicencekey'];
        $ds_auth_type    = $args['dsauthtype'];
        $config          = new Configurations();
        $response        = $config->varifycredientials($email, $password, $integratorKey, $envoirment, 2, $notifications, $sugarlicencekey, $ds_auth_type);
        return $response;
    }
    public function Test_credientials($api, $args)
    {
        $email         = $args['email'];
        $password      = $args['password'];
        $integratorKey = $args['integrationkey'];
        $envoirment    = $args['envoirnment'];
        $notifications = $args['notifications'];
        $config        = new Configurations();
        $response      = $config->varifycredientials($email, $password, $integratorKey, $envoirment, 1, $notifications);
        return $response;
    }
    public function Test_Schedular($api, $args)
    {
        // we will implement this method to check if RT docuSign Scheduler is enabled or not
        $label = translate('LBL_RT_DOCUSGIN_SCHEDULAR_ERROR', 'RT_DocuSign');
        return "";
    }
    //validate license key
    public function validate($api, $args)
    {
        if (!isset($GLOBALS['currentModule'])) {
            $GLOBALS['currentModule'] = "RT_DocuSign";
        }
        if (isset($args) && isset($args['key'])) {
            $_REQUEST['key'] = $args['key'];
        }
        require_once('modules/RT_DocuSign/license/OutfittersLicense.php');
        // return OutfittersLicense::validate();
        return array('data'=> true);
    }
    
    public function validateModule($api, $args)
    {
        
        $cred     = new DocuSign_Creadientials();
        $response = $cred->getAdminConfigurations();
        
        
        
        if (!isset($GLOBALS['currentModule'])) {
            $GLOBALS['currentModule'] = "RT_DocuSign";
        }
        $current_user = BeanFactory::getBean('Users', $_SESSION['user_id']);
        /*
         * Do not validate License
         */
        return array(
                'data' => true,
                'is_admin' => $current_user->is_admin
            );
        
        if (isset($response->sugarlicencekey)) {
            $_REQUEST['key'] = $response->sugarlicencekey;
            
            require_once('modules/RT_DocuSign/license/OutfittersLicense.php');
            $return_array = OutfittersLicense::validate();
            
            $return_array['is_admin'] = $current_user->is_admin;
            return array('data'=> true);
            //return $return_array;
        } else {
            return array(
                'data' => false,
                'is_admin' => $current_user->is_admin
            );
        }
    }
    
    public function change($api, $args)
    {
        if (isset($args) && isset($args['key'])) {
            $_REQUEST['key'] = $args['key'];
        }
        if (isset($args) && isset($args['user_count'])) {
            $_REQUEST['user_count'] = $args['user_count'];
        }
        require_once('modules/RT_DocuSign/license/OutfittersLicense.php');
        
        if (!isset($GLOBALS['currentModule'])) {
            $GLOBALS['currentModule'] = "RT_DocuSign";
        }
        return OutfittersLicense::change();
    }
    public function getLicenceFromAdminConfig($api, $args)
    {
        
        
        $obj   = array();
        $focus = BeanFactory::getBean('RT_DocuSign');
        // first we try to  get the admin configurations.
        $focus->retrieve_by_string_fields(array(
            'docusign_sugar_crm_userid' => 1
        ));
        
        $obj['email']                        = $focus->docusign_username;
        $key                                 = blowfishGetKey("RT_DocuSign");
        $decrypt                             = blowfishDecode($key, $focus->docusign_password);
        $obj['password']                     = $decrypt;
        $obj['integrator_key']               = $focus->docusign_integrationkey;
        $obj['environment']                  = $focus->docusign_connection_envoirnment;
        $obj['baseurl']                      = $focus->docusign_base_url;
        $obj['accountId']                    = $focus->docusign_accountid;
        $obj['notificationurl']              = $focus->docusign_notification_url;
        $obj['version']                      = "v2";
        $obj['sugarlicencekey']              = $focus->docusign_sugar_licence_key;
        $obj['docusign_authentication_type'] = $focus->docusign_authentication_type;
        $obj['docusign_sugar_crm_userid']    = $focus->docusign_sugar_crm_userid;
        return $obj;
        
    }
}
