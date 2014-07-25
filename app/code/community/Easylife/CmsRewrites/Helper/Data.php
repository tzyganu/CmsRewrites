<?php
/**
 * Easylife_CmsRewrites extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_EASYLIFE_CMSREWRITES.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Easylife
 * @package        Easylife_CmsRewrites
 * @copyright      Copyright (c) 2013
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
class Easylife_CmsRewrites_Helper_Data
    extends Mage_Core_Helper_Abstract {
    protected $_stores;

    /**
     * get stores
     * @access public
     * @return Mage_Core_Model_Resource_Store_Collection
     */
    public function getStores() {
        if (is_null($this->_stores)) {
            $this->_stores = Mage::getModel('core/store')->getCollection()
                ->addFieldToFilter('store_id', array('neq'=>0));
        }
        return $this->_stores;
    }
}