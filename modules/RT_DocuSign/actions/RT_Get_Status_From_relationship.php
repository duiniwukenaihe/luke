<?php

/** 
*	RT_DocuSign
*	Author : Rolustech
* 	Sep 2015
*/

/**
* This will save values from request to session that we will use in saving PDF to Sugar CRM. 
*/

$function = $_POST['func'];
if ($function == 'getContatctStatus') {
    // getting parameters form Request.
    $envelopeID      = $_POST['envID'];
    $contactID    = $_POST['cntctID'];
    
	// getting status from relationship table
	global $db;	
	$query="SELECT receipnt_status as 'status'  FROM dp_doucumentspackets_contacts_c WHERE deleted=0 AND dp_doucumentspackets_contactsdp_doucumentspackets_ida = '".$envelopeID."' AND dp_doucumentspackets_contactscontacts_idb='".$contactID."'";
	$result = $db->query($query);
    $status="";
    while ($row = $result->fetch_assoc()) // we are checking if document with this name already exists.
    {
		$status=$row['status'];
	}
	echo $status;
	die();
}
else if ($function == 'getDocumentStatus') {
    // getting parameters form Request.
    $envelopeID      = $_POST['envID'];
    $documentID    = $_POST['docID'];
    
	// getting status from relationship table
	global $db;	
	$query="SELECT document_status as status  FROM dp_doucumentspackets_attachments WHERE deleted=0 AND packet_id = '".$envelopeID."' AND attachment_id='".$documentID."'";
	$result = $db->query($query);
    $status="";
    while ($row = $result->fetch_assoc()) // we are checking if document with this name already exists.
    {
		$status=$row['status'];
	
	}
	echo $status;
	die();
}