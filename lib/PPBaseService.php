<?php
require_once 'PPAPIService.php';


class PPBaseService {

	private $serviceName;
	private $serviceBinding;
	private $handlers;

   /*
    * Setters and getters for Third party authentication (Permission Services)
    */
	protected $accessToken;
	protected $tokenSecret;
	protected $lastRequest;
	protected $lastResponse;

    public function getLastRequest() {
		return $this->lastRequest;
	}
    public function setLastRequest($lastRqst) {
		$this->lastRequest = $lastRqst;
	}
    public function getLastResponse() {
		return $this->lastResponse;
	}
    public function setLastResponse($lastRspns) {
		$this->lastResponse = $lastRspns;
	}

	public function getAccessToken() {
		return $this->accessToken;
	}
	public function setAccessToken($accessToken) {
		$this->accessToken = $accessToken;
	}
	public function getTokenSecret() {
		return $this->tokenSecret;
	}
	public function setTokenSecret($tokenSecret) {
		$this->tokenSecret = $tokenSecret;
	}

	public function __construct($serviceName, $serviceBinding, $handlers=array()) {
		$this->serviceName = $serviceName;
		$this->serviceBinding = $serviceBinding;
		$this->handlers = $handlers;
	}

	public function getServiceName() {
		return $this->serviceName;
	}

	/**
	 * 
	 * @param string $method - API method to call
	 * @param object $requestObject Request object 
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 */
	public function call($port, $method, $requestObject, $apiCredential = null) {		
		$service = new PPAPIService($port, $this->serviceName, 
				$this->serviceBinding, $this->handlers);		
		$ret = $service->makeRequest($method, $requestObject, $apiCredential,
				$this->accessToken, $this->tokenSecret);
		$this->lastRequest = $ret['request'];
		$this->lastResponse = $ret['response'];
		return $this->lastResponse;
	}

    private function marshall($object) {
		$transformer = new PPObjectTransformer();
		return $transformer->toString($object);
	}
}
?>
