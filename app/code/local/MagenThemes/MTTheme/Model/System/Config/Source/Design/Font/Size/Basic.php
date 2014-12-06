<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Themes
 * ------------------------------------------------------------------------------
 * @copyright    Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license      GNU General Public License version 2 or later;
 * @author       YesTheme.com
 * @email        support@yestheme.com
 * ------------------------------------------------------------------------------
 *
 */
?>
<?php
class MagenThemes_MTTheme_Model_System_Config_Source_Design_Font_Size_Basic
{
    public function toOptionArray()
    {
		return array(
			array('value' => '12px',	'label' => Mage::helper('adminhtml')->__('12 px')),
			array('value' => '13px',	'label' => Mage::helper('adminhtml')->__('13 px')),
            array('value' => '14px',	'label' => Mage::helper('adminhtml')->__('14 px'))
        );
    }
}