<?php
require_once("modules/Administration/Administration.php");
/**
* Helper class to handle API calls
*
*
*/
class rt_GSyncApiCalls
{
    var $module;
    var $scheduler;
    /**
    * constructor: sets scheduler = 'Schedulers' and module = 'rt_GSync'
    *
    */
    function __construct()
    {
        $this->scheduler = 'Schedulers';
        $this->module = 'rt_GSync';
    }
    /**
    * Returns user's preferences regarding which modules are to be synced and in which direction (Google to sugar and vice versa)
    *
    * Returning array has follwoing format
    * <table id="preferences_gsync_get_format">
    * <tr>
    * <td>module_google </td> <td> Google to Sugar </td>
    * </tr>
    * <tr>
    * <td>module_sugar </td> <td> Sugar to Google </td>
    * </tr>
    * <tr>
    * <td>activate_module </td> <td> syncing of that module is enabled or not </td>
    * </tr>
    * <tr>
    * <td>activate_module_created </td> <td> true </td>
    * </tr>
    * <table>
    *
    *
    * @return array of user's syncing preferences
    * @access public
    */
    function getPreferences($args)
    {
        $data = array();
        $bean = BeanFactory::retrieveBean($this->module, $GLOBALS['current_user']->id, array());
        if (!($bean == FALSE || $bean->deleted == 1)) {
            $data['contacts_google'] = $bean->contacts_google == '1' ? true : false;
            $data['contacts_sugar'] = $bean->contacts_sugar == '1' ? true : false;
            $data['documents_google'] = $bean->documents_google == '1' ? true : false;
            $data['documents_sugar'] = $bean->documents_sugar == '1' ? true : false;
            $data['calendar_meetings'] = $bean->calendar_meetings == '1' ? true : false;
            $data['calendar_calls'] = $bean->calendar_calls == '1' ? true : false;
            $data['calendar_tasks'] = $bean->calendar_tasks == '1' ? true : false;
        } else {
            $data['calendar_meetings'] = true;
            $data['calendar_calls'] = true;
            $data['calendar_tasks'] = true;
            $data['contacts_google'] = false;
            $data['contacts_sugar'] = true;
            $data['documents_google'] = true;
            $data['documents_sugar'] = true;
        }

        $scheduler = BeanFactory::getBean('Schedulers');
        //calendar

        $scheduler->retrieve_by_string_fields(array('job' => 'function::googleCalenderSync', 'deleted' => '0'));

        if (!empty($scheduler->id)) {
            $data['activate_calendar_created'] = true;
            $data['activate_calendar'] = $scheduler->status == 'Active' ? true : false;
        }
        //contacts
        $scheduler->id = "";
        $scheduler->retrieve_by_string_fields(array('job' => 'function::googleContactsSync', 'deleted' => '0'));

        if (!empty($scheduler->id)) {
            $data['activate_contacts_created'] = true;
            $data['activate_contacts'] = $scheduler->status == 'Active' ? true : false;
        }
        //documents
        $scheduler->id = "";
        $scheduler->retrieve_by_string_fields(array('job' => 'function::googleDriveSync', 'deleted' => '0'));

        if (!empty($scheduler->id)) {
            $data['activate_documents_created'] = true;
            $data['activate_documents'] = $scheduler->status == 'Active' ? true : false;
        }
        //archive emails
        $scheduler->id = "";
        $scheduler->retrieve_by_string_fields(array('job' => 'function::importCacheEmails', 'deleted' => '0'));
        if (!empty($scheduler->id)) {
            $data['activate_archive_emails_created'] = true;
            $data['activate_archive_emails'] = $scheduler->status == 'Active' ? true : false;
        }
        return array('data' => $data);
    }
    /**
    * Given a true false value in string format, returns it in boolean format
    */
    function convertToBoolean($val)
    {
        if (gettype($val) == "string") {
            if ($val == 'true') {
                $val = true;
            } else if ($val == 'false') {
                $val = false;
            }
        }
        return $val;
    }
    /**
    * Sets user's preferences regarding which modules to sync on which side
    *
    * arguments array has follwoing format
    * <table id="preferences_gsync_set_format">
    * <tr>
    * <td>module_google </td> <td> Google to Sugar </td>
    * </tr>
    * <tr>
    * <td>module_sugar </td> <td> Sugar to Google </td>
    * </tr>
    * <tr>
    * <td>activate_module </td> <td> syncing of that module is enabled or not </td>
    * </tr>
    * <table>
    *
    *
    * @return array of user's syncing preferences
    * @access public
    */
    function setPreferences($args)
    {
        $data = array();
        $bean = BeanFactory::newBean($this->module);
        $bean->retrieve($GLOBALS['current_user']->id);
        $bean->contacts_google = $this->convertToBoolean($args['contacts_google']);
        $bean->contacts_sugar = $this->convertToBoolean($args['contacts_sugar']);
        $bean->documents_google = $this->convertToBoolean($args['documents_google']);
        $bean->documents_sugar = $this->convertToBoolean($args['documents_sugar']);
        $bean->activate_calendar = $this->convertToBoolean($args['activate_calendar']);
        $bean->activate_contacts = $this->convertToBoolean($args['activate_contacts']);
        $bean->activate_documents = $this->convertToBoolean($args['activate_documents']);
        $bean->activate_archive_emails = $this->convertToBoolean($args['activate_archive_emails']);
        $bean->calendar_meetings = true;
        $bean->calendar_calls = $this->convertToBoolean($args['calendar_calls']);
        $bean->calendar_tasks = $this->convertToBoolean($args['calendar_tasks']);
        $bean->name = 'Prefrences';
        if (empty($bean->id)) {
            $bean->id = $GLOBALS['current_user']->id;
            $bean->new_with_id = true;
        }
        $bean->assigned_user_id = $GLOBALS['current_user']->id ? $GLOBALS['current_user']->id : '1';
        $bean->modified_user_id = $GLOBALS['current_user']->id ? $GLOBALS['current_user']->id : '1';
        if ($bean->save(false)) {
            $data['id'] = $bean->id;
        }
        return array('data' => $data);
    }
    /**
    *
    * returning array has follwoing format
    * <table id="preferences_gsync_get_format">
    * <tr>
    * <td>isRepaired </td> <td> Quick repair and rebuild is performed? </td>
    * </tr>
    * <tr>
    * <td>enabled_users </td> <td> active users with gsync access </td>
    * </tr>
    * <tr>
    * <td>enabled_users </td> <td> all active users </td>
    * </tr>
    * <table>
    *
    *
    * @return array of user's syncing preferences
    * @access public
    */
    function getUserConfig($args)
    {
        global $sugar_config;
        $admin = new Administration();
        $admin->retrieveSettings();
        $data = array();
        $data['isRepaired'] = true;
        $enabled_active_users = array();
        $active_users = array();
        if ($this->dbFieldExists('users', 'enable_gsync')) {

            //get_user_array function from utils is deprecated, now using Users->getUserArray()
            $user = BeanFactory::newBean('Users');
            $enabled_active_users = $user->getUserArray( false, 'Active', '', false, '', ' AND is_group=0 AND enable_gsync=1', false);
            $active_users  = $user->getUserArray(false, 'Active', '', false, '', ' AND is_group=0');
            $data['enabled_active_users'] = $enabled_active_users;
            $data['active_users'] = $active_users;
        } else {
            $data['isRepaired'] = false;//do quick repair and rebuild
        }

        $data['select2Onchange'] = true;
        if ($sugar_config['sugar_version']) {
            $version = explode('.', $sugar_config['sugar_version']);
            if ($version[0] >= 7 && $version[1] >= 1 && $version[2] >= 6) {
                $data['select2Onchange'] = false;
            }
        }
        return array('data' => $data);
    }
    /*
    * array of sugar users is provided and gsync is enabled for those users
    */
    function setUserConfig($args)
    {
        $data = array();
        $data['isRepaired'] = true;
        if (!is_admin($GLOBALS['current_user'])) {
            sugar_die("Unauthorized access to administration.");
        }
        if ($this->dbFieldExists('users', 'enable_gsync')) {
            if (!isset($args['selectedUserIDS'])) {
                $args['selectedUserIDS'] = array();
            }
            $enabled = $args['selectedUserIDS'];
            $enabled = "'" . implode("','", $enabled) . "'";
            //$update_enabled_users_query="UPDATE users SET enable_gsync = CASE WHEN id IN ($enabled) THEN 1 WHEN id NOT IN ($enabled) THEN 0 ELSE enable_gsync=enable_gsync END";
            $sql1 = "UPDATE users SET enable_gsync = 1 WHERE id IN ($enabled)";
            $sql2 = "UPDATE users SET enable_gsync = 0 WHERE id NOT IN ($enabled)";
            $res1 = $GLOBALS['db']->query($sql1);
            $res2 = $GLOBALS['db']->query($sql2);
            //$GLOBALS['db']->query($update_enabled_users_query);
            //$GLOBALS['db']->query($update_enabled_users_query);
            $data['enabled_active_users'] = $args['selectedUserIDS'];
        } else {
            $data['isRepaired'] = false;
        }
        return array('data' => $data);
    }


    //check in db if column exist or not
    /**
    * Given a column name and table name, check if that column exists in the table
    *
    *
    * @param  string    $table   table name to look in
    * @param  string    $column  column to check
    * @return bool      true     if exists, false otherwise
    */
    function dbFieldExists($table, $column)
    {
        /*  $sql="SELECT count(*) as count FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$GLOBALS['sugar_config']['dbconfig']['db_name']."' AND TABLE_NAME = '".$table."' AND COLUMN_NAME = '".$column."'";
            $r=$GLOBALS['db']->query($sql);
            $field=$GLOBALS['db']->fetchByAssoc($r);
            if(isset($field) && isset($field['count']) && $field['count'] > 0){
                return true;
            }else{
                return false;
            }*/
        global $db;
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

