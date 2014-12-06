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
class MagenThemes_MTTheme_Model_System_Config_Source_Category_Altimagecolumn
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'label', 'label'=>Mage::helper('adminhtml')->__('Label')),
            array('value'=>'position', 'label'=>Mage::helper('adminhtml')->__('Sort Order'))
        );
    }

}