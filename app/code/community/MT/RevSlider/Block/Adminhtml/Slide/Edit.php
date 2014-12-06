<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Block_Adminhtml_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        $this->_blockGroup      = 'revslider';
        $this->_controller      = 'adminhtml_slide';
        $this->_form            = 'edit';
        $slide                  = Mage::registry('revslide');
        $slider                 = Mage::registry('revslider');
        $mediaUrl               = Mage::getBaseUrl('media');
        $this->_formScripts[]   = "var cssEditor;";
        $this->_formScripts[]   = "var revLayer = new RevLayers(editForm, {$slider->getDelay()}, '{$this->getUrl('revslider/index/getCssCaptions')}', '{$mediaUrl}');";
        if (is_array($slide->getLayers())){
            $this->_formScripts[]   = "setTimeout(function(){";
            foreach ($slide->getLayers() as $layer){
                $this->_formScripts[] = "revLayer.addLayer(".Mage::helper('core')->jsonEncode($layer).");";
            }
            $this->_formScripts[]   = "}, 300);";
        }
        parent::__construct();
    }

    public function getHeaderText(){
        $slide = Mage::registry('revslide');
        return Mage::helper('revslider')->__($slide->getId() ? "Edit Slide '{$slide->getTitle()}'" : 'New Slide');
    }

    public function _prepareLayout(){
        parent::_prepareLayout();
        $slider = Mage::registry('revslider');
        $slide = Mage::registry('revslide');
        $backUrl = $this->getUrl('*/*/edit', array(
            'id' => $slider->getId(),
            'activeTab' => 'slide_section'
        ));
        $deleteUrl = $this->getUrl('*/*/deleteSlide', array(
            'id'        => $slide->getId(),
            'sid'       => $slider->getId()
        ));
        $this->updateButton('delete', 'onclick', "setLocation('{$deleteUrl}');");
        $this->updateButton('save', 'onclick', 'revLayer.save();');
        $this->updateButton('back', 'onclick', 'setLocation(\''.$backUrl.'\');');
        $this->_addButton('sac', array(
            'label'     => Mage::helper('revslider')->__('Save and Continue Edit'),
            'class'     => 'save',
            'onclick'   => "revLayer.save(true);"
        ));
        if (version_compare(Mage::getVersion(), '1.7.0.0') < 0){
            $this->getLayout()->getBlock('head')->addJs('mt/extensions/prototype/dragdrop.js');
        }
        return $this;
    }
}