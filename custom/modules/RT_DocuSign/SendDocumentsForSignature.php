<?php

    /**
     * SendDocumentsForSignature (Send documents for signature to DocuSign)
     * Copyright (c) 2015 Rolustech
     * All rights reserved.
     * V 1.0
     */
    if (!defined('sugarEntry') || !sugarEntry)
        die('Not A Valid Entry Point');


    require_once 'custom/modules/RT_DocuSign/Configurations.php';
    require_once 'custom/modules/RT_DocuSign/lib/src/DocuSign_Client.php';
    require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_RequestSignatureService.php';
    require_once 'custom/modules/RT_DocuSign/DocuSign_Views.php';
    require_once 'include/upload_file.php';

    /**
     * SendDocumentsForSignature (Send documents for signature to DocuSign)
     * Class to Create DocuSign Envelope from Attached document and Contacts and Open DocuSign Sender Views url.
     */
    class sendDocumentsForSignature {

        public $sugarRootUrl;
        public $returnURL;
        public $doucments = array();
        public $contacts = array();
        public $attachments_ids = array();
        public $contacts_ids = array();
        public $notificationsURL;
        public $signed_attachment_type;
        public $signed_attachment_name;
        public $template_id;
        public $documents_type;
        public $template_roles = array();

        /**
         * sendForSignature (Send documents for signature to DocuSign)
         * function to fetch all the attached document and contact, create Envelope and open docuSign Sender View by attaching this envelope.
         * @return array containing DocuSign Sender View URL
         */
        function sendForSignature()
        {
            $client = $this->getDocuSignClient();
            $signature_service = new DocuSign_RequestSignatureService($client);
            $recipients = $this->getRecipents();
            $documents = $this->getDocument();
            $return_url = $this->returnURL;
            $return_url = htmlspecialchars_decode($return_url);


            $notification_url = $this->notificationsURL;

            $status = array(
                'delivered',
                'completed',
                'declined',
                'voided'
            );
            try {

                $docusign_event_notifications = new DocuSign_EventNotification($notification_url, false, false, false, NULL, false, NULL, false, false, false, $status, NULL);
                $user = BeanFactory::getBean('Users', $_SESSION["user_id"]);
                $email_subject = $user->name . ' Document for Signature';
                $emailBlurb = $user->personalized_message_c;
                if ($this->documents_type == 'DocuSign Templates') {
                    $signature_response = $signature_service->signature->createEnvelopeFromTemplate($email_subject, $emailBlurb, $this->template_id, 'created', $this->template_roles, $docusign_event_notifications, false);
                } else {
                    $signature_response = $signature_service->signature->createEnvelopeFromDocument($email_subject, $emailBlurb, 'created', $documents, $recipients, $docusign_event_notifications, false);
                }
                $docusign_view = new DocuSign_views($client);

                // modifications for document packet
                $docusign_packet = BeanFactory::getBean('DP_DoucumentsPackets');
                $docusign_packet->packetstatus = 'Created';
                $docusign_packet->sendinguserid = $_SESSION["user_id"];
                $docusign_packet->name = 'DocuSign Document Packet-Temp';
                $docusign_packet->assigned_user_id = $_SESSION['user_id'];
                $docusign_packet->signed_attachment_type = $this->signed_attachment_type;
                $docusign_packet->signed_attachment_name = $this->signed_attachment_name;
                $packetID = $docusign_packet->save();

                // Adding relationship of documents packet with documents
                foreach ($this->attachments_ids as $attachment_id) {
                    // getting document ID from Document Revision ID To Add in Relationship
                    $doc = BeanFactory::getBean('Documents');
                    $doc->retrieve_by_string_fields(array('document_revision_id' => $attachment_id));
                    $docid = $doc->id;

                    // adding Relationship between Document Packets and Documents
                    global $db;
                    $query = "INSERT INTO dp_doucumentspackets_attachments VALUES ('" . create_guid() . "', SYSDATE(), '0','" . $packetID . "','" . $attachment_id . "','Sent for Signature')";
                    if ($db->query($query) === TRUE) {
                        $GLOBALS['log']->debug("relationship added");
                    } else {
                        $GLOBALS['log']->debug("relationship with document not added");
                    }
                }

                // Adding Relationship of Documents Packets with contacts
                foreach ($this->contacts_ids as &$cntcts) {
                    // As Leads Module by default fetch email from Accounts module. So we are using Name and Email of Leads and create Contact in Sugar CRM.
                    $bean = BeanFactory::retrieveBean('Contacts', $cntcts['id']); // checking if contact with this ID exists.
                    if (is_null($bean)) {
                        $module = BeanFactory::getBean('Contacts');
                        $module->last_name = trim($cntcts['name']);
                        $module->email1 = trim($cntcts['email']);
                        $saveid = $module->save();
                        $cntcts['id'] = $saveid;
                    }

                    $document_packet = BeanFactory::getBean('DP_DoucumentsPackets', $packetID);
                    $document_packet->load_relationship('dp_doucumentspackets_contacts');
                    $document_packet->dp_doucumentspackets_contacts->add($cntcts['id']);
                    $document_packet->save();
                }

                // Adding the ID of this newly created record with return URL for future processing.
                $return_url = $return_url . "&envelope_rec_id=$packetID";
                $sender_view_url = $docusign_view->getSenderView($return_url, $signature_response->envelopeId, false);

                return $sender_view_url;
            } catch (Exception $e) {
                echo json_encode(array(
                    'error' => $e->getMessage()
                ));
                return;
            }
        }

        /**
         * getDocuSignClient
         * return the client of DocuSign Api using saved configurations.
         * @return $client object
         */
        function getDocuSignClient()
        {
            $config = new Configurations();
            $creds = $config->getCredientials();
            $client = new DocuSign_Client($creds);
            if ($client->hasError()) {
                echo json_encode(array(
                    'error' => $client->errorMessage
                ));
                return;
            }
            return $client;
        }

        /**
         * getRecipents
         * function to create array of 'DocuSign_Recipient' from array of recipient that are sent with contacts.
         * @return array of DocuSign_Recipient
         */
        function getRecipents()
        {
            $recipients = array();
            $count = 1;
            foreach ($this->contacts as $cntct) {
                $this->contacts_ids[] = array('id' => $cntct['id'], 'name' => $cntct['name'], 'email' => $cntct['email']);
                $recipients[] = new DocuSign_Recipient(1, $count, $cntct['name'], $cntct['email'], $cntct['initial']);
                $this->template_roles[] = new DocuSign_TemplateRole($cntct['initial'], $cntct['name'], $cntct['email']);

                $count++;
            }
            return $recipients;
        }

        /**
         * getDocument
         * function to create array of 'DocuSign_Document' from array of documents that received with request.
         * @return array of DocuSign_Document.
         */
        function getDocument()
        {
            $Documents = array();
            $count = 1;
            foreach ($this->doucments as $docs) {
                $content = $this->getDocumentContents($docs);
                $Documents[] = new DocuSign_Document($docs['name'], $count, $content);
                $count++;
            }
            return $Documents;
        }

        /**
         * getDocumentContents
         * function function to return contents of document array that is passed as parameter.
         * @param array  An array containing information about documents e.g. it name and revisionID
         * @return string return contents of object
         */
        function getDocumentContents($document)
        {
            $contents = "";
            if (isset($document['revisionId'])) {
                $this->attachments_ids[] = $document['revisionId'];
                $f = new UploadFile();
                $f->temp_file_location = 'upload/' . $document['revisionId'];
                $contents = $f->get_file_contents();
            } else {
                $content = base64_decode($document['content']);
            }
            return $contents;
        }

    }
    