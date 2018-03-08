<?php

    if (!defined('sugarEntry') || !sugarEntry)
        die('Not A Valid Entry Point');

    /**
     * Copyright (c) 2015 Rolustech
     * All rights reserved.
     * */
    require_once 'include/api/SugarApi.php';
    require_once 'custom/modules/RT_DocuSign/SendDocumentsForSignature.php';

    class RT_DocuSign_Api extends SugarApi {

        public function registerApiRest()
        {
            return array(
                'SendForSignature' => array(
                    'reqType' => 'GET',
                    'path' => array('RT_DocuSign', 'sendforsign'),
                    'pathVars' => array('', '', 'data'),
                    'method' => 'SendForSignature',
                    'shortHelp' => 'Some help text'
                ),
                'docuSignTemplates' => array(
                    'reqType' => 'GET',
                    'path' => array('RT_DocuSign', 'docuSignTemplates'),
                    'pathVars' => array('', '', 'data'),
                    'method' => 'docuSignTemplates',
                    'shortHelp' => 'Some help text'
                ),
                'docuSignTemplate' => array(
                    'reqType' => 'GET',
                    'path' => array('RT_DocuSign', 'docuSignTemplate'),
                    'pathVars' => array('', '', 'data'),
                    'method' => 'docuSignTemplate',
                    'shortHelp' => 'Some help text'
                )
            );
        }

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

        public function docuSignTemplates($api, $args)
        {
            $client = $this->getDocuSignClient();
            require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_RequestSignatureService.php';
            $signature_service = new DocuSign_RequestSignatureService($client);
            $templates = $signature_service->signature->getDocuSignTemplates();
            $saved_templates = array();
            foreach ($templates->envelopeTemplates as $template) {
                $saved_templates[] = array(
                    'id' => $template->templateId,
                    'name' => $template->name,
                );
            }

            return $saved_templates;
        }

        public function docuSignTemplate($api, $args)
        {
            $client = $this->getDocuSignClient();
            $roles = array();
            $name = "";
            if (!empty($args['template_id'])) {
                require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_RequestSignatureService.php';
                $signature_service = new DocuSign_RequestSignatureService($client);
                $template_date = $signature_service->signature->getDocuSignTemplate($args['template_id']);
                foreach ($template_date->recipients->signers as $template) {
                    $roles[] = $template->roleName;
                }
            }
            $data['name'] = $name;
            $data['roles'] = $roles;
            return $data;
        }

        public function SendForSignature($api, $args)
        {
            $send_docs_for_sig = new sendDocumentsForSignature();
            $send_docs_for_sig->sugarRootUrl = $args['sugarRoot'];
            $send_docs_for_sig->returnURL = $args['returnUrl'];
            $send_docs_for_sig->contacts = $args['contacts'];
            /*
             * Checking if file exist
             */
            foreach ($args['documents'] as $key => $value) {
                $uploadFile = new UploadFile();
                $uploadFile->temp_file_location = "upload/" . $value['revisionId'];
                $file_contents = $uploadFile->get_file_contents();
                if (!$file_contents) {
                    unset($args['documents'][$key]);
                }
            }
            $args['documents'] = array_values($args['documents']);
            
            if($args['documents_type'] == 'Sugar Attachments') {
            $send_docs_for_sig->doucments = $args['documents'];
            }
            
            $send_docs_for_sig->notificationsURL = $args['notificationsurl'];
            $send_docs_for_sig->signed_attachment_type = $args['signed_attachment_type'];
            $send_docs_for_sig->signed_attachment_name = $args['signed_attachment_name'];
            $send_docs_for_sig->template_id = $args['template_id'];
            $send_docs_for_sig->documents_type = $args['documents_type'];


            $sender_view_url = $send_docs_for_sig->sendForSignature();
            return json_encode(array(
                'url' => $sender_view_url
            ));
        }

    }
    