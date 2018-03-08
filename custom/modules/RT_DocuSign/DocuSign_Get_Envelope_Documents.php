<?php

require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_Service.php';
require_once 'custom/modules/RT_DocuSign/lib/src/service/DocuSign_Resource.php';

class DocuSign_Get_Envelope_Documents extends DocuSign_Service {
	
	public $envelope;
	public function __construct(DocuSign_Client $client) {
		parent::__construct($client);
		$this->envelope = new RT_DocuSign_EnvelopeResource($this);
	}
}

class RT_DocuSign_EnvelopeResource extends DocuSign_Resource {

	public function getEnvelopeDocumentsContents($envelopeId, $certificate = true,$documentID) {
		if (!preg_match("/^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/i",$envelopeId))
		{
			return "Bad Request:  Invalid Envelope Id \"$envelopeId\".\nEnvelope Id should be a 32 digit GUID in following format:  1a2b3c4d-1a2b-1a2b-1a2b-1a2b3c4d5e6f\n";
		}
		$url = $this->client->getBaseURL() . '/envelopes/' . $envelopeId . '/documents/'.$documentID;
		$params = (is_bool($certificate) === true) ? array( 'certificate' => 'true') : array();
		return $this->curl->makeRequest($url, 'GET', $this->client->getHeaders('Accept: application/pdf', 'Content-Type: application/pdf'), $params);
	}

}

?>