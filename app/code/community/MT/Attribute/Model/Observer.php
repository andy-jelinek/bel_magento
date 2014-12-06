<?php
/**
 * @category    MT
 * @package     MT_Attribute
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_Attribute_Model_Observer {
    public function updateLayout(){
        Mage::helper('mtext')->loadJsLibs('browser');
    }
}