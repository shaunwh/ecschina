<?php
class Vfeelit_RestConnect_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction() {
		//Basic parameters that need to be provided for oAuth authentication
		//on Magento
        $params = array(
            'siteUrl' => 'http://learn.magento.com/oauth',
            'requestTokenUrl' => 'http://learn.magento.com/oauth/initiate',
            'accessTokenUrl' => 'http://learn.magento.com/oauth/token',
            'authorizeUrl' => 'http://learn.magento.com/admin/oAuth_authorize',//This URL is used only if we authenticate as Admin user type
            'consumerKey' => 'vnh9icj7kbpynggc4dub84jb25ommnw7',//Consumer key registered in server administration
            'consumerSecret' => 'g5zz1yiy5pwp7zfy943nm26h6xscwysn',//Consumer secret registered in server administration
            'callbackUrl' => 'http://learn.magento.com/restconnect/index/callback',//Url of callback action below
        );
		$oAuthClient = Mage::getModel('restconnect/oauth_client');
		$oAuthClient->reset();
		$oAuthClient->init($params);
		$oAuthClient->authenticate();
		return;
	}
	public function callbackAction() {
		$oAuthClient = Mage::getModel('restconnect/oauth_client');
		$params = $oAuthClient->getConfigFromSession();
		$oAuthClient->init($params);
		$state = $oAuthClient->authenticate();
		if ($state == Vfeelit_RestConnect_Model_OAuth_Client::OAUTH_STATE_ACCESS_TOKEN) {
			$acessToken = $oAuthClient->getAuthorizedToken();
		}
		$restClient = $acessToken->getHttpClient($params);
		// Set REST resource URL
		$restClient->setUri('http://learn.magento.com/api/rest/products');
		// In Magento it is neccesary to set json or xml headers in order to work
		$restClient->setHeaders('Accept', 'application/json');
		// Get method
		$restClient->setMethod(Zend_Http_Client::GET);
		//Make REST request
		$response = $restClient->request();
		// Here we can see that response body contains json list of products
		Zend_Debug::dump($response);
		return;
	}
}