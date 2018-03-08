<?php

require_once 'custom/include/MailChimp/MailChimpLogger.php';

class MailChimp {
    
    /**
     * $api_url MailChimp API endpoint
     * @var string
     */
    public $api_url = "https://<dc>.api.mailchimp.com/3.0";
	
    /**
     * $api_key API key
     * @var string
     */
    public $api_key = '';
	
    /**
     * $ch CURL Handler
     * @var null
     */
    public $ch = null;

    /**
     * $debug Debugging on|off
     * @var boolean
     */
	public $debug = false;

    /**
     * $print MailChimp Logger Object
     * @var object
     */
    public $print;

    /**
     * $level MailChimp Logger Level
     * @var string
     */
	public $level = 'debug';

    /**
     * $timeout CURL Request Timeout
     * @var integer
     */
	public $timeout = 10;

    /**
     * $response CURL Response
     * @var array
     */
	public $response = array();
	
    /**
     * $curl_info CURL Response Information
     * @var array
     */
    public $curl_info = array();
	
    /**
     * $curl_error CURL Error Detail
     * @var array
     */
    public $curl_error = array();

    /**
     * $curl_errno CURL Error Number
     * @var array
     */
	public $curl_errno = array();
	
    /**
     * $verify_ssl CURL Verify SSL
     * @var boolean
     */
    public $verify_ssl = true;
	
    /**
     * $last_response CURL Last Call Response
     * @var array
     */
    private $last_response = array();
	
    /**
     * $api_state API State
     * @var string
     */
    private $api_state = 'active';
	
    /**
     * $request Request
     * @var array
     */
    private $request = array();

    /**
     * MailChimp constructor.
     * @param string $api_key
     * @param array $options
     */
	public function __construct($api_key = '', $options = array()) {
	    if(!empty($api_key)) {
            $this->api_key = $api_key;
        }
        $this->print = new MailChimpLogger();
		$this->retrieveApiCredentials();

		if(!empty($options['debug'])) {
			$this->debug = $options['debug'];
		}

		if(!empty($options['timeout'])) {
			$this->timeout = $options['timeout'];
		}

	}

    /**
     * Retireve mailchimp settings from config
     */
	private function retrieveApiCredentials() {
        $admin = new Administration();
        $admin->retrieveSettings();
        if(empty($this->api_key) && !empty($admin->settings) && !empty($admin->settings['mailchimp_api_key'])) {
            $this->api_key = $admin->settings['mailchimp_api_key'];
        }

        if(empty($this->api_key) || strpos($this->api_key, '-') === false) {
            $this->print->log($this->level, "Invalid API key.");
            $this->api_state = 'inactive';
        } else {
            list(, $data_center) = explode('-', $this->api_key);
            $this->api_url  = str_replace('<dc>', $data_center, $this->api_url);
        }
    }

    /**
     * @param string $http_verb (get, post, put, patch, delete)
     * @param string $method list, member, campaign etc
     * @param array $args
     * @return array|false
     */
	public function call($http_verb, $method, $args = array()) {
        if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
            $this->print->log($this->level, "cURL support is required, but can't be found.");
            return false;
        }
        if($this->api_state == 'inactive') {
            return false;
        }

        $api_url = rtrim($this->api_url, '/') . '/' . $method;

        $this->ch = curl_init($api_url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($this->ch, CURLOPT_USERPWD, 'apikey:'.$this->api_key);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
        curl_setopt($this->ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);

        switch ($http_verb) {
            case 'post':
                curl_setopt($this->ch, CURLOPT_POST, 1);
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->prepareRequestParams($args)));
                break;
            case 'get':
                $query = http_build_query($this->prepareRequestParams($args), '', '&');
                curl_setopt($this->ch, CURLOPT_URL, $api_url . '?' . $query);
                break;
            case 'delete':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'patch':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->prepareRequestParams($args)));
                break;
            case 'put':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->prepareRequestParams($args)));
                break;
        }

        $this->request['verbose'] = $http_verb;
        $this->request['method'] = $method;
        $this->request['arguments'] = $args;
        $this->request['api_url'] = $api_url;

        $response = $this->formatResponse(curl_exec($this->ch));
        $this->curl_info = curl_getinfo($this->ch);
        $this->curl_error = curl_error($this->ch);
        $this->curl_errno = curl_errno($this->ch);

        $this->response = $this->prepareResponse($response);
        return $this->response;
    }

    /**
     * Decode the response and format any error messages for debugging
     * @param array $response The response from the curl request
     * @return array|false    The JSON decoded into an array
     */
    private function prepareResponse($response) {
        $request = json_encode($this->request);
        if(isset($response['errors']) || (isset($response['status']) && $response['status'] == '404')) {
            $response['errors'] = !empty($response['errors']) ? $response['errors'] : 'Something went wrong.';
            $this->print->log($this->level, "Type: " . $response['type'] . ". Status: " . $response['status'] . ". Title: " . $response['title'] . ". Details: ". $response['detail'] . ". Errors: " . json_encode($response['errors']) . ". Request : " . $request);
            return false;
        } else if($this->curl_info['http_code'] != 200) {
            $code = $this->curl_info['http_code'];
            if($code > 200 && $code <= 206) {
                $this->print->log($this->level, "Status: " . $code . ". Title:  Request successful but not completed. Details: Unexpected failure. Try later time. Request : " . $request);
            } else if($code >= 400 && $code <= 417) {
                $this->print->log($this->level, "Status: " . $code . ". Title:  Bad Request. Details: Unexpected failure. Try later time. Request : " . $request);
            } else {
                $this->print->log($this->level, "Status: " . $code . ". Title:  Resource not found. Details: Unexpected failure. Try later time. Request : " . $request);
            }
            return false;
        } else if(!empty($this->curl_errno)) {
            $this->print->log($this->level, "Status: " . $this->curl_errno . ". Title: Curl Error - " . $this->curl_error . ". Details: ". curl_strerror($this->curl_errno).". Request : " . $request);
            return false;
        }
        return $response;
    }

    /**
     * Decode the response and format any error messages for debugging
     * @param array $response The response from the curl request
     * @return array|false    The JSON decoded into an array
     */
    private function formatResponse($response) {
        $this->last_response = $response;
        if (!empty($response)) {
            return json_decode($response, true);
        }
        return false;
    }

    /**
     * @param array $params
     * @return array
     */
    private function prepareRequestParams(array $params = array()) {
        if(!empty($params)) {
            foreach($params as $key=>$value){
                if((empty($value) || $value == '') && $value !== 0){
                    unset($params[$key]);
                }
            }
        }
        return $params;
    }

    /**
     * MailChimp destructor
     */
    public function __distruct() {
        if(is_resource($this->ch)) {
            curl_close($this->ch);
        }
    }

}