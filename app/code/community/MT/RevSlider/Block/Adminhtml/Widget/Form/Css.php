<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Block_Adminhtml_Widget_Form_Css
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface{

    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('mt/revslider/widget/form/css.phtml');
    }

    public function getElement(){
        return $this->_element;
    }

    public function setElement(Varien_Data_Form_Element_Abstract $element){
        return $this->_element = $element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }

    protected function _prepareLayout(){
        $this->setChild('css', $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
            'label'     => Mage::helper('revslider')->__('CSS'),
            'type'      => 'button',
            'onclick'   => sprintf('MT.MediabrowserUtility.openDialog(\'%s\', \'editCssWindow\', null, null, \'%s\')',
                $this->getUrl('revslideradmin/slider/css'),
                Mage::helper('revslider')->__('Edit CSS')
            ),
        )));
        return parent::_prepareLayout();
    }
}