<?php

class LilySoft_ImageShow_Model_Mysql4_ImageShow_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	protected $enabledSelected = 1;
    public function _construct()
    {
    	parent::_construct();
        $this->_init('imageshow/imageshow');
    }
	public function addEnabledFilter($enabledSelectd = NUll){
		if(empty($enabledSelectd)){
			$enabledSelectd = $this->enabledSelected;
		}
		$this->getSelect()->where('main_table.status = ?', $enabledSelectd);
		return $this;
    }
	/**
     * set order by position field
     *
     * @param   string $dir
     * @return  Varien_Data_Collection_Db
     */
    public function setPositionOrder($dir='ASC')
    {
        $this->setOrder('main_table.sortorder', $dir);
        return $this;
    }
    public function setLimit($pageSize = 5,$curPage = 1){
    	if($curPage <1){
    		$curPage = 1;
    	}
    	$this->setPageSize($pageSize)->setCurPage ( $curPage );
    	return $this;
    }
}