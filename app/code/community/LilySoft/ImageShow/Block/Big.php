<?php
class LilySoft_ImageShow_Block_Big extends Mage_Core_Block_Template
{
	protected $template = 'imageshow/big.phtml';
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getImageShow()     
     { 
        if (!$this->hasData('imageshow')) {
            $this->setData('imageshow', Mage::registry('imageshow'));
        }
        return $this->getData('imageshow');
    }
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate($this->template);
    }
    
	public function getImageShowConfig($name)
    {
        return Mage::getStoreConfig('imageshow/general/' . $name);
    }
    
    
    /**
     * 
     * 返回要插入的基准元素选择器
     */
    public function getBaseElement(){
    	//$baseElement = ".main";
    	$baseElement = $this->getImageShowConfig('base_element');
    	return $baseElement;
    }
    /**
     * 
     * 返回要插入的基准元素的方式
     */
    public function getInsertType(){
    	//append prepend before after
    	$insertType = $this->getImageShowConfig('insert_type');
    	return $insertType;
    }
    public function getMarginLeft(){
    	//$marginLeft = "-20";
    	$marginLeft = $this->getImageShowConfig('margin_left');
    	return $marginLeft;
    }
    public function getMarginTop(){
    	//$marginTop = "-20";
    	$marginTop = $this->getImageShowConfig('margin_top');
    	return $marginTop;
    }
	public function getMarginBottom(){
    	//$marginBottom = "10";
    	$marginBottom = $this->getImageShowConfig('margin_bottom');
    	return $marginBottom;
    }
    public function getImageWidth(){
    	//$imageWidth = "920";
    	$imageWidth = $this->getImageShowConfig('image_width');
    	return $imageWidth;
    }
    public function getImageHeight(){
    	//$imageHeight = "330";
    	$imageHeight = $this->getImageShowConfig('image_height');
    	return $imageHeight;
    }
    public function getCycleType(){
    	//$cycleType = "fade";
    	$cycleType = $this->getImageShowConfig('cycle_type');
    	return $cycleType; 
    }
    public function getSpeed(){
    	//$speed = '1500';
    	$speed = $this->getImageShowConfig('speed');
    	return $speed;
    }
    public function getTimeout(){
    	//$timeout = '500';
    	$timeout = $this->getImageShowConfig('timeout');
    	return $timeout;
    }
	public function getMaxCount(){
    	//$timeout = '500';
    	$max_count = $this->getImageShowConfig('max_count');
    	return $max_count;
    }
    public function getItems(){
    	$collection = Mage::getModel ('imageshow/imageshow')->getCollection ();
    	$collection = $collection->addEnabledFilter()->setPositionOrder()->setLimit($this->getMaxCount());
    	if($collection->getSize() >0){
    	foreach ( $collection as &$item ) {
			//在这里做一些处理，根据blog进行列表的处理
			$item->setImageUrl ( Mage::getBaseUrl('media') . $item->getFilename());
			$href = $item->getHref();
			if(empty($href)){
				$item->setHref ('javascript:void(0)');
			}
		}
    		return $collection;
    	}else{
    		return false;
    	}
    }
    
}