<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Google_Client.php';
require_once 'contrib/Google_Oauth2Service.php';
class Google{
	private $client;
	public function __construct($config = array()) {
		$this->client = new Google_Client();
		$this->client->setApplicationName('Login to Sanwebe.com');
		$this->client->setClientId($config['google_client_id']);
		$this->client->setClientSecret($config['google_client_secret']);
		$this->client->setRedirectUri($config['google_redirect_url']);
		//$this->client->setDeveloperKey($config['google_developer_key']);	
		//$this->client->setAccessToken($token);
	}
	
	public function Google_Oauth2Service(){
	return new Google_Oauth2Service($this->client);
	}
	public function createAuthUrl(){
	 return $this->client->createAuthUrl();
	}
	
	public function authenticate($code){
	return $this->client->authenticate($code);
	}
	
	public function getAccessToken(){
	  return $this->client->getAccessToken();
	}
  
	public function setAccessToken($token){
		return $this->client->setAccessToken($token);
	}

}
