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

class MagenThemes_MTTheme_Model_System_Config_Source_Css_Background_Repeat
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'no-repeat',	'label' => Mage::helper('adminhtml')->__('no-repeat')),
            array('value' => 'repeat',		'label' => Mage::helper('adminhtml')->__('repeat')),
            array('value' => 'repeat-x',	'label' => Mage::helper('adminhtml')->__('repeat-x')),
			array('value' => 'repeat-y',	'label' => Mage::helper('adminhtml')->__('repeat-y'))
        );
    }
}