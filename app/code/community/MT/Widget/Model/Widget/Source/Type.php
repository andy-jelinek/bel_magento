<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */

class MT_Widget_Model_Widget_Source_Type{
    public function toOptionArray(){
        $types[] = array('value'=>'product', 'label'=>Mage::helper('mtwidget')->__('Product'));
        $types[] = array('value'=>'block', 'label'=>Mage::helper('mtwidget')->__('Block'));
        $mt_attribute = Mage::helper('mtext')->getExtensionInfo('MT_Attribute');
        if ($mt_attribute == '1'){
            $types[] = array('value'=>'attribute', 'label'=>Mage::helper('mtwidget')->__('Attribute'));
        }
        return $types;
    }
}