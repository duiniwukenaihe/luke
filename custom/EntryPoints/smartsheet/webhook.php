<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once 'custom/include/Helpers/SmartSheets/smartSheetSynchronizer.php';


$admin = new Administration();
$admin->retrieveSettings();
$sheet_id=$admin->settings['smartsheet_id'];
$webhook_id=$admin->settings['smartsheet_webhook_id'];

$smart_sheet_synchronizer = new smartSheetSynchronizer($sheet_id);  //2622275372509060
if ($smart_sheet_synchronizer->isWebHookEnabled($webhook_id)) {
    $smart_sheet_synchronizer->handleWebhookResponse();
} else {
    $header_array = getallheaders();
    $hook_response_id = $header_array['Smartsheet-Hook-Challenge'];
    header("HTTP status: 200 OK");
    header("Smartsheet-Hook-Response: $hook_response_id");
}


	    
	    