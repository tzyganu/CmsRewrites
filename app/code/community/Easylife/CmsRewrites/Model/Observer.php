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
class Easylife_CmsRewrites_Model_Observer {
    /**
     * add delete mass action
     * @access public
     * @param Varien_Event_Observer $observer
     */
    public function addMassAction($observer) {
        $block = $observer->getEvent()->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Urlrewrite_Grid) {
            $block->setMassactionIdField('url_rewrite_id');
            $block->getMassactionBlock()->setFormFieldName('rewriteids');
            $block->getMassactionBlock()->setUseSelectAll(true);
            $block->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('adminhtml')->__('Delete'),
                'url' => $block->getUrl('*/cmsrewrites_index/massDelete'),
            ));
            $columnId = 'massaction';
            $massactionColumn = array(
                'index' => $block->getMassactionIdField(),
                'filter_index' => $block->getMassactionIdFilter(),
                'type' => 'massaction',
                'name' => $block->getMassactionBlock()->getFormFieldName(),
                'align' => 'center',
                'is_system' => true
            );

            if ($block->getNoFilterMassactionColumn()) {
                $massactionColumn->setData('filter', false);
            }
            $oldColumns = $block->getColumns();
            foreach($oldColumns as $column){
                $block->removeColumn($column->getId());
            }
            $block->addColumn($columnId, $massactionColumn);

            foreach($oldColumns as $column){
                $block->addColumn($column->getId(),$column->getData());
            }
        }
    }
}
