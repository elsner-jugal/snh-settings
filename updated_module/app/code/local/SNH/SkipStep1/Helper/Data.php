<?php
class SNH_SkipStep1_Helper_Data extends Mage_Core_Helper_Data
{
    public function isSkipEnabled()
    {
    	return Mage::getStoreConfig('snh_settings/messages/skipstep1_enabled');
    }
}