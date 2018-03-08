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
    const DIRECTION_SUGAR_TO_SMARTSHEET='sugar_to_smartsheet';
    const DIRECTION_SMARTSHEET_TO_SUGAR='smartsheet_to_sugar';
    const DIRECTION_BIDIRECTIONAL='';

    public function __construct($sheet_id) {
        $this->sheet_id = $sheet_id;
        $this->smart_sheet_helper = new SmartSheetApiHelper();
        $this->field_mapping = $this->getSmartsheetFieldMappings($this->sheet_id);
        $this->field_mapping_arr = $this->objectToArray($this->field_mapping);
        $this->new_rows_for_create = array();
        $this->new_rows_for_update = array();
        $this->message_logs="";
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

    public function syncSugarToSmartSheet($optional_where = null) {

        $sugar_to_smartsheet_fields=$this->getFieldsUsingDirectionFilter(self::DIRECTION_SUGAR_TO_SMARTSHEET);        
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
        
        
        $pushed_sugar_ids = array();
        $this->prepareCreateUpdateRowData($sugar_to_smartsheet_fields,$result, $pushed_sugar_ids);
        $update_params['data'] = $this->new_rows_for_update;
        
        
        //update
        $update_response = $this->smart_sheet_helper->updateRowBulk($this->sheet_id, $update_params);
        $this->handleSmartSheetCreateUpdateResponse($update_response, $pushed_sugar_ids);
        
        
        //we only want creation on run time via manual sync
        //send email notifincation at this about against all
        //new records that are not present is smartsheet
        //create
        /*****Only uncomment to sync new records*****/
        /*$create_response = $this->smart_sheet_helper->createRow($this->sheet_id, $this->new_rows_for_create);
        $this->handleSmartSheetCreateUpdateResponse($create_response, $pushed_sugar_ids);*/
                
        return $this->message_logs;
    }

    private function handleSmartSheetCreateUpdateResponse($create_response, $pushed_sugar_ids) {
        if (!empty($create_response)) {
            $module = 'm_CAMS';
            $smart_sheet_result = $create_response->result;

            foreach ($smart_sheet_result as $row_info_key => $row_info_value) {

                $time = '';
                if (!empty($row_info_value->modifiedAt)) {
                    $datetime = new DateTime($row_info_value->modifiedAt);
                    $time = $datetime->format('Y-m-d H:i:s');
                }

                $params = array(
                    'smartsheet_modified_at' => $time,
                    'smartsheet_row_id' => $row_info_value->id,
                        //'smartsheet_row_number' => $row_info_value->rowNumber;
                );

                $cam_bean_id = $pushed_sugar_ids[$row_info_key];
                $fields_value = $this->getCamsFieldMappingForUpdate($params);
                $fields_value['sugar_to_smartsheet_sync'] = true;
                $this->updateSugarCrm($fields_value, $module, $cam_bean_id);
            }
        }
    }

    private function getCamsFieldMappingForUpdate($params) {

        return array(
            'has_synchronized' => true,
            'smartsheet_modified_at' => $params['smartsheet_modified_at'],
            'smartsheet_row_id' => $params['smartsheet_row_id'],
        );
    }

    private function updateSugarCrm($fields_value, $module, $id) {

        $this->message_logs.= "fields value " . var_dump($fields_value) . "<br>";
        $this->message_logs.= "id $id <br>";
        
        $GLOBALS['log']->fatal('message',$this->message_logs);
        if (!empty($module) && !empty($id) && is_array($fields_value)) {
            $bean = BeanFactory::getBean($module);
            $bean->retrieve($id);
            if (!empty($bean->id)) {
                foreach ($fields_value as $key => $value) {
                    $bean->$key = $value;
                }
                $bean->save();
                return $bean->id;
            }
            return -1;
        }
        return -1;
    }

    public function syncSmartSheetToSugar() {

        $last_run_time = $this->getLastSchedulerSyncTime();
        $rows = $this->smart_sheet_helper->getAllRows();
        $smartsheet_to_sugar_fields=$this->getFieldsUsingDirectionFilter(self::DIRECTION_SMARTSHEET_TO_SUGAR);
        $count = 0;
        
        //$this->smart_sheet_helper->dd($rows,true);
        foreach ($rows as $row) {
            $this->createUpdateCamRecord($row,$smartsheet_to_sugar_fields);
            $count++;
        }
    }

    /*
     * params $row
     * $row must be std class object returned from API
     * 
     */

    private function createUpdateCamRecord($row,$smartsheet_to_sugar_fields) {

        //$GLOBALS['log']->fatal("row id".$row->id."<br>");
        
        if (!empty($row) && !empty($row->cells[1]->value)) {
            $GLOBALS['log']->fatal("row value -->".$row->cells[1]->value);
            $cam_bean = BeanFactory::getBean('m_CAMS');
            $job_number = $row->cells[1]->value;
            $cam_bean->retrieve_by_string_fields(array('job_number' => trim($job_number)));
            $cam_bean->smartsheet_row_id = $row->id;
            $cam_bean->smartsheet_modified_at = $row->modifiedAt;
            $cam_bean->has_synchronized = 1;
            $cam_bean->sugar_to_smartsheet_sync = true;
            $GLOBALS['log']->fatal("bean id ".$cam_bean->id);
            $this->mapSmartsheetCellWithSugarField($smartsheet_to_sugar_fields,$row, $cam_bean);
            echo "check bean $cam_bean->id  $cam_bean->job_number  $cam_bean->construction_stage <br>";
            $cam_bean->save();
        }
    }

    private function mapSmartsheetCellWithSugarField($smartsheet_to_sugar_fields,$row, &$bean) {

        foreach ($row->cells as $cell) {
            $field_name = $smartsheet_to_sugar_fields[$cell->columnId];
            if (!empty($field_name)) {
                if(!empty($cell->value) && $cell->value != "1" ){
                   $bean->$field_name = $cell->value; 
                }
                if(is_array($field_name) && $cell->value == "1") {
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

    private function prepareCreateUpdateRowData($field_mapping,$result, &$pushed_sugar_ids) {
        $inverse_field_mapping = array_flip($field_mapping);
        $new_rows = array();
        $new_row = null;
        $iteration = 0;
        
        
        
        foreach ($result as $key => $value) {
            echo "in loop";
            $cells = array();
            foreach ($value as $field_name => $field_value) {
                $col_id = $inverse_field_mapping[$field_name];

                if ($field_name == 'id') {
                    array_push($pushed_sugar_ids, $field_value);
                } else if (!empty($col_id)) {
                    array_push($cells, array(
                        'columnId' => $col_id,
                        'value' => $field_value,
                    ));
                }
            }
            if (isset($result[$iteration]['smartsheet_row_id']) && !empty($result[$iteration]['smartsheet_row_id'])) {
                echo "in update";
                $new_row_update = array(
                    'id' => $result[$iteration]['smartsheet_row_id'],
                    'cells' => $cells,
                );

                array_push($this->new_rows_for_update, $new_row_update);
            } else {
                $new_row_update = array(
                    'toBottom' => true,
                    'cells' => $cells,
                );
                array_push($this->new_rows_for_create, $new_row_update);
            }
            $iteration++;
        }
        $this->new_rows_for_update = json_encode($this->new_rows_for_update);
        $this->new_rows_for_create = json_encode($this->new_rows_for_create);
        
        
    }
    
    private function getFieldsUsingDirectionFilter($direction_filter) {
        $return_array=array();
        foreach($this->field_mapping as $key => $value) {
            
            if($value->direction == $direction_filter) {
                if(empty($value->option))
                    $return_array[$key]=$value->name;
                else {
                    $return_array[$key]=array(
                        'name' => $value->name,
                        'options' => $value->option,
                    );
                }
            }
        }
        return $return_array;
    }
    
}

/*echo "<form method='post' action='#bwc/index.php?entryPoint=test'>"
 . "<input type='hidden' name='mode' value='a'>"
 . "<input class='button' type='submit' value='Sync Sugar To SmartSheet'></input> </form>";

echo "<form method='post' action='#bwc/index.php?entryPoint=test'>"
 . "<input type='hidden' name='mode' value='b'>"
 . "<input class='button' type='submit' value='SmartSheet to Sugar'></input> </form>";
*/

/*if ($_REQUEST['mode'] == 'a') {
    
    echo "start";
    $smart_sheet_synchronizer = new smartSheetSynchronizer('2622275372509060');
    //$smart_sheet_synchronizer->syncSugarToSmartSheet(" sync_cam_to_smartsheet='1' ");
    $smart_sheet_synchronizer->syncSugarToSmartSheet();
    
    echo "<br> sugar to smartsheet sync completed! <br>";
    
} elseif ($_REQUEST['mode'] == 'b') {
    
    $smart_sheet_synchronizer = new smartSheetSynchronizer('2622275372509060');
    $smart_sheet_synchronizer->syncSmartSheetToSugar();
    
    echo "<br> Smartsheet to sugar sync completed <br>";
    
}*/
