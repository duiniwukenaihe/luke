<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

/**
 * Copyright (c) 2015 Rolustech
 * All rights reserved.
 **/

require_once 'custom/modules/RT_DocuSign/Configurations.php';
require_once 'custom/modules/RT_DocuSign/lib/src/DocuSign_Client.php';
require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_ViewsService.php';



class DocuSign_Views
{
    
    function getSenderView($return_url, $envelopeID)
    {
        
        $client       = $this->getDocuSignClient();
        $view_service = new DocuSign_ViewsService($client);
        try {
            $view_response = $view_service->views->getSenderView($return_url, $envelopeID, false);           
            return $view_response->url;
        }
        catch (Exception $e) {
            echo json_encode(array(
                'error' => $e->getMessage()
            ));
            return;
        }
    }
    function getDocuSignClient()
    {
        $config = new Configurations();
        $creds  = $config->getCredientials();
        $client = new DocuSign_Client($creds);
        if ($client->hasError()) {
            echo json_encode(array(
                'error' => $client->errorMessage
            ));
            return;
        }
        return $client;
    }
    
}