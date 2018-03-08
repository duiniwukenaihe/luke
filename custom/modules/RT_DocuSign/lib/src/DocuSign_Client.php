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

if (! function_exists('json_decode')) {
  throw new Exception('DocuSign PHP API Client requires the JSON PHP extension');
}

if (! function_exists('curl_version')) {
  throw new Exception('DocuSign PHP API Client requires the PHP Client URL Library');
}

if (! function_exists('http_build_query')) {
  throw new Exception('DocuSign PHP API Client requires http_build_query()');
}

if (! ini_get('date.timezone') && function_exists('date_default_timezone_set')) {
  date_default_timezone_set('UTC');
}

// hack around with the include paths a bit so the library 'just works'
set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());

require_once 'config.php';
require_once 'io/DocuSign_Creds.php';
require_once 'io/DocuSign_CurlIO.php';
require_once 'service/DocuSign_Model.php';
require_once 'service/DocuSign_Resource.php';

class DocuSign_Client {

    // The DocuSign Credentials
    public $creds;

	// The version of DocuSign API
	public $version;

    // The DocuSign Environment
    public $environment;

    // The base url of the DocuSign Account
    public $baseURL;

    // The DocuSign Account Id
    public $accountID;

    // The DocuSign "Send On Behalf Of" User
    public $soboUser;

    // The DocuSign_CurlIO class
    public $curl;

    // The flag indicating if it has multiple DocuSign accounts
    public $hasMultipleAccounts = false;

    public $hasError = false;

    public $errorMessage = '';

	public function __construct($config = NULL) {
		global $apiConfig;
		global $apiConfigTraceLogFlag;

		if (!isset($config)) {
			// Use config settings in the config.php
			$config = $apiConfig;
		}

		$this->creds = new DocuSign_Creds($config['integrator_key'], $config['email'], $config['password'], $config['oauth_token']);
		if (!empty($config['version'])) $this->version = $config['version'];
		if (!empty($config['environment'])) $this->environment = $config['environment'];
		if (!empty($config['account_id'])) $this->accountID = $config['account_id'];
		if (!empty($config['sobo_user'])) $this->soboUser = $config['sobo_user'];

		$this->curl = new DocuSign_CurlIO($apiConfigTraceLogFlag);

		if ($this->creds->hasOauthToken()) {
			// no need to log into DS if using OAuth
			// ...but we need to use the base URL given in the config object since we're not calling Login
			$this->baseURL = $config['base_url'];

		} else if (!$this->creds->isEmpty()) {
			self::authenticate();
		} else {
			// you can potentially make this a warning instead of error if you'd like, depends on
			// how you want to handle missing api credentials...
			$this->hasError = true;
			$this->errorMessage = "One or more missing config settings found.  Please check config.php, or pass in required credentials to DocuSign_Client class constructor.";
		}
	}
	
	public function authenticate() {
		$url = 'https://' . $this->environment . '.docusign.net/restapi/' . $this->version . '/login_information';
		try {
		 	$response = $this->curl->makeRequest($url, 'GET', $this->getHeaders());
		} catch (DocuSign_IOException $e) {
			$this->hasError = true;
			$this->errorMessage = $e->getMessage();
			return;
		}

		$this->hasMultipleAccounts = count($response->loginAccounts) > 1;

		$defaultBaseURL = '';
		$defaultAccountID = '';
		foreach($response->loginAccounts as $account) {
			if( !empty($this->accountID) ) {
				if( $this->accountID == $account->accountId ) {
					$this->baseURL = $account->baseUrl;
					break;
				}
			}
			if( $account->isDefault == 'true' ) { 
				$defaultBaseURL = $account->baseUrl;
				$defaultAccountID = $account->accountId;
			}
		}
		if(empty($this->baseURL)) {
			$this->baseURL = $defaultBaseURL;
			$this->accountID = $defaultAccountID;
		}

		return $response;
	}

	public function createOauthToken() {
		$url = preg_replace('#(https://\w+.docusign.net/restapi/v\d+)/accounts/\d+#', '$1/oauth2/token', $this->getBaseURL());

		$headers = $this->getHeaders('Accept: application/json', 'Content-Type: application/x-www-form-urlencoded');
		$data = http_build_query(array(
			'grant_type' => 'password',
			'client_id' => $this->creds->getIntegratorKey(),
			'username' => $this->creds->getEmail(),
			'password' => $this->creds->getPassword(),
			'scope' => 'api',
		));

		$response = $this->curl->makeRequest($url, 'POST', $headers, array(), $data);
		if (property_exists($response, 'error')) {
			throw new DocuSign_IOException($response->error. ': ' . $response->error_description);
		}

		return $response->access_token;
	}

	public function getCreds() { return $this->creds; }
	public function getVersion() { return $this->version; }
	public function getEnvironment() { return $this->environment; }
	public function getBaseURL() { return $this->baseURL; }
	public function getAccountID() { return $this->accountID; }
	public function getSoboUser() { return $this->soboUser; }
	public function getCUrl() { return $this->curl; }

	public function hasMultipleAccounts() { return $this->hasMultipleAccounts; }
	public function hasError() { return $this->hasError; }
	public function getErrorMessage() { return $this->errorMessage; }

	public function getHeaders($accept = 'Accept: application/json', $contentType = 'Content-Type: application/json', $useSobo = false) {
		$headers = array();

		if ($this->creds->hasOauthToken()) {
			$headers[] = 'Authorization: bearer ' . $this->creds->getOauthToken();
			if ($useSobo) {
				$headers[] = 'X-DocuSign-Act-As-User: ' . $this->getSoboUser();
			}
		} else { // use password authentication
			$soboString = $useSobo ? '<SendOnBehalfOf>' . $this->getSoboUser() . '</SendOnBehalfOf>' : '';
			$headers[] = 'X-DocuSign-Authentication: <DocuSignCredentials>' . $soboString . '<Username>' . $this->creds->getEmail() . '</Username><Password>' . $this->creds->getPassword() . '</Password><IntegratorKey>' . $this->creds->getIntegratorKey() . '</IntegratorKey></DocuSignCredentials>';
		}

		$headers[] = $accept;
		$headers[] = $contentType;

		return $headers;
	}
}

// Exceptions that the DocuSign PHP API Library can throw
class DocuSign_Exception extends Exception {}
class DocuSign_AuthException extends DocuSign_Exception {}
class DocuSign_IOException extends DocuSign_Exception {}

?>
