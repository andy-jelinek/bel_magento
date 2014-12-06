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
/**
 * Call actions after configuration is saved
 */
class MagenThemes_MTBrave_Model_Observer
{
	/**
     * After any system config is saved
     */
	public function configSave()
	{
		$section = Mage::app()->getRequest()->getParam('section');
		if ($section == 'mtbrave_design')
		{
			$websiteCode = Mage::app()->getRequest()->getParam('website');
			$storeCode = Mage::app()->getRequest()->getParam('store');
			
			Mage::getSingleton('mtbrave/cssgen_generator')->generateCss('design', $websiteCode, $storeCode);
		}
	}
	
	/**
     * After store view is saved
     */
	public function storeEdit(Varien_Event_Observer $observer)
	{
		$store = $observer->getEvent()->getStore();
		$storeCode = $store->getCode();
		$websiteCode = $store->getWebsite()->getCode();

		Mage::getSingleton('mtbrave/cssgen_generator')->generateCss('design', $websiteCode, $storeCode);
	}
}
