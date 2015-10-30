<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-9
 * Time: 上午11:53
 */

class Magento_Action_TestController extends Mage_Core_Controller_Front_Action{

    public function IndexAction($observer){
        //get the param
        $abc = $this->getRequest()->getParam('id',false);
        echo $abc;exit;
        $str = $_GET['id'];
        echo $str;
        echo '<br/>';
        echo 'this is test controller index function.';
    }
}