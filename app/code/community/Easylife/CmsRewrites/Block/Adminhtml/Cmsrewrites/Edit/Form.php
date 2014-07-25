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
class Easylife_CmsRewrites_Block_Adminhtml_Cmsrewrites_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * @access protected
     * prepare the form
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('adminhtml/cmsrewrites_index/save'),
            'method' => 'post'));
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
