<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Block_Adminhtml_Widget_Grid_Column_Renderer_Slide_Thumb extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
    public function _getValue(Varien_Object $row){
        $params = Mage::helper('core')->jsonDecode($row->getParams());
        if (isset($params['slide_thumb']) && $params['slide_thumb']){
            return sprintf('<img src="%s" width="100"/>', $params['slide_thumb']);
        }elseif (isset($params['background_type'])){
            switch ($params['background_type']){
                case 'image':
                    if (isset($params['image_url']) && $params['image_url']){
                        return sprintf('<img src="%s" width="100"/>', strpos($params['image_url'], 'http') === 0 ? $params['image_url'] : Mage::getBaseUrl('media') . $params['image_url']);
                    }
                    break;
                case 'solid':
                    if (isset($params['slide_bg_color']) && $params['slide_bg_color'])
                        return sprintf('<div style="width:100px;height:80px;background:#%s;"></div>', $params['slide_bg_color']);
                    break;
                case 'trans':
                    return '<div style="width:100px;height:80px;background:url('.$this->getSkinUrl('mt/revslider/trans_tile2.png').');"></div>';
                    break;
                case 'external':
                    if (isset($params['bg_external']) && $params['bg_external']){
                        return sprintf('<img src="%s" width="100"/>', strpos($params['bg_external'], 'http') === 0 ? $params['bg_external'] : Mage::getBaseUrl('media') . $params['bg_external']);
                    }
                    break;
            }
        }
        return '';
    }
}