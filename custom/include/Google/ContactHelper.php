<?php
require_once("modules/Contacts/Contact.php");
require_once("custom/include/Google/lib/GoogleContacts.php");
require_once 'vendor/Zend/Loader.php';
/**
* ContactHelper uses google api to perform <b>contacts</b> syncing
*
* This class is responsible for syncing contacts between Google and Sugar
* It takes care of all the details like removing duplicates 
* or deleting contacts on one side which are deleted on the other
*
*
*/
class ContactHelper
{
    /**
    * Retrieves google contacts, process those and save in SugarCRM if necessary.
    *
    * <b>Function breakdown</b>
    * <ol>
        * <li> Set parameters before fetching contacts (e.g. fetch only those updated after the last sync)</li>
        * <li> Fetch contacts</li>
        * <li> Process those and save in sugar or ignore with proper logs</li>
    * </ol>
    *
    * @param Google_DriveService $client       Contact API service instance.
    * @param  string             $userID       ID of current user
    * @param  date               $lastSync     Last time sync was performed
    * @param  string             $user_email   Email address of the user
    * @return array                            IDs of new events stored in SugarCRM
    * @access public
    */
    public static function updateFromGoogle($client, $userID, $lastSync, $user_email)
    {
        global $db;
        //Get Contacts by Group -------------------------------------------------------------------
        // Now we request the users contacts based on group. For now, we will retreive 'My Contacts'

        $group = "http%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2Fgroups%2F" . $user_email . "%2Fbase%2F6";
        $max_results = 100000;
        if (substr($lastSync, -4) == '.000') {
            $lastSync = substr($lastSync, 0, -4);
        }
        $lastUpdated = str_replace(' ', 'T', $lastSync) . ".000Z";
        $req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/" . $user_email . "/full?alt=json&max-results=" . $max_results . "&v=3.0&showdeleted=true&updated-min=" . $lastUpdated);
        $req->setRequestHeaders(array(
            'GData-Version' => '3.0',
            'content-type' => 'application/atom+xml; charset=UTF-8; type=feed'
        ));
        $val = $client->getIo()->authenticatedRequest($req);
        $response = $val->getResponseBody();
        $feeds = json_decode($response, 1);

        if (count($feeds) == 0 && gettype($feeds) == 'NULL') {
            $GLOBALS['log']->fatal("response: " . print_r($response, 1));
        }
        $ids = array();
        foreach ($feeds['feed']['entry'] as $feed) {
            $updated = '';
            if (isset($feed['updated'])) {
                if ($feed['updated']['$t'] != null) {
                    $updated = $feed['updated']['$t'];
                }
            }
            $date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format(), strtotime($updated));
            if (strtotime($date_modified) >= strtotime($lastSync)) {
                $tmp = new Contact();
                //if($feed['deleted']=='false' ){
                if ($feed['gContact$groupMembershipInfo'][0]['deleted'] == 'false' || !(isset($feed['gd$deleted']))) {
                    //not deleted contacts from google
                    //START: contact deleted in SugarCRM but not deleted in Google
                    //	$sql = "SELECT * from ".$tmp->table_name." WHERE gcontact_id='".$feed['gcontact_id']."';";
                    $sql = "SELECT * from " . $tmp->table_name . " WHERE gcontact_id='" . $feed['id']['$t'] . "';";
                    $result = $GLOBALS['db']->query($sql);
                    $row = $GLOBALS['db']->fetchByAssoc($result);
                    if ($row) {
                        if (!empty($row['gcontact_id']) && $row['deleted'] == '1') {
                            $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $row['id'] . " deleted in SugarCRM but not deleted in Google.");
                            continue;
                        } //no id is returned so that we can delete contact in Google
                    }
                    //END: contact deleted in SugarCRM but not deleted in Google
                    //$tmp->retrieve_by_string_fields(array('gcontact_id' => $feed['gcontact_id']));
                    $tmp->retrieve_by_string_fields(array(
                        'gcontact_id' => $feed['id']['$t']
                    ));
                    if (!empty($tmp->id)) {
                        if (strtotime($tmp->date_modified) > strtotime($date_modified)) {
                            $GLOBALS['log']->debug($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " date modified in Sugar is greater so skip it");
                            continue;
                        }

                    }

                    if (!empty($tmp->id)) {
                        $id = $tmp->id;
                        $tmp = new Contact();
                        $tmp->retrieve($id);
                    }

                    /*if contact has matching email1 in existing contacts*/
                    //	if(empty($tmp->id) && !empty($feed['email1'])){
                    /*                    if (empty($tmp->id) && isset($feed['gd$email'][0])) {
                                            if (!empty($feed['gd$email'][0]['address'])) {
                                                $tmp->id = self::findByEmail('Contacts', $feed['gd$email'][0]['address']);
                                                $tmp->retrieve($tmp->id);
                                            }
                                        }*/
                    /*if contact has matching email2 in existing contacts*/
                    /*	if(empty($tmp->id) && !empty($feed['email2'])){
                    $tmp->id=self::findByEmail('Contacts',$feed['email2']);
                    }*/
                    /*                    if (empty($tmp->id) && isset($feed['gd$email'][1])) {
                                            if (!empty($feed['gd$email'][1]['address'])) {
                                                $tmp->id = self::findByEmail('Contacts', $feed['gd$email'][1]['address']);
                                                $tmp->retrieve($tmp->id);
                                            }
                                        }*/
                    /*if contact has matching mobile no in existing contacts*/
                    //if(empty($tmp->id) && !empty($feed['phone_mobile'])){
/*                    $phone_mobile_found_google = false; //will be true if phone_mobile is coming from google
                    if (empty($tmp->id) && isset($feed['gd$phoneNumber'])) {
                        //if phone_mobile is coming from google, search it in existing contacts
                        foreach ($feed['gd$phoneNumber'] as $phone) {
                            if ($phone['rel'] == 'http://schemas.google.com/g/2005#mobile') {
                                $tmp->retrieve_by_string_fields(array(
                                    'phone_mobile' => $phone['$t']
                                ));
                                if (!empty($tmp->id)) {
                                    $id = $tmp->id;
                                    $tmp = new Contact();
                                    $tmp->retrieve($id);
                                }
                                $phone_mobile_found_google = true;
                                break;
                            }
                        }
                        //	if phone_mobile is not coming from google and phone other is coming, search it in existing contacts
                        if ($phone_mobile_found_google == false) {
                            foreach ($feed['gd$phoneNumber'] as $phone) {
                                if ($phone['rel'] == 'http://schemas.google.com/g/2005#other') {
                                    $tmp->retrieve_by_string_fields(array(
                                        'phone_mobile' => $phone['$t']
                                    ));
                                    if (!empty($tmp->id)) {
                                        $id = $tmp->id;
                                        $tmp = new Contact();
                                        $tmp->retrieve($id);
                                    }
                                }
                                break;
                            }
                        }

                    }*/
                    //2013-09-23J
                    if (empty($tmp->id)) {
                        //created by should be as assigned user
                        $tmp->set_created_by = false;
                        $tmp->created_by = $userID;
                    }
                    //modified by should be as assigned user
                    $tmp->update_modified_by = false;
                    $tmp->modified_user_id = $userID;
                    ///////////////////////////////////////////////////////////////////////////////
                    $tmp->assigned_user_id = $userID;
                    $tmp->created_by = $userID;
                    $tmp->modified_user_id = $userID;

                    $tmp->gcontact_id = $feed['id']['$t'];
                    if (isset($feed['content']['$t'])) {
                        $tmp->description = $feed['content']['$t'];
                    }
                    $primary_address_google_found = false;
                    $alt_address_google_found = false;
                    if (isset($feed['gd$structuredPostalAddress'])) {
                        foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                            if ($address_array['rel'] == 'http://schemas.google.com/g/2005#work') {
                                if (isset($address_array['gd$postcode'])) {
                                    $tmp->primary_address_postalcode = $address_array['gd$postcode']['$t'];
                                }
                                if (isset($address_array['gd$street'])) {
                                    $tmp->primary_address_street = $address_array['gd$street']['$t'];
                                }
                                if (isset($address_array['gd$city'])) {
                                    $tmp->primary_address_city = $address_array['gd$city']['$t'];
                                }
                                if (isset($address_array['gd$region'])) {
                                    $tmp->primary_address_state = $address_array['gd$region']['$t'];
                                }
                                if (isset($address_array['gd$country'])) {
                                    $tmp->primary_address_country = $address_array['gd$country']['$t'];
                                }
                                $primary_address_google_found = true;
                            }

                            if ($address_array['rel'] == 'http://schemas.google.com/g/2005#home') {
                                if (isset($address_array['gd$postcode'])) {
                                    $tmp->alt_address_postalcode = $address_array['gd$postcode']['$t'];
                                }
                                if (isset($address_array['gd$street'])) {
                                    $tmp->alt_address_street = $address_array['gd$street']['$t'];
                                }
                                if (isset($address_array['gd$city'])) {
                                    $tmp->alt_address_city = $address_array['gd$city']['$t'];
                                }
                                if (isset($address_array['gd$region'])) {
                                    $tmp->alt_address_state = $address_array['gd$region']['$t'];
                                }
                                if (isset($address_array['gd$country'])) {
                                    $tmp->alt_address_country = $address_array['gd$country']['$t'];
                                }
                                $alt_address_google_found = true;
                            }
                        } //end foreach
                        if ($primary_address_google_found == false && $alt_address_google_found == false) {
                            if (isset($feed['gd$structuredPostalAddress'][0])) {
                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$postcode'])) {
                                    $tmp->primary_address_postalcode = $feed['gd$structuredPostalAddress'][0]['gd$postcode']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$street'])) {
                                    $tmp->primary_address_street = $feed['gd$structuredPostalAddress'][0]['gd$street']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$city'])) {
                                    $tmp->primary_address_city = $feed['gd$structuredPostalAddress'][0]['gd$city']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$region'])) {
                                    $tmp->primary_address_state = $feed['gd$structuredPostalAddress'][0]['gd$region']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$country'])) {
                                    $tmp->primary_address_country = $feed['gd$structuredPostalAddress'][0]['gd$country']['$t'];
                                }
                            }
                            if (isset($feed['gd$structuredPostalAddress'][1])) {
                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$postcode'])) {
                                    $tmp->alt_address_postalcode = $feed['gd$structuredPostalAddress'][1]['gd$postcode']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$street'])) {
                                    $tmp->alt_address_street = $feed['gd$structuredPostalAddress'][1]['gd$street']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$city'])) {
                                    $tmp->alt_address_city = $feed['gd$structuredPostalAddress'][1]['gd$city']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$region'])) {
                                    $tmp->alt_address_state = $feed['gd$structuredPostalAddress'][1]['gd$region']['$t'];
                                }
                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$country'])) {
                                    $tmp->alt_address_country = $feed['gd$structuredPostalAddress'][1]['gd$country']['$t'];
                                }
                            }
                        }
                        if ($primary_address_google_found == true && $alt_address_google_found == false) {
                            foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                                if ($address_array['rel'] != 'http://schemas.google.com/g/2005#work') {
                                    if (isset($address_array['gd$postcode'])) {
                                        $tmp->alt_address_postalcode = $address_array['gd$postcode']['$t'];
                                    }
                                    if (isset($address_array['gd$street'])) {
                                        $tmp->alt_address_street = $address_array['gd$street']['$t'];
                                    }
                                    if (isset($address_array['gd$city'])) {
                                        $tmp->alt_address_city = $address_array['gd$city']['$t'];
                                    }
                                    if (isset($address_array['gd$region'])) {
                                        $tmp->alt_address_state = $address_array['gd$region']['$t'];
                                    }
                                    if (isset($address_array['gd$country'])) {
                                        $tmp->alt_address_country = $address_array['gd$country']['$t'];
                                    }
                                    break;
                                }
                            }
                        }
                        if ($primary_address_google_found == false && $alt_address_google_found == true) {
                            foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                                if ($address_array['rel'] != 'http://schemas.google.com/g/2005#home') {
                                    if (isset($address_array['gd$postcode'])) {
                                        $tmp->alt_address_postalcode = $address_array['gd$postcode']['$t'];
                                    }
                                    if (isset($address_array['gd$street'])) {
                                        $tmp->alt_address_street = $address_array['gd$street']['$t'];
                                    }
                                    if (isset($address_array['gd$city'])) {
                                        $tmp->alt_address_city = $address_array['gd$city']['$t'];
                                    }
                                    if (isset($address_array['gd$region'])) {
                                        $tmp->alt_address_state = $address_array['gd$region']['$t'];
                                    }
                                    if (isset($address_array['gd$country'])) {
                                        $tmp->alt_address_country = $address_array['gd$country']['$t'];
                                    }
                                    break;
                                }
                            }
                        }
                    }

                    //Bug #11371 fax field should be synced
                    $phoneMobile_found = false;
                    $phoneWork_found = false;
                    $phoneFax_found = false;
                    if (isset($feed['gd$phoneNumber'])) {
                        foreach ($feed['gd$phoneNumber'] as $phoneNumber) {
                            # code...
                            if ($phoneNumber['rel'] == 'http://schemas.google.com/g/2005#work') {
                                $tmp->phone_work = $phoneNumber['$t'];
                                $phoneWork_found = true;
                            }
                            if ($phoneNumber['rel'] == 'http://schemas.google.com/g/2005#mobile') {
                                $tmp->phone_mobile = $phoneNumber['$t'];
                                $phoneMobile_found = true;
                            }
                            if ($phoneNumber['rel'] == 'http://schemas.google.com/g/2005#work_fax' || $phoneNumber['rel'] == 'http://schemas.google.com/g/2005#home_fax') {
                                $tmp->phone_fax = $phoneNumber['$t'];
                                $phoneFax_found = true;
                            }

                            if ($phoneMobile_found == false && $phoneWork_found == false && $phoneFax_found == false) {
                                if (isset($feed['gd$phoneNumber'][0])) {
                                    $tmp->phone_mobile = $feed['gd$phoneNumber'][0]['$t'];
                                }
                                if (isset($feed['gd$phoneNumber'][1])) {
                                    $tmp->phone_work = $feed['gd$phoneNumber'][1]['$t'];
                                }
                                if (isset($feed['gd$phoneNumber'][2])) {
                                    $tmp->phone_fax = $feed['gd$phoneNumber'][2]['$t'];
                                }
                            }
                        }
                    }
                    /*if (isset($feed['gd$email'][0])) {
                        $tmp->email1 = $feed['gd$email'][0]['address'];
                    }
                    if (isset($feed['gd$email'][1])) {
                        $tmp->email2 = $feed['gd$email'][1]['address'];
                    }*/

                    $mailCount = 0;
                    $it = 1;
                    while (1) {
                        if (isset($feed['gd$email'][$mailCount])) {
                            $mailno = 'email' . $it;
                            $tmp->{$mailno} = $feed['gd$email'][$mailCount]['address'];
                            $it++;
                            $mailCount++;
                        } else {
                            break;
                        }

                    }

                    if (!(isset($feed['gd$name']['gd$fullName'])) && !(isset($feed['gd$name']['gd$givenName'])) && !(isset($feed['gd$name']['gd$familyName']))) {
                        if (isset($feed['gd$email'][0])) {
                            $split = explode('@', $feed['gd$email'][0]['address']);
                            $tmp->last_name = $split[0];
                        } else if (isset($feed['gd$email'][1])) {
                            $split = explode('@', $feed['gd$email'][1]['address']);
                            $tmp->last_name = $split[0];
                        }
                    }

                    if (isset($feed['gd$name']['gd$givenName'])) {
                        $tmp->first_name = $feed['gd$name']['gd$givenName']['$t'];
                    }
                    if (isset($feed['gd$name']['gd$familyName'])) {
                        $tmp->last_name = $feed['gd$name']['gd$familyName']['$t'];
                    }
                    if (isset($feed['gd$name']['gd$namePrefix'])) {
                        $tmp->salutation = $feed['gd$name']['gd$namePrefix']['$t'];
                    }
                    if (isset($feed['gd$organization'][0]['gd$orgTitle'])) {
                        $tmp->title = $feed['gd$organization'][0]['gd$orgTitle']['$t'];
                    }
                    //////////////////////////////////////////////////////////////////////////////

                    $tmp->date_modified = $date_modified;
                    //2013-10-29J
                    if (empty($tmp->id)) {
                        $update_feed = true;
                    }
                    if ($tmp->save()) {
                        //2013-10-29J
                        //after contact save update sugar feed entry
                        if ($update_feed === true) {
                            $feed_update_query = "UPDATE sugarfeed SET created_by='" . $tmp->created_by . "' WHERE related_module='Contacts' AND related_id='" . $tmp->id . "' AND deleted='0'";
                            // $GLOBALS['db']->query($feed_update_query);
                        }
                        $ids[] = $tmp->id;
                        $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " saved in SugarCRM.");
                    }
                } elseif ($feed['gContact$groupMembershipInfo'][0]['deleted'] == 'true' || (isset($feed['gd$deleted']))) {
                    //deleted contact in google
                    //START: contact already deleted in both SugarCRM & Google

                    $sql = "SELECT * from " . $tmp->table_name . " WHERE gcontact_id='" . $feed['id']['$t'] . "';";
                    $result = $GLOBALS['db']->query($sql);
                    $row = $GLOBALS['db']->fetchByAssoc($result);
                    if ($row) {
                        if (!empty($row['gcontact_id']) && $row['deleted'] == '1') {
                            $sql_update = "UPDATE " . $tmp->table_name . " SET gcontact_id='' WHERE gcontact_id='" . $row['gcontact_id'] . "';";
                            $GLOBALS['db']->query($sql_update);
                            $ids[] = $row['id'];
                            $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $row['id'] . " is already deleted in both SugarCRM & Google. contact id in SugarCRM is deleted");
                            continue;
                        }
                    }

                    //END: contact already deleted in both SugarCRM & Google
                    if ($tmp->retrieve_by_string_fields(array(
                        'gcontact_id' => $feed['id']['$t']
                    ))
                    ) {
                        $tmp->date_modified = $date_modified;
                        $tmp->deleted = '1';
                        $tmp->gcontact_id = '';

                        if ($tmp->save()) {
                            $ids[] = $tmp->id;
                            $GLOBALS['log']->fatal($tmp->object_name . ": " . $tmp->name . " with id " . $tmp->id . " deleted in SugarCRM.");
                        }
                    }

                } //elseif (deleted contacts)

            } //last sync date check
        } //loop

        return $ids;
    }

    //retrieve updated records from sugar except those ids that are recently got from sugar and updated in sugar

    /**
    * Retrieve updated records from sugar except those that are recently fetched from google and updated in sugar
    *
    * <b>Function breakdown</b>
    * <ol>
        * <li> Fetch sugar contacts added/modified/deleted after the last sync, ignore the ones added by <i>updateFromGoogle()</i> </li>
        * <li> If contact is deleted in sugar, push it in <i>deleted_contacts</i> array </li>
        * <li> Otherwise push it to <i>beans</i> array </li>
        * <li> At the end, call <i>deleteFromGoogle</i> and pass <i> deleted_contacts </i>  </li>
        * <li> Return <i>beans</i> array </li>
    * </ol>
    *
    *
    * @param Google_DriveService $client           Contact API service instance.
    * @param  string             $assigned_user_id ID of current user
    * @param  date               $lastSync         Last time sync was performed
    * @param  array              $ids              List of event IDs saved from google (returning array from above function)
    * @param  string             $user_email       Email address of the user
    * @return array                                beans of events updated after the last sync
    * @access public
    */
    public static function retrieveUpdatedFromSugar($client, $assigned_user_id, $lastSync, $ids = array(), $user_email)
    {

        global $db;
        $sql = "SELECT id,deleted,gcontact_id FROM contacts WHERE assigned_user_id= '" . $assigned_user_id . "' AND date_modified >'" . $lastSync . "' AND id NOT IN ('" . implode("','", $ids) . "')";
        $deleted_contacts = array();
        $res = $db->query($sql);
        $beans = array();
        while ($row = $db->fetchByAssoc($res)) {
            if ($row['deleted'] == '0') {

                //contacts to be sent to google for update
                $bean = new Contact();
                $bean->retrieve($row['id']);
                $beans[] = $bean;
            } else if (!empty($row['gcontact_id'])) {
                //unlink gcontact id for deleted contacts in sugar
                $sql_update = "UPDATE contacts SET gcontact_id='' WHERE gcontact_id='" . $row['gcontact_id'] . "';";
                $db->query($sql_update);
                $deleted_contacts[] = $row['gcontact_id'];
            }
        }
        //delete from google
        self::deleteFromGoogle($client, $deleted_contacts, $user_email);
        return $beans;
    }
    /**
    * Deletes contacts in google
    *
    *
    * @param Google_DriveService $client       Contact API service instance.
    * @param  array              $ids          beans of contacts to be deleted
    * @param  string             $user_email   Email address of the user
    * @access public
    */
    public static function deleteFromGoogle($client, $ids = array(), $user_email)
    {
        if (empty($ids))
            return;

        foreach ($ids as $id) {
            try {

                $client_id = explode("base/", $id);
                $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/" . $user_email . "/full/" . $client_id[1] . "?&v=3.0");
                $add->setRequestMethod("Delete");
                $add->setRequestHeaders(array(
                    'GData-Version' => '3.0',
                    'content-type' => 'application/atom+xml; charset=UTF-8; type=feed',
                    'If-Match' => '*'
                ));

                $submit = $client->getIo()->authenticatedRequest($add);
                $sub_response = $submit->getResponseBody();
                //$gdata->delete($entry->getEditLink()->href);//delete contact in Google
                $GLOBALS['log']->fatal("gcontact_id: " . $id . " deleted in GOOGLE");
            } catch (Exception $ex) {
                //if(strpos($ex->getMessage(), 'not found')===false)
                $GLOBALS['log']->fatal('ERROR:' . $ex->getMessage());
            }
        }
    }
    /**
    * Save sugar's contacts to google
    *
    *
    * @param  array               $beans             beans of contacts added/modified in sugar after the last sync
    * @param  string              $email_id          Email address of the user
    * @param Google_DriveService  $googleClient      Contact API service instance.
    * @access public
    */
    public static function sendUpdatedToGoogle($beans, $email_id, $googleClient)
    {
        global $db;

        foreach ($beans as $bean) {

            try {
                // create new entry
                $doc = new DOMDocument();
                $doc->formatOutput = true;

                $entry = $doc->createElement('atom:entry');

                $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:atom', 'http://www.w3.org/2005/Atom');
                $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:gd', 'http://schemas.google.com/g/2005');
                $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:gd', 'http://schemas.google.com/g/2005');
                $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:openSearch', 'http://a9.com/-/spec/opensearchrss/1.0/');
                $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:gContact', 'http://schemas.google.com/contact/2008');

                $doc->appendChild($entry);
                // add name element
                $name = $doc->createElement('gd:name');
                $entry->appendChild($name);
                //$contact.=" <gd:name>";

                if (!empty($bean->first_name)) {
                    $firstName = $doc->createElement('gd:givenName', $bean->first_name);
                    $name->appendChild($firstName);
                }

                if (!empty($bean->last_name)) {
                    $lastName = $doc->createElement('gd:familyName', $bean->last_name);
                    $name->appendChild($lastName);
                }
                //handling namePrefix
                if (!empty($bean->salutation)) {
                    // add salutation dome value instead of key
                    $namePrefix = $doc->createElement('gd:namePrefix', $GLOBALS['app_list_strings'][$bean->field_defs['salutation']['options']][$bean->salutation]);
                    $name->appendChild($namePrefix);
                    $contact .= "<gd:namePrefix>" . $GLOBALS['app_list_strings'][$bean->field_defs['salutation']['options']][$bean->salutation] . "/<gd:namePrefix>";
                }
                // add Notes element
                $content = $doc->createElement('atom:content', $bean->description);
                $content->setAttribute('type', 'text');
                $entry->appendChild($content);

                // add primary email element
                if (!empty($bean->email1)) {
                    $email = $doc->createElement('gd:email');
                    $email->setAttribute('address', $bean->email1);
                    $email->setAttribute('primary', 'true');
                    $email->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
                    $entry->appendChild($email);
                }
                // add secondary emails
                $number = 2;
                $mailnumber = 'email' . $number;
                while( !empty($bean->{$mailnumber} ) ) {
                    $emailx = $doc->createElement('gd:email');
                    $emailx->setAttribute('address', $bean->{$mailnumber});
                    $emailx->setAttribute('rel', 'http://schemas.google.com/g/2005#home');
                    $entry->appendChild($emailx);
                    $number++;
                    $mailnumber = 'email' . $number;
                }


                // add Phone work element
                if (!empty($bean->phone_work)) {
                    $phone_Number = $doc->createElement('gd:phoneNumber', $bean->phone_work);
                    $phone_Number->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
                    $phone_Number->setAttribute('primary', 'true');
                    $entry->appendChild($phone_Number);
                }

                //add Phone mobile element
                if (!empty($bean->phone_mobile)) {
                    $phone_mobile = $doc->createElement('gd:phoneNumber', $bean->phone_mobile);
                    $phone_mobile->setAttribute('rel', 'http://schemas.google.com/g/2005#mobile');
                    $entry->appendChild($phone_mobile);
                }
                //add work fax element
                if (!empty($bean->phone_fax)) {
                    $phone_fax = $doc->createElement('gd:phoneNumber', $bean->phone_fax);
                    $phone_fax->setAttribute('rel', 'http://schemas.google.com/g/2005#work_fax');
                    $entry->appendChild($phone_fax);
                }

                //add primary address element
                $address = $doc->createElement('gd:structuredPostalAddress');
                $address->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
                $address->setAttribute('primary', 'true');
                $entry->appendChild($address);

                if (!empty($bean->primary_address_street)) {
                    $street = $doc->createElement('gd:street', $bean->primary_address_street);
                    $address->appendChild($street);
                }

                if (!empty($bean->primary_address_city)) {
                    $city = $doc->createElement('gd:city', $bean->primary_address_city);

                    $address->appendChild($city);
                }

                if (!empty($bean->primary_address_state)) {
                    $region = $doc->createElement('gd:region', $bean->primary_address_state);
                    $address->appendChild($region);
                }

                if (!empty($bean->primary_address_postalcode)) {
                    $postcode = $doc->createElement('gd:postcode', $bean->primary_address_postalcode);
                    $address->appendChild($postcode);
                }

                if (!empty($bean->primary_address_country)) {
                    $country = $doc->createElement('gd:country', $bean->primary_address_country);
                    $address->appendChild($country);
                }

                //add alternate address element
                $address = $doc->createElement('gd:structuredPostalAddress');
                $address->setAttribute('rel', 'http://schemas.google.com/g/2005#home');
                $entry->appendChild($address);

                if (!empty($bean->alt_address_street)) {
                    $street = $doc->createElement('gd:street', $bean->alt_address_street);
                    $address->appendChild($street);
                }

                if (!empty($bean->alt_address_city)) {
                    $city = $doc->createElement('gd:city', $bean->alt_address_city);
                    $address->appendChild($city);
                }

                if (!empty($bean->alt_address_state)) {
                    $region = $doc->createElement('gd:region', $bean->alt_address_state);
                    $address->appendChild($region);
                }

                if (!empty($bean->alt_address_postalcode)) {
                    $postcode = $doc->createElement('gd:postcode', $bean->alt_address_postalcode);
                    $address->appendChild($postcode);
                }

                if (!empty($bean->alt_address_country)) {
                    $country = $doc->createElement('gd:country', $bean->alt_address_country);
                    $address->appendChild($country);
                }

                // add organization element
                $org = $doc->createElement('gd:organization');
                $org->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
                $entry->appendChild($org);

                $orgName = $doc->createElement('gd:orgName', $bean->account_name);
                $org->appendChild($orgName);

                $orgTitle = $doc->createElement('gd:orgTitle', $bean->title);
                $org->appendChild($orgTitle);

                // insert entry

                if ($bean->gcontact_id != '') {

                    try {

                        $group = $doc->createElement('gContact:groupMembershipInfo');
                        $group->setAttribute('deleted', 'false');
                        $group->setAttribute('href', 'https://www.google.com/m8/feeds/groups/' . urlencode($email_id) . '/base/6'); //6 only for "My Contacts"
                        $entry->appendChild($group);

                        $len = strlen($doc->saveXML());
                        $client_id = explode("base/", $bean->gcontact_id);
                        $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/" . $email_id . "/full/" . $client_id[1] . "?&v=3.0&alt=json");
                        $add->setRequestMethod("Put");
                        //$add->setPostBody($contact);
                        $add->setPostBody($doc->saveXML());
                        $add->setRequestHeaders(array(
                            'content-length' => $len,
                            'GData-Version' => '3.0',
                            'content-type' => 'application/atom+xml; charset=UTF-8; type=feed',
                            'If-Match' => '*'
                        ));

                        $submit = $googleClient->getIo()->authenticatedRequest($add);
                        $sub_response = $submit->getResponseBody();
                        $sub_response_prev = $sub_response;
                        $sub_response = json_decode($sub_response, 1);
                        if (!(isset($sub_response['entry']['id']['$t']))) {
                            $GLOBALS['log']->fatal("response: " . print_r($sub_response, 1));
                            $GLOBALS['log']->fatal(print_r($sub_response_prev, 1));
                        }
                        $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->name . " with id " . $bean->id . " updated in Google.");
                    } catch (Exception $e) {

                        if ($e->getCode() == 404 || $e->getCode() == 403) { // not found or forbidden

                            $GLOBALS['log']->fatal('Creating as a new entry...');
                            $bean->gcontact_id = '';

                        } else {
                            $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                            //deleted from google or id changed in user settings but exist in sugar , delete it and unlink
                            $sql = "UPDATE contacts SET gcontact_id='' WHERE id='" . $bean->id . "';";
                            $db->query($sql);
                        }
                    }
                } else {
                    /*adding group membership info*/
                    // add group element
                    $group = $doc->createElement('gContact:groupMembershipInfo');
                    $group->setAttribute('deleted', 'false');
                    $group->setAttribute('href', 'https://www.google.com/m8/feeds/groups/' . urlencode($email_id) . '/base/6'); //6 only for "My Contacts"
                    $entry->appendChild($group);

                    $len = strlen($doc->saveXML());
                    $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/" . $email_id . "/full?&v=3.0&alt=json");
                    $add->setRequestMethod("Post");
                    $add->setPostBody($doc->saveXML());
                    $add->setRequestHeaders(array(
                        'content-length' => $len,
                        'GData-Version' => '3.0',
                        'content-type' => 'application/atom+xml; charset=UTF-8; type=feed'
                    ));

                    $submit = $googleClient->getIo()->authenticatedRequest($add);
                    $sub_response = $submit->getResponseBody();
                    $sub_response_prev = $sub_response;
                    $sub_response = json_decode($sub_response, 1);
                    if (!(isset($sub_response['entry']['id']['$t']))) {
                        $GLOBALS['log']->fatal("response: " . print_r($sub_response, 1));
                        $GLOBALS['log']->fatal(print_r($sub_response_prev, 1));
                    }
                    $sql = "UPDATE contacts SET gcontact_id='" . $sub_response['entry']['id']['$t'] . "' WHERE id='" . $bean->id . "';";

                    $db->query($sql);
                    $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->name . " with id " . $bean->id . " saved in Google.");
                }

            } catch (Exception $e) {
                $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
            }
        }
    }
    /**
    * Converts Google API contact feed from object to array 
    *
    *
    * @param  object $feed         An instance of contacts from Google contacts API
    * @return array                Google contact in the form of associative array
    * @access public
    */
    public static function toArray($feed)
    {
        $entry = array(
            'deleted' => '0',
            'salutation' => ''
        );
        $ext_elements = $feed->getExtensionElements();

        foreach ($ext_elements as $ext_element) {
            $ext_attributes = $ext_element->getExtensionAttributes();
            if (isset($ext_attributes['deleted']))
                $entry['deleted'] = $ext_attributes['deleted']['value'];
        }
        $feed_converted = array();
        $feed_converted = $feed->toArray();
        //handling group changing info and deleted bit
        if ($entry['deleted'] == 'true' || $entry['deleted'] == '0') {
            if (!empty($feed_converted['full_name']) || (!empty($feed_converted['email1']) || !empty($feed_converted['email2'])) || (!empty($feed_converted['phone_main']) || !empty($feed_converted['phone_mobile']) || !empty($feed_converted['phone_work']) || !empty($feed_converted['phone_home']))) {
                $entry['deleted'] = 'false';
            } else {
                $entry['deleted'] = 'true';
            }
        }
        //handling namePrefix
        $names_temp = array();
        $names_temp = $feed->{'names'};
        if (!empty($names_temp)) {
            $name_extensions = $names_temp->getExtensionElements();

            foreach ($name_extensions as $extension) {

                if ($extension->rootElement == 'namePrefix') {
                    $entry['salutation'] = $extension->getText();
                }
            }
        }

        $entry = array_merge($feed_converted, $entry);

        return $entry;


    }
    /**
    * Finds record ID against a module and email ID 
    *
    *
    * <b>Function breakdown</b>
    * <ol>
        * <li> Take a union of emailAddresses and email_addr_bean_rel on <i>$email_id</i> and fetch id of record in <i>$module</i></li>
        * <li> Return id after verifying the record with that id exists in <i>$module</i></li>
        * <li> Return empty string if verification fails</li>
    * </ol>
    * @param  string  $module       module name
    * @param  string  $email_id     email id
    * @return string                record id in the module against email
    * @access public
    */
    public static function findByEmail($module, $email_id)
    {
        /*$module_table_name=strtolower($module);
        $sql="SELECT DISTINCT $module_table_name.id from $module_table_name where $module_table_name.id IN ( SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea	ON eabr.email_address_id = ea.id WHERE eabr.bean_module = '$module' AND ea.email_address_caps = '".strtoupper($email_id)."' AND ea.deleted='0' AND eabr.deleted='0') AND $module_table_name.deleted='0'" ;

        $result=$GLOBALS['db']->query($sql);
        $row = $GLOBALS['db']->fetchByAssoc($result);
        if(!empty($row))
        return $row['id'];
        else
        return '';*/
        $q = new SugarQuery();
        $q->from(BeanFactory::getBean('EmailAddresses'), array(
            'team_security' => false
        ));
        $q->joinTable('email_addr_bean_rel')->on()->equalsField('email_addresses.id', 'email_addr_bean_rel.email_address_id');
        $q->where()->equals('email_addr_bean_rel.bean_module', $module)->equals('email_addresses.email_address_caps', strtoupper($email_id))->equals('email_addr_bean_rel.deleted', 0);
        $q->select(array(
            'email_addr_bean_rel.bean_id'
        ));
        $results = $q->execute();
        $beanids = array();
        foreach ($results as $result) {
            $beanids[] = $result['bean_id'];
        }
        if (count($beanids) > 0) {
            $q = new SugarQuery();
            $q->from(BeanFactory::getBean($module), array(
                'team_security' => false
            ));
            $module_table_name = strtolower($module);
            $q->where()->in($module_table_name . '.id', $beanids);
            $q->select(array(
                $module_table_name . '.id'
            ));
            $q->distinct(true);
            $results = $q->execute();
            if (count($results > 1)) {
                return $results[0]['id'];
            } else
                return '';
        } else
            return '';

    }

}

//bug http://framework.zend.com/issues/browse/ZF-10194
// overriding class to use only for delete contacts
/**
* Overriding class to use only for delete contacts
*
* @link http://zendframework.com/issues/browse/ZF-10194
*
*
*/
class ZendGdataContacts extends Zend_Gdata
{
    /**
     * Overridden to fix an issue with the HTTP request/response for deleting.
     * @link http://zendframework.com/issues/browse/ZF-10194
     *
     * @param       $method
     * @param null $url
     * @param array $headers
     * @param null $data
     * @param null $contentTypeOverride
     *
     * @return array
     */
    public function prepareRequest($method, $url = null, $headers = array(), $data = null, $contentTypeOverride = null)
    {
        $request = parent::prepareRequest($method, $url, $headers, $data, $contentTypeOverride);

        if ($request['method'] == 'DELETE') {
            // Default to any
            $request['headers']['If-Match'] = '*';

            if ($data instanceof Zend_Gdata_App_MediaSource) {
                $rawData = $data->encode();
                if (isset($rawData->etag) && $rawData->etag != '') {
                    // Set specific match
                    $request['headers']['If-Match'] = $rawData->etag;
                }
            }
        }

        return $request;
    }
}


?>