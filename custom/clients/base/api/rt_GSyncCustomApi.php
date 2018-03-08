<?php
/*20'1'4-0'1'-'1'0JH*/
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
* CustomAPI class to register REST api functions
*
* This class has various functions to help perform methods quickly
* through REST API
*
*/
class rt_GSyncCustomApi extends SugarApi
{
    /**
    * Register functions with the REST API
    *
    * @param  
    * @return 
    * @access public
    */
    public function registerApiRest()
    {
        return array(
            'rt_GSyncGetUserConfig' => array(
                'reqType' => 'GET',
                'path' => array('rt_GSyncConfig', 'prefs'),
                'pathVars' => array('', ''),
                'method' => 'userConfig',
                'shortHelp' => 'This method is used for user configuration options',
                'longHelp' => '',
            ),
            'getSugarVersion' => array(
                'reqType' => 'GET',
                'path' => array('sugar_version',),
                'pathVars' => array('',),
                'method' => 'getSugarVersion',
                'shortHelp' => 'This method returns sugar_version from config',
                'longHelp' => '',
            ),
        );
    }

    /**
    * get sugarcrm version from config
    *
    *
    * @param  object $api  API  
    * @param  array  $args key provided by the user
    * @return string   $sugar_version
    * @access public
    */
    public function getSugarVersion($api, $args)
    {
        $sugar_version = SugarConfig::getInstance()->get('sugar_version');
        return $sugar_version;
    }

    /**
    * getters, setters for gsync users, gsync schedulars
    *
    *
    * First case gets state of schedulars as either active or inactive
    * Second case sets state of schedulars as either active or inactive
    * Third case gets all the gsync enabled users
    * Forth case registers new users
    * @param  object $api                         API  
    * @param  array  $args              Method to call
    * @return bool   $response          response from the function calls
    * @access public
    */
    public function userConfig($api, $args)
    {
        require_once("custom/include/rt_GSync/apiCalls/rt_GSyncApiCalls.php");
        $response = array();
        $rt_GSyncApiCalls = new rt_GSyncApiCalls();
        if (!empty($args['method']) && method_exists($rt_GSyncApiCalls, $args['method'])) {
            switch ($args['method']) {
                case 'getPreferences':
                    $response = $rt_GSyncApiCalls->getPreferences($args);
                    break;
                case 'setPreferences':
                    $response = $rt_GSyncApiCalls->setPreferences($args);
                    break;
                case 'getUserConfig':
                    $response = $rt_GSyncApiCalls->getUserConfig($args);
                    break;
                case 'setUserConfig':
                    $response = $rt_GSyncApiCalls->setUserConfig($args);
                    break;
                default:
                    break;
            }
        } else {
            //
        }
        return $response;
        // $all_users = getAllUsers();
        // $enabled_users = getGSyncUsers();
        // return array('all_users'=> $all_users,'enabled_users'=> $enabled_users);
    }
    /**
    * I failed to understand core existance of my nature
    *
    *
    * The truth is I don't even know why I was created in the first place
    * @param  object $api               API  
    * @param  array  $args              args
    * @return bool   $args              args
    * @access public
    */
    public function saveUserConfig($api, $args)
    {
        return $args;
    }
}
