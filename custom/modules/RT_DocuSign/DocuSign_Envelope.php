<?php

/**
 * Copyright (c) 2015 Rolustech
 * All rights reserved.
 **/


require_once 'custom/modules/RT_DocuSign/Configurations.php';
require_once 'custom/modules/RT_DocuSign/lib/src/DocuSign_Client.php';
require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_EnvelopeService.php';
require_once 'custom/modules/RT_DocuSign/DocuSign_Get_Envelope_Documents.php';

class DocuSign_Envelope
{
    
    // function to get envelope object using DocuSign Envelope Service.
    public function getEnvelopeObject($send_user_id=null)
    {
        $client     = $this->getDocuSignClient($send_user_id);
        $envService = new DocuSign_EnvelopeService($client);
        $envelope   = $envService->envelope;
        return $envelope;
    }
    // function to get client of docusign.
    function getDocuSignClient($send_user_id=null)
    {
        $config = new Configurations();
        $creds  = $config->getCredientials($send_user_id);
        $client = new DocuSign_Client($creds);
        if ($client->hasError()) {
            echo json_encode(array(
                'error' => $client->errorMessage
            ));
            return;
        }
        return $client;
    }
    // function to get Names of Recipients of envelopes
    function getRecipentsNames($envelope_obj, $envelopeID)
    {
        $recipents      = $envelope_obj->getEnvelopeRecipients("$envelopeID");
        $recipents_list = array();
        if ($recipents) {
            foreach ($recipents as &$recipents_data) {
                if ($recipents_data) {
                    foreach ($recipents_data as &$value) {
                        $recipents_list[] =& $value->name;
                    }
                }
            }
        }
        return $recipents_list;
    }
	// function to get Recipients of envelopes
    function getRecipents($envelope_obj, $envelopeID)
    {
        $recipents      = $envelope_obj->getEnvelopeRecipients("$envelopeID");
        $recipents_list = array();
        if ($recipents) {
            foreach ($recipents as &$recipents_data) {
                if ($recipents_data) {
                    foreach ($recipents_data as &$value) {
                       $recipent = array('name' => &$value->name ,'email'=> &$value->email,'index'=> $value->recipientId, 'status' => $value->status );
                    
                       if(isset($value->signedDateTime)) {
                           $recipent['date_modified'] = $value->signedDateTime; 
                       } else if(isset($value->deliveredDateTime)) {
                           $recipent['date_modified'] = $value->deliveredDateTime; 
                       }  else if(isset($value->declinedDateTime)) {
                           $recipent['date_modified'] = $value->declinedDateTime; 
                       } 
                       
                       $recipents_list[] = $recipent;
                    }
                }
            }
        }
        return $recipents_list;
    }
    // function to get Names of Attached documents
    function getDocumentsNames($envelope_obj, $envelopeID)
    {
        $envelops_documents = $envelope_obj->getEnvelopeDocuments("$envelopeID");
        $documents_list     = array();
        if ($envelops_documents) {
            foreach ($envelops_documents as &$document_data) {
                if ($document_data) {
                    foreach ($document_data as &$value) {
                        if ($value->documentId != 'certificate') {
                            $documents_list[] = array('name' =>$value->name, 'id' => $value->documentId );
                        }
                    }
                }
            }
        }
        return $documents_list;
    }
	// function to get contents of attached Documents
	function getDocumentsContents($envelope_obj, $envelopeID)
	{	
		$document_contents=$envelope_obj->getEnvelopeDocumentsCombined($envelopeID,false);
		return $document_contents;
	}
	function getDocumentsContents2($envelope_obj, $envelopeID)
	{	
		$envelops_documents = $envelope_obj->getEnvelopeDocuments("$envelopeID");
        $documents_list     = array();
        if ($envelops_documents) {
            foreach ($envelops_documents as &$document_data) {
                if ($document_data) {
                    foreach ($document_data as &$value) {
                        if ($value->documentId != 'certificate') {
                            $documents_list[] = &$value;
                        }
                    }
                }
            }
        }
        return $documents_list;
	}
	function getEnvelope($envelope_obj, $envelopeID)
	{
		$envelope=$envelope_obj->getEnvelope($envelopeID);
		return $envelope;
	}
	// this function will the contents of each document
	function getSaperatedDocumentContents($envelope_obj, $envelopeID,$docID)
	{		
		/*
		As default API client of DocuSign does not provides functionality to get contents of each documents separately.
		we are calling our custom service(DocuSign_Get_Envelope_Documents) that will fetch the contents of each documents separately.
		*/
		$client     = $this->getDocuSignClient();
		$envService = new DocuSign_Get_Envelope_Documents($client);
		$envelope_obj2   = $envService->envelope;
		
		$contents=$envelope_obj2->getEnvelopeDocumentsContents($envelopeID,false ,$docID);
		return $contents;
	}
}
