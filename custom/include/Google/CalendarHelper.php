<?php
require_once("modules/Calls/Call.php");
require_once("modules/Meetings/Meeting.php");
require_once("modules/Tasks/Task.php");
require_once("modules/Contacts/Contact.php");
require_once 'vendor/Zend/Gdata/Calendar.php';
require_once 'vendor/Zend/Gdata/Calendar/EventQuery.php';
/**
* CalendarHelper uses google api to perform calendar events syncing
*
* This class is responsible for syncing events between Google and Sugar
* It takes care of all the details like removing duplicates 
* or deleting events on one side which are deleted on the other
*
* Example usage:
* CalendarHelper::updateFromGoogle($client, '1', 'example@gmail.com', '2013-01-01 01:01:00', false);
*
*/
class CalendarHelper
{
    /**
    * Retrieves google calendar events, process those and save in SugarCRM if necessary.
    *
    * <b>Function breakdown</b>
    * <ol>
        * <li> Set parameters before fetching events (e.g. fetch only those updated after the last sync)</li>
        * <li> Fetch events</li>
        * <li> Process those and save in sugar or ignore with proper logs</li>
    * </ol>
    *
    *
    * @param Google_DriveService    $client       Calendar API service instance.
    * @param  string                $userID       ID of current user
    * @param  string                $userEmailID  Email address of the user
    * @param  date                  $lastSync     Last time sync was performed
    * @param  bool                  $recurrence   Whether to fetch repeating events or not
    * @param  array                 $prefrences   Which events (tasks/meetings/calls) to sync
    * @return array                               IDs of new events stored in SugarCRM
    * @access public
    */
    public static function updateFromGoogle($client, $userID, $userEmailID, $lastSync, $recurrence = false, $prefrences = array())
    {
        $optParams = array();
        if (!empty($userID)) {
            $user = new User();
            $user->retrieve($userID);
        }
        $service = $client;
        $optParams['maxResults'] = 100000;

        if ($recurrence === false) {
            if ($lastSync !== '2013-01-01 01:01:00' && $lastSync !== '2013-01-01 01:01:01' && $lastSync !== '2013-01-01 01:01:00.000') {
                $optParams['updatedMin'] = date("Y-m-d\TH:i:s+00:00", strtotime($lastSync));
            } else {
                $optParams['timeMin'] = date("Y-m-d\TH:i:s+00:00", strtotime($lastSync));
            }
        } else {
            $optParams['timeMin'] = date('Y-m-d', strtotime(gmdate("Y-m-d"))) . "T00:00:01.000Z";
            $optParams['timeMax'] = date('Y-m-d', strtotime(gmdate("Y-m-d") . " +10 days")) . "T23:59:59.000Z";
            $optParams['orderBy'] = 'starttime';

        }
        $optParams['singleEvents'] = 'true';
        $optParams['showDeleted'] = 'true';
        $event_feeds = $service->events->listEvents('primary', $optParams)->getItems();
        $GLOBALS['log']->debug('Total Events updated/deleted in GOOGLE: ' . count($event_feeds));
        $ids = array();
        $_SESSION['from_google'] = 1;
        foreach ($event_feeds as $event_feed) {

            $is_shared = false;
            $event_status = self:: getEventStatus($event_feed);
            $feed = self::toArray($event_feed);
            $feed['assigned_user_id'] = $userID;
            $feed['allday'] = 0;
            //checking for all day event
            if (self::isAlldayEvent($user, $feed['all_day_start'], $feed['all_day_end'], 'GOOGLE')) {
                $feed['allday'] = 1;
            }

            //only handle owns events not shared by others
            if (isset($feed['event_author']) && strtolower($feed['event_author']) != strtolower($userEmailID)) {
                /*START: shared events*/
                $feed['assigned_user_id'] = '';
                $is_shared = true;
                /*END: shared events*/
            }
            if ($event_status != 'cancelled')//confirmed events in Google
            {

                $feed['gevent_id'] = $feed['id'];
                unset($feed['id']);


                if ($feed['allday'] == 0) {
                    $feed['date_start'] = '';
                    if (!empty($feed['start'])) {
                        $feed['date_start'] = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['start']));
                    }

                    $feed['date_end'] = '';
                    if (!empty($feed['end'])) {
                        $feed['date_end'] = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['end']));
                    }

                    $feed['date_due'] = '';
                    if (!empty($feed['end'])) {
                        $feed['date_due'] = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['end']));
                    } else if (!empty($feed['start'])) {
                        $feed['date_due'] = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['start']));
                    }
                } else {
                    $feed['date_start'] = '';
                    if (!empty($feed['all_day_start'])) {
                        $start_date = $GLOBALS['timedate']->getDayStartEndGMT($feed['all_day_start'], $user);
                        $feed['date_start'] = $start_date['start'];
                    }
                    $feed['date_end'] = '';
                    $feed['date_due'] = '';

                    $date_one_day_detected = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['all_day_end'])) . "-01 days");
                    $date_one_day_detected = date('Y-m-d', $date_one_day_detected);

                    if (!empty($feed['all_day_end'])) {
                        $end_date = $GLOBALS['timedate']->getDayStartEndGMT($date_one_day_detected, $user);
                        $feed['date_end'] = $end_date['end'];
                        $feed['date_due'] = $end_date['end'];
                    }
                }

                if (!empty($feed['date_start']) && !empty($feed['date_end'])) {
                    $diff = strtotime($feed['date_end']) - strtotime($feed['date_start']);
                    $feed['duration_hours'] = floor($diff / (60 * 60));
                    $feed['duration_minutes'] = floor(($diff / 60) % 60);
                }
                //2013-12-19
                //don't save any event which does not hold date_start due to any reason(allday,recurring)
                if (empty($feed['date_start'])) {
                    $GLOBALS['log']->fatal('GOOGLE Event without date_start will not be saved in SugarCRM,skipping...');
                    continue;
                }
                //don't save any event which does not hold date_due due to any reason(allday,recurring)
                if (empty($feed['date_due'])) {
                    $GLOBALS['log']->fatal('GOOGLE Event without date_due will not be saved in SugarCRM,skipping...');
                    continue;
                }
                //don't save any event which does not hold name
                if (empty($feed['name'])) {
                    $GLOBALS['log']->fatal('GOOGLE Event without name will not be saved in SugarCRM,skipping...');
                    continue;
                }
                $date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['updated']));

                //if($recurrence===true || strtotime($date_modified) >= strtotime($lastSync)){
                $tmp = new Meeting();

                $feed['name'] = explode(':', $feed['name']);

                if (strtolower(trim($feed['name'][0])) == "call") {
                    if (isset($prefrences['schedulers']['calendar_calls']) && $prefrences['schedulers']['calendar_calls'] == false) {
                        continue;
                    }
                    $tmp = new Call();
                    $tmp->direction = 'Inbound';
                } else if (strtolower(trim($feed['name'][0])) == "task") {
                    if (isset($prefrences['schedulers']['calendar_tasks']) && $prefrences['schedulers']['calendar_tasks'] == false) {
                        continue;
                    }
                    $tmp = new Task();
                }
                if (strtolower(trim($feed['name'][0])) == "call" || strtolower(trim($feed['name'][0])) == "meeting" || strtolower(trim($feed['name'][0])) == "task") {
                    unset($feed['name'][0]);
                }

                $feed['name'] = implode(':', $feed['name']);

                // remove extra spaces from start and end of name
                $feed['name'] = trim($feed['name']);

                //START: event deleted in SugarCRM but not deleted in Google
                $sql = "SELECT * FROM " . $tmp->table_name . " WHERE gevent_id='" . $feed['gevent_id'] . "';";
                $result = $GLOBALS['db']->query($sql);
                $row = $GLOBALS['db']->fetchByAssoc($result);

                if ($row) {
                    if (!empty($row['gevent_id']) && $row['deleted'] == '1') {
                        $GLOBALS['log']->fatal($tmp->object_name . ": " . $row['name'] . " with id " . $row['id'] . " deleted in SugarCRM but not deleted in Google.");
                        continue;
                    }//no id is returned so that we can delete event in Google
                }

                //END: event deleted in SugarCRM but not deleted in Google

                if (!$tmp->retrieve_by_string_fields(array('gevent_id' => $feed['gevent_id']))) {
                    $tmp->is_gevent = '1';
                } else {
                    $googleDateModified = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['updated']));
                    if (strtotime($tmp->date_modified) > strtotime($googleDateModified)) {
                        $GLOBALS['log']->debug($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " date modified in Sugar is greater so skip it");
                        continue;
                    }
                }
                //2012-12-20J
                if (!$recurrence === false && !empty($tmp->id)) {
                    $GLOBALS['log']->debug('skipping recurrence event instance , it is already fetched');
                    continue;
                }

                /*START: shared events*/
                if ($is_shared === true) {
                    //means event owner also exist, so it will be updated on that turn
                    if (!empty($tmp->assigned_user_id)) {
                        $GLOBALS['log']->debug('skipping shared event as owner(user) exist');
                        continue;
                    }
                    /*as we dont have invitees for tasks so skip*/
                    if (strtolower($tmp->object_name) == 'task') {
                        $GLOBALS['log']->debug('skipping shared event (Task)');
                        continue;
                    }
                }
                /*END: shared events*/
                foreach ($feed as $k => $v) {
                    $tmp->$k = $v;
                }
                $tmp->date_modified = $date_modified;

                //2013-09-23J set created by and modified by
                if (empty($tmp->assigned_user_id)) {
                    $tmp->modified_user_id = $userID;
                    $tmp->update_modified_by = false;
                    $tmp->created_by = $userID;
                    $tmp->set_created_by = false;
                }
                //2013-09-23J end
                if ($tmp->save()) {
                    $ids[] = $tmp->id;
                    //double emailing issue on sugarcrm 6.7 2013-07-29
                    $tmp->retrieve($tmp->id);
                    $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " saved in SugarCRM.");

                    if ($tmp->object_name == 'Meeting' || $tmp->object_name == 'Call') {

                        $table_key = 'meeting';
                        if ($tmp->object_name == 'Call') {
                            $table_key = 'call';
                        }

                        //Adding Invitees
                        $invitees = self::getSugarInvitees($event_feed);
                        $invitee_user_itself = '1';
                        $invitee_email_addresses = array();
                        $all_invitee_email_addresses = array();
                        foreach ($invitees as $invitee) {
                            $all_invitee_email_addresses[] = $invitee['email'];
                            while ($row = $GLOBALS['db']->fetchByAssoc($invitee['result'])) {
                                $accept_status = self:: toSugarAcceptStatus($invitee['accept_status']);

                                if ($row['email_address'] == $userEmailID) {
                                    if ($row['bean_id'] == $userID) {
                                        $relate_values = array('user_id' => $row['bean_id'], $table_key . '_id' => $tmp->id);
                                        $data_values = array('accept_status' => $accept_status, 'deleted' => '0');
                                        $tmp->set_relationship($tmp->rel_users_table, $relate_values, true, true, $data_values);
                                        $invitee_user_itself = '0';

                                        $GLOBALS['log']->debug("User " . $userID . " being added as inivitee");
                                    }
                                    $invitee_email_addresses[$row['bean_id']] = $row['email_address'];
                                    continue;//skipping all other where owner's email exist
                                }
                                $invitee_email_addresses[$row['bean_id']] = $row['email_address'];
                                if ($row['bean_module'] == 'Users') {
                                    $relate_values = array('user_id' => $row['bean_id'], $table_key . '_id' => $tmp->id);
                                    $data_values = array('accept_status' => $accept_status, 'deleted' => '0');
                                    $tmp->set_relationship($tmp->rel_users_table, $relate_values, true, true, $data_values);
                                    $GLOBALS['log']->debug("User " . $row['bean_id'] . " being added as inivitee");
                                } else if ($row['bean_module'] == 'Contacts') {
                                    $relate_values = array('contact_id' => $row['bean_id'], $table_key . '_id' => $tmp->id);
                                    $data_values = array('accept_status' => $accept_status, 'deleted' => '0');
                                    $tmp->set_relationship($tmp->rel_contacts_table, $relate_values, true, true, $data_values);
                                    $GLOBALS['log']->debug("Contact " . $row['bean_id'] . " being added as inivitee");
                                    //2013-09-23J set created by and modified by
                                    /*This scenario will runn only when contact is created by invitee user*/
                                    if (!$is_shared === true) {
                                        $tmp_contact_invitee = BeanFactory::getBean($row['bean_module'], $row['bean_id']);
                                        if (!empty($tmp_contact_invitee->id)) {
                                            if (empty($tmp_contact_invitee->assigned_user_id)) {
                                                $tmp_contact_invitee->assigned_user_id = $userID;
                                                $tmp_contact_invitee->modified_user_id = $userID;
                                                $tmp_contact_invitee->update_modified_by = false;
                                                $tmp_contact_invitee->created_by = $userID;
                                                $tmp_contact_invitee->set_created_by = false;
                                                if ($tmp_contact_invitee->save(false)) {
                                                    $GLOBALS['log']->fatal("Contact :" . $tmp_contact_invitee->name . " assigned user is set while sync");
                                                }
                                            }

                                        }
                                        $tmp_contact_invitee = null;//unset
                                    }
                                    //2013-09-23J end
                                } else if ($row['bean_module'] == 'Leads') {
                                    $relate_values = array('lead_id' => $row['bean_id'], $table_key . '_id' => $tmp->id);
                                    $data_values = array('accept_status' => $accept_status, 'deleted' => '0');
                                    $tmp->set_relationship($tmp->rel_leads_table, $relate_values, true, true, $data_values);
                                    $GLOBALS['log']->debug("Lead " . $row['bean_id'] . " being added as inivitee");
                                }
                            }
                        }

                        if ($invitee_user_itself == '1') {
                            $relate_values = array('user_id' => $userID, $table_key . '_id' => $tmp->id);
                            $data_values = array('accept_status' => 'accept', 'deleted' => '0');
                            $tmp->set_relationship($tmp->rel_users_table, $relate_values, true, true, $data_values);
                            $invitee_email_addresses[$userID] = $userEmailID;
                            $GLOBALS['log']->debug("User " . $userID . " being added as inivitee");
                        }

                        //delete invitees if deleted in google event
                        $related_beans['leads'] = $tmp->get_linked_beans('leads', 'Lead');
                        $related_beans['contacts'] = $tmp->get_linked_beans('contacts', 'Contact');
                        $related_beans['users'] = $tmp->get_linked_beans('users', 'User');
                        foreach ($related_beans as $rel_name => $beans) {
                            $tmp->load_relationship($rel_name);
                            // Loop through the records
                            foreach ($beans as $bean) {
                                if (!in_array($bean->id, array_keys($invitee_email_addresses)) && $bean->id != $userID) {
                                    if (($bean->email1 && in_array($bean->email1, $all_invitee_email_addresses))) {
                                        // do nothing this check is done for multi user as invitee and probably they have differen email as gmail id
                                    } else {
                                        $GLOBALS['log']->debug($bean->object_name . " " . $bean->id . " being removed as inivitee");
                                        $tmp->$rel_name->delete($tmp->id, $bean->id);
                                    }
                                }
                            }
                        }
                        //START: create contact if no record exist for email/invitee in leads/contacts/users


                        foreach ($event_feed->getAttendees() as $who) {
                            $temp = array();
                            //if(self::isAttendee($who->rel))
                            //{
                            if ($who->getEmail() !== '' && !in_array($who->getEmail(), $invitee_email_addresses)) {
                                $tmp_contact = new Contact();
                                $tmp_contact->lead_source = 'Other';
                                $tmp_contact->email1 = $who->getEmail();
                                if ($who->getDisplayName() && $who->getDisplayName() != $who->email) {
                                    $tmp_contact->first_name = strrpos($who->getDisplayName(), " ") === false ? $who->getDisplayName() : substr($who->getDisplayName(), 0, strrpos($who->getDisplayName(), " "));
                                    $tmp_contact->last_name = substr($who->getDisplayName(), strlen($tmp_contact->first_name) + 1);
                                } else {
                                    $tmp_name = substr($who->getEmail(), 0, strrpos($who->getEmail(), "@"));
                                    $tmp_contact->first_name = ucfirst(strrpos($tmp_name, ".") === false ? (strrpos($tmp_name, "_") === false ? (strrpos($tmp_name, "-") === false ? ($tmp_name) : substr($tmp_name, 0, strrpos($tmp_name, "-"))) : substr($tmp_name, 0, strrpos($tmp_name, "_"))) : substr($tmp_name, 0, strrpos($tmp_name, ".")));
                                    $tmp_contact->last_name = ucfirst(substr($tmp_name, strlen($tmp_contact->first_name) + 1));
                                }
                                if (empty($tmp_contact->last_name)) {
                                    $tmp_contact->last_name = $tmp_contact->first_name;
                                    $tmp_contact->first_name = "";
                                }
                                //2013-09-23J set created by and modified by
                                if ($is_shared === true) {
                                    $tmp_contact->modified_user_id = $userID;
                                    $tmp_contact->update_modified_by = false;
                                    $tmp_contact->created_by = $userID;
                                    $tmp_contact->set_created_by = false;
                                    $GLOBALS['log']->debug("contact creating by invitee user sync");
                                } else {
                                    $tmp_contact->assigned_user_id = $userID;
                                    $tmp_contact->modified_user_id = $userID;
                                    $tmp_contact->update_modified_by = false;
                                    $tmp_contact->created_by = $userID;
                                    $tmp_contact->set_created_by = false;
                                    $GLOBALS['log']->debug("contact creating by owner user sync");
                                }
                                //2013-09-23J end
                                if ($tmp_contact->save()) {
                                    //2013-10-29J
                                    //after contact save update sugar feed entry
                                    $feed_update_query = "UPDATE sugarfeed SET created_by='" . $tmp_contact->created_by . "' WHERE related_module='Contacts' AND related_id='" . $tmp_contact->id . "' AND deleted='0'";
                                    // $GLOBALS['db']->query($feed_update_query);

                                    $GLOBALS['log']->debug($tmp_contact->id . " contact has been saved");
                                    $relate_values = array('contact_id' => $tmp_contact->id, $table_key . '_id' => $tmp->id);
                                    $data_values = array('accept_status' => self:: toSugarAcceptStatus(self::getSugarInviteeStatus($who->getResponseStatus())), 'deleted' => '0');
                                    $tmp->set_relationship($tmp->rel_contacts_table, $relate_values, true, true, $data_values);
                                    $invitee_email_addresses[$tmp_contact->id] = $who->getEmail();
                                }

                            }
                            //}
                        }

                        //END: create contact if no record exist for email/invitee in leads/contacts/users

                        $tmp->invitee_email_addresses = base64_encode(serialize($invitee_email_addresses));
                        $tmp->save();

                    }
                }
                //}
                //handle single events conversion into recurring event
                if ($event_feed->getRecurringEventId() != '') {
                    self::singleToRecurrence($event_feed->getRecurringEventId(), $tmp->table_name);
                }
            } else    //canceled events in Google
            {

                $feed['gevent_id'] = $feed['id'];
                unset($feed['id']);
                $date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($feed['updated']));
                //if($recurrence===true || strtotime($date_modified) >= strtotime($lastSync)){
                $tmp = new Meeting();

                if (isset($prefrences['schedulers']['calendar_calls']) && $prefrences['schedulers']['calendar_calls'] == false) {
                    continue;
                }
                $sql = "SELECT id FROM calls WHERE gevent_id='" . $feed['gevent_id'] . "';";
                $result = $GLOBALS['db']->query($sql);
                $row = $GLOBALS['db']->fetchByAssoc($result);
                if ($row) {
                    $tmp = new Call();
                }

                if (isset($prefrences['schedulers']['calendar_tasks']) && $prefrences['schedulers']['calendar_tasks'] == false) {
                    continue;
                }
                $sql = "SELECT id FROM tasks WHERE gevent_id='" . $feed['gevent_id'] . "';";
                $result = $GLOBALS['db']->query($sql);
                $row = $GLOBALS['db']->fetchByAssoc($result);
                if ($row) {
                    $tmp = new Task();
                }
                //START: event already deleted in both SugarCRM & Google

                $sql = "SELECT * FROM " . $tmp->table_name . " WHERE gevent_id='" . $feed['gevent_id'] . "';";
                $result = $GLOBALS['db']->query($sql);
                $row = $GLOBALS['db']->fetchByAssoc($result);
                if ($row) {
                    if (!empty($row['gevent_id']) && $row['deleted'] == '1') {
                        $sql_update = "UPDATE " . $tmp->table_name . " SET gevent_id='' WHERE gevent_id='" . $row['gevent_id'] . "';";
                        $GLOBALS['db']->query($sql_update);
                        $ids[] = $row['id'];
                        $GLOBALS['log']->fatal($tmp->object_name . ": " . $row['name'] . " with id " . $row['id'] . " is already deleted in both SugarCRM & Google. Event id in SugarCRM is deleted");
                        continue;
                    }
                }

                //END: event already deleted in both SugarCRM & Google

                if ($tmp->retrieve_by_string_fields(array('gevent_id' => $feed['gevent_id']))) {
                    /*START: shared events*/
                    if ($is_shared === true) {
                        $invitee_users_counter = 0;
                        $related_beans_users = $tmp->get_linked_beans('users', 'User');

                        $tmp->load_relationship('users');
                        // Loop through the records
                        foreach ($related_beans_users as $bean) {
                            $invitee_users_counter++;
                            //removing only current calendar user invitee
                            if ($bean->id == $userID) {
                                $GLOBALS['log']->debug("User " . $bean->id . " being removed as inivitee");
                                $tmp->users->delete($tmp->id, $bean->id);
                            }
                        }
                        if ($invitee_users_counter > 1) {
                            continue;
                            //skipping to delete because this is shared event and other users are still invitees in this event they will be handled on their own turn and no one is owner from them
                        }
                        if (!empty($tmp->assigned_user_id)) {
                            $GLOBALS['log']->debug("assigned user not empty it will be handled in that user turn");
                            continue;
                        }
                    }
                    /*END: shared events*/
                    $tmp->date_modified = $date_modified;
                    $tmp->deleted = '1';
                    $tmp->gevent_id = '';

                    if ($tmp->save()) {
                        $ids[] = $tmp->id;

                        $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " deleted in SugarCRM.");

                        if ($tmp->object_name == 'Meeting' || $tmp->object_name == 'Call') {
                            $tmp->load_relationship('users');
                            $tmp->users->delete($tmp->assigned_user_id);
                            $invitees = self::getSugarInvitees($event_feed);
                            foreach ($invitees as $invitee) {
                                while ($row = $GLOBALS['db']->fetchByAssoc($invitee['result'])) {
                                    if ($row['bean_module'] == 'Users') {
                                        $tmp->load_relationship('users');
                                        $tmp->users->delete($row['bean_id']);
                                    } else if ($row['bean_module'] == 'Contacts') {
                                        $tmp->load_relationship('contacts');
                                        $tmp->contacts->delete($row['bean_id']);
                                    } else if ($row['bean_module'] == 'Leads') {
                                        $tmp->load_relationship('leads');
                                        $tmp->leads->delete($row['bean_id']);
                                    }
                                }
                            }
                        }
                    }
                }
                //}
            }
        }
        unset($_SESSION['from_google']);
        return $ids;
    }

    /**
    * Retrieve updated records from sugar except those that are recently fetched from google and updated in sugar
    *
    * <b>Function breakdown</b>
    * <ol>
        * <li> Fetch sugar events added/modified/deleted after the last sync, ignore the ones added by <i>updateFromGoogle()</i> </li>
        * <li> If contact is deleted in sugar, delete it on google </li>
        * <li> Otherwise push it to <i>beans</i> array </li>
        * <li> Return <i>beans</i> array </li>
    * </ol>
    *
    *
    * @param Google_DriveService    $client       Calendar API service instance.
    * @param  string                $userID       ID of current user
    * @param  date                  $lastSync     Last time sync was performed
    * @param  array                 $ids          List of event IDs saved from google (returning array from above function)
    * @param  array                 $prefrences   Which events (tasks/meetings/calls) to sync
    * @return array                               beans of events updated after the last sync
    * @access public
    */
    public static function retrieveUpdatedFromSugar($client, $user_id, $lastSync, $ids = array(), $prefrences = array())
    {

        global $db;
        $beans = array();
        //$deleted_gevent = '';//events deleted in SugarCRM
        $service = $client;
        //Getting Calls
        if (isset($prefrences['schedulers']['calendar_calls']) && $prefrences['schedulers']['calendar_calls'] == false) {
        } else {
            //added check status!=Held 2013-07-29
            $sql = "SELECT id, deleted, gevent_id FROM calls WHERE (status!='Held' OR deleted=1) AND assigned_user_id= '" . $user_id . "' AND date_modified >='" . $lastSync . "' AND id NOT IN ('" . implode("','", $ids) . "')";
            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                if ($row['deleted'] == '0') {

                    $bean = new Call();
                    $bean->retrieve($row['id']);
                    $beans[] = $bean;
                } else if (!empty($row['gevent_id'])) {
                    //$deleted_gevent = $row['gevent_id'];
                    $sql_update = "UPDATE calls SET gevent_id='' WHERE gevent_id='" . $row['gevent_id'] . "';";
                    $db->query($sql_update);
                    try {
                        $service->events->delete('primary', $row['gevent_id']);//delete event in Google
                        $GLOBALS['log']->fatal("Call: with id " . $row['id'] . " deleted in Google.");
                    } catch (Exception $e) {
                        $GLOBALS['log']->fatal($bean->gevent_id . " Exception: " . $e->getMessage());
                    }
                }
            }
        }
        //Getting Meetings
        //added check status!=Held 2013-07-29
        $sql = "SELECT id, deleted, gevent_id FROM meetings WHERE (status!='Held' OR deleted=1) AND assigned_user_id= '" . $user_id . "' AND date_modified >='" . $lastSync . "' AND id NOT IN ('" . implode("','", $ids) . "')";
        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            if ($row['deleted'] == '0') {

                $bean = new Meeting();
                $bean->retrieve($row['id']);
                $beans[] = $bean;
            } else if (!empty($row['gevent_id'])) {
                //$deleted_gevent = $row['gevent_id'];
                $sql_update = "UPDATE meetings SET gevent_id='' WHERE gevent_id='" . $row['gevent_id'] . "';";
                $db->query($sql_update);
                try {
                    $service->events->delete('primary', $row['gevent_id']);//delete event in Google
                    $GLOBALS['log']->fatal("Meeting: with id " . $row['id'] . " deleted in Google.");
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal($bean->gevent_id . " Exception: " . $e->getMessage());
                }
            }
        }

        //Gettting Tasks
        if (isset($prefrences['schedulers']['calendar_tasks']) && $prefrences['schedulers']['calendar_tasks'] == false) {
        } else {
            $sql = "SELECT id, deleted, gevent_id FROM tasks WHERE assigned_user_id= '" . $user_id . "' AND date_modified >='" . $lastSync . "' AND id NOT IN ('" . implode("','", $ids) . "')";
            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                if ($row['deleted'] == '0') {

                    $bean = new Task();
                    $bean->retrieve($row['id']);
                    $beans[] = $bean;
                } else if (!empty($row['gevent_id'])) {
                    //$deleted_gevent = $row['gevent_id'];
                    $sql_update = "UPDATE tasks SET gevent_id='' WHERE gevent_id='" . $row['gevent_id'] . "';";
                    $db->query($sql_update);
                    try {
                        $service->events->delete('primary', $row['gevent_id']);//delete event in Google
                        $GLOBALS['log']->fatal("Task: with id " . $row['id'] . " deleted in Google.");
                    } catch (Exception $e) {
                        $GLOBALS['log']->fatal($bean->gevent_id . " Exception: " . $e->getMessage());
                    }
                }
            }
        }
        return $beans;
    }
    /**
    * Save sugar's updated events to google
    *
    *
    * @param Google_DriveService    $client       Calendar API service instance.
    * @param  array                 $beans        beans of events added/modified in sugar after the last sync
    * @param  string                $userID       ID of current user
    * @access public
    */
    public static function sendUpdatedToGoogle($client, $beans, $userID)
    {

        global $db;
        if (!empty($userID)) {
            $user = new User();
            $user->retrieve($userID);
        }
        $service = $client;
        foreach ($beans as $bean) {
            $newEvent = new Google_Event();
            if ($bean->gevent_id != '') {
                $newEvent = $service->events->getA('primary', $bean->gevent_id);
            }

            if ($bean->object_name == 'Meeting') {
                $title = "Meeting: " . $bean->name;
                $newEvent->setLocation($bean->location);
            } else if ($bean->object_name == 'Task') {
                $title = "Task: " . $bean->name;
                $newEvent->setColorId('10');
            } else if ($bean->object_name == 'Call') {
                $title = "Call: " . $bean->name;
                $newEvent->setColorId('4');
            }


            //Bug #10609
            if (!empty($title)) $newEvent->setSummary(htmlspecialchars_decode($title, ENT_QUOTES));
            if (!empty($bean->description)) $newEvent->setDescription(htmlspecialchars_decode($bean->description, ENT_QUOTES));

            //Adding Time values
            $start = new Google_EventDateTime();
            $end = new Google_EventDateTime();

            $tzOffset = '+00:00';
            $date_start = '';
            if (!empty($bean->date_start)) {
                $date_start = $GLOBALS['timedate']->to_db($bean->date_start);
            } else if (!empty($bean->date_due)) {
                $date_start = $GLOBALS['timedate']->to_db($bean->date_due);
            }
            $date_end = '';
            if (!empty($bean->date_end)) {
                $date_end = $GLOBALS['timedate']->to_db($bean->date_end);//date_start
            } else if (!empty($bean->date_due)) {
                $date_end = $GLOBALS['timedate']->to_db($bean->date_due);
            } else if (!empty($bean->date_start)) {
                $end_date = strtotime($bean->date_start);

                if (!empty($bean->duration_hours)) {
                    $end_date = strtotime("+" . $bean->duration_hours . " hours", $end_date);
                }

                if (!empty($bean->duration_minutes)) {
                    $end_date = strtotime("+" . $bean->duration_minutes . " mins", $end_date);
                }

                $end_date = gmdate("Y-m-d H:i:s", $end_date);
            }
            if ($bean->allday == 0) {
                //Adding start date
                if (!empty($date_start)) {
                    $date_start = str_replace(' ', 'T', $date_start);
                    $start->setDateTime("{$date_start}.000{$tzOffset}");
                    $newEvent->setStart($start);
                }
                if (!empty($date_end)) {
                    $date_end = str_replace(' ', 'T', $date_end);
                    $end->setDateTime("{$date_end}.000{$tzOffset}");
                    $newEvent->setEnd($end);
                }
            } else {

                $date_start = date('Y-m-d', strtotime($GLOBALS['timedate']->to_display_date_time($date_start, true, true, $user)));

                $date_end_one_day_added = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_end)) . "+01 days");
                $date_end_one_day_added = date($GLOBALS['timedate']->get_db_date_time_format(), $date_end_one_day_added);
                $date_end = date('Y-m-d', strtotime($GLOBALS['timedate']->to_display_date_time($date_end_one_day_added, true, true, $user)));

                $start->setDate($date_start);
                $newEvent->setStart($start);
                $end->setDate($date_end);
                $newEvent->setEnd($end);

            }
            //2013-12-19
            //don't save any event which does not hold date_start due to any reason(allday,recurring)
            if (empty($date_start)) {
                $GLOBALS['log']->fatal('SugarCRM Event without date_start will not be saved in GOOGLE,skipping...');
                continue;
            }
            //don't save any event which does not hold date_due due to any reason(allday,recurring)
            if (empty($date_end)) {
                $GLOBALS['log']->fatal('SugarCRM Event without date_end/date_due will not be saved in GOOGLE,skipping...');
                continue;
            }

            $update_date = str_replace(' ', 'T', gmdate('Y-m-d H:i:s'));
            $newEvent->setUpdated("{$update_date}.000{$tzOffset}");

            //don't save any event which does not hold date_due due to any reason(allday,recurring)
            if (strtotime($date_end) < strtotime($date_start)) {
                $GLOBALS['log']->fatal('SugarCRM Event with date_due < date_start will not be saved in GOOGLE,skipping...');
                continue;
            }

            //Adding reminders
            $reminders = new Google_EventReminders();
            $remindersArray = array();
            if ($bean->reminder_checked) {
                $reminderP = new Google_EventReminder();
                $reminderP->setMethod('popup');
                $reminderP->setMinutes(self::toGoogleReminderTime($bean->reminder_time));
                $remindersArray[] = $reminderP;
            }
            if ($bean->email_reminder_checked) {
                $reminderE = new Google_EventReminder();
                $reminderE->setMethod('email');
                $reminderE->setMinutes(self::toGoogleReminderTime($bean->email_reminder_time));
                $remindersArray[] = $reminderE;
            }
            $reminders->setOverrides($remindersArray);
            $reminders->setUseDefault("false");
            $newEvent->setReminders($reminders);

            /*if(!empty($date_end) || !empty($date_start)){
                $newEvent->when = array($when);
            }*/
            //Adding Invitees
            if ($bean->object_name == 'Meeting' || $bean->object_name == 'Call') {
                $target_key = 'meeting';
                if ($bean->object_name == 'Call') {
                    $target_key = 'call';
                }

                $invitees = unserialize(base64_decode($bean->invitee_email_addresses));
                $attendees = self:: setGoogleInvitees($target_key, $bean->id, $invitees, $bean->assigned_user_id);
                if (!empty($attendees)) {
                    $newEvent->attendees = $attendees;
                }
            }
            if ($bean->gevent_id != '') {
                $service->events->update('primary', $newEvent->getId(), $newEvent);
            } else {
                $createdEvent = $service->events->insert('primary', $newEvent);

                $sql = "UPDATE " . $bean->table_name . " SET gevent_id='" . $createdEvent->getId() . "' WHERE id='" . $bean->id . "'";
                $db->query($sql);
            }

            $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->name . " with id " . $bean->id . " saved in Google.");
        }
    }
    /**
    * Clean calendar sync
    *
    *
    * @param Google_DriveService    $client       Calendar API service instance.
    * @param  string                $userID        Current user's id
    * @param  date                  $date_modified Current date
    * @access public
    */
    public static function cleanCalendarSync($client, $userID, $date_modified)
    {
        global $db;
        $service = $client;
        $activities = array(
            0 => 'meetings',
            1 => 'calls',
            2 => 'tasks',
        );

        foreach ($activities as $activity) {
            //Bug #12181 fixed
            //Get Sugar Activities
            $sql_gevents = "SELECT id, gevent_id FROM " . $activity . " WHERE assigned_user_id='" . $userID . "' AND is_gevent='0' AND gevent_id!='';";
            //Remove gevent_id from Sugar Activities
            $sql_update_sugar_meetings = "UPDATE " . $activity . " SET gevent_id='', date_modified='" . $date_modified . "' WHERE assigned_user_id='" . $userID . "' AND is_gevent='0' AND gevent_id!='';";
            //Delete gevents from Sugar
            $sql_delete_gevents = "UPDATE " . $activity . " SET gevent_id='', date_modified='" . $date_modified . "', deleted='1' WHERE assigned_user_id='" . $userID . "' AND is_gevent='1';";

            //delete Sugar Activities from Google
            $result = $db->query($sql_gevents);
            while ($row = $db->fetchByAssoc($result)) {
                try {
                    $service->events->delete('primary', $row['gevent_id']);//delete event in Google
                    $GLOBALS['log']->fatal($activity . " with id " . $row['id'] . " deleted in Google.");
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal($row['id'] . " Exception: " . $e->getMessage());
                }
            }
            $db->query($sql_update_sugar_meetings);
            $db->query($sql_delete_gevents);
            $GLOBALS['log']->fatal($activity . " deleted in Sugar.");
            $GLOBALS['log']->debug('Running calendar clean sync for shared events');

            /*START: shared events*/
            if ($activity == 'meetings' || $activity == 'calls') {
                $sql_shared_events = "SELECT DISTINCT a.id, au.user_id
										FROM " . $activity . " AS a JOIN " . $activity . "_users AS au ON au." . substr($activity, 0, strlen($activity) - 1) . "_id = a.id
										WHERE     a.deleted = '0'
										AND a.gevent_id != ''
										AND a.is_gevent = '1'
										AND a.assigned_user_id = ''
										AND au.deleted = '0'
										AND au.user_id='" . $userID . "'";
                $GLOBALS['log']->debug("SQL query to get shared event for user " . $userID);
                $GLOBALS['log']->debug($sql_shared_events);
                $result = $db->query($sql_shared_events);
                while ($row = $db->fetchByAssoc($result)) {
                    $invitee_users_counter = 0;
                    if ($activity == 'meetings') {
                        $tmp = new Meeting();
                    } else {
                        $tmp = new Call();
                    }
                    $tmp->retrieve($row['id']);
                    if (!empty($tmp->id)) {
                        $related_beans_users = $tmp->get_linked_beans('users', 'User');
                        $tmp->load_relationship('users');
                        // Loop through the records
                        foreach ($related_beans_users as $bean) {
                            $invitee_users_counter++;
                            //removing only current calendar user invitee
                            if ($bean->id == $userID) {
                                $GLOBALS['log']->debug("User " . $bean->id . " being removed as inivitee");
                                $tmp->users->delete($tmp->id, $bean->id);
                            }
                        }
                        if ($invitee_users_counter > 1) {
                            continue;
                            //skipping to delete because this is shared event and other users are still invitees in this event they will be handled on their own turn
                        } else {
                            $tmp->deleted = '1';
                            $tmp->gevent_id = '';
                            if ($tmp->save()) {
                                $GLOBALS['log']->fatal($tmp->object_name . " with id " . $tmp->id . " deleted in SugarCRM");
                            }
                        }
                    }//if(!empty($tmp->id))
                }// while
            }//if activity
            /*END: shared events*/
        }//foreach
    }//function

    /**
    * Convert Google API event feed from object to array 
    *
    *
    * @param  object $feed         An event from Google Calendar API
    * @return array                Google calendar event in the form of associative array
    * @access public
    */
    public static function toArray(&$feed)
    {
        $entry = array('name' => '', 'start' => '', 'reminder_time' => -1, 'email_reminder_time' => -1, 'reminder_checked' => '', 'email_reminder_checked' => '', 'updated' => '', 'end' => '', 'description' => '', 'id' => '', 'location' => '', 'event_author' => '', 'all_day_start' => '', 'all_day_end' => '');

        if ($feed->getStart() != '') {
            $entry['start'] = $feed->getStart()->getDateTime();
            $entry['all_day_start'] = $feed->getStart()->getDate();
        }
        if ($feed->getEnd() != '') {
            $entry['end'] = $feed->getEnd()->getDateTime();
            $entry['all_day_end'] = $feed->getEnd()->getDate();
        }
        //Setting reminders
        $reminders = $feed->getReminders();
        if (isset($reminders) && !empty($reminders)) {
            if ($reminders->getUseDefault() != '1') {
                $entry['reminder_time'] = -1;
                $entry['email_reminder_time'] = -1;
                foreach ($reminders->getOverrides() as $reminder) {
                    if ($reminder->getMethod() == 'popup') {
                        $entry['reminder_checked'] = true;
                        $entry['reminder_time'] = self::toSugarReminderTime($reminder);
                    } else if ($reminder->getMethod() == 'email') {
                        $entry['email_reminder_checked'] = true;
                        $entry['email_reminder_time'] = self::toSugarReminderTime($reminder);
                    }
                }
            } else {
                $entry['reminder_checked'] = true;
                $entry['reminder_time'] = 30 * 60;
            }
        }

        $event_author = $feed->getCreator();
        if ($event_author != null) {
            $entry['event_author'] = $event_author->getEmail();
        }

        if ($feed->getSummary() != null) {
            $entry['name'] = $feed->getSummary();
        }

        $entry['id'] = $feed->getId();

        if ($feed->getDescription() != null) {
            $entry['description'] = $feed->getDescription();
        }

        if ($feed->getUpdated() != null) {
            $entry['updated'] = $feed->getUpdated();
        }

        $entry['location'] = $feed->getLocation();

        return $entry;
    }
    /**
    * Check if an event is allday
    *
    * If it is a google event, check for all_day_start or all_day_end and return true if they are non-empty, false otherwise.
    * In case it is a sugar event, check if start time and end time is 12:00 and return true 
    *
    * @param  object  $user             current user
    * @param  object  $date_time_start  event_start_date (if sugar event), all_day_event_start (if Google's)
    * @param  object  $date_time_end    event_end_date (if sugar event), all_day_event_end (if Google's)
    * @param  string  $from             Event's origin (SUGAR/GOOGLE)
    * @return bool                      true if event is all day
    * @access public
    */
    public static function isAlldayEvent($user, $date_time_start, $date_time_end, $from = 'GOOGLE')
    {
        $GLOBALS['log']->debug('Checking isAlldayEvent');
        switch ($from) {
            case 'GOOGLE':
                if (!empty($date_time_start) && !empty($date_time_end)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'SUGAR':
                //start date
                $date_time_start_new = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time_start));
                $date_time_start_new = $GLOBALS['timedate']->to_display_date_time($date_time_start_new, true, true, $user);
                $date_time_start_new = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time_start_new));
                //end date
                $date_time_end_new = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time_end));
                $date_time_end_new = $GLOBALS['timedate']->to_display_date_time($date_time_end_new, true, true, $user);
                $date_time_end_new = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time_end_new));
                //getting time part
                $time_part_start = array();
                $time_part_start = explode(' ', $date_time_start_new, 2);
                $time_part_end = array();
                $time_part_end = explode(' ', $date_time_end_new, 2);
                if (isset($time_part_start[1]) && isset($time_part_end[1]) && $time_part_start[1] == '00:00:00' && $time_part_end[1] == '00:00:00') {
                    return true;
                } else return false;
                break;
            default:
                return false;
                break;
        }
    }
    /**
    * handleAlldayEventTime
    *
    * @access public
    */
    public static function handleAlldayEventTime($date_time, $from = 'GOOGLE', User $user = null)
    {
        $GLOBALS['log']->debug('handleAlldayEventTime');
        $user_tz_offset = $GLOBALS['timedate']->getUserUTCOffset($user);
        switch ($from) {
            case 'GOOGLE':
                $old_date = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time));
                $date_time_added = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($old_date)) . "" . (-($user_tz_offset)) . " minutes");

                $new_date = date($GLOBALS['timedate']->get_db_date_time_format(), $date_time_added);
                if ($new_date) {
                    return $new_date;
                } else {
                    return $date_time;
                }
                break;
            case 'SUGAR':
                $old_date = date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($date_time));
                $date_time_added = strtotime(date($GLOBALS['timedate']->get_db_date_time_format(), strtotime($old_date)) . "" . ($user_tz_offset) . " minutes");
                $new_date = date($GLOBALS['timedate']->get_db_date_time_format(), $date_time_added);
                $date_part = array();
                $date_part = explode(' ', $new_date, 2);
                return $date_part[0];
                break;
            default:
                return $date_time;
                break;
        }
    }
    /**
    * This function just deletes the event in sugar
    *
    *
    * @param  string  $is     event id
    * @param  string  $table  meeting or task or call
    * @access public
    */
    public static function singleToRecurrence($id, $table)
    {
        $GLOBALS['log']->debug('Deleting Single occurence of recurring event if exist');
        global $db;
        $sql = "UPDATE " . $table . " SET deleted='1' where gevent_id='" . $id . "'";
        $db->query($sql);
    }
    /**
    * Returns google calendar event's status
    *
    * @param  object  $feed        google api event
    * @return string  $eventStatus status of event (confirmed/held etc)
    * @access public
    */
    public static function getEventStatus(&$feed)
    {

        $eventStatus = $feed->getStatus();
        if ($eventStatus != null) {
            return $eventStatus;
        }
        return "confirmed";

    }
    /**
    * Returns google's event attendees
    *
    * @param  object  $feed     google api event
    * @return array   $invitees array of invitees and their emails
    * @access public
    */
    public static function getSugarInvitees(&$feed)
    {
        $who_arr = $feed->getAttendees();
        $invitees = array();

        foreach ($who_arr as $who) {
            $temp = array();
            // if(self::isAttendee($who->rel))
            // {
            $sql = "SELECT DISTINCT eabr.bean_id, eabr.bean_module,ea.email_address 
							FROM email_addr_bean_rel AS eabr JOIN email_addresses AS ea
							ON ea.id=eabr.email_address_id
							WHERE ea.deleted=0 AND (eabr.bean_module = 'Contacts' OR eabr.bean_module = 'Leads') AND eabr.deleted=0 AND ea.email_address='" . $who->getEmail() .
                "' UNION 
							SELECT u.id AS bean_id,'Users' bean_module,u.gmail_id FROM users AS u WHERE u.deleted='0' AND u.status='Active' AND u.gmail_id='" . $who->getEmail() . "';";
            $GLOBALS['log']->debug('SQL query for invitees search');
            $GLOBALS['log']->debug($sql);

            $temp['email'] = $who->getEmail();
            $temp['result'] = $GLOBALS['db']->query($sql);
            $temp['accept_status'] = self::getSugarInviteeStatus($who->getResponseStatus());
            $invitees[] = $temp;
            $temp = array();
            // }
        }
        return $invitees;
    }
    /**
    * isAttendee
    *
    * @access public
    */
    public static function isAttendee($rel)
    {
        $rel = explode('.', $rel);
        end($rel);
        if ($rel[key($rel)] == 'attendee') {
            return true;
        }
        return false;
    }
    /**
    * getter for invitee status
    *
    * @access public
    */
    public static function getSugarInviteeStatus($status)
    {
        return $status;
    }
    /**
    * Sugar reminder time to google reminder time format
    *
    * @param  number  $reminder_time     reminder time in sugar format
    * @return number     reminder time in google format
    * @access public
    */
    public static function toGoogleReminderTime($reminder_time)
    {
        /*if($reminder_time<=3600 )
        {
            $reminderMinutes = $reminder_time/60;
        }
        else if($reminder_time>=3600 && $reminder_time<=18000 )
        {
            $reminderMinutes = $reminder_time/3600;
        }
        else if($reminder_time>=86400)
        {
            $reminderMinutes = 1;
        }*/
        $reminderMinutes = round($reminder_time * 0.0166667, 0, PHP_ROUND_HALF_DOWN);
        return $reminderMinutes;
    }
    /**
    * google reminder time to Sugar google reminder time format
    *
    * @param  number  $reminder_time     reminder time in google format
    * @return number                     reminder time in sugar format
    * @access public
    */
    public static function toSugarReminderTime($reminder)
    {
        $reminderMinutes = $reminder->getMinutes();
        if (!empty($reminderMinutes)) {
            if ($reminderMinutes > 1 && $reminderMinutes < 5) {
                $reminderMinutes = 5;
            } else if ($reminderMinutes > 5 && $reminderMinutes < 10) {
                $reminderMinutes = 10;
            } else if ($reminderMinutes > 10 && $reminderMinutes < 15) {
                $reminderMinutes = 15;
            } else if ($reminderMinutes > 15 && $reminderMinutes < 30) {
                $reminderMinutes = 30;
            } else if ($reminderMinutes > 30 && $reminderMinutes < 60) {
                $reminderMinutes = 60;
            } else if ($reminderMinutes > 60 && $reminderMinutes < 120) {
                $reminderMinutes = 120;
            } else if ($reminderMinutes > 120 && $reminderMinutes < 180) {
                $reminderMinutes = 180;
            } else if ($reminderMinutes > 180 && $reminderMinutes < 300) {
                $reminderMinutes = 300;
            } else if ($reminderMinutes > 300) {
                $reminderMinutes = 1440;
            }

            return $reminderMinutes * 60;
        }
        return 60;
    }
    /**
    * Get an array of email addresses and set those as attendeees of an event before syncronising to google
    *
    * @param  string  $target_key               concerning module (meeting, task or call)
    * @param  string  $id                       id of the sugar event in db
    * @param  array   $invitee_email_addresses  email addresses to set as attendees
    * @param  string  $assigned_user_id         id of the current user
    * @return array                             attendees in google acceptable format
    * @access public
    */
    public static function setGoogleInvitees($target_key, $id, $invitee_email_addresses, $assigned_user_id = '')
    {
        $attendees = array();
        $sql = "SELECT lead_id as id, accept_status, 'Lead' as bean FROM " . $target_key . "s_leads WHERE deleted=0 AND " . $target_key . "_id='" . $id . "' 
					UNION 
					SELECT contact_id as id, accept_status, 'Contact' as bean FROM " . $target_key . "s_contacts WHERE deleted=0 AND " . $target_key . "_id='" . $id . "'
					UNION
					SELECT user_id as id, accept_status, 'User' as bean FROM " . $target_key . "s_users WHERE deleted=0 AND " . $target_key . "_id='" . $id . "'";
        $result = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            switch ($row['bean']) {
                case "User":
                    $bean = new User();
                    break;
                case "Contact":
                    $bean = new Contact();
                    break;
                case "Lead":
                    $bean = new Lead();
                    break;
                default:
                    $bean = new Lead();
                    break;
            }
            $bean->retrieve($row['id']);
            if (isset($bean->email1) && !empty($bean->email1)) {
                $attendee = new Google_EventAttendee();
                $email_addresses = array();
                $primary = "";
                if (isset($bean->emailAddress) && isset($bean->emailAddress->addresses)) {
                    foreach ($bean->emailAddress->addresses as $addr) {
                        $email_addresses[] = $addr['email_address'];
                        if (isset($addr['primary_address']) && $addr['primary_address'] == 1) {
                            $primary = $addr['email_address'];
                        }
                    }
                }

                if (isset($invitee_email_addresses[$bean->id]) && !empty($invitee_email_addresses[$bean->id]) && in_array($invitee_email_addresses[$bean->id], $email_addresses)) {
                    $attendee->setEmail($invitee_email_addresses[$bean->id]);
                } else {
                    if (empty($primary)) {
                        $primary = $bean->email1;
                    }
                    //for user created ,only send gmail id instead of email1
                    if ($row['bean'] == 'User' && $assigned_user_id == $row['id']) {
                        $primary = $bean->gmail_id;
                    }
                    $attendee->setEmail($primary);

                }
                $accept_status = self:: toGoogleAcceptStatus($row['accept_status']);
                if ($row['bean'] == 'User' && $assigned_user_id == $row['id']) {
                    $attendee->setResponseStatus('accepted');
                } else {
                    $attendee->setResponseStatus($accept_status);
                }
                $attendees[] = $attendee;
            }
        }
        return $attendees;
    }
    /**
    * Sugar stores status in first form, this function converts it into acceptable google status (third form)
    *
    * @param  string  $status sugar status
    * @return string          google status
    * @access public
    */
    public static function toGoogleAcceptStatus($status)
    {
        $accept_status = 'needsAction';
        if ($status == 'none') {
            $accept_status = 'needsAction';
        } else if ($status == 'accept') {
            $accept_status = 'accepted';
        } else if ($status == 'tentative') {
            $accept_status = 'tentative';
        } else if ($status == 'decline') {
            $accept_status = 'declined';
        }
        return $accept_status;
    }
    /**
    * Google stores status in third form, this function converts it into acceptable sugar status (first form)
    *
    * @param  string  $status  google status
    * @return string           sugar status
    * @access public
    */
    public static function toSugarAcceptStatus($status)
    {
        $accept_status = 'none';
        if ($status == 'needsAction') {
            $accept_status = 'none';
        } else if ($status == 'accepted') {
            $accept_status = 'accept';
        } else if ($status == 'tentative') {
            $accept_status = 'tentative';
        } else if ($status == 'declined') {
            $accept_status = 'decline';
        }
        return $accept_status;
    }

}

?>