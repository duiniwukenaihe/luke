<?php
require_once("custom/include/Google/CalendarHelper.php");
require_once("custom/include/Google/ContactHelper.php");
require_once("vendor/Zend/Gdata/ClientLogin.php");
if (sugar_is_file('custom/include/Google/google-api-php-client/src/Google_Client.php')) {
    require_once 'custom/include/Google/google-api-php-client/src/Google_Client.php';
    require_once 'custom/include/Google/google-api-php-client/src/contrib/Google_CalendarService.php';
    require_once 'custom/include/Google/google-api-php-client/src/contrib/Google_DriveService.php';
    require_once 'custom/include/Google/DriveHelper.php';
    require_once 'custom/include/Google/lib/GoogleOauthHandler.php';
}
/**
* GoogleHelper performs different types of syncs with the help of appropriate helpers (e.g. CalendarHelper.php)
*
* The class has various functions, the handler is performSync which calls appropriate function accordingly
*
*/
class GoogleHelper
{
    var $calendar_client;
    var $docs_client;
    var $contact_client;
    var $userID;
    var $user_email;
    var $google_client;
    var $auth_handler;
    var $drive_service;
    var $prefrences;

    /**
    * Main function of GoogleHelper
    *
    * decides which function to call based on syncType passed
    *
    * @param  string  $user       user
    * @param  string  $pass       pass
    * @param  string  $id         current user id
    * @param  date    $lastSync   Last time sync was performed
    * @param  string  $syncType   SyncType to perform (call, contacts or calendar, default is calendar)
    */
    function performSync($user = '', $id = '', $lastSync, $syncType = "calendar")
    {
        $this->userID = $id;
        $this->user_email = $user;
        switch ($syncType) {
            case "calendar":
                $this->init_sync();
                $this->syncCalendar($lastSync);
                break;
            case "calendarRecurring":
                // TODO
                // $this->calendar_client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, Zend_Gdata_Calendar::AUTH_SERVICE_NAME)->setConfig(array(
                // "timeout" => 100
                // ));
                // $this->syncCalendarRecurring(date());//pass date object
                break;
            case "contacts":
                $this->init_sync();
                //    $this->contact_client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, 'cp');
                $this->syncContacts($lastSync);
                break;
            case "drive":
                $this->init_sync();
                $this->syncGdrive($lastSync);
                break;
            default:
                $GLOBALS['log']->fatal('$syncType is required');
                break;
        }
    }
    /**
    * Syncs calendar events to/from Google
    *
    * <b>Function break down</b>
    * <ol>
    * <li>Creates/initializes google client</li>
    * <li>Calls updateFromGoogle() of calendarHelper which will fetch new events from google, save those on sugar and return their sugar ids</li>
    * <li>
    *   then calls retrieveUpdatedFromSugar and pass ids from returned from above function call, 
    *   those ids will be ignored in retrieving updated records from sugar.
    *   This will return updated records from Sugar Calendar in the form of array of beans
    * </li>
    * <li>Beans from previous step are forwarded to sendUpdatedToGoogle() which updates calendar on Google</li>
    * </ol>
    * @param  date    $lastSync   Last time sync was performed
    */
    function syncCalendar($lastSync)
    {
        $current_date = date($GLOBALS['timedate']->get_db_date_time_format());
        $dateAdded = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($current_date)) . "+03 seconds");
        $last_synch = gmdate($GLOBALS['timedate']->get_db_date_time_format(), $dateAdded);

        $GLOBALS['log']->fatal('GOOGLE-TO-SUGAR');
        $jsonCredentials = $this->auth_handler->getStoredCredentials($this->userID);
        if ($jsonCredentials) {
            $oauthCredentials = $this->auth_handler->getOauth2Credentials($jsonCredentials);
            $this->google_client->setAccessToken($oauthCredentials->toJson());
            if ($this->google_client->getAccessToken()) {
                $this->calendar_client = new Google_CalendarService($this->google_client);
                $this->google_client->setUseObjects(true);
                $ids = array();
                $ids = CalendarHelper::updateFromGoogle($this->calendar_client, $this->userID, $this->user_email, $lastSync, false, $this->prefrences);

                $GLOBALS['log']->fatal('SUGAR-TO-GOOGLE');
                $beans = CalendarHelper::retrieveUpdatedFromSugar($this->calendar_client, $this->userID, $lastSync, $ids, $this->prefrences);
                CalendarHelper::sendUpdatedToGoogle($this->calendar_client, $beans, $this->userID);

                //last sync date saving to db
                $sql_update = "UPDATE users set lastsync_calendar='" . $last_synch . "' WHERE id='" . $this->userID . "'";
                $res_update = $GLOBALS['db']->query($sql_update);
            } else {
                $GLOBALS['log']->fatal("error occured while getting access token for userID: " . $this->userID);
            }
        } else {
            $GLOBALS['log']->fatal("No google auth credentials saved for userID : " . $this->userID);
            //die();
        }
    }
    /**
    * Syncs recurring calendar events from Google
    *
    * <b>Function break down</b>
    * <ol>
    * <li>Calls updateFromGoogle() of calendarHelper which will fetch new events from google, save those on sugar and return their sugar ids</li>
    * </ol>
    * @param  date    $lastSync   Last time sync was performed
    */
    function syncCalendarRecurring($lastSync)
    {
        $GLOBALS['log']->fatal('GOOGLE-TO-SUGAR: recurring events');
        $ids = CalendarHelper::updateFromGoogle($this->calendar_client, $this->userID, $this->user_email, $lastSync, true);
    }
    /**
    * cleanCalendarSync
    *
    */
    function cleanCalendarSync()
    {
        $date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format());
        CalendarHelper::cleanCalendarSync($this->calendar_client, $this->userID, $date_modified);
    }
    /**
    * Syncs contacts to/from Google
    *
    * <b>Function break down</b>
    * <ol>
    * <li>Creates/initializes google client</li>
    * <li>Calls updateFromGoogle() of calendarHelper which will fetch new contacts from google, save those on sugar and return their sugar ids</li>
    * <li>
    *   then calls retrieveUpdatedFromSugar and pass ids from returned from above function call, 
    *   those ids will be ignored in retrieving updated records from sugar.
    *   This will return updated records from Sugar contacts in the form of an array of beans
    * </li>
    * <li>Beans from previous step are forwarded to sendUpdatedToGoogle() which updates contacts on Google</li>
    * </ol>
    * @param  date    $lastSync   Last time sync was performed
    */
    function syncContacts($lastSync)
    {
        $jsonCredentials = $this->auth_handler->getStoredCredentials($this->userID);
        if ($jsonCredentials) {
            $oauthCredentials = $this->auth_handler->getOauth2Credentials($jsonCredentials);
            $this->google_client->setAccessToken($oauthCredentials->toJson());
            if ($this->google_client->getAccessToken()) {
                $ids = array();
                if ($this->prefrences["schedulers"]["contacts_google"] == true) {
                    $GLOBALS['log']->fatal('GOOGLE-TO-SUGAR');
                    $ids = ContactHelper::updateFromGoogle($this->google_client, $this->userID, $lastSync, $this->user_email);
                }
                if ($this->prefrences["schedulers"]["contacts_sugar"] == true) {
                    $GLOBALS['log']->fatal('SUGAR-TO-GOOGLE');
                    $beans = ContactHelper::retrieveUpdatedFromSugar($this->google_client, $this->userID, $lastSync, $ids, $this->user_email);
                    ContactHelper::sendUpdatedToGoogle($beans, $this->user_email, $this->google_client);
                }
            }
        } else {
            $GLOBALS['log']->fatal("Please re save gmail id and credentials");
        }

    }
    /**
    * Initializes google_client and auth_handler to be used in performing sync
    *
    */
    function init_sync()
    {
        global $sugar_config;
        $this->google_client = new Google_Client();
        $this->auth_handler = new GoogleOauthHandler();
        $this->google_client->setClientId($sugar_config['GOOGLE']['CLIENT_ID']);
        $this->google_client->setClientSecret($sugar_config['GOOGLE']['CLIENT_SECRET']);
        $this->google_client->setRedirectUri($sugar_config['GOOGLE']['REDIRECT_URI']);
        $this->google_client->setScopes($sugar_config['GOOGLE']['SCOPES']);
    }
    /**
    * Syncs documents to/from Google
    *
    * <b>Function break down</b>
    * <ol>
    * <li>Creates/initializes google client</li>
    * <li>Calls updateFromGoogle() of calendarHelper which will fetch new documents from google, save those on sugar and return their sugar ids</li>
    * <li>
    *   then calls retrieveUpdatedFromSugar and pass ids from returned from above function call, 
    *   those ids will be ignored in retrieving updated records from sugar.
    *   This will return updated documents from Sugar in the form of an array of beans
    * </li>
    * <li>Beans from previous step are forwarded to sendUpdatedToGoogle() which updates documents on Google</li>
    * </ol>
    * @param  date    $lastSync   Last time sync was performed
    */
    function syncGdrive($lastSync)
    {
        $GLOBALS['log']->fatal('*********syncGdrive-START**********');
        $jsonCredentials = $this->auth_handler->getStoredCredentials($this->userID);
        if ($jsonCredentials) {
            $oauthCredentials = $this->auth_handler->getOauth2Credentials($jsonCredentials);
            $this->google_client->setAccessToken($oauthCredentials->toJson());
            if ($this->google_client->getAccessToken()) {
                $this->drive_service = new Google_DriveService($this->google_client);
                $this->google_client->setUseObjects(true);
                $ids = array();
                if ($this->prefrences["schedulers"]["documents_google"] == true) {
                    $GLOBALS['log']->fatal('GOOGLE-TO-SUGAR');
                    $ids = DriveHelper::updateFromGoogle($this->drive_service, $this->userID, $lastSync);
                }
                if ($this->prefrences["schedulers"]["documents_sugar"] == true) {
                    $GLOBALS['log']->fatal('SUGAR-TO-GOOGLE');
                    $beans = DriveHelper::retrieveUpdatedFromSugar($this->userID, $lastSync, $ids);
                    DriveHelper::sendUpdatedToGoogle($this->drive_service, $beans);
                }
            } else {
                $GLOBALS['log']->fatal("error occured while getting access token for userID: " . $this->userID);
            }
        } else {
            $GLOBALS['log']->fatal("No google auth credentials saved for userID : " . $this->userID);
        }

        $GLOBALS['log']->fatal('*********syncGdrive-END**********');
    }
    /**
    * Clean Sync
    */
    function cleanSync($user = '', $id = '')
    {
        $this->userID = $id;
        $this->user_email = $user;
        try {
            $GLOBALS['log']->fatal('Started: Clean Google Sync');
            $GLOBALS['log']->fatal('Initializing login process');
            $this->init_sync();
            $jsonCredentials = $this->auth_handler->getStoredCredentials($this->userID);
            if ($jsonCredentials) {
                $oauthCredentials = $this->auth_handler->getOauth2Credentials($jsonCredentials);
                $this->google_client->setAccessToken($oauthCredentials->toJson());
                if ($this->google_client->getAccessToken()) {
                    $this->calendar_client = new Google_CalendarService($this->google_client);
                    $this->google_client->setUseObjects(true);
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
        }
        $GLOBALS['log']->fatal('Started: Clean Calendar Sync');
        $this->cleanCalendarSync();
        $GLOBALS['log']->fatal('Completed: Clean Google Sync');
    }
    /**
    * Given a column name and table name, check if that column exists in the table
    *
    *
    * @param  string    $table   table name to look in
    * @param  string    $column  column to check
    * @return bool      true     if exists, false otherwise
    */
    public static function check_column_if_exist($db_name, $table, $column)
    {
        global $db;
        /*$sql="SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$db_name."' AND TABLE_NAME = '".$table."' AND COLUMN_NAME = '".$column."'";
        $r=$db->query($sql);
        $fields=$db->fetchByAssoc($r);
        if($fields){
            return true;
        }else{
            return false;
        }*/
        $cols = $db->get_columns($table);
        //if(isset($field) && isset($field['count']) && $field['count'] > 0){
        if (is_array($cols)) {
            if (isset($cols[$column])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

?>