<?php
/**
 * @category    MT
 * @package     MT_Attribute
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_Attribute_Model_System_Config_Source_Show{
    public function toOptionArray(){
        return array(
            array('value' => 0, 'label' => Mage::helper('mtattribute')->__('Not show')),
            array('value' => 2, 'label' => Mage::helper('mtattribute')->__('Replace')),
            array('value' => 3, 'label' => Mage::helper('mtattribute')->__('Show all'))
        );
    }
}