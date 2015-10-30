<?php
class LilySoft_ImageShow_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/imageshow?id=15 
    	 *  or
    	 * http://site.com/imageshow/id/15 	
    	 */
    	/* 
		$imageshow_id = $this->getRequest()->getParam('id');

  		if($imageshow_id != null && $imageshow_id != '')	{
			$imageshow = Mage::getModel('imageshow/imageshow')->load($imageshow_id)->getData();
		} else {
			$imageshow = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($imageshow == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$imageshowTable = $resource->getTableName('imageshow');
			
			$select = $read->select()
			   ->from($imageshowTable,array('imageshow_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$imageshow = $read->fetchRow($select);
		}
		Mage::register('imageshow', $imageshow);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}