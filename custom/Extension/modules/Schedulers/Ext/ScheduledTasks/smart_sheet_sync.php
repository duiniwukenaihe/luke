<?php

$job_strings[] = 'sugar_to_smartsheet_sync';
$job_strings[] = 'verify_webhooks';
$job_strings[] = 'smartsheet_to_sugar_sync';

function sugar_to_smartsheet_sync() {

    $GLOBALS['log']->debug("sugar_to_smartsheet_sync");
    require_once 'custom/include/Helpers/SmartSheets/smartSheetSynchronizer.php';
    $admin = new Administration();
    $admin->retrieveSettings();
    $sheet_id = $admin->settings['smartsheet_id'];
    if (!empty($sheet_id)) {
        $smart_sheet_synchronizer = new smartSheetSynchronizer($sheet_id);
        $query=" sync_cam_to_smartsheet='1' AND smartsheet_row_id<>'' ";
        $smart_sheet_synchronizer->syncSugarToSmartSheet(" $query ");
    } else {
        //notify user
    }
    return true;
}

function verify_webhooks() {

    $GLOBALS['log']->debug("Webhook sch called");

    $admin = new Administration();
    $admin->retrieveSettings();
    $sheet_id = $admin->settings['smartsheet_id'];
    $webhook_id = $admin->settings['smartsheet_webhook_id'];

    require_once 'custom/include/Helpers/SmartSheets/smartSheetSynchronizer.php';
    $smart_sheet_synchronizer = new smartSheetSynchronizer($sheet_id);
    $response = $smart_sheet_synchronizer->isWebHookEnabled($webhook_id, true);


    if ($response->enabled == 1 && $response->status == 'ENABLED') {
        $GLOBALS['log']->debug("Webhook is enabled");
    } else {
        /*
         * manual attempt to enable webhook.
         * manually sync records from smartsheet to sugar
         */
        $smart_sheet_synchronizer->syncSmartSheetToSugar(true);
        $webhook_update_response = $smart_sheet_synchronizer->enableWebHook($webhook_id);
        $GLOBALS['log']->debug("response after update webhook--->", $webhook_update_response);
    }

    //disabledDetails
    //status
    //enabled

    return true;
}

function smartsheet_to_sugar_sync() {

    $GLOBALS['log']->debug("sugar_to_smartsheet_sync");
    require_once 'custom/include/Helpers/SmartSheets/smartSheetSynchronizer.php';
    $admin = new Administration();
    $admin->retrieveSettings();
    $sheet_id = $admin->settings['smartsheet_id'];
    if (!empty($sheet_id)) {
        $smart_sheet_synchronizer = new smartSheetSynchronizer($sheet_id);
        $smart_sheet_synchronizer->syncSmartSheetToSugar(true);
    } else {
        // notify user
    }


    return true;
}

?>
