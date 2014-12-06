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

class MagenThemes_MTBrave_Adminhtml_SupportController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('magenthemes/mtbrave')
            ->_title(Mage::helper('adminhtml')->__('Help & Support'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Help & Support'), Mage::helper('adminhtml')->__('Help & Support'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
} 
?>
