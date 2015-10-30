<?php


class Chinapay_Chinapay_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    protected $_code  = 'chinapay';
    protected $_formBlockType = 'chinapay/form';

    // Payment configuration
    protected $_isGateway               = false;
    protected $_canAuthorize            = true;
    protected $_canCapture              = true;
    protected $_canCapturePartial       = false;
    protected $_canRefund               = false;
    protected $_canVoid                 = false;
    protected $_canUseInternal          = false;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = false;
	protected $_canSaveCc = false;

    // Order instance
    protected $_order = null;

    /**
     *  Returns Target URL
     *
     *  @return	  string Target URL
     */
    public function getChinapayUrl()
    {
		//http://bianmin-test.chinapay.com/cpeduinterface/OrderGet.do
		//http://apps.chinapay.com/cpeduinterface/OrderGet.do
		
		if($this->getConfigData("test"))
		{
			return "http://bianmin-test.chinapay.com/cpeduinterface/OrderGet.do";
		}
		else
		{
			return "http://apps.chinapay.com/cpeduinterface/OrderGet.do";	
		}
        //$url = $this->getConfigData('transport').'://'.$this->getConfigData('gateway');
        //return $url;
    }

    /**
     *  Return back URL
     *
     *  @return	  string URL
     */
	protected function getReturnURL()
	{
		return Mage::getUrl('checkout/onepage/success', array('_secure' => true));
	}

	/**
	 *  Return URL for Chinapay success response
	 *
	 *  @return	  string URL
	 */
	protected function getSuccessURL()
	{
		return Mage::getUrl('checkout/onepage/success', array('_secure' => true));
	}

    /**
     *  Return URL for Chinapay failure response
     *
     *  @return	  string URL
     */
    protected function getErrorURL()
    {
        return Mage::getUrl('chinapay/payment/error', array('_secure' => true));
    }

	/**
	 *  Return URL for Chinapay notify response
	 *
	 *  @return	  string URL
	 */
	protected function getNotifyURL()
	{
		return Mage::getUrl('chinapay/payment/notify/', array('_secure' => true));
	}

    /**
     * Capture payment
     *
     * @param   Varien_Object $orderPayment
     * @return  Mage_Payment_Model_Abstract
     */
    public function capture(Varien_Object $payment, $amount)
    {
        $payment->setStatus(self::STATUS_APPROVED)
            ->setLastTransId($this->getTransactionId());

        return $this;
    }

    /**
     *  Form block description
     *
     *  @return	 object
     */
    public function createFormBlock($name)
    {
        $block = $this->getLayout()->createBlock('chinapay/form_payment', $name);
        $block->setMethod($this->_code);
        $block->setPayment($this->getPayment());

        return $block;
    }

    /**
     *  Return Order Place Redirect URL
     *
     *  @return	  string Order Redirect URL
     */
    public function getOrderPlaceRedirectUrl()
    {
		$session = Mage::getSingleton('checkout/session');
		$order = $this->getOrder();
        return Mage::getUrl('chinapay/payment/redirect',array("rand",rand()));
    }

    /**
     *  Return Standard Checkout Form Fields for request to Chinapay
     *
     *  @return	  array Array of hidden form fields
     */
    public function getStandardCheckoutFormFields()
    {
        $session = Mage::getSingleton('checkout/session');
		$customerSession = Mage::getSingleton('customer/session');
		
		$dirfds42 = dirname(__FILE__);
		include_once($dirfds42."/netpayclient.class.php");
		$netpay = new Chinapay();
		$merid = $netpay->buildKey("MerPrK.key");

		if(!$merid) {
			//echo "import error;";
		}

        $order = $this->getOrder();
        if (!($order instanceof Mage_Sales_Model_Order)) {
            Mage::throwException($this->_getHelper()->__('Cannot retrieve order object'));
        }

		//convert to CNY
		//$currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
		//$converted_final_price = Mage::helper('directory')->currencyConvert($order->getBaseGrandTotal(), $currency_code, 'CNY');
		//if($converted_final_price){
		//	$converted_final_price=$converted_final_price;
		//}else{
		//	$converted_final_price=$order->getBaseGrandTotal();
		//}
		$parameter = array(
                            'MerId'				=>  $merid,
						    //'BusiId'			=>	$this->getConfigData('branch_id'),
							'OrdId'				=>	$order->getRealOrderId(),
							'OrdAmt'			=>	$order->getBaseGrandTotal()*100,
							'CuryId'			=>	'156',
							'Version'			=>	'20100401',
							'BgRetUrl'			=>	$this->getNotifyURL(),
							'PageRetUrl'        =>	$this->getSuccessURL(),
							//'GateId'			=> '', // customer choose
							'Param1'			=> $customerSession->getCustomer()->getEmail(),
							'Param2'			=> $customerSession->getCustomer()->getId(),
							'Param3'			=> $order->getQuoteId(),
							'Param4'			=> $order->getId(),
							//'OrdDesc'			=> $order->getRealOrderId(),
							'ShareType'			=>	'0001',
							'ShareData'			=>	$this->getConfigData('branch_id')."^".$order->getBaseGrandTotal()*100,
							//'Priv1'			=> '',
							//'CustomIp'			=> '',
							'ChkValue'			=>	'CHKVALUE'
                        );
		
		$plain = "";
		foreach($parameter as $key=>$value)
		{
			if($key != "ChkValue")
			{
				$plain .= $value;
			}
		}

		$base_64_string = base64_encode($plain);

		$chkvalue = $netpay->sign($base_64_string);
		//echo $chkvalue;
		$parameter['ChkValue'] = $chkvalue;
		Mage::log("Send Data to Chinapay");
		Mage::log($parameter);
        return $parameter;
    }

}