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
class Easylife_CmsRewrites_Block_Adminhtml_Cmsrewrites_Edit_Line
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * get available stores
     * @access public
     * @return Mage_Core_Model_Resource_Store_Collection
     */
    public function getStores() {
        return Mage::helper('easylife_cmsrewrites')->getStores();
    }

    /**
     * prepare the form
     * @access protected
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset(uniqid('fieldset_'),
            array(
                'legend'=>$this->__('Rewrite %s', $this->getIncrement())
            )
        );
        foreach ($this->getStores() as $store) {
            $fieldset->addField('rewrite_'.$store->getId(), 'text', array(
                'name' => 'store_'.$store->getId(),
                'label' => $this->__('Store %s', $store->getName())
            ));
        }
        $fieldset->addField('redirect', 'select', array(
            'name' => 'redirect',
            'label' => $this->__('Redirect'),
            'options'   => array(
                ''   => Mage::helper('adminhtml')->__('No'),
                'R'  => Mage::helper('adminhtml')->__('Temporary (302)'),
                'RP' => Mage::helper('adminhtml')->__('Permanent (301)'),
            ),

        ));
        $form->setHtmlIdPrefix('rewrite_'.$this->getIncrement().'_');
        $form->addFieldNameSuffix('rewrite['.$this->getIncrement().']');
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
