<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_IndexController extends Mage_Core_Controller_Front_Action{
    public function previewAction(){
        $id = $this->getRequest()->getParam('id');
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate('page/empty.phtml');
        $block = $this->getLayout()->createBlock('revslider/slider_preview', '', array('id' => $id));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function getCssCaptionsAction(){
        $this->getResponse()->setHeader('Content-Type', 'text/css');
        $this->getResponse()->setHeader('X-Content-Type-Options', 'nosniff');
        $reset = $this->getRequest()->getParam('reset');
        $file = Mage::getBaseDir().'/js/mt/revslider/rs-plugin/css/captions.css';
        if ($reset == 1){
            if (is_file($file)) $css = file_get_contents($file);
        }else{
            $css = Mage::getStoreConfig('revslider/config/css');
            if (!$css){
                if (is_file($file)) $css = file_get_contents($file);
            }
        }
        $this->getResponse()->setBody($css);
    }
}