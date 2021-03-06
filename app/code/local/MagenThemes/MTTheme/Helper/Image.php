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

class MagenThemes_MTTheme_Helper_Image extends Mage_Core_Helper_Abstract
{
	public function getImg($product, $w, $h, $imgVersion='image', $file=NULL)
	{
		$url = '';
		if ($h <= 0)
		{
			$url = Mage::helper('catalog/image')
				->init($product, $imgVersion, $file)
				->constrainOnly(true)
				->keepAspectRatio(true)
				->keepFrame(false)
				->resize($w);
		}
		else
		{
			$url = Mage::helper('catalog/image')
				->init($product, $imgVersion, $file)
				->resize($w, $h);
		}
		return $url;
	}
}
