<?php

class Chinapay_Chinapay_Block_Redirect extends Mage_Core_Block_Abstract
{

	protected function _toHtml()
	{
		$standard = Mage::getModel('chinapay/payment');
        $form = new Varien_Data_Form();
        $form->setAction($standard->getChinapayUrl())
            ->setId('chinapay_payment_checkout')
            ->setName('chinapay_payment_checkout')
            ->setMethod('POST')
            ->setUseContainer(false);
        foreach ($standard->setOrder($this->getOrder())->getStandardCheckoutFormFields() as $field => $value) {
            $form->addField($field, 'hidden', array('name' => $field, 'value' => $value));
        }

        $formHTML = $form->toHtml();

        $html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
        $html.= $this->__('You will be redirected to Chinapay in a few seconds.');
		$html.= "<form action='".$standard->getChinapayUrl()."' id='chinapay_payment_checkout' name='chinapay_payment_checkout' method='POST'>";
        $html.= $formHTML;
		$html.= "</form>";
        $html.= '<script type="text/javascript">document.getElementById("chinapay_payment_checkout").submit();</script>';
        $html.= '</body></html>';


        return $html;
    }
}