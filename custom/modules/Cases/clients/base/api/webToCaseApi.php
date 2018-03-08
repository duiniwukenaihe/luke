<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**************************************************************************************************************
   * Description  : Web to Case Custom Endpoint to Capture Enquiries from Webforms
   * Created by   : Mohammed Jhosawa @ BHEA.
   * Date Created : 23rd October, 2017.
   * Date Modified: 6th December, 2017.
   * Copyright (C) 2004-2017 SugarCRM Inc. All rights reserved.
 **************************************************************************************************************/
class webToCaseApi extends SugarApi {
  private $cases_fields;
  private $srvReq_fields;
  private $upload_files_count;
  private $uploadfield_name;
  function __construct(){
    $this->cases_fields = array('customer_name_c','customer_address_street_c','customer_address_city_c','customer_address_state_c','customer_address_postalcode_c','customer_phone_c','customer_email_c');
    $this->srvReq_fields = array('item_1','item_2','item_3','item_4','item_5','item_6','item_7','item_8','item_9','item_10');
    $this->upload_files_count = 10; #upload files field count 
    $this->uploadfield_name = "item_file_"; #name of the upload field on the webform
  }
  
  //register method
  public function registerApiRest(){
    return array(
      'create' => array(
      'reqType' => 'POST',
      'path' => array('<module>','create'),
      'pathVars' => array('module'),
      'method' => 'createCase',
      'shortHelp' => 'Create service requests from Montevista service request forms in SugarCRM',
      'longHelp' => '',
      'noLoginRequired' => true,
      ),
    );
  }
  
  //create case record
  public function createCase($api,$args){
    if (isset($args['campaign_id']) && !empty($args['campaign_id'])) {
      $campaign_id = $args['campaign_id'];
      $campaign = BeanFactory::newBean('Campaigns');
      $camp_query  = 'SELECT name, id FROM campaigns WHERE id = ' . $campaign->db->quoted($campaign_id);
      $camp_query .= " and deleted=0";
      $camp_result = $campaign->db->query($camp_query);
      $camp_data = $campaign->db->fetchByAssoc($camp_result);

      if(isset($camp_data) && $camp_data != null){
        $caseBean = BeanFactory::newBean($args['module']);
        foreach($this->cases_fields as $field){
          $caseBean->$field = $args[$field];
        }

        $caseBean->status = 'In Progress';
        $caseBean->team_id = 1;

        // This is necessary in order to programatically set the created_by
        $system_user = $this->getSystemUser();
        $caseBean->set_created_by = false;
        $caseBean->update_modified_by = false;
        $caseBean->created_by = $system_user->id;
        $caseBean->modified_user_id = $system_user->id;

        $args['case_id'] = $caseBean->save();
        if($args['case_id']){
          $this->createServiceRequests($args);
        }
        $GLOBALS['log']->debug("Case successfully created");
        $this->returnSuccess($args);
      }
      else{
        $GLOBALS['log']->debug("Campaign ID doesnt exist in Sugar");
        //return 400 error and message when campaign id doesnt exist.
        http_response_code(400);
        return array ( "error_code" => 400, "error_message" => "Campaign ID doesnt exist in Sugar!");
      }
    }
    else{
      $GLOBALS['log']->debug("Campaign ID is empty");
      //return 422 error and message when campaign id is empty or blank.
      http_response_code(422);
      return array ( "error_code" => 422, "error_message" => "Campaign ID is empty");
      
    }
  }

  protected function getSystemUser()
  {
    $user = BeanFactory::newBean('Users');
    $user->getSystemUser();
    return $user;
  }
  
  //create service request record
  protected function createServiceRequests($args){
    
    //link attached file to case in case of field upload_file
    if(isset($_FILES['upload_file']) && !empty($_FILES['upload_file'])){
      $attachment_id = $this->uploadAttachments('upload_file');
      if(!empty($args['case_id']) && !empty($attachment_id)){
        $this->linkRecord('Cases',$args['case_id'],$attachment_id,'cases_mv_attachments');
      }
    }
    
    $sr_count=1; #service request flag
    foreach($this->srvReq_fields as $field){

      $attachmentField = $this->uploadfield_name . $sr_count;
      $hasAttachment = self::checkForSrvReqAttachment($attachmentField);

      if(
        (isset($args[$field]) && !empty($args[$field])) OR $hasAttachment
      ){
        // Create the Service Request
        $srvReqBean = BeanFactory::newBean('mv_SrvReq');
        $srvReqBean->description = $args[$field];
        $srvReqBean->team_id = 1;

        $srvReq_id = $srvReqBean->save();
      
        // Link each service request to case
        if($srvReq_id){ $this->linkRecord('Cases',$args['case_id'],$srvReq_id,'cases_mv_srvreq_1');}
          
        // Link the attachement if it exists
        if($hasAttachment){
          $attachment_id = $this->uploadAttachments($attachmentField);
          if(!empty($srvReq_id) && !empty($attachment_id)){     
            $this->linkRecord('mv_SrvReq',$srvReq_id,$attachment_id,'mv_srvreq_mv_attachments');
          }
        }

        $srvReqBean->save(); //Save one more time to recalculate Name based on case relationship

      }
      $sr_count++;
    } 
  }

  protected static function checkForSrvReqAttachment($attachmentField){
    return 
      isset($_FILES[$attachmentField]) && 
      !empty($_FILES[$attachmentField]) &&
      $_FILES[$attachmentField]['error'] === 0 &&
      $_FILES[$attachmentField]['size'] > 0;
  }
  
  //upload file
  protected function uploadAttachments($field){
    require_once('include/upload_file.php');
    $upload_file = new UploadFile($field);
    $do_final_move = 0;
    if (isset($_FILES[$field]) && $upload_file->confirm_upload()){
      //upload file attachment in mv_Attachments
      $attachmentsBean = BeanFactory::newBean('mv_Attachments');
      $attachmentsBean->document_name = $upload_file->get_stored_file_name();
      $attachmentsBean->filename = $upload_file->get_stored_file_name();
      $attachmentsBean->file_mime_type = $upload_file->mime_type;
      $attachmentsBean->team_id = 1;
      $attachmentsBean->category_id = 'Warranty Item';
      $do_final_move = 1;
    }
    $attachmentsBean->save();
    if($do_final_move)  { 
      $upload_file->final_move($attachmentsBean->id);
    }
    return $attachmentsBean->id;
  }
  
  //load relationship and add link
  protected function linkRecord($module,$bean_id,$link_id,$link_name){
    $getBean = BeanFactory::getBean($module,$bean_id);
    $getBean->load_relationship($link_name);
    $getBean->$link_name->add($link_id);
  }

  protected function returnSuccess($args)
  {
    if(isset($args['redirect_url']) AND !empty($args['redirect_url'])){
      header( "Location: {$args['redirect_url']}" ) ;
      return;
    }else{
      return array ("msg" => "Case successfully created");
    }
  }
}
