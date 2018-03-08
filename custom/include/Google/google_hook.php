<?php
require_once("modules/Configurator/Configurator.php");
require_once('custom/include/Google/GoogleHelper.php');
require_once("include/utils/encryption_utils.php");
require_once("modules/Administration/Administration.php");
/**

*/
class GoogleHook
{
    /*
    * sets defaults before_save on following
    * 
    * sets defaults before_save on following
    * <ul>
    * <li> gevent_id for Meetings   </li>
    * <li> gevent_id for Calls      </li>
    * <li> gevent_id for Tasks      </li>
    * <li> gcontact_id for Contacts </li>
    * <li> Gmail ID for Users       </li>
    * <li> gdrive_id for Documents  </li>
    * </ul>
    */
    function geventHandler($bean, $event)
    {
        global $db;
        /*unlink Meetings,Calls,Tasks from google event list*/
        if ($bean->module_dir == 'Meetings' || $bean->module_dir == 'Calls' || $bean->module_dir == 'Tasks') {
            if (!empty($bean->fetched_row) && $bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id && !empty($bean->fetched_row['assigned_user_id'])) {
                $bean->gevent_id = '';
                $bean->is_gevent = '0';
            }
            if ($bean->allday == 1 && !isset($_SESSION['dcheckAlldayFunc']) && !empty($bean->fetched_row)) {
                $GLOBALS['log']->debug("All day time reassign....");
                $bean->date_start = $bean->fetched_row['date_start'];
                if ($bean->module_dir == 'Meetings' || $bean->module_dir == 'Calls') {
                    $bean->date_end = $bean->fetched_row['date_end'];
                    $bean->duration_hours = $bean->fetched_row['duration_hours'];
                    $bean->duration_minutes = $bean->fetched_row['duration_minutes'];
                }
                if ($bean->module_dir == 'Tasks') {
                    $bean->date_due = $bean->fetched_row['date_due'];
                }
            }
            //handling of Recurrences in Sugar
            if (!empty($bean->fetched_row) && $bean->fetched_row['id'] != $bean->id && !empty($bean->repeat_type)) {
                $bean->gevent_id = '';
            }
        }
        /*unlink Contacts from google Contacts list*/
        if ($bean->module_dir == 'Contacts') {
            if (!empty($bean->fetched_row) && $bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
                $bean->gcontact_id = '';
            }
        }
        /*unlink Documents from google drive*/
        if ($bean->module_dir == 'Documents') {
            if (!empty($bean->fetched_row) && $bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
                $bean->gdrive_id = '';
            }
        }
        /*unlink Documents,Contacts,Meetings,Calls,Tasks from google if user has changed his gmail id in settings*/
        if ($bean->module_dir == 'Users') {
            if (!empty($bean->fetched_row) && $bean->fetched_row['gmail_id'] != $bean->gmail_id) {
                //start clean sync for cal
                if (!empty($bean->fetched_row['gmail_id']) ) {
                    $gh = new GoogleHelper();
                    $gh->cleanSync($bean->fetched_row['gmail_id'], $bean->id);
                }
                $sql_contacts = "UPDATE contacts SET gcontact_id='', date_modified='" . $bean->date_modified . "' WHERE assigned_user_id='" . $bean->id . "';";
                $sql_documents = "UPDATE documents SET gdrive_id='', date_modified='" . $bean->date_modified . "' WHERE assigned_user_id='" . $bean->id . "';";
                $db->query($sql_contacts);
                // $db->query($sql_documents);
                //unset refresh code
                $bean->gdrive_refresh_code = '';
                //unset sync date
                $bean->lastsync_calendar = '2013-01-01 01:01:01';
                $bean->lastsync_contacts = '2013-01-01 01:01:01';
                $bean->lastsync_drive = '2013-01-01 01:01:01';
            }
            //START: edit 02-01-2013 for docs/authorization
            if (!empty($bean->gmail_id) && ($bean->fetched_row['gmail_id'] != $bean->gmail_id || empty($bean->gdrive_refresh_code)) && sugar_is_file('custom/include/Google/google-api-php-client/src/Google_Client.php')) {
                $GLOBALS['log']->fatal("setting redirect for google authorization token for user: " . $bean->name);
                $_REQUEST['oauth_redirect'] = '1';
            }
            //END: edit 02-01-2013 for docs
        }
    }

    //START: edit 02-01-2013 for docs , redirecting user to a google authorization page
    /*
    * redirecting user to a google authorization page
    * 
    * after_save on Users
    */
    function gdriveHandler($bean, $event)
    {
        global $db, $current_user;
        if ($bean->module_dir == 'Users' && $current_user->id == $bean->id) {
            if (isset($_REQUEST['oauth_redirect']) && $_REQUEST['oauth_redirect'] == '1' &&
                !empty($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Users') {
                $GLOBALS['log']->fatal("redirecting...");
                SugarApplication::redirect("index.php?module=Users&action=GoogleOauth");
            }
        }
        /*as date modified of document is not going to be changed when new revisions are created , this hook will change date_modified
        and also as there is no facility to update file of doc as excel or other type due to this reason we have to unlink that doc to be created new one
        */
        if ($bean->module_dir == 'DocumentRevisions') {
            if (!empty($bean->file_mime_type) && !empty($bean->documents->beans[$bean->document_id]->last_rev_mime_type)) {
                $sql_documents = "UPDATE documents SET documents.date_modified='" . $bean->date_modified . "' WHERE documents.id='" . $bean->document_id . "';";
                if (strpos($bean->file_mime_type, $bean->documents->beans[$bean->document_id]->last_rev_mime_type) !== false || strpos($bean->documents->beans[$bean->document_id]->last_rev_mime_type, $bean->file_mime_type) !== false) {
                    //$sql_documents	= "UPDATE documents SET documents.gdrive_id='',documents.date_modified='".$bean->date_modified."' WHERE documents.id='".$bean->document_id."';";
                }
                $db->query($sql_documents); //documents
            }
        }
    }

    /*relationship removed (using subpanel) with invitee update date modified
    so that it can be synced when sync will be performed
    */
    /**
    * relationship removed (using subpanel) with invitee update date modified so that it can be synced when sync will be performed
    * 
    * after_relationship_delete on meetings
    * after_relationship_delete on calls
    */
    function inviteeHandler($bean, $event, $arguments)
    {
        if (isset($arguments['related_module'])) {
            if (in_array($arguments['related_module'], array(
                    'Contacts',
                    'Users',
                    'Leads'
                )) && $bean->deleted != '1'
            ) {
                $bean->save();
                $GLOBALS['log']->debug("Bean saved in after_relationship_delete hook");
            }
        }
    }


    /**  
    * The purpose of this function is to sync all recurring event. i.e If we update one recurring event, 
    *  all related recuuring event become like this updated event. 
    */

    function syncRecurringEvent($bean, $event)
    {
        global $db;
        /*if ($bean->module_dir == 'Meetings' || $bean->module_dir == 'Calls' || $bean->module_dir == 'Tasks') {
            if (!isset($_SESSION['from_google'])) {
                // Here we are using event_id in session to avoid infinit loop while saving.
                if ($bean->id != $_SESSION['gevent_id']) {
                    //getting related contact of current event
                    $contacts = $bean->get_linked_beans('contacts', 'Contact');
                    $gevent_id = explode("_", $bean->gevent_id);
                    $gevent_id=$gevent_id[0];
                    $sql = "SELECT id FROM " . $bean->table_name . " WHERE gevent_id LIKE '$gevent_id%' AND deleted=0";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $db->fetchByAssoc($result)) {
                            $event = new Meeting();
                            if ($bean->module_dir == 'Calls') {
                                $event = new Call();
                            } else if ($bean->module_dir == 'Tasks') {
                                $event = new Task();
                            }
                            $event->retrieve($row['id']);

                            $bean->id = $row['id'];
                            $bean->date_start = $event->date_start;
                            $bean->date_end = $event->date_end;
                            $bean->gevent_id = $event->gevent_id;
                            $bean->fetched_row['date_start'] = $event->fetched_row['date_start'];
                            $bean->fetched_row['date_end'] = $event->fetched_row['date_end'];
                            $bean->fetched_row['gevent_id'] = $event->fetched_row['gevent_id'];
                            $_SESSION['gevent_id'] = $bean->id;

                            foreach ($contacts as $contact) {
                                $GLOBALS['log']->fatal("contactid=" . $contact->id);
                                $bean->load_relationship('contacts');
                                $bean->contacts->add($contact->id);
                            }
                            $bean->save();
                            $GLOBALS['log']->fatal("Event is Updated with id= " . $row['id']);
                            $_SESSION['gevent_id'] = '';
                        }
                    }
                }
            }
        }*/
    }
    /**
    * The purpose of this function is to delete recurring event contact. 
    */
    function deleteRecurringEventContact($bean, $event, $arguments)
    {
        global $db;
        /*$GLOBALS['log']->fatal(print_r($arguments,true));
        if ($arguments['related_id'] != '') {
            $gevent_id = explode("_", $bean->gevent_id);
            $gevent_id=$gevent_id[0];
            $sql = "SELECT id FROM " . $bean->table_name . " WHERE gevent_id LIKE '$gevent_id%' AND deleted=0";
            $result = $db->query($sql);
           // $_SESSION['gevent_id'] = '';exit;
            if ($_SESSION['gevent_id'] == '') {
                if ($result->num_rows > 0) {
                    while ($row = $db->fetchByAssoc($result)) {
                        $event = new Meeting();
                        if ($bean->module_dir == 'Calls') {
                            $event = new Call();
                        } else if ($bean->module_dir == 'Tasks') {
                            $event = new Task();
                        }
                        $_SESSION['gevent_id'] = $bean->id;
                        $event->retrieve($row['id']);
                        $link=$arguments['link'];
                        $event->load_relationship($link);
                        $event->$link->delete($row['id'], $arguments['related_id']);
                        $GLOBALS['log']->fatal($link. $row['id']." contact unlinked with id= " . $arguments['related_id']);
                    }
                }
                $_SESSION['gevent_id'] = '';
            }
        }*/
    }
}

?>