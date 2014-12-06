<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Block_Adminhtml_Slider_Edit_Tab_Font
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface{

    public function getTabLabel(){
        return Mage::helper('revslider')->__('Font Settings');
    }

    public function getTabTitle(){
        return Mage::helper('revslider')->__('Font Settings');
    }

    public function canShowTab(){
        return true;
    }

    public function isHidden(){
        return false;
    }

    public function _prepareForm(){
        /* @var $model MT_RevSlider_Model_Slider */
        $model = Mage::registry('revslider');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('font_fieldset', array('legend' => Mage::helper('revslider')->__('Font Settings')));

        $google = $fieldset->addField('load_googlefont', 'select', array(
            'name'      => 'load_googlefont',
            'label'     => Mage::helper('revslider')->__('Load Google Font'),
            'title'     => Mage::helper('revslider')->__('Load Google Font'),
            'values'    => $model->getYesNoOptions(),
            'note'      => Mage::helper('revslider')->__('Yes / No to load google font')
        ));
        $google1 = $fieldset->addField('google_font', 'text', array(
            'name'      => 'google_font',
            'label'     => Mage::helper('revslider')->__('Google Font'),
            'note'      => Mage::helper('revslider')->__('The google font families to load. To add more google fonts please read <a href="%s" target="_blank">this tutorial</a>', 'http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380/faqs/15268'),
        ));
        $form->getElement('google_font')->setRenderer(
            $this->getLayout()->createBlock('revslider/adminhtml_widget_form_font')
        );

        $this->setForm($form);
        if ($model->getId()) $form->setValues($model->getData());
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($google->getHtmlId(), $google->getName())
            ->addFieldMap($google1->getHtmlId(), $google1->getName())
            ->addFieldDependence($google1->getName(), $google->getName(), 'true')
        );
        return parent::_prepareForm();
    }
}