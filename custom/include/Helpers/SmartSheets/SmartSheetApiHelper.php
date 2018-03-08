<?php

require_once 'CurlHelper.php';

class SmartSheetApiHelper {

    public $access_token;
    public $base_url;
    private $curl_helper;
    //$admin->settings['smartsheet_api_key'];
    public function __construct() {;
        $this->base_url = "https://api.smartsheet.com/2.0";
        $admin = new Administration();
        $admin->retrieveSettings();
        $this->access_token = $admin->settings['smartsheet_api_key']; //'2jijxauztjemvjyskyxqam57u';
        $this->curl_helper = new CurlHelper($this->access_token);
    }

    public function retrieveFromSmartSheet($sheet_url) {

        try {
            $params = array(
                'type' => 'GET',
                'url' => $sheet_url,
                'headers' => array("Authorization: Bearer " . $this->access_token),
            );
            return $this->curl_helper->execute($params);
        } catch (Exception $ex) {
            // log exeption here           
        }
    }

    public function updateSmartSheet($sheet_url, $data) {

        try {
            $params = array(
                'type' => 'PUT',
                'url' => $sheet_url,
                'headers' => array("Authorization: Bearer " . $this->access_token, "Content-type: application/json"),
                'data' => $data,
            );
            return $this->curl_helper->execute($params);
        } catch (Exception $ex) {
            // log exeption here           
        }
    }

    public function removeFromSmartSheet($sheet_id, $data) {

        try {
            $url = $this->base_url . "/sheets/$sheet_id/rows?ids=3916685853910916";

            $params = array(
                'type' => 'DELETE',
                'url' => $url,
                'headers' => array("Authorization: Bearer " . $this->access_token, "Content-type: application/json"),
            );
            return $this->curl_helper->execute($params);
        } catch (Exception $ex) {
            // log exeption here           
        }
    }

    private function prepareRowIdStr($row_ids) {
        $str = '';
        foreach ($row_ids as $id) {
            
        }
    }

    public function getAllRows($sheet_id = '2622275372509060') {
        $sheet = $this->retrieveFromSmartSheet($this->base_url . "/sheets/$sheet_id");
        return $sheet->rows;
    }

    public function getAllColumns($sheet_id) {
        if (!empty($sheet_id)) {
            $sheet = $this->retrieveFromSmartSheet($this->base_url . "/sheets/$sheet_id");
            return $sheet->columns;
        }
    }

    public function updateRow($params) {
        if (!empty($params)) {
            $fields = '[{"id":' . $params['row_id'] . ',"cells": [{"columnId":' . $params['col_id'] . ', "value": "' . $params['value'] . '", "displayValue": "' . $params['display_value'] . '"}]}]';
            $url = $this->base_url . "/sheets/{$params['sheet_id']}/rows";
            return $this->updateSmartSheet($url, $fields);
        }
    }

    public function dd($data, $die = false, $die_msg = '') {
        echo "<pre>";
        print_r($data);
        if ($die)
            die($die_msg);
        echo "</pre>";
    }

    //
    public function createWebHook($params) {

        try {
            //32 

            $data = '{ "name": ' . $params['name'] . ', "callbackUrl": ' . $params['callback_url'] . ', "scope": "sheet", "scopeObjectId": ' . $params['sheet_id'] . ', "version": 1, "events": [ "*.*" ]}';

            $data = '{ "name": "Webhook #1", "callbackUrl": "https://staging3.rolustech.com:44323/ss_callback.php", "scope": "sheet", "scopeObjectId": 2622275372509060, "version": 1, "events": [ "*.*" ]}';
            $url = $this->base_url . "/webhooks/";
            $headers = array("Authorization: Bearer " . $this->access_token, "Content-type: application/json");
            $curlSession = curl_init($url);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "POST");
            $getSheetResponseData = curl_exec($curlSession);
            var_dump($getSheetResponseData);
            return json_decode($getSheetResponseData);
        } catch (Exception $ex) {
            // log exeption here           
        }
    }

    public function updateWebHook($webhook_id) {
        $url = $this->base_url . "/webhooks/$webhook_id";
        $fields = '{ "enabled": true }';
        return $this->updateSmartSheet($url, $fields);
    }

    public function getSmartSheetByTime($date_time, $sheet_id) {
        try {

            if (!empty($date_time)) {

                $url = $this->base_url . "/search/sheets/?query=''";
                return $this->retrieveFromSmartSheet($url);
            }
        } catch (Exception $ex) {
            
        }
    }

    public function getAllSheets() {

        $response = $this->retrieveFromSmartSheet($this->base_url . "/sheets?includeAll=true");
        return $response;
        /*
          $flag=true;
          while($flag && !empty($response->data)) {
          // for paination
          } */
    }

    public function createRow($sheet_id, $data) {
        try {
            $url = $this->base_url . "/sheets/$sheet_id/rows";

            $params = array(
                'type' => 'POST',
                'data' => $data,
                'url' => $url,
                'headers' => array("Authorization: Bearer " . $this->access_token, "Content-type: application/json"),
            );
            return $this->curl_helper->execute($params);
        } catch (Exception $ex) {
            // log exeption here
        }
    }

    public function updateRowBulk($sheet_id, $params) {
        if (is_array($params) && !empty($sheet_id) && !empty($params['data'])) {
            $url = $this->base_url . "/sheets/$sheet_id/rows";
            return $this->updateSmartSheet($url, $params['data']);
        }
    }

    public function getFieldOptionsFromMoldule($module, $field_name, $id_name_count, $selected) {

        if (!empty($module) && !empty($field_name)) {
            require_once 'custom/modules/Administration/views/view.smartsheetconfig.php';
            $customview = new AdministrationViewSmartSheetConfig();
            $bean = BeanFactory::getBean($module);
            $var_def = $bean->getFieldDefinition($field_name);
            return $customview->getFieldOptions($field_name, $var_def['options'], $id_name_count, $selected);
        }
        return "";
    }
    
    public function validateSmartSheetKey($sheet_url,$access_token) {
        try {
            $params = array(
                'type' => 'GET',
                'url' => $sheet_url,
                'headers' => array("Authorization: Bearer " . $access_token),
            );
            return $this->curl_helper->execute($params);
        } catch (Exception $ex) {
            // log exeption here           
        }
    }

}