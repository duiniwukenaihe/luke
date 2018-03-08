<?php

// RT_DocuSign
// Author : Rolustech
// Sep 2015

// This will save values from request to session that we will use in saving PDF to Sugar CRM. 

$function = $_POST['func'];
if ($function == 'saveValues') {
    // getting parameters form Request.
    $template_id      = $_POST['template_id'];
    $parent_module    = $_POST['parent_module'];
    $parent_record_id = $_POST['parent_record_id'];
    
    
    // Saving parameters to Session	
    session_start();
    $_SESSION['template_id']      = $template_id;
    $_SESSION['parent_module']    = $parent_module;
    $_SESSION['parent_record_id'] = $parent_record_id;
}