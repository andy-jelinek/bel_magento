<?php
/**
 * @category    MT
 * @package     MT_Filter
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_Filter_Helper_Data extends Mage_Core_Helper_Abstract{
    public function getConfig($path=null){
        if ($path) return Mage::getStoreConfig($path);
        else{
            $enable = $this->getConfig('mtfilter/general/enable');
            $bar    = $this->getConfig('mtfilter/general/bar');
            return Mage::helper('core')->jsonEncode(
                array(
                    'mainDOM'   => trim($this->getConfig('mtfilter/general/main_selector')),
                    'layerDOM'  => trim($this->getConfig('mtfilter/general/layer_selector')),
                    'enable'    => (bool)$enable,
                    'bar'       => (bool)$bar
                )
            );
        }
    }
}