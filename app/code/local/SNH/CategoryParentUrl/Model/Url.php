<?php

class SNH_CategoryParentUrl_Model_Url extends Mage_Catalog_Model_Url
{

	/**
     * Get unique category request path
     *
     * @param Varien_Object $category
     * @param string $parentPath
     * @return string
     */
    public function getCategoryRequestPath($category, $parentPath)
    {
        $storeId = $category->getStoreId();
        $idPath  = $this->generatePath('id', null, $category);
        $suffix  = $this->getCategoryUrlSuffix($storeId);

        if (isset($this->_rewrites[$idPath])) {
            $this->_rewrite = $this->_rewrites[$idPath];
            $existingRequestPath = $this->_rewrites[$idPath]->getRequestPath();
        }

        if ($category->getUrlKey() == '') {
            $urlKey = $this->getCategoryModel()->formatUrlKey($category->getName());
        }
        else {
            $urlKey = $this->getCategoryModel()->formatUrlKey($category->getUrlKey());
        }

        $categoryUrlSuffix = $this->getCategoryUrlSuffix($category->getStoreId());
        
		/* SNH custom code Magento 1.8.1 verify before upgrade */
		$configValue = Mage::getStoreConfig('catalog/seo/category_use_parentcategory',Mage::app()->getStore());

		if (null === $configValue || $configValue) {
		
			if (null === $parentPath) {
				$parentPath = $this->getResource()->getCategoryParentPath($category);
			}
			elseif ($parentPath == '/') {
				$parentPath = '';
			}
		}
		
		$parentPath = Mage::helper('catalog/category')->getCategoryUrlPath($parentPath,
                                                                           true, $category->getStoreId());

        $requestPath = $parentPath . $urlKey . $categoryUrlSuffix;
        if (isset($existingRequestPath) && $existingRequestPath == $requestPath . $suffix) {
            return $existingRequestPath;
        }

        if ($this->_deleteOldTargetPath($requestPath, $idPath, $storeId)) {
            return $requestPath;
        }

        return $this->getUnusedPath($category->getStoreId(), $requestPath,
                                    $this->generatePath('id', null, $category)
        );
    }


}
		