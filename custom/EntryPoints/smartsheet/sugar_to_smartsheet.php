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

$smart_sheet_synchronizer = new smartSheetSynchronizer($sheet_id);
$smart_sheet_synchronizer->syncSugarToSmartSheet(" sync_cam_to_smartsheet='1' ");
//$message=$smart_sheet_synchronizer->syncSugarToSmartSheet();

echo $message;
echo "<br> Sugar to smartsheet sync completed <br>";