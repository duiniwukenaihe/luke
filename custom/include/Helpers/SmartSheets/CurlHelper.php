<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CurlHelper {

    private $access_token;

    public function __construct($token) {
        $this->access_token = $token;
    }

    /*
     * $params 
     * type 
     * url 
     * data
     */
    public function execute($params) {

        switch ($params['type']) {
            
            case 'PUT':
                //$headers = array("Authorization: Bearer " . $this->access_token, "Content-type: application/json");
                $curlSession = curl_init($params['url']);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['headers']);
                curl_setopt($curlSession, CURLOPT_POSTFIELDS, $params['data']);
                curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "PUT");
                $getSheetResponseData = curl_exec($curlSession);
                return json_decode($getSheetResponseData);

            case 'DELETE':
                //$headers = array("Authorization: Bearer " . $this->access_token, "Content-type: application/json");
                $curlSession = curl_init($params['url']);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['headers']);
                curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "DELETE");
                $getSheetResponseData = curl_exec($curlSession);
                var_dump($getSheetResponseData);
                return json_decode($getSheetResponseData);
                
            case 'POST':

                //$headers = array("Authorization: Bearer " . $this->access_token, "Content-type: application/json");
                $curlSession = curl_init($params['url']);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['headers']);
                curl_setopt($curlSession, CURLOPT_POSTFIELDS, $params['data']);
                curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "POST");
                $getSheetResponseData = curl_exec($curlSession);
                //var_dump($getSheetResponseData);
                return json_decode($getSheetResponseData);

            case 'GET':

                //$headers = array("Authorization: Bearer " . $this->access_token);
                $curlSession = curl_init($params['url']);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['headers']);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
                $getSheetResponseData = curl_exec($curlSession);
                return json_decode($getSheetResponseData);
        }
    }

}
