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

class MagenThemes_MTTheme_Model_System_Config_Source_Css_Background_Positiony
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'top',		'label' => Mage::helper('adminhtml')->__('top')),
            array('value' => 'center',	'label' => Mage::helper('adminhtml')->__('center')),
            array('value' => 'bottom',	'label' => Mage::helper('adminhtml')->__('bottom'))
        );
    }
}