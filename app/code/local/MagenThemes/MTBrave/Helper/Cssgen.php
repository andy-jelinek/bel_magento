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

class MagenThemes_MTBrave_Helper_Cssgen extends Mage_Core_Helper_Abstract
{
	/**
	 * Path and directory of the automatically generated CSS
	 *
	 * @var string
	 */
	protected $_generatedCssFolder;
	protected $_generatedCssPath;
	protected $_generatedCssDir;
	
	public function __construct()
	{
		//Create paths
		$this->_generatedCssFolder = 'css/_config/';
		$this->_generatedCssPath = 'frontend/mtbrave/default/' . $this->_generatedCssFolder;
		$this->_generatedCssDir = Mage::getBaseDir('skin') . '/' . $this->_generatedCssPath;
	}
	
	/**
	 * Get automatically generated CSS directory
	 *
	 * @return string
	 */
	public function getGeneratedCssDir()
    {
        return $this->_generatedCssDir;
    }

	/**
	 * Get file path: CSS design
	 *
	 * @return string
	 */
	public function getDesignFile()
	{
        if (is_file($this->_generatedCssDir . 'design_' . Mage::app()->getStore()->getCode() . '.less')) {
		    return $this->_generatedCssFolder . 'design_' . Mage::app()->getStore()->getCode() . '.less';
        }
	}
}
