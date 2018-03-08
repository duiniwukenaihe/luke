<?php

// RT DocuSign Plugin
// DocuSign Notifications.
// Copyright Rolustech (Sep 2015)


    require_once 'modules/RT_DocuSign/actions/RT_PostActivity_Status.php';
    require_once 'custom/modules/RT_DocuSign/DocuSign_Envelope.php';
    require_once 'modules/RT_DocuSign/actions/RT_SaveSugarDocument.php';
    require_once 'modules/RT_DocuSign/actions/RT_Update_Relationship_Status.php';
    require_once('include/utils.php');



    $file = new UploadFile();
    $file->temp_file_location = 'php://input';
    $cntnts = $file->get_file_contents();
// getting Envelope from XML contents.
    $envelopeid = value_in('EnvelopeID', $cntnts, true);


// getting sending user id from envelope.
    global $db;
    $query = "SELECT sendinguserid FROM dp_doucumentspackets WHERE docusignenvelopeid='" . $envelopeid . "'";
    $result = $db->query($query);
    $send_user_id = "";

    while ($row = $result->fetch_assoc()) { // we are checking if document with this name already exists.
        $send_user_id = $row['sendinguserid'];
    }

// creating object to post status.

    $user_id = $send_user_id;

    $post_status = new RT_PostActivity_Status();

    $bean = new DP_DoucumentsPackets();
    $bean->retrieve_by_string_fields(array(
        'docusignenvelopeid' => $envelopeid
    ));

    $env_rec_id = $bean->id;
    $parent_module = $bean->parent_type;
    $parent_rec_id = $bean->parent_id;


// object to handle functionality of contacts and documens in relationship table.
    $relationship_status = new RT_Update_Relationship_Status();

    if (!((empty($envelopeid)) )) {
        // this case will occurred if signed by any of recipients or delivered to any of recipient.
        //pulling information from envelope
        $ds_envelope = new DocuSign_Envelope();

        $envelope_object = $ds_envelope->getEnvelopeObject($send_user_id);

        $envelope = $ds_envelope->getEnvelope($envelope_object, $envelopeid);

        $envelopestatus = $envelope->status;

        $documents_contents = $ds_envelope->getDocumentsContents($envelope_object, $envelopeid);

        $envelopes_documents = $ds_envelope->getDocumentsNames($envelope_object, $envelopeid);

        $receipents = $ds_envelope->getRecipents($envelope_object, $envelopeid);

        foreach ($receipents as $val) {
                        if (strtolower($val['status']) == strtolower('Completed')) {
                $GLOBALS['log']->fatal('_____________status = completed_______ ');
                if (!find_in_completed_recipents($envelopeid, $val['index'])) {
                    $GLOBALS['log']->fatal('in if condition');
                    // Post Status in Activity Stream.
                    $cntct_id = find_receipents_contact($env_rec_id, $val['name'], $val['email']);
                    //$msg      = createMessages($env_rec_id, $cntct_id, "CompletedByReceipent");
                    // $post_status->PostStatus($user_id, $parent_module, $parent_rec_id, $msg);
                    if (method_exists($relationship_status, 'updateDocumentsStatuses')) {
                        $GLOBALS['log']->fatal('updateDocumentsStatuses method exists ');
                    }
                    $GLOBALS['log']->fatal('between if conditions ');

                    if (method_exists($relationship_status, 'updateReceipentStatus')) {
                        $GLOBALS['log']->fatal('updateReceipentStatus method exists ');
                    }
                    // update statuses of documents in relationship table
                    $doc_status_msg = translate('LBL_RT_DOCUSGIN_DOCUMENT_SIGNED_BY', 'RT_DocuSign') . $val['name'];
                    $relationship_status->updateDocumentsStatuses($env_rec_id, $doc_status_msg);
                    $GLOBALS['log']->fatal('after if conditions ');
                    // update status of contacts in relationship table
                    $receipnt_status_msg = translate('LBL_RT_DOCUSGIN_STATUS_COMPLETED', 'RT_DocuSign');
                    $relationship_status->updateReceipentStatus($env_rec_id, $receipnt_status_msg, $val['email'],$val['date_modified']);

                    // creating Revision
                    $change_log = translate('LBL_RT_DOCUSGIN_DOCUMENT_SIGNED_BY', 'RT_DocuSign') . $val['name'];
                    $updated_name = translate('LBL_RT_DOCUSGIN_DOCUSIGNED', 'RT_DocuSign') . "(" . $val['name'] . ")";
                    createPacketPDFRevision($envelopeid, $env_rec_id, $change_log, $updated_name, $documents_contents, $val['status']);

                    // if completed by all recipients.
                    if (strtolower($envelopestatus) == strtolower('Completed')) {
                        // update status in db.
                        $GLOBALS['log']->fatal('_____________completed by all recipients_______ ');

                        $bean = new DP_DoucumentsPackets();
                        $bean->retrieve_by_string_fields(array(
                            'docusignenvelopeid' => $envelopeid
                        ));

                        if (($bean->packetstatus == "Delivered") || ($bean->packetstatus == "Send")) {
                            $bean->packetstatus = "Completed";
                            $bean->save();

                            // calling function to take final revision of document.
                            $change_log = translate('LBL_RT_DOCUSGIN_SIGNED_BY_ALL_CHNG_LOG', 'RT_DocuSign');
                            $updated_name = translate('LBL_RT_DOCUSGIN_FINAL_DOCUSIGNED', 'RT_DocuSign');
                            createPacketPDFRevision($envelopeid, $env_rec_id, $change_log, $updated_name, $documents_contents, $val['status']);

                            // creating final revision of each document
                            createAttachedDocumentsRevisions($envelopeid, $env_rec_id, $change_log, $updated_name, $envelopes_documents, $ds_envelope, $envelope_obj, $val['status']);

                            // post status completed by all recipients
                            $msg = createMessages($env_rec_id, "", "Completed");
                            $post_status->PostStatus($user_id, $parent_module, $parent_rec_id, $msg);

                            // update statuses of documents in relationship table
                            $doc_status_msg = translate('LBL_RT_DOCUSGIN_STATUS_COMPLETED', 'RT_DocuSign');
                            $relationship_status->updateDocumentsStatuses($env_rec_id, $doc_status_msg);
                        }
                    }
                }
            } else if (strtolower($val['status']) == strtolower('Delivered')) {

                if (!find_in_delivered_recipents($envelopeid, $val['index'])) {

                    $cntct_id = find_receipents_contact($env_rec_id, $val['name'], $val['email']);
                    //$msg      = createMessages($env_rec_id, $cntct_id, "DeliveredToReceipent");
                    //$post_status->PostStatus($user_id, $parent_module, $parent_rec_id, $msg);
                    // update statuses of documents in relationship table
                    $doc_status_msg = translate('LBL_RT_DOCUSGIN_DELIVERED_TO', 'RT_DocuSign') . $val['name'];
                    $relationship_status->updateDocumentsStatuses($env_rec_id, $doc_status_msg);

                    // update status of document in relationship table
                    $receipnt_status_msg = translate('LBL_RT_DOCUSGIN_DELIVERED', 'RT_DocuSign');
                    $relationship_status->updateReceipentStatus($env_rec_id, $receipnt_status_msg, $val['email'],$val['date_modified']);


                    // if delivered to all recipients
                    if (strtolower($envelopestatus) == strtolower('Delivered')) {

                        // update Document Packet Status in DB.
                        $bean = new DP_DoucumentsPackets();
                        $bean->retrieve_by_string_fields(array(
                            'docusignenvelopeid' => $envelopeid
                        ));
                        if ($bean->packetstatus == "Send") {
                            $bean->packetstatus = "Delivered";
                            $bean->save();

                            // update statuses of documents in relationship table
                            $doc_status_msg = translate('LBL_RT_DOCUSGIN_DELIVERED_TO_ALL', 'RT_DocuSign');
                            $relationship_status->updateDocumentsStatuses($env_rec_id, $doc_status_msg);

                            // post status delivered to all recipients
                            $msg = createMessages($env_rec_id, "", "Delivered");
                            $post_status->PostStatus($user_id, $parent_module, $parent_rec_id, $msg);
                        }
                    }
                }
            }
        }

        if ((strtolower($envelopestatus) == strtolower('Voided')) || (strtolower($envelopestatus) == strtolower('Declined'))) {
            // update status in DB.

            $bean = new DP_DoucumentsPackets();
            $bean->retrieve_by_string_fields(array(
                'docusignenvelopeid' => $envelopeid
            ));
            $parent_module = $bean->parent_type;
            if (($bean->packetstatus == "Delivered") || ($bean->packetstatus == "Created") || ($bean->packetstatus == "Completed") || ($bean->packetstatus == "Send")) {

                $bean->packetstatus = "Voided";
                $bean->save();

                // Posting Voided Status in Activity Stream
                $msg = createMessages($env_rec_id, "", "Voided");

                $post_status->PostStatus($user_id, $parent_module, $parent_rec_id, $msg);

                // update statuses of documents in relationship table
                $doc_status_msg = 'Voided';
                $relationship_status->updateDocumentsStatuses($env_rec_id, $doc_status_msg);

                // update status of document in relationship table
                $receipnt_status_msg = 'Voided';
                $relationship_status->updateReceipentStatus($env_rec_id, $receipnt_status_msg, $val['email'],$val['date_modified']);
            }
        }
    }

// this function will find the given recipients in the list of recipient who has completed signature.
    function find_in_completed_recipents($envelopeid, $index)
    {
        $bean = new DP_DoucumentsPackets();
        $bean->retrieve_by_string_fields(array(
            'docusignenvelopeid' => $envelopeid
        ));
        // getting the indexes of all the recipients of this envelope who has completed signature.
        if (isset($bean->completedcontacts)) { // if list is not empty
            $completed_list = explode('|', $bean->completedcontacts); // split list on basis of '|'
            foreach ($completed_list as &$completed_index) { // find if index is already in list
                if (trim($index) == trim($completed_index)) {
                    return true; // if the given index already in the list.
                }
            }
            // if index not already in list. we will add in list and return false.
            $bean->completedcontacts = $bean->completedcontacts . "|" . $index;
            $bean->save();
            return false;
        } else {
            // if there is not any index already in list. we will add in list and return false.
            $bean->completedcontacts = $index . "";
            $bean->save();
            return false;
        }
    }

//function to find the given recipients in the list of recipient to whom envelope is delivered
    function find_in_delivered_recipents($envelopeid, $index)
    {

        $bean = new DP_DoucumentsPackets();
        $bean->retrieve_by_string_fields(array(
            'docusignenvelopeid' => $envelopeid
        ));

        // getting the indexes of all the recipients of this envelope to whom envelope id delivered.
        if (isset($bean->deliveredcontacts)) { // if list is not empty
            $delivered_list = explode('|', $bean->deliveredcontacts); // split list on basis of '|'
            foreach ($delivered_list as &$delivered_index) { // find if index is already in list
                if (trim($index) == trim($delivered_index)) {
                    return true; // if the given index already in the list.
                }
            }
            // if index not already in list. we will add in list and return false.
            $bean->deliveredcontacts = $bean->deliveredcontacts . "|" . $index;
            $bean->save();
            return false;
        } else { // if there is no element in the list.
            $bean->deliveredcontacts = $index . "";
            $bean->save();
            return false;
        }
    }

// function to create message to post status in Activity Stream.
    function createMessages($env_rec_id, $contacts_ids, $msg_code)
    {
        $document_packet_bean = BeanFactory::getBean("DP_DoucumentsPackets", $env_rec_id);
        $status_data = "";
        if ($contacts_ids != "") {
            $temp = explode('|', $contacts_ids);
            $contacts_ids = $temp[0];
            $contact_name = $temp[1];
        }
        if ($msg_code == "Completed") { // Activity Stream message if All receipts have signed Envelope
            $document_link = '{"value":"@[DP_DoucumentsPackets:' . $document_packet_bean->id . ':' . $document_packet_bean->name . '] ' . translate('LBL_RT_DOCUSGIN_SIGNED_BY_ALL_MSG', 'RT_DocuSign') . '",';
            $tags = '"tags":[],';
            $embds = '"embeds":[]}';
            $status_data = $document_link . $tags . $embds;
        } else if ($msg_code == "Delivered") { // Activity Stream message if Envelope is delivered to All receipts
            $document_link = '{"value":"@[DP_DoucumentsPackets:' . $document_packet_bean->id . ':' . $document_packet_bean->name . '] ' . translate('LBL_RT_DOCUSGIN_DELIVERED_TO_ALL_MSG', 'RT_DocuSign') . '",';
            $tags = '"tags":[],';
            $embds = '"embeds":[]}';
            $status_data = $document_link . $tags . $embds;
        } else if ($msg_code == "Voided") { // Activity Stream message if Envelope is delivered to All receipts
            $document_link = '{"value":"@[DP_DoucumentsPackets:' . $document_packet_bean->id . ':' . $document_packet_bean->name . '] ' . translate('LBL_RT_DOCUSGIN_VOIDED_MSG', 'RT_DocuSign') . '",';
            $tags = '"tags":[],';
            $embds = '"embeds":[]}';
            $status_data = $document_link . $tags . $embds;
        } else if ($msg_code == "DeliveredToReceipent") { // message when envelope is delivered to specific receipt
            $document_link = '{"value":"@[DP_DoucumentsPackets:' . $document_packet_bean->id . ':' . $document_packet_bean->name . '] ' . translate('LBL_RT_DOCUSGIN_DELIVERED_TO_MSG', 'RT_DocuSign');
            $tags = '"tags":[{"id":"' . $document_packet_bean->id . '","name":"' . $document_packet_bean->name . '","module":"DP_DoucumentsPackets"}';
            $embds = '"embeds":[]}';
            $objct = ',"object":{"name":"' . $document_packet_bean->name . '","type":"DP_DoucumentsPackets","module":"DP_DoucumentsPackets","id":"' . $document_packet_bean->id . '"}}';
            $contacts_link = '';

            // Adding contact to Status.
            $cntct_link = '@[Contacts:' . $contacts_ids . ':' . $contact_name . '] ';
            $contacts_link = $contacts_link . $cntct_link;
            $tag = ',{"id":"' . $contacts_ids . '","name":"' . $contact_name . '","module":"Contacts"}';
            $tags = $tags . $tag;

            $contacts_link = $contacts_link . ' ",';
            $tags = $tags . '],';
            $status_data = $document_link . $contacts_link . $tags . $embds;
        } else if ($msg_code == "CompletedByReceipent") { // message when envelope is completed by specific receipt
            $document_link = '{"value":"@[DP_DoucumentsPackets:' . $document_packet_bean->id . ':' . $document_packet_bean->name . '] ' . translate('LBL_RT_DOCUSGIN_SIGNED_BY_ALL_MSG', 'RT_DocuSign');
            $tags = '"tags":[{"id":"' . $document_packet_bean->id . '","name":"' . $document_packet_bean->name . '","module":"DP_DoucumentsPackets"}';
            $embds = '"embeds":[]}';
            $objct = ',"object":{"name":"' . $document_packet_bean->name . '","type":"DP_DoucumentsPackets","module":"DP_DoucumentsPackets","id":"' . $document_packet_bean->id . '"}}';
            $contacts_link = '';

            // Adding contact to status.
            $cntct_link = '@[Contacts:' . $contacts_ids . ':' . $contact_name . '] ';
            $contacts_link = $contacts_link . $cntct_link;
            $tag = ',{"id":"' . $contacts_ids . '","name":"' . $contact_name . '","module":"Contacts"}';
            $tags = $tags . $tag;

            $contacts_link = $contacts_link . ' ",';
            $tags = $tags . '],';
            $status_data = $document_link . $contacts_link . $tags . $embds;
        }
        return $status_data;
    }

// function to create revision of document
    function createPacketPDFRevision($envelopeid, $env_rec_id, $change_log, $updated_name, $documents_contents, $status)
    {
        // To Take final revision getting information from envelope
        /* $ds_envelope        = new DocuSign_Envelope();
          $envelope_object    = $ds_envelope->getEnvelopeObject();
          $documents_contents = $ds_envelope->getDocumentsContents($envelope_object, $envelopeid); */

        $document_packet_bean = BeanFactory::getBean("DP_DoucumentsPackets", $env_rec_id);
        $doc_id = $document_packet_bean->document_id_c;
        $doc_upload = new RT_SaveSugarDocument();
        $document_bean = BeanFactory::retrieveBean('Documents', $doc_id, array('disable_row_level_security' => true));
        $doc_id = $doc_upload->updateDocumentRevision($doc_id, $document_bean->document_name, $documents_contents, $change_log, "Sugar", $status,$env_rec_id);
    }

// this function will take the revision of each SugarCRM Document attached with documents Packet
    function createAttachedDocumentsRevisions($envelopeid, $env_rec_id, $change_log, $updated_name, $envelopes_documents, $ds_envelope, $envelope_obj, $status)
    {
        foreach ($envelopes_documents as &$env_doc) {
            $documents_contents = $ds_envelope->getSaperatedDocumentContents($envelope_obj, $envelopeid, $env_doc['id']);
            $document_info = find_receipents_documents($env_rec_id, $env_doc['name'], $env_doc['id']);

            $doc_upload = new RT_SaveSugarDocument();
            $doc_id = $doc_upload->updateDocumentRevision($document_info['id'], $updated_name . '-' . $document_info['name'], $documents_contents, $change_log, "Sugar", $status, $env_rec_id);
        }
    }

// this function will return Sugar CRM ID of given document.
    function find_receipents_documents($env_rec_id, $document_name, $doc_index_id)
    {
        global $db;
        $query = "SELECT dp_doucumentspackets_documentsdocuments_idb AS 'did' FROM dp_doucumentspackets_documents_c WHERE deleted='0' AND dp_doucumentspackets_documentsdp_doucumentspackets_ida='" . $env_rec_id . "'";
        $result = $db->query($query);
        $document_id = array();
        while ($row = $result->fetch_assoc()) { // we are checking if document with this name already exists.
            $doc_id = $row['did'];
            $document_bean = BeanFactory::retrieveBean('Documents', $doc_id, array('disable_row_level_security' => true));
            $docname = str_replace(".pdf", "", trim($document_bean->document_name));
            // As we have appended .pdf to the name of external documents therefore we are comparing names without .pdf
            if (strtolower($docname) == strtolower(str_replace(".pdf", "", $document_name))) {
                $document_id['id'] = $doc_id;
                $document_id['name'] = $document_name;
            }
        }
        return $document_id;
    }

// function to find the Sugar CRM Contact of recipient
    function find_receipents_contact($env_rec_id, $receipts_name, $receipt_email)
    {
        global $db;
        $query = "select dp_doucumentspackets_contactscontacts_idb as 'cid' from dp_doucumentspackets_contacts_c where deleted='0' and dp_doucumentspackets_contactsdp_doucumentspackets_ida='" . $env_rec_id . "'";
        $result = $db->query($query);
        $contact_id;
        while ($row = $result->fetch_assoc()) { // we are checking if document with this name already exists.
            $cid = $row['cid'];
            $query2 = "select  TRIM(CONCAT(COALESCE(salutation,''),' ',COALESCE(first_name,''),' ',COALESCE(last_name,''))) as 'contact_name' from  contacts where id='" . $cid . "'";
            $result2 = $db->query($query2);
            $cname2 = "";
            while ($row2 = $result2->fetch_assoc()) {
                $cname2 = $row2['contact_name'];
            }
            if ((strtolower(trim($cname2)) == strtolower(trim($receipts_name)))) {
                $contact_id = $cid . "|" . $cname2;
            }
        }
        return $contact_id;
    }

    function value_in($element_name, $xml, $content_only = true)
    {
        if ($xml == false) {
            return false;
        }
        $found = preg_match('#<' . $element_name . '(?:\s+[^>]+)?>(.*?)' .
                '</' . $element_name . '>#s', $xml, $matches);
        if ($found != false) {
            if ($content_only) {
                return $matches[1];  //ignore the enclosing tags
            } else {
                return $matches[0];  //return the full pattern match
            }
        }
        // No match found: return false.
        return false;
    }
    