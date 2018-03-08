<?php
// RT_DocuSign
// Author : Rolustech
// Sep 2015

require_once 'include/upload_file.php';
require_once 'modules/RT_DocuSign/actions/RT_SaveSugarDocument.php';

// getting pdf blob from request
$file = new UploadFile();
$file->temp_file_location = 'php://input';
$contents = $file->get_file_contents();



// to get name we get pdf template id, and record id. 
if ((isset($_SESSION["template_id"])) && ((isset($_SESSION["parent_module"]))) && ((isset($_SESSION["parent_record_id"])))) // getting name of document from session that we have previously set.
    {
    $template_id      = $_SESSION["template_id"];
    $Parent_module    = $_SESSION["parent_module"];
    $Parent_record_id = $_SESSION["parent_record_id"];
    
    $pdfmgr       = BeanFactory::getBean('PdfManager', $template_id);
    $bean         = BeanFactory::getBean($Parent_module, $Parent_record_id);
    // Name of Document is in format <parent_record_name>_<template_name>.pdf 
    $documentName = "";
	if($Parent_module=="Contacts")
	{
		$documentName = $bean->salutation ." ". $bean->first_name ." ". $bean->last_name . "_" . $pdfmgr->name;
		$documentName = str_replace(" ", "_", trim($documentName)) . ".pdf";
	}
	else
	{
		$documentName = $bean->name . "_" . $pdfmgr->name;
		$documentName = str_replace(" ", "_", $documentName) . ".pdf";
	}
        
    
    //creating Sugar CRM Document from contents and name
    $savedoc = new RT_SaveSugarDocument();
    $saveid  = $savedoc->saveDocument($documentName, $contents,"PDF");
    // creating relationship
   
	$focus = BeanFactory::getBean("Documents");
	$focus->retrieve_by_string_fields(array(
		'document_revision_id' => '' . $saveid
	));
	
	
	// returning name and ID of PDF to ajax request.
	echo $saveid . "|" . $focus->document_name;
}



