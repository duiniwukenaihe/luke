<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Google/GoogleHelper.php');
require_once("include/utils/encryption_utils.php");
require_once("modules/Administration/Administration.php");
$job_strings[] = 'googleDriveSync';

/**
* Sync documents to/from google
*
*
* This function performs certain checks before sycing documents
* <ul>
    * <li> Checks for php client file </li>
    * <li> Then checks if repair and rebuild is performed after installation </li>
    * <li> If all conditions are fulfilled, the sync is performed and last_sync is updated </li>
* </ul>
* <br> In case of any failure, the appropriate message is logged
* 
* @return bool  true    if syncing is successful, false otherwise
* @access public
*/
function googleDriveSync()
{

        $admin = new Administration();
        $admin->retrieveSettings();
        if (sugar_is_file('custom/include/Google/google-api-php-client/src/Google_Client.php')) { // if php client exist then do drive sync
            if (GoogleHelper::check_column_if_exist($GLOBALS['sugar_config']['dbconfig']['db_name'], 'users', 'enable_gsync')) {
            $gh = new GoogleHelper();
            $tmp = array(
                'rt_set_time_limit' => 'set_time_limit',
                'rt_ini_set' => 'ini_set',
            );
            //increasing limits
            //set_time_limit(9000);
            $tmp['rt_set_time_limit'](9000);
            $json = getJSONobj();
            //ini_set('memory_limit', '2048M'); //blacklist while package scan
            $tmp['rt_ini_set']('memory_limit', '2048M'); //blacklist while package scan
            //ahmed nawaz
            $module = "Users";
            $q = new SugarQuery();
            $q->from(BeanFactory::getBean($module), array('team_security' => false));
            $q->joinTable('rt_gsync', array('joinType' => 'LEFT'))->on()->equalsField('users.id', 'rt_gsync.id.user_id')->equals('rt_gsync.deleted', '0');
            $q->select(array('users.id', 'users.user_name', 'users.gmail_id', 'users.lastsync_calendar', 'users.lastsync_drive', array('rt_gsync.id', 'GSyncID'), 'rt_gsync.calendar_google', 'rt_gsync.calendar_sugar', 'rt_gsync.calendar_calls', 'rt_gsync.calendar_tasks', 'rt_gsync.contacts_google', 'rt_gsync.contacts_sugar', 'rt_gsync.documents_google', 'rt_gsync.documents_sugar'));
            $q->where()->equals('users.status', 'Active')->equals('users.enable_gsync', 1);
            $q->distinct(true);
            //$sql = $q->compileSql();
            //$res = $GLOBALS['db']->query($sql);
            $res = $q->execute();
            $processed = array();
            //while ($row = $GLOBALS['db']->fetchByAssoc($res)) {
            foreach ($res as $row) {
                $schedulers = array();

                try {

                    //if not saved 
                    if (empty($row['GSyncID'])) {
                        $schedulers = array(
                            "calendar_google" => true,
                            "calendar_sugar" => true,
                            "contacts_google" => false,
                            "contacts_sugar" => true,
                            "documents_google" => true,
                            "documents_sugar" => true,
                            "calendar_meetings" => true,
                            "calendar_calls" => true,
                            "calendar_tasks" => true,
                        );
                    } else {
                        $schedulers = array(
                            "calendar_google" => true,
                            "calendar_sugar" => true,
                            "contacts_google" => $row["contacts_google"],
                            "contacts_sugar" => $row["contacts_sugar"],
                            "documents_google" => $row["documents_google"],
                            "documents_sugar" => $row["documents_sugar"],
                            "calendar_meetings" => true,
                            "calendar_calls" => $row["calendar_calls"],
                            "calendar_tasks" => $row["calendar_tasks"],
                        );
                    }
                    $gh->prefrences = array('schedulers' => $schedulers);
                    /* user gsync prefrences */
                    if (!empty($row['gmail_id']) && ($gh->prefrences["schedulers"]["documents_google"] == true || $gh->prefrences["schedulers"]["documents_sugar"] == true)) {
                        if (in_array(strtolower($row['gmail_id']), $processed)) {
                            $GLOBALS['log']->fatal("This email (" . $row['gmail_id'] . ") is configured in multiple users settings,skipping....");
                            continue;
                        } else {
                            $processed[] = strtolower($row['gmail_id']);
                        }
                        $GLOBALS['log']->fatal('STARTED: Drive sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                        if (empty($row['lastsync_drive']) || !isset($row['lastsync_drive'])) {
                            $row['lastsync_drive'] = '2013-01-01 01:01:01';
                        }
                        $current_date = date($GLOBALS['timedate']->get_db_date_time_format());
                        $dateAdded = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($current_date)) . "+03 seconds");
                        $last_synch = gmdate($GLOBALS['timedate']->get_db_date_time_format(), $dateAdded);
                        $gh->performSync($row['gmail_id'], $row['id'], $row['lastsync_drive'], 'drive');
                        //last sync date saving to db
                        $sql_update = "UPDATE users set lastsync_drive='" . $last_synch . "' WHERE id='" . $row['id'] . "'";
                        $res_update = $GLOBALS['db']->query($sql_update);
                        $GLOBALS['log']->fatal('COMPLETED: Drive sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                    }
                } catch (Exception $ex) {
                    $GLOBALS['log']->fatal('ERROR:' . $ex->getMessage());
                }
            }
            return true;
        } else {
            $GLOBALS['log']->fatal('Gmail Sync failed in CRON run. do quick repair and rebuild first.');
            return false;
        }
    } else {
        $GLOBALS['log']->fatal('Google api php client does not exist');
        return false;
    }
}
