<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Model_Mysql4_Slide extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){
        $this->_init('revslider/slide', 'id');
    }
}