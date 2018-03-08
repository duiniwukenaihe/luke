<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * returns ununsynchronized CAM module records
 */
require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';

class smartSheetSynchronizer {
    /*
     * returns ids of unsynchronized records
     * module must have field has_synchronized
     */

    private $smart_sheet_helper;
    private $sheet_id;
    private $field_mapping;
    private $new_rows_for_update;
    private $new_rows_for_create;
    private $message_logs;
    private $call_back_new_rows;
    private $call_back_update_rows;
    private $call_back_update_rows_id;
    private $call_back_new_rows_id;
    private $new_smartsheet_records_email_body;
    private $call_back_delete_rows;
    private $call_back_delete_rows_id;

    const DIRECTION_SUGAR_TO_SMARTSHEET = 'sugar_to_smartsheet';
    const DIRECTION_SMARTSHEET_TO_SUGAR = 'smartsheet_to_sugar';
    const DIRECTION_BIDIRECTIONAL = '';
    const NOTIFICATION_PRIMARY_EMAIL = "mohammad.ali@rolustech.net";
    const PRIMARY_MODULE = 'm_CAMS';

    public function __construct($sheet_id) {
        $this->new_smartsheet_records_email_body = '';
        $this->sheet_id = $sheet_id;
        $this->smart_sheet_helper = new SmartSheetApiHelper();
        $this->field_mapping = $this->getSmartsheetFieldMappings($this->sheet_id);
        $this->field_mapping_arr = $this->objectToArray($this->field_mapping);
        $this->new_rows_for_create = array();
        $this->new_rows_for_update = array();
        $this->message_logs = "";
        $this->call_back_new_rows = array();
        $this->call_back_update_rows = array();
        $this->call_back_update_rows_id = array();
        $this->call_back_new_rows_id = array();
        $this->call_back_delete_rows = array();
        $this->call_back_delete_rows_id = array();
    }

    public function fetchUnsynchronizedRecords($params) {

        return $this->queryBean($params['module'], $params['select'], $params['where']);
    }

    public function queryBean($module, $select, $where_sql, $limit = 0) {
        if (!empty($module) && is_array($select)) {
            $sugarQuery = new SugarQuery();
            $sugarQuery->from(BeanFactory::newBean($module)); //m_CAMS
            $sugarQuery->select($select);
            if ($limit != 0)
                $sugarQuery->limit($limit);
            $sugarQuery->whereRaw($where_sql);

            return $sugarQuery->execute();
        }
    }

    public function getLastSchedulerSyncTime($name) {
        $result = $this->queryBean('Schedulers', array('last_run', 'name'), "name LIKE '%$name%' ");
        return $result[0]['last_run'];
    }

    public function syncSugarToSmartSheet($optional_where = null, $enable_creation = false) {


        $GLOBALS['log']->fatal('function called');

        $sugar_to_smartsheet_fields = $this->getFieldsUsingDirectionFilter(self::DIRECTION_SUGAR_TO_SMARTSHEET);
        $sugar_sync_fields = array_values($sugar_to_smartsheet_fields);
        array_push($sugar_sync_fields, 'id');
        array_push($sugar_sync_fields, 'smartsheet_row_id');
        $where = !empty($optional_where) ? " has_synchronized='0' AND $optional_where " : " has_synchronized='0' ";

        $params = array(
            'module' => 'm_CAMS',
            'select' => $sugar_sync_fields,
            'where' => $where,
        );
        $result = $this->fetchUnsynchronizedRecords($params);

        $GLOBALS['log']->fatal('unsynchronzied sugar data is', $result);


        $pushed_sugar_ids = array();
        $this->prepareCreateUpdateRowData($sugar_to_smartsheet_fields, $result, $pushed_sugar_ids, $enable_creation);


        $GLOBALS['log']->fatal('update scene is', $this->new_rows_for_update);
        $GLOBALS['log']->fatal('create scene is', $this->new_rows_for_create);

        if (!empty(json_decode($this->new_rows_for_update))) {

            $update_params['data'] = $this->new_rows_for_update;
            //update
            $GLOBALS['log']->fatal('updating bulk');
            $update_response = $this->smart_sheet_helper->updateRowBulk($this->sheet_id, $update_params);
            $this->handleSmartSheetCreateUpdateResponse($update_response, $pushed_sugar_ids, $result);
        }
        $GLOBALS['log']->fatal('update', $update_response);

        if ($enable_creation) {

            if (!empty(json_decode($this->new_rows_for_create))) {
                
                $create_response = $this->smart_sheet_helper->createRow($this->sheet_id, $this->new_rows_for_create);
                $this->handleSmartSheetCreateUpdateResponse($create_response, $pushed_sugar_ids, $result);
                
                $GLOBALS['log']->fatal('creating Row',$create_response);
            }
        }

        return $this->message_logs;
    }

    private function handleSmartSheetCreateUpdateResponse($api_response, $pushed_sugar_ids, $unsynced_records) {
        if (!empty($api_response)) {
            $module = 'm_CAMS';
            $smart_sheet_result = $api_response->result;

            //$GLOBALS['log']->fatal('Api result', $smart_sheet_result);

            if (empty($smart_sheet_result)) {
                //result is empty due some error
                $GLOBALS['log']->fatal('Api returned no result');
                $logs = $this->handleSmartSheetApiLogs($api_response, $pushed_sugar_ids, $unsynced_records);
                $GLOBALS['log']->fatal('log is', $logs);

                $target_bean = BeanFactory::getBean(self::PRIMARY_MODULE);
                foreach ($pushed_sugar_ids as $id) {
                    $target_bean->retrieve($id);
                    if (!empty($id)) {
                        $target_bean->smartsheet_sync_logs = $logs;
                        $target_bean->smart_sheet_write_log = true;
                        $target_bean->sugar_to_smartsheet_sync = true;
                        $target_bean->save();
                    }
                }
            } else {
                //no error best case
                $GLOBALS['log']->fatal('else case creating');
                $job_number_col_id = $this->inverse_field_mapping['job_number'];

                $GLOBALS['log']->fatal('$job_number_col_id', $job_number_col_id);
                $GLOBALS['log']->fatal('smartsheet result new is', $smart_sheet_result);

                foreach ($smart_sheet_result as $row_info_key => $row_info_value) {

                    //if ($row_info_key == 'cells') {

                        //$GLOBALS['log']->fatal('Hellooo',$row_info_value);
                        //identify job number col_id 
                        foreach ($row_info_value->cells as $cols) {
                            if ($cols->columnId == $job_number_col_id) {
                                /*
                                 * Match col id 
                                 * so that exact crm record is mapped
                                 */
                                $api_response_job_number = trim($cols->value);

                                $GLOBALS['log']->fatal('api response -->' . $api_response_job_number, $api_response_job_number);
                            }
                        }
                   // }

                    $time = '';
                    if (!empty($row_info_value->modifiedAt)) {
                        $datetime = new DateTime($row_info_value->modifiedAt);
                        $time = $datetime->format('Y-m-d H:i:s');
                    }

                    $logs = $this->handleSmartSheetApiLogs($api_response, $pushed_sugar_ids, $unsynced_records);

                    $params = array(
                        'smartsheet_modified_at' => $time,
                        'smartsheet_row_id' => $row_info_value->id,
                        'smartsheet_sync_logs' => $logs,
                    );


                    //$cam_bean_id = $pushed_sugar_ids[$row_info_key];
                    $cam_bean_id = $pushed_sugar_ids[$api_response_job_number];
                    if (!empty($cam_bean_id)) {
                        $fields_value = $this->getCamsFieldMappingForUpdate($params);
                        $fields_value['sugar_to_smartsheet_sync'] = true;
                        //$GLOBALS['log']->fatal('field values', $fields_value);
                        $this->updateSugarCrm($fields_value, $module, $cam_bean_id);
                    }
                }
            }
        }
    }

    private function getCamsFieldMappingForUpdate($params) {

        return array(
            'has_synchronized' => true,
            'smartsheet_modified_at' => $params['smartsheet_modified_at'],
            'smartsheet_row_id' => $params['smartsheet_row_id'],
            'smartsheet_sync_logs' => $params['smartsheet_sync_logs'],
            'sugar_to_smartsheet_sync' => true,
        );
    }

    private function updateSugarCrm($fields_value, $module, $id) {

        $this->message_logs.= "fields value " . print_r($fields_value, true) . "<br>";
        $this->message_logs.= "id $id <br>";

        $GLOBALS['log']->fatal('message', $this->message_logs);
        if (!empty($module) && !empty($id) && is_array($fields_value)) {
            $bean = BeanFactory::getBean($module);
            $bean->retrieve($id);
            if (!empty($bean->id)) {
                foreach ($fields_value as $key => $value) {
                    if ($key == 'smartsheet_row_id' && !empty($bean->smartsheet_row_id)) {
                        //smartsheet row id already exist skip this value
                        $GLOBALS['log']->fatal('skipping id already exist');
                        continue;
                    } else {
                        $bean->$key = $value;
                    }
                }
                $bean->save();
                return $bean->id;
            }
            return -1;
        }
        return -1;
    }

    public function syncSmartSheetToSugar($manual_sync = false) {

        if ($manual_sync) {
            //via schdedular
            $rows = $this->smart_sheet_helper->getAllRows($this->sheet_id);
        } else {
            //via callback 
            $rows = $this->getSmartSheetRowsFromId($this->call_back_update_rows_id);
        }

        if (!empty($rows)) {

            $smartsheet_to_sugar_fields = $this->getFieldsUsingDirectionFilter(self::DIRECTION_SMARTSHEET_TO_SUGAR);
            $count = 0;

            foreach ($rows as $row) {
                $this->createUpdateCamRecord($row, $smartsheet_to_sugar_fields);
                $count++;
            }
        }

        $this->handleDeletedSmartSheetRows();
        /*
         * we never create record in cam, instead, we need 
         * to send email to Luke for newly created records.
         * 
         */
        $this->sendNewSmartSheetRowsNotification();
    }

    private function handleDeletedSmartSheetRows() {

        $GLOBALS['log']->fatal('deleted records', $this->call_back_delete_rows_id);

        if (!empty($this->call_back_delete_rows_id)) {
            $bean = BeanFactory::getBean(self::PRIMARY_MODULE);
            foreach ($this->call_back_delete_rows_id as $row_id) {
                $GLOBALS['log']->fatal('bean id is ', $bean->id);
                $bean->retrieve_by_string_fields(array('smartsheet_row_id' => $row_id));
                $bean->smartsheet_row_id = '';
                $bean->save();
            }
        }
    }

    private function getSmartSheetRowsFromId($row_id_array) {
        $rows = array();
        foreach ($row_id_array as $row_id) {
            $url = 'https://api.smartsheet.com/2.0/sheets/' . $this->sheet_id . '/rows/' . $row_id;
            $response = $this->smart_sheet_helper->retrieveFromSmartSheet($url);
            array_push($rows, $response);
        }

        return $rows;
    }

    /*
     * params $row
     * $row must be std class object returned from API
     * 
     */

    private function createUpdateCamRecord($row, $smartsheet_to_sugar_fields) {

        if (!empty($row) && !empty($row->cells[1]->value)) {
            $cam_bean = BeanFactory::getBean('m_CAMS');
            $job_number = $row->cells[1]->value;
            $cam_bean->retrieve_by_string_fields(array('job_number' => trim($job_number)));
            if (!empty($cam_bean->id)) {
                $cam_bean->smartsheet_row_id = $row->id;
                $cam_bean->smartsheet_modified_at = $row->modifiedAt;
                $cam_bean->has_synchronized = 1;
                $cam_bean->sugar_to_smartsheet_sync = true;
                $this->mapSmartsheetCellWithSugarField($smartsheet_to_sugar_fields, $row, $cam_bean);
                $logs = "check bean $cam_bean->id  $cam_bean->job_number  $cam_bean->construction_stage <br>";
                $GLOBALS['log']->fatal($logs);
                $cam_bean->save();
            } else {
                $GLOBALS['log']->fatal("bean not found against smartsheet jobnumber--> $job_number");
                $this->prepareEmailBodyForNewSmartSheetRows($row);
            }
        }
    }

    private function mapSmartsheetCellWithSugarField($smartsheet_to_sugar_fields, $row, &$bean) {

        foreach ($row->cells as $cell) {
            $field_name = $smartsheet_to_sugar_fields[$cell->columnId];
            if (!empty($field_name)) {
                if (!empty($cell->value) && $cell->value != "1") {
                    $bean->$field_name = $cell->value;
                }
                if (is_array($field_name) && $cell->value == "1") {
                    $bean->$field_name['name'] = $field_name['options'];
                }
            }
        }
    }

    public function startSync($params) {
        
    }

    public function getSmartsheetFieldMappings($sheet_id) {
        if (!empty($sheet_id)) {
            require_once('modules/Administration/Administration.php');
            $admin = new Administration();
            $admin_settings = $admin->retrieveSettings('smart_sheet');
            return json_decode($admin_settings->settings['smart_sheet_smart_sheet_' . $sheet_id]);
        }
        return '';
    }

    function objectToArray($d) {
        $return_array = array();
        foreach ($d as $key => $value) {
            $return_array[$key] = $value;
        }

        return $return_array;
    }

    private function prepareCreateUpdateRowData($field_mapping, $result, &$pushed_sugar_ids, $enable_creation) {

        $inverse_field_mapping = array_flip($field_mapping);
        $new_rows = array();
        $new_row = null;
        $iteration = 0;
        $this->inverse_field_mapping = $inverse_field_mapping;

        foreach ($result as $key => $value) {
            $cells = array();
            $job_number = $value['job_number'];
            foreach ($value as $field_name => $field_value) {
                $col_id = $inverse_field_mapping[$field_name];

                if ($field_name == 'id') {
                    //array_push($pushed_sugar_ids, $field_value);
                    $pushed_sugar_ids[$job_number] = $field_value;
                } else if (!empty($col_id)) {
                    array_push($cells, array(
                        'columnId' => $col_id,
                        'value' => $field_value,
                    ));
                }
            }
            if (isset($result[$iteration]['smartsheet_row_id']) && !empty($result[$iteration]['smartsheet_row_id'])) {
                $GLOBALS['log']->fatal("create update case 1 smartsheet id found");
                $new_row_update = array(
                    'id' => $result[$iteration]['smartsheet_row_id'],
                    'cells' => $cells,
                );

                array_push($this->new_rows_for_update, $new_row_update);
            } else if ($enable_creation) {
                $GLOBALS['log']->fatal("create update case 2 no smartsheet id and called via button");
                //search smartsheet before creating new row
                //this step is duplication prevention of rows with same job number
                if (!$this->searchForRowIdInSmartsheet($job_number, $cells)) {
                    $GLOBALS['log']->fatal("create update case 2, no record found create new");
                    $new_row_update = array(
                        'toTop' => true,
                        'cells' => $cells,
                    );

                    array_push($this->new_rows_for_create, $new_row_update);
                } else {
                    
                }
            } else {

                /*
                 * this condition is met whenever a row exist in smartsheet
                 * but sugarcrm is not aware of it
                 * need to check existence of data via api call
                 */
                $GLOBALS['log']->fatal("create update case 3, row exist but sugarcrm unaware");
                $this->searchForRowIdInSmartsheet($job_number, $cells);
            }
            $iteration++;
        }
        $this->new_rows_for_update = json_encode($this->new_rows_for_update);
        $this->new_rows_for_create = json_encode($this->new_rows_for_create);
        
        
    }

    private function searchForRowIdInSmartsheet($job_number, $cells) {

        $url = $this->smart_sheet_helper->base_url . '/search/sheets/' . $this->sheet_id . '/?query=' . $job_number;
        $search_response = $this->smart_sheet_helper->retrieveFromSmartSheet($url);
        $search_response_result = $search_response->results;
        if (!empty($search_response_result)) {
            $row_id = $search_response_result[0]->objectId;
            //verifiy row first before assiging
            $verify_row_result = $this->getSmartSheetRowsFromId(array($row_id));

            /*
             * column sholud be dynamic
             * what if number col id is changed?
             */
            $searched_job_number = $verify_row_result[0]->cells[1]->value;

            if ($searched_job_number == $job_number) {

                if (!empty($cells)) {
                    $new_row_update = array(
                        'id' => $row_id,
                        'cells' => $cells,
                    );

                    array_push($this->new_rows_for_update, $new_row_update);
                }

                return true;
            }
        }

        $GLOBALS['log']->fatal("search response ", $search_response);
        $GLOBALS['log']->fatal("verify row result ", $verify_row_result);
        $GLOBALS['log']->fatal("searched job number ", $searched_job_number);
        $GLOBALS['log']->fatal("actual  job number ", $job_number);
        $GLOBALS['log']->fatal("cells ", $cells);
        $GLOBALS['log']->fatal("new row update ", $new_row_update);

        return false;
    }

    private function getFieldsUsingDirectionFilter($direction_filter) {
        $return_array = array();
        foreach ($this->field_mapping as $key => $value) {

            if ($value->direction == $direction_filter) {
                if (empty($value->option))
                    $return_array[$key] = $value->name;
                else {
                    $return_array[$key] = array(
                        'name' => $value->name,
                        'options' => $value->option,
                    );
                }
            }
        }
        return $return_array;
    }

    private function prepareCreateUpdateCallBackRows($events) {
        foreach ($events as $event) {

            if ($event->objectType == 'row' && $event->eventType == 'updated') {
                array_push($this->call_back_update_rows, $event);
                array_push($this->call_back_update_rows_id, $event->id);
            } elseif ($event->objectType == 'row' && $event->eventType == 'created') {
                array_push($this->call_back_new_rows, $event);
                array_push($this->call_back_new_rows_id, $event->id);
            } else if ($event->objectType == 'row' && $event->eventType == 'deleted') {
                array_push($this->call_back_delete_rows, $event);
                array_push($this->call_back_delete_rows_id, $event->id);
            }
        }
    }

    public function handleWebhookResponse() {

        require_once 'include/upload_file.php';
        $uf = new UploadFile();
        $uf->temp_file_location = 'php://input';
        $smartsheet_response = $file_contents = $uf->get_file_contents();
        $smartsheet_response = json_decode($smartsheet_response);
        $events = $smartsheet_response->events;
        $GLOBALS['log']->fatal("events ---->  ", $events);
        $this->prepareCreateUpdateCallBackRows($events);
        $this->syncSmartSheetToSugar();
    }

    private function sendNewSmartSheetRowsNotification() {

        $rows = $this->getSmartSheetRowsFromId($this->call_back_new_rows_id);



        if (!empty($rows)) {
            $bean = BeanFactory::getBean(self::PRIMARY_MODULE);
            foreach ($rows as $row) {
                $job_number = $row->cells[1]->value;
                $bean->retrieve_by_string_fields(array('job_number' => $job_number));
                if (!empty($bean->id)) {
                    continue;
                }
                $this->prepareEmailBodyForNewSmartSheetRows($row);
            }
        }

        if (strlen($this->new_smartsheet_records_email_body) > 0) {

            $template = new EmailTemplate();
            $template->retrieve_by_string_fields(array('name' => 'New Cam Records', 'type' => 'email'));
            $template->body_html = str_replace('$html_body', $this->new_smartsheet_records_email_body, $template->body_html);

            $admin = new Administration();
            $admin->retrieveSettings();
            $primary_sender_email = $admin->settings['smartsheet_email_id'];
            $GLOBALS['log']->fatal("Sending mail to id $primary_sender_email");
            $this->sendMail($primary_sender_email, $template);
        }
    }

    private function prepareEmailBodyForNewSmartSheetRows($row) {

        if (!empty($row)) {
            $job_number = $row->cells[1]->value;
            $this->new_smartsheet_records_email_body.=" <b>Row Number:</b> $row->rowNumber, <b>Job Number:</b> $job_number <br>";
        }
    }

    public function sendMail($emailId, EmailTemplate $template) {
        return true;
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $mail = new SugarPHPMailer();
        $mail->IsHTML(true);
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject = $template->subject;
        $mail->Body = from_html($template->body_html);
        $mail->prepForOutbound();
        $mail->AddAddress($emailId);
        $send = $mail->Send();
        if (!$send) {
            $GLOBALS['log']->fatal("Could not send Mail:  " . $mail->ErrorInfo);
        }
    }

    public function isWebHookEnabled($webhook_id, $extra_info = false) {
        if (!empty($webhook_id)) {
            $response = $this->smart_sheet_helper->retrieveFromSmartSheet($this->smart_sheet_helper->base_url . "/webhooks/$webhook_id");
            if ($response->enabled == 1 && $response->status == 'ENABLED') {

                if ($extra_info)
                    return $response;

                return true;
            }

            if ($extra_info)
                return $response;
        }
        return false;
    }

    private function handleSmartSheetApiLogs($api_response, $target_ids, $unsynced_records) {
        if (!empty($target_ids) && ($api_response->message != 'SUCCESS')) {

            $GLOBALS['log']->fatal('Api response Failed. Writing in logs', $target_ids);
            $additonal_details = '';
            $failed_job_number = '';
            if (!empty($api_response->detail->rowId)) {
                foreach ($unsynced_records as $record) {
                    if ($record['smartsheet_row_id'] == $api_response->detail->rowId) {
                        $failed_job_number = $record['job_number'];
                    }
                }
            }

            if (!empty($failed_job_number)) {
                $additonal_details = " $api_response->message, this is due to missing Job number: $failed_job_number in smartsheets. In order for sync to be successful you"
                        . " are advised to disable sync for record with Job Number: $failed_job_number and try again.";
            } else {
                //we dont know what error code and message is
                $additonal_details = "Message: ".$api_response->message;
                //parse addtional deatils
                foreach ($api_response->failedItems as $failed_records) {
                    $additonal_details.=" RowID: $failed_records->rowId , Error: {$failed_records->error->message} ";
                }
            }


            if (!empty($failed_job_number)) {
                //auto disable sync for records causing trouble
                $target_bean = BeanFactory::getBean(self::PRIMARY_MODULE);
                $target_bean->retrieve_by_string_fields(array(
                    'job_number' => $failed_job_number,
                ));

                if (!empty($target_bean->idupdate)) {
                    /*
                     * Culprit record found, 
                     * Auto disable sync by unchecking sync_cam_to_smartsheet field
                     * If Sugar to smartsheet schedular is enabled, other records will
                     * be synced automatically.
                     */
                    $target_bean->sync_cam_to_smartsheet = 0;
                    $target_bean->smartsheet_row_id = '';
                    $target_bean->sugar_to_smartsheet_sync = true;
                    $target_bean->save();
                }
            }

            return "Sync failed! " . $additonal_details;
        } else if ($api_response->message == 'SUCCESS') {

            $GLOBALS['log']->fatal('Api response Succes. Writing in logs', $target_ids);
            $time_now = $GLOBALS['timedate']->nowDb();
            return "Sync successfully at $time_now";
        } else {
            $GLOBALS['log']->fatal('Api response missing case. Writing in logs', $target_ids);
            return '';
        }
    }

    public function enableWebHook($webhook_id) {
        if (!empty($webhook_id)) {

            $url = $this->smart_sheet_helper->base_url . "/webhooks/$webhook_id";
            $json = array('enabled' => true);

            return $this->smart_sheet_helper->updateSmartSheet($url, json_encode($json));
        }
    }

}
