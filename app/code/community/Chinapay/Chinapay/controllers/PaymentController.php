<?php

class Chinapay_Chinapay_PaymentController extends Mage_Core_Controller_Front_Action
{
    /**
     * Order instance
     */
    protected $_order;

    /**
     *  Get order
     *
     *  @param    none
     *  @return	  Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if ($this->_order == null)
        {
            $session = Mage::getSingleton('checkout/session');
            $this->_order = Mage::getModel('sales/order');
            $this->_order->loadByIncrementId($session->getLastRealOrderId());
        }
        return $this->_order;
    }

    /**
     * When a customer chooses Chinapay on Checkout/Payment page
     *
     */
    public function redirectAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $session->setChinapayPaymentQuoteId($session->getQuoteId());

        $order = $this->getOrder();

        if (!$order->getId())
        {
            $this->norouteAction();
            return;
        }

        $order->addStatusToHistory(
        $order->getStatus(),
        Mage::helper('chinapay')->__('Customer was redirected to Chinapay')
        );
        $order->save();

        $this->getResponse()
        ->setBody($this->getLayout()
        ->createBlock('chinapay/redirect')
        ->setOrder($order)
        ->toHtml());

        $session->unsQuoteId();
    }

    public function notifyAction()
    {
		$data = array();
		Mage::log("China pay callback");
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();
            $method = 'post';


        } 
		else if ($this->getRequest()->isGet())
        {
            $data = $this->getRequest()->getQuery();
            $method = 'get';

        }
		else
        {
            return;
        }
		$chinapay = Mage::getModel('chinapay/payment');
		Mage::log($data);
		$dirfds42 = dirname(__FILE__);
		include_once($dirfds42."/netpayclient.class.php");
		$netpay = new Chinapay();
		$merid = $netpay->buildKey("PgPubk.key");

		if(!$merid) {
		}
		
		$chkvalue = $data['ChkValue'];
		$plain = "";
		//verify($plain, $checkvalue); 

		$orderId = $data['OrdId'];
		if($orderId)
		{
			$order = Mage::getModel('sales/order');
			$order->loadByIncrementId($orderId);
			$order->setStatus("processing");
			$order->addStatusToHistory("processing",
					Mage::helper('chinapay')->__('Payment Gateway Nodify'));
			try{
				$order->sendNewOrderEmail();
				$order->save();
			} catch(Exception $e){
				Mage::log("Set Order Status: Processing Error");
			}
		}
		Mage::log("Set Order Status: Processing");
		Mage::log("Order Status:".$order->getStatus());
		echo "eduok";
    }
    
    protected function saveInvoice(Mage_Sales_Model_Order $order)
    {
        if ($order->canInvoice())
        {
            $convertor = Mage::getModel('sales/convert_order');
            $invoice = $convertor->toInvoice($order);
            foreach ($order->getAllItems() as $orderItem)
            {
                if (!$orderItem->getQtyToInvoice())
                {
                    continue ;
                }
                $item = $convertor->itemToInvoiceItem($orderItem);
                $item->setQty($orderItem->getQtyToInvoice());
                $invoice->addItem($item);
            }
            $invoice->collectTotals();
            $invoice->register()->capture();
            Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder())
            ->save();
            return true;
        }

        return false;
    }

    /**
     *  Success payment page
     *
     *  @param    none
     *  @return	  void
     */
    public function successAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getChinapayPaymentQuoteId());
        $session->unsChinapayPaymentQuoteId();

        $order = $this->getOrder();

        if (!$order->getId())
        {
            $this->norouteAction();
            return;
        }

        $order->addStatusToHistory(
        $order->getStatus(),
			Mage::helper('chinapay')->__('Customer successfully returned from Chinapay')
        );

        $order->save();

        $this->_redirect('checkout/onepage/success');
    }

    /**
     *  Failure payment page
     *
     *  @param    none
     *  @return	  void
     */
    public function errorAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $errorMsg = Mage::helper('chinapay')->__(' There was an error occurred during paying process.');

        $order = $this->getOrder();

        if (!$order->getId())
        {
            $this->norouteAction();
            return;
        }
        if ($order instanceof Mage_Sales_Model_Order && $order->getId())
        {
            $order->addStatusToHistory(
            Mage_Sales_Model_Order::STATE_CANCELED,//$order->getStatus(),
            Mage::helper('chinapay')->__('Customer returned from Chinapay.').$errorMsg
            );

            $order->save();
        }

        $this->loadLayout();
        $this->renderLayout();
        Mage::getSingleton('checkout/session')->unsLastRealOrderId();
    }
}
