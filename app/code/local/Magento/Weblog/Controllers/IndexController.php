<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-14
 * Time: 下午4:57
 */

class Magento_Weblog_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        try{
            $read = Mage::getSingleton('core/resource')->getConnection('core_read');
            //$sql = "select a.*, b.* from catalog_category_product a left join catalog_product_entity b on b.entity_id = a.product_id";
            //$res = $read->fetchAll($sql);
            //var_dump($res);
            $table = Mage::getSingleton('core/resource')->getTableName('catalog_category_product');
            $select = $read->select()->from($table);
            $res = $read->fetchAll($select);
            return $res;
        } catch (Exception $e){
            echo $e;
            Mage::logException($e);
        }

    }
}