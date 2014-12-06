<?php
/**
 * @category    MT
 * @package     MT_Extensions
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class MT_Extensions_Adminhtml_Cms_Wysiwyg_ImagesController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController{
    public function indexAction(){
        if ($this->getRequest()->getParam('static_urls_allowed')){
            $this->_getSession()->setStaticUrlsAllowed(true);
        }
        parent::indexAction();
    }

    public function onInsertAction(){
        parent::onInsertAction();
        $this->_getSession()->setStaticUrlsAllowed();
    }
}