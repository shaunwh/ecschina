<?php
class LilySoft_ImageShow_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getImageFolderPath(){
		return 'imageshow' . DS . 'big';
	}
	public function getImageUrlPath(){
		return 'imageshow/big/';
	}
}
?>