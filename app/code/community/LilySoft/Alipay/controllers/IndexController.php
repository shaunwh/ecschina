<?php
class LilySoft_Alipay_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/alipay?id=15 
    	 *  or
    	 * http://site.com/alipay/id/15 	
    	 */
    	/* 
		$alipay_id = $this->getRequest()->getParam('id');

  		if($alipay_id != null && $alipay_id != '')	{
			$alipay = Mage::getModel('alipay/alipay')->load($alipay_id)->getData();
		} else {
			$alipay = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($alipay == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$alipayTable = $resource->getTableName('alipay');
			
			$select = $read->select()
			   ->from($alipayTable,array('alipay_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$alipay = $read->fetchRow($select);
		}
		Mage::register('alipay', $alipay);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}