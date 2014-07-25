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
class Easylife_CmsRewrites_Adminhtml_Cmsrewrites_IndexController
    extends Mage_Adminhtml_Controller_Action {
    /**
     * default redirect option
     */
    const DEFAULT_REDIRECT_DIRECTIVE = 'RP';

    /**
     * default action
     * just display the form
     * @access public
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * save rewrites action
     * @access public
     */
    public function saveAction() {
        $rewrites = $this->getRequest()->getPost('rewrite');
        if (!$rewrites) {
            $this->_getSession()->addError(Mage::helper('easylife_cmsrewrites')->__('Add at least one rewrite'));
            $this->_redirect('*/*/');
            return;
        }
        $stores = $this->getStores();
        $toInsert = array();
        foreach ($rewrites as $rewrite) {
            $rewriteObj = new Varien_Object($rewrite);
            $redirect = $rewriteObj->getRedirect();
            foreach ($stores as $storeFrom) {
                foreach ($stores as $storeTo) {
                    if ($storeFrom->getId() == $storeTo->getId() ||
                        $rewriteObj->getData('store_'.$storeFrom->getId()) == $rewriteObj->getData('store_'.$storeTo->getId()) ||
                        !$rewriteObj->getData('store_'.$storeFrom->getId()) ||
                        !$rewriteObj->getData('store_'.$storeTo->getId())) {

                        continue;
                    }
                    $item = array();
                    $item['store_id'] = $storeTo->getId();
                    $item['category_id'] = null;
                    $item['product_id'] = null;
                    $item['is_system'] = 0;
                    $item['request_path'] = $rewriteObj->getData('store_'.$storeFrom->getId());
                    $item['target_path'] = $rewriteObj->getData('store_'.$storeTo->getId());
                    $item['options'] = $redirect;
                    $item['id_path'] = uniqid('cmsrewrite_');
                    $toInsert[$item['request_path'].'_'.$item['store_id']] = $item;
                }
            }
        }
        if (count($toInsert)) {
            /** @var Mage_Core_Model_Resource $resource */
            $resource = Mage::getSingleton('core/resource');
            /**  @var Varien_Db_Adapter_Interface  $adapter */
            $adapter = $resource->getConnection('core_write');
            $table = $resource->getTableName('core/url_rewrite');
            $adapter->insertOnDuplicate($table, $toInsert);
            $this->_getSession()->addSuccess(Mage::helper('easylife_cmsrewrites')->__('%s Url rewrites were created', count($toInsert)));
            $this->_redirect('*/*/');
            return;
        }
        $this->_getSession()->addError(Mage::helper('easylife_cmsrewrites')->__('No Url rewrite found'));
        $this->_redirect('*/*/');
        return;

    }

    /**
     * get current stores
     * @access public
     * @return Mage_Core_Model_Resource_Store_Collection
     */
    public function getStores() {
        return Mage::helper('easylife_cmsrewrites')->getStores();
    }

    /**
     * delete url rewrites bulk
     * @access public
     */
    public function massDeleteAction() {
        $rewriteIds = $this->getRequest()->getParam('rewriteids');
        if(!is_array($rewriteIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easylife_cmsrewrites')->__('Please select URL rewrites to delete.'));
        }
        else {
            try {
                foreach ($rewriteIds as $rewriteId) {
                    $rewrite = Mage::getModel('core/url_rewrite');
                    $rewrite->setId($rewriteId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('easylife_cmsrewrites')->__('Total of %d URL rewrites were successfully deleted.', count($rewriteIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easylife_cmsrewrites')->__('There was an error deleting URL rewrites.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/urlrewrite/index');
    }
}
