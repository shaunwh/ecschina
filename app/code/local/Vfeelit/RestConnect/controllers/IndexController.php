<?php
class Vfeelit_RestConnect_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {

        //Basic parameters that need to be provided for oAuth authentication
        //on Magento
        $params = array(
            'siteUrl' => 'http://ecschina.com/oauth',
            'requestTokenUrl' => 'http://ecschina.com/oauth/initiate',
            'accessTokenUrl' => 'http://ecschina.com/oauth/token',
            'authorizeUrl' => 'http://ecschina.com/admin/oAuth_authorize',//This URL is used only if we authenticate as Admin user type
            'consumerKey' => 'ufs7anw8j9duj754vplvczyxmcdvor5b',//Consumer key registered in server administration
            'consumerSecret' => 'i8mcujolcsglsx3egi2do10cmvelkly8',//Consumer secret registered in server administration
            'callbackUrl' => 'http://ecschina.com/restconnect/index/callback',//Url of callback action below
        );

        // Initiate oAuth consumer with above parameters
        $consumer = new Zend_Oauth_Consumer($params);
        // Get request token
        $requestToken = $consumer->getRequestToken();
        // Get session
        $session = Mage::getSingleton('core/session');
        // Save serialized request token object in session for later use
        $session->setRequestToken(serialize($requestToken));
        // Redirect to authorize URL
        $consumer->redirect();

        return;
    }

    public function callbackAction() {

        //oAuth parameters
        $params = array(
            'siteUrl' => 'http://ecschina.com/oauth',
            'requestTokenUrl' => 'http://ecschina.com/oauth/initiate',
            'accessTokenUrl' => 'http://ecschina.com/oauth/token',
            'consumerKey' => 'ufs7anw8j9duj754vplvczyxmcdvor5b',
            'consumerSecret' => 'i8mcujolcsglsx3egi2do10cmvelkly8'
        );

        // Get session
        $session = Mage::getSingleton('core/session');
        // Read and unserialize request token from session
        $requestToken = unserialize($session->getRequestToken());
        // Initiate oAuth consumer
        $consumer = new Zend_Oauth_Consumer($params);
        // Using oAuth parameters and request Token we got, get access token
        $acessToken = $consumer->getAccessToken($_GET, $requestToken);
        // Get HTTP client from access token object
        $restClient = $acessToken->getHttpClient($params);
        // Set REST resource URL
        $restClient->setUri('http://magento.loc/api/rest/products');
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