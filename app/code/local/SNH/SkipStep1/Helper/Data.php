<?php
class SNH_SkipStep1_Helper_Data extends Mage_Core_Helper_Data
{
    public function isSkipEnabled()
    {
    	return Mage::getStoreConfig('snh_settings/messages/skipstep1_enabled');
    }
    public function isShowFax()
    {
        return Mage::getStoreConfig('snh_settings/messages/showfax_enabled');
    }
    public function isShowCustomBlock()
    {
        return Mage::getStoreConfig('snh_settings/messages/custom_block');
    }
    public function isCustomValidation()
    {
        return Mage::getStoreConfig('snh_settings/messages/custom_validation');
    }
}