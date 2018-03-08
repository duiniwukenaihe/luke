<?php
/*
 * Copyright 2013 DocuSign Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once 'DocuSign_IO.php';

class DocuSign_CurlIO extends DocuSign_IO {

	public $apiTraceLog;

	public function __construct($apiTraceLog = false) {
		$this->apiTraceLog = $apiTraceLog;
	}

	public function makeRequest($url, $method = 'GET', $headers = array(), $params = array(), $data = NULL) {
		if ($this->apiTraceLog) {
			$requestMessage = "DocuSign API Request:\n  $method $url\n  $data\n\n";

		}

		$curl = curl_init($url . '?' . http_build_query($params, NULL, '&'));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		switch (strtoupper($method)) {

			case 'GET':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
				break;
                        case 'POST':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;

			case 'PUT':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;

			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;

			default:
				break;
      	}

		try {
			$result = curl_exec($curl);
			if( curl_error($curl) != '' ) {
				throw new DocuSign_IOException(curl_error($curl));
			}
			$jsonResult = json_decode($result);
			$response = (!is_null($jsonResult)) ? $jsonResult : $result;
		} catch(Exception $e) {
			throw new DocuSign_IOException($e);
		}
		
		curl_close($curl);

		if (is_a($response, 'stdClass') && property_exists($response, 'errorCode')) {
			$error = $response->errorCode . ': ' . $response->message;

			if ($this->apiTraceLog) {
				$errorMessage = "DocuSign API Error:\n  $error\n\n";

			}

			throw new DocuSign_IOException($error);
		}

		if ($this->apiTraceLog) {
			$responseMessage = "DocuSign API Response:\n  " . json_encode($response) . "\n\n";

		}

		return $response;
	}

}

?>
