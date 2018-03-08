<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Google/GoogleHelper.php');
require_once("include/utils/encryption_utils.php");
require_once("modules/Administration/Administration.php");
require_once 'include/SugarQuery/SugarQuery.php';
/* calendar scheduler */
$job_strings[] = 'googleCalenderSync';
/**
* Sync calendars to/from google
*
*
* This function performs certain checks before sycing calendars
* <br> --> Then, it checks for php client file
* <br> --> Finally it see if repair and rebuild is performed after installation
* <br> If all conditions are fulfilled, the sync is performed and last_sync is updated
* <br> ----------------In case of any failure, the appropriate message is logged----------------
* @return bool  true    if syncing is successful, false otherwise
* @access public
*/
function googleCalenderSync()
{
    $admin = new Administration();
    $admin->retrieveSettings();
    $_SESSION['dcheckAlldayFunc'] = 1;
    if (GoogleHelper::check_column_if_exist($GLOBALS['sugar_config']['dbconfig']['db_name'], 'users', 'enable_gsync')) {
        $gh = new GoogleHelper();
        //$sql= "SELECT DISTINCT users.id, users.user_name, users.gmail_id, users.lastsync_calendar, rt_gsync.id AS GSyncID, rt_gsync.calendar_google, rt_gsync.calendar_sugar, rt_gsync.calendar_calls, rt_gsync.calendar_tasks, rt_gsync.contacts_google, rt_gsync.contacts_sugar, rt_gsync.documents_google, rt_gsync.documents_sugar FROM users LEFT JOIN rt_gsync ON rt_gsync.id=users.id AND rt_gsync.deleted='0' WHERE users.deleted='0' AND users.status='Active' AND enable_gsync=1";
        $module = "Users";
        $q = new SugarQuery();
        $q->from(BeanFactory::getBean($module), array('team_security' => false));
        $q->joinTable('rt_gsync', array('joinType' => 'LEFT'))->on()->equalsField('users.id', 'rt_gsync.id.user_id')->equals('rt_gsync.deleted', '0');
        $q->select(array('users.id', 'users.user_name', 'users.gmail_id', 'users.lastsync_calendar', array('rt_gsync.id', 'GSyncID'), 'rt_gsync.calendar_google', 'rt_gsync.calendar_sugar', 'rt_gsync.calendar_calls', 'rt_gsync.calendar_tasks', 'rt_gsync.contacts_google', 'rt_gsync.contacts_sugar', 'rt_gsync.documents_google', 'rt_gsync.documents_sugar'));
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
                if (!empty($row['gmail_id']) ) {
                    if (in_array(strtolower($row['gmail_id']), $processed)) {
                        $GLOBALS['log']->fatal("This email (" . $row['gmail_id'] . ") is configured in multiple users settings,skipping....");
                        continue;
                    } else {
                        $processed[] = strtolower($row['gmail_id']);
                    }
                    $GLOBALS['log']->fatal('STARTED: Calendar sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                    if (empty($row['lastsync_calendar']) || !isset($row['lastsync_calendar'])) {
                        $row['lastsync_calendar'] = '2013-01-01 01:01:01';
                    }

                    $gh->performSync($row['gmail_id'], $row['id'], $row['lastsync_calendar'], 'calendar');

                    $GLOBALS['log']->fatal('COMPLETED: Calendar sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                }
            } catch (Exception $ex) {
                $GLOBALS['log']->fatal('ERROR:' . $ex->getMessage());
            }
        }
        unset($_SESSION['dcheckAlldayFunc']);
        return true;
    } else {
        $GLOBALS['log']->fatal('Gmail Sync failed in CRON run. do quick repair and rebuild first.');
        return false;
    }
}

/* contacts scheduler */
$job_strings[] = 'googleContactsSync';
/**
* Sync contacts to/from google
*
*
* This function performs certain checks before sycing contacts
* <br> --> Then, it checks for php client file
* <br> --> Finally it see if repair and rebuild is performed after installation
* <br> If all conditions are fulfilled, the sync is performed and last_sync is updated
* <br> ----------------In case of any failure, the appropriate message is logged----------------
* @return bool  true    if syncing is successful, false otherwise
* @access public
*/
function googleContactsSync()
{
    $admin = new Administration();
    $admin->retrieveSettings();
    if (GoogleHelper::check_column_if_exist($GLOBALS['sugar_config']['dbconfig']['db_name'], 'users', 'enable_gsync')) {
        $gh = new GoogleHelper();
        //$sql= "SELECT DISTINCT users.id, users.user_name, users.gmail_id, users.lastsync_contacts,users.gdrive_refresh_code, rt_gsync.id AS GSyncID, rt_gsync.calendar_google, rt_gsync.calendar_sugar, rt_gsync.contacts_google, rt_gsync.contacts_sugar, rt_gsync.documents_google, rt_gsync.documents_sugar FROM users LEFT JOIN rt_gsync ON rt_gsync.id=users.id AND rt_gsync.deleted='0' WHERE users.deleted='0' AND users.status='Active' AND enable_gsync=1";
        $module = "Users";
        $q = new SugarQuery();
        $q->from(BeanFactory::getBean($module), array('team_security' => false));
        $q->joinTable('rt_gsync', array('joinType' => 'LEFT'))->on()->equalsField('users.id', 'rt_gsync.id.user_id')->equals('rt_gsync.deleted', '0');
        $q->select(array('users.id', 'users.user_name', 'users.gmail_id', 'users.lastsync_contacts', 'users.gdrive_refresh_code', array('rt_gsync.id', 'GSyncID'), 'rt_gsync.calendar_google', 'rt_gsync.calendar_sugar', 'rt_gsync.contacts_google', 'rt_gsync.contacts_sugar', 'rt_gsync.documents_google', 'rt_gsync.documents_sugar'));
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
                        "documents_sugar" => true
                    );
                } else {
                    $schedulers = array(
                        "calendar_google" => true,
                        "calendar_sugar" => true,
                        "contacts_google" => $row["contacts_google"],
                        "contacts_sugar" => $row["contacts_sugar"],
                        "documents_google" => $row["documents_google"],
                        "documents_sugar" => $row["documents_sugar"]
                    );
                }
                $gh->prefrences = array('schedulers' => $schedulers);
                if (!empty($row['gmail_id']) && !empty($row['gdrive_refresh_code']) && ($gh->prefrences["schedulers"]["contacts_google"] == true || $gh->prefrences["schedulers"]["contacts_sugar"] == true)) {
                    if (in_array(strtolower($row['gmail_id']), $processed)) {
                        $GLOBALS['log']->fatal("This email (" . $row['gmail_id'] . ") is configured in multiple users settings,skipping....");
                        continue;
                    } else {
                        $processed[] = strtolower($row['gmail_id']);
                    }
                    $GLOBALS['log']->fatal('STARTED: Contacts sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                    if (empty($row['lastsync_contacts']) || !isset($row['lastsync_contacts'])) {
                        $row['lastsync_contacts'] = '2013-01-01 01:01:01';
                    }
                    $current_date = date($GLOBALS['timedate']->get_db_date_time_format());
                    $dateAdded = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($current_date)) . "+03 seconds");
                    $last_synch = gmdate($GLOBALS['timedate']->get_db_date_time_format(), $dateAdded);
                    $gh->performSync($row['gmail_id'], $row['id'], $row['lastsync_contacts'], 'contacts');
                    //last sync date saving to db
                    $sql_update = "UPDATE users set lastsync_contacts='" . $last_synch . "' WHERE id='" . $row['id'] . "'";
                    $res_update = $GLOBALS['db']->query($sql_update);
                    $GLOBALS['log']->fatal('COMPLETED: Contacts sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                } else {
                    if (empty($row['gdrive_refresh_code'])) {
                        $GLOBALS['log']->fatal("Please go to your user profile and re save Gmail id");
                    }
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
}

/* archive emails scheduler */
$job_strings[] = 'importCacheEmails';
/**
* Sync emails to/from google
*
*
* @return bool  true    if syncing is successful, false otherwise
* @access public
*/
function importCacheEmails()
{
    $admin = new Administration();
    $admin->retrieveSettings();
    require_once('custom/include/CacheEmails/CacheEmails.php');
    return CacheEmails::import_emails();
}

/* calendar recurring scheduler */

// TODO
// $job_strings[] = 'googleCalenderRecurringSync';

/**
* Sync repeating (recurring) calendar events to/from google
*
*
* This function performs certain checks before sycing recurring calendar events
* <br> --> It checks for php client file
* <br> --> Finally it see if repair and rebuild is performed after installation
* <br> If all conditions are fulfilled, the sync is performed and last_sync ish updated
* <br> ----------------In case of any failure, the appropriate message is logged----------------
* @return bool  true    if syncing is successful, false otherwise
* @access public
*/
function googleCalenderRecurringSync()
{
    $admin = new Administration();
    $admin->retrieveSettings();
    $_SESSION['dcheckAlldayFunc'] = 1;
    if (GoogleHelper::check_column_if_exist($GLOBALS['sugar_config']['dbconfig']['db_name'], 'users', 'enable_gsync')) {
        $gh = new GoogleHelper();
        /* $sql       = "SELECT 
          DISTINCT U.id,U.user_name,U.gmail_id,U.lastsync_calendar
          FROM users AS U
          WHERE
          U.deleted='0' AND
          U.status='Active' AND U.enable_gsync=1"; */
        $module = "Users";
        $q = new SugarQuery();
        $q->from(BeanFactory::getBean($module), array('team_security' => false));
        $q->select(array('users.id', 'users.user_name', 'users.gmail_id', 'users.lastsync_calendar'));
        $q->where()->equals('users.status', 'Active')->equals('users.enable_gsync', 1);
        $q->distinct(true);
        //$sql = $q->compileSql();
        //$res = $GLOBALS['db']->query($sql);
        $res = $q->execute();
        $processed = array();
        //while ($row = $GLOBALS['db']->fetchByAssoc($res)) {
        foreach ($res as $row) {
            try {

                if (!empty($row['gmail_id']) ) {
                    if (in_array(strtolower($row['gmail_id']), $processed)) {
                        $GLOBALS['log']->fatal("This email (" . $row['gmail_id'] . ") is configured in multiple users settings,skipping....");
                        continue;
                    } else {
                        $processed[] = strtolower($row['gmail_id']);
                    }
                    $GLOBALS['log']->fatal('STARTED: calendarRecurring sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                    if (empty($row['lastsync_calendar']) || !isset($row['lastsync_calendar'])) {
                        $row['lastsync_calendar'] = '2013-01-01 01:01:01';
                    }
                    $gh->performSync($row['gmail_id'], $row['id'], $row['lastsync_calendar'], 'calendarRecurring');

                    $GLOBALS['log']->fatal('COMPLETED: calendarRecurring sync: ' . $row['user_name'] . '(' . $row['gmail_id'] . ')');
                }
            } catch (Exception $ex) {
                $GLOBALS['log']->fatal('ERROR:' . $ex->getMessage());
            }
        }
        unset($_SESSION['dcheckAlldayFunc']);
        return true;
    } else {
        $GLOBALS['log']->fatal('Gmail Sync failed in CRON run. do quick repair and rebuild first.');
        return false;
    }
}
