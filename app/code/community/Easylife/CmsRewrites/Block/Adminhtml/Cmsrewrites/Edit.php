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
class Easylife_CmsRewrites_Block_Adminhtml_Cmsrewrites_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * construct
     * additional button
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->_blockGroup = 'easylife_cmsrewrites';
        $this->_controller = 'adminhtml_cmsrewrites';
        $this->setTemplate('easylife_cmsrewrites/edit.phtml');
        $this->_removeButton('back');
        $this->_addButton(
            'add-rewrite',
            array(
                'label'     => Mage::helper('easylife_cmsrewrites')->__('Add rewrite'),
                'class'     => 'add-rewrite'
            ),
            100
        );
    }

    /**
     * get header text
     * @access public
     * @return string
     */
    public function getHeaderText() {
        return $this->__('Add CMS pages rewrites');
    }

    /**
     * prepare the layout
     * generate line template
     * @access protected
     * @return Mage_Core_Block_Abstract|void
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $block = Mage::app()->getLayout()
            ->createBlock('easylife_cmsrewrites/adminhtml_cmsrewrites_edit_line')
            ->setTemplate('easylife_cmsrewrites/edit/line.phtml')
            ->setIncrement('{{id}}');
        $this->setChild('line-template', $block);
    }

    /**
     * get the save url
     * @access public
     * @return string
     */
    public function getFormActionUrl() {
        return $this->getUrl('*/*/save');
    }
}