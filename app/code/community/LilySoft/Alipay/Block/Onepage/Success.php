<?php
/**
 * 
 * 用来重写 checkout_onepage_success这个block的 
 * @author Administrator
 *
 */
class LilySoft_Alipay_Block_Onepage_Success extends Mage_Checkout_Block_Onepage_Success{
	protected $_notAllowOnlinePayment = array('free', 'cod','bankremittance');
	protected $template = "alipay/success.phtml";
	
	
	/**
	 * 通过重写父类中的 _toHtml()函数，在这个函数中添加上新的 template的指向，就可以了。
	 * (non-PHPdoc)
	 * @see Mage_Core_Block_Template::_toHtml()
	 */
	protected function _toHtml()
    {
    	//还要在这里判断订单是不是支付宝的，如果是支付宝的，就加载他的success文件，如果不是，则加载原来的。支付宝和财付通的插件中都写上这个才比较好
    	$order = Mage::getSingleton('sales/order')->loadByIncrementId($this->getOrderId());
    	if($order->getPayment()->getMethodInstance()->getCode() == 'alipay'){
    		$this->setTemplate('alipay/success.phtml');
    	}else if($order->getPayment()->getMethodInstance()->getCode() == 'tenpay'){
    		$this->setTemplate('tenpay/success.phtml');
    	}
    	return parent::_toHtml();
    }
	
	/**
     * Get order
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
    	//如果是空的，就需要调用 缓存中的order才可以，如果还是空的，就要使用 orderid来查询
    	return Mage::getSingleton('sales/order')->loadByIncrementId($this->getOrderId());
    }
    
	public function canOnlinePayment(){
    	return !in_array($this->getOrder()->getPayment()->getMethodInstance()->getCode(), $this->_notAllowOnlinePayment);
    }
    
	public function getReturnUrl()
    {
    	if(Mage::getSingleton('customer/session')->isLoggedIn()){
    		return $this->getUrl('sales/order/view', array('order_id' =>Mage::getSingleton('checkout/session')->getLastOrderId()));
    	}

        return  Mage::getUrl('searchorder/order/order',array('order_id' => $this->getOrderId()));
    }
}
?>