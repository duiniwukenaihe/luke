<?php

require_once 'modules/RT_DocuSign/actions/RT_PostActivity_Status.php';
require_once 'custom/modules/RT_DocuSign/DocuSign_Envelope.php';
require_once 'modules/RT_DocuSign/actions/RT_SaveSugarDocument.php';
require_once 'modules/RT_DocuSign/actions/RT_Update_Relationship_Status.php';
require_once('include/utils.php');


// getting parameters from Request.
$envelopeID     = $_GET['envelopeId'];
$envelopestatus = $_GET['event'];
$baseurl        = $_GET['urlRoot'];
$module         = $_GET['parentRecord'];
$recordid       = $_GET['parentId'];
$isbwc          = $_GET['bwc'];
$env_rec_id		= $_GET['envelope_rec_id'];

$Record_name="";
$ds= BeanFactory::getBean($module,$recordid);
if($module=='Documents')
{
	$Record_name=$ds->document_name;
}
else
{
	$Record_name=$ds->name;
}


$contacts_ids=array();
$document_ids=array();

// saving the record of envelope.
$envelope                  = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
$envelope->name = "DocuSign Packet-".$Record_name;
$envelope->docusignenvelopeid            = $envelopeID;
if($envelopestatus=="Save")
{
	$envelope->packetstatus	  = "Created";
}
else {
	$envelope->packetstatus	  = $envelopestatus;
}
$envelope->parent_type   = $module;
$envelope->parent_id = $recordid;
$envelope->sending_user_id= $_SESSION["user_id"];

$envelope->load_relationship('dp_doucumentspackets_attachments');
$attached_docus=$envelope->dp_doucumentspackets_attachments->getBeans();
foreach($attached_docus as $docs)
{
	$document_ids[]=$docs->id;
}
$envelope->load_relationship('dp_doucumentspackets_contacts');
$attached_contacts=$envelope->dp_doucumentspackets_contacts->getBeans();
foreach($attached_contacts as $contct)
{
	$contacts_ids[]=$contct->id;
}
$envelope->save();


// getting information from envelope.	
$ds_envelope     = new DocuSign_Envelope();
$envelope_object = $ds_envelope->getEnvelopeObject();
$recipents_name  = $ds_envelope->getRecipentsNames($envelope_object, $envelopeID);
$recipents_objs  = $ds_envelope->getRecipents($envelope_object, $envelopeID);
$documents_name  = $ds_envelope->getDocumentsNames($envelope_object, $envelopeID);
$documents_contents  = $ds_envelope->getDocumentsContents($envelope_object, $envelopeID);


// posting status in activity stream.
$user_id        = $_SESSION["user_id"];
$recipents_name = implode(', ', $recipents_name);

$post_status    = new RT_PostActivity_Status();

$contacts_ids=addExternalContactsToSugar($contacts_ids,$recipents_objs,$recordid);
updatePacketContacts($contacts_ids,$env_rec_id);
$document_ids=addExternalDocumentsToSugar($documents_name,$document_ids,$ds_envelope,$envelope_obj,$envelopeID);
updatePacketDocuments($document_ids,$env_rec_id);
$messages=createMessages($env_rec_id,$contacts_ids);
addPacketToParentRecord($module,$recordid,$env_rec_id);

if($envelopestatus=='Send')
{
	// posting messages...
	$post_status->PostStatus($user_id, $module, $recordid,$messages);

	// update status of documents and recipents
	$relationship_status=new RT_Update_Relationship_Status();
	$doc_status_msg="Sent for Signature";
	$relationship_status->updateDocumentsStatuses($env_rec_id,$doc_status_msg);
	$receipnt_status_msg="Sent";
	$relationship_status->updateReceipentsStatuses($env_rec_id,$receipnt_status_msg,null,2);
}
else if($envelopestatus=='Cancel')
{
	// update status of documents and recipents
	$relationship_status=new RT_Update_Relationship_Status();
	$doc_status_msg="Cancelled";
	$relationship_status->updateDocumentsStatuses($env_rec_id,$doc_status_msg);
	$receipnt_status_msg="Cancelled";
	$relationship_status->updateReceipentsStatuses($env_rec_id,$receipnt_status_msg,null,2);
}
else if(($envelopestatus=='Save')||($envelopestatus=='Created'))
{
	// update status of documents and recipents
	$relationship_status=new RT_Update_Relationship_Status();
	$doc_status_msg="Created";
	$relationship_status->updateDocumentsStatuses($env_rec_id,$doc_status_msg);
	$receipnt_status_msg="Created";
	$relationship_status->updateReceipentsStatuses($env_rec_id,$receipnt_status_msg,null,2);
}

// creating pdf of packet and attach its link with this documents Packet.
$docname="DocuSign Packet-".$Record_name.".pdf";
savePacketPDF($env_rec_id,$docname,$documents_contents);


// This function will create array of messages that we will post on activity status.
function createMessages($env_rec_id,$contacts_ids)
{
	$document_packet_bean = BeanFactory::getBean("DP_DoucumentsPackets",$env_rec_id);
	$document_link ='{"value":"@[DP_DoucumentsPackets:'.$document_packet_bean->id .':'.$document_packet_bean->name .'] '.translate('LBL_RT_DOCUSGIN_SENT_MSG', 'RT_DocuSign');
	$tags='"tags":[{"id":"'.$document_packet_bean->id .'","name":"'.$document_packet_bean->name .'","module":"DP_DoucumentsPackets"}';
	$embds='"embeds":[]}';
	$objct=',"object":{"name":"'.$document_packet_bean->name .'","type":"DP_DoucumentsPackets","module":"DP_DoucumentsPackets","id":"'.$document_packet_bean->id .'"}}';
	$contacts_link= '(';
	foreach($contacts_ids as &$contact_id)
	{
		
		$contact_bean = BeanFactory::getBean("Contacts",$contact_id);			
		$cntct_link='@[Contacts:'.$contact_bean->id .':'.$contact_bean->name .'] ';
		$contacts_link=$contacts_link.$cntct_link;
		$tag=',{"id":"'.$contact_bean->id .'","name":"'.$contact_bean->name .'","module":"Contacts"}';
		$tags=$tags.$tag;
	}
	$contacts_link=$contacts_link.') ",';
	$tags=$tags.'],';
	$status_data=$document_link.$contacts_link.$tags.$embds;
	return $status_data;
}

// function to check if contact exists in sugarcrm. if not then this will add contact to sugarcrm.
function addExternalContactsToSugar($contacts_ids,$recipents_objs,$recordid)
{		
	$new_contacts_ids_array=array();// this array  will maintains the ids of all the contacts that are currently attached with envelope after adding and removing.
	foreach($recipents_objs as &$resobj){					
		global $db;	
		$query="SELECT id  FROM contacts WHERE deleted='0' AND TRIM(CONCAT(COALESCE(salutation,''),' ',COALESCE(first_name,''),' ',COALESCE(last_name,''))) ='".trim($resobj['name'])."'";
		$result=$db->query($query);				
		$check=false;
		$saveid='';
		while($row = $result->fetch_assoc()) // we are checking if contact with this name already exists.
		{	
			$id=$row['id'];
			$module = BeanFactory::getBean('Contacts',$id);	
			
			if($module->email1 == trim($resobj['email']))// if contact with given name exist then we will check its email. If email is different we will create new contact in sugar crm.
			{				
				$check=true;
				foreach($contacts_ids as &$cid)
				{
					if($cid==$id)
					{						
						$new_contacts_ids_array[]=$id;
					}
				}
			}			
		}	
		if($check==false)// if contact with given name does not exist we will create one.
		{			
			// create contact
			$module = BeanFactory::getBean('Contacts');												
			$module->last_name=trim($resobj['name']);
			$module->email1=trim($resobj['email']);			
			$saveid=$module->save();	
			// Adding id of newly created contact in list of currently attached contacts with envelops.
			$new_contacts_ids_array[]=$saveid;		
		}
	}
	return $new_contacts_ids_array;
}
// function to check if document exists in sugarcrm. if not then this will add document to sugarcrm.
function addExternalDocumentsToSugar($documents_name,$document_ids,$ds_envelope,$envelope_obj,$envelopeID)
{	
	$new_document_ids=array();
	foreach($documents_name as &$docname){					
		global $db;	
		$query="SELECT document_revision_id FROM documents d WHERE d.deleted='0' and d.document_name='".trim($docname['name'])."'";
		$result=$db->query($query);			
		$check=false;
		while($row = $result->fetch_assoc()) // we are checking if document with this name already exists.
		{				
			$id=$row['document_revision_id'];			
			foreach($document_ids as &$docid)
			{				
				if($id == $docid)
				{				
					$check=true;
					$new_document_ids[]=$id;
				}
			}
		}
		if($check==false)// if document already not exists in sugar. We have to create one.
		{	
			$contents=$ds_envelope->getSaperatedDocumentContents($envelope_obj, $envelopeID,$docname['id']);
			$doc_upload=new RT_SaveSugarDocument();	
			$doc_name=$docname['name'];
			// As docusign contains files in pdf format. So we are saving file as pdf.
			if (strpos($doc_name, '.pdf') == false)
			{
				$doc_name=$docname['name'].".pdf";
			}
			$doc_id=$doc_upload->saveDocument($doc_name,$contents,"EXT");
			$new_document_ids[]=$doc_id;
		}
	}
	return $new_document_ids;
}

// This function will return the SugarCRM Contacts IDs of All the Contacts attached with envelope.
function updatePacketContacts($contacts_ids,$env_rec_id)
{
	// deleting existing relationships with contacts
	$document_packet = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
	$document_packet->load_relationship('dp_doucumentspackets_contacts');
	$document_packet->dp_doucumentspackets_contacts->delete();
	// adding all contacts with parent record.
	foreach($contacts_ids as &$cnts)
	{
		$document_packet->dp_doucumentspackets_contacts->add($cnts);
	}
	$document_packet->save();
}

// This function will return the SugarCRM Documents IDs of All the Documents attached with envelope.
function updatePacketDocuments($document_ids,$env_rec_id)
{
	// Deleting existing records.
	$document_packet = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
	$document_packet->load_relationship('dp_doucumentspackets_documents');
	$document_packet->dp_doucumentspackets_documents->delete();
	foreach($document_ids as &$revid)
	{
		// fetching documents ID from rev id
		$doc                  = BeanFactory::getBean('Documents');
		$doc->retrieve_by_string_fields(array('document_revision_id' => $revid ));			
		$docid=$doc->id;
		
		// adding Relationship between Document Packets and Documents
		$document_packet->dp_doucumentspackets_documents->add($docid);
	}
	$document_packet->save();
}
// This function will Add the Relationship of Docusign Packet with Parent Record
function addPacketToParentRecord($module,$recordid,$env_rec_id)
{
	if($module=='Accounts')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_accounts');
		$bean->dp_doucumentspackets_accounts->add($recordid);
		$bean->save();
	}
	else if($module=='Opportunities')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_opportunities_1');
		$bean->dp_doucumentspackets_opportunities_1->add($recordid);
		$bean->save();
	}
	else if($module=='Leads')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_leads_1');
		$bean->dp_doucumentspackets_leads_1->add($recordid);
		$bean->save();
	}
	else if($module=='Cases')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_cases');
		$bean->dp_doucumentspackets_cases->add($recordid);
		$bean->save();
	}
	else if($module=='m_CAMS')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_m_cams');
		$bean->dp_doucumentspackets_m_cams->add($recordid);
		$bean->save();
	}
	else if($module=='Contacts')
	{
		$bean = BeanFactory::getBean('DP_DoucumentsPackets',$env_rec_id);
		$bean->load_relationship('dp_doucumentspackets_contacts');
		$bean->dp_doucumentspackets_contacts->add($recordid);
		$bean->save();
	}
}

// This function will create PDF of current packet and attach it with current record.
function savePacketPDF($env_rec_id,$docname,$documents_contents){

	$doc_upload=new RT_SaveSugarDocument();			
	$doc_id=$doc_upload->saveDocument($docname,$documents_contents,"PDF","2"); // if we send mode 2 in function it will return documents ID of created documents else it will return revision id.	
	
	$document_packet_bean = BeanFactory::getBean("DP_DoucumentsPackets",$env_rec_id);
        $document_packet_bean->document_id_c=$doc_id;
	$document_packet_bean->save();
        $document_packet_bean->load_relationship('dp_doucumentspackets_documents');
	$document_packet_bean->dp_doucumentspackets_documents->add($doc_id);
	
}

// closing Drawer
//$script='<script> console.log(top.frames.SUGAR.App); top.frames.location.reload(false); </script>';
$script='<script>  top.frames.SUGAR.App.drawer.close();  </script>';
echo $script;
