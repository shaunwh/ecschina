<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-9
 * Time: 上午11:26
 */
class Magento_Action_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){

        //$configProduct = Mage::getModel('catalog/product');
        //print_r($configProduct);
    }

    public function testAction(){

        echo 'this is test action.';
    }

    public function getProductsAction(){

        echo 'this is get products api.';
    }
}