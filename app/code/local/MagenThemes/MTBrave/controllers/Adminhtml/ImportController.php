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
class MagenThemes_MTBrave_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/mtbrave/"));
    }
    public function blocksAction() {
        $config = Mage::helper('mtbrave')->getCfg('install/overwrite_blocks');
        Mage::getSingleton('mtbrave/import_cms')->importCmsItems('cms/block', 'blocks', $config);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/mtbrave/"));
    }
    public function pagesAction() {
        $config = Mage::helper('mtbrave')->getCfg('install/overwrite_pages');
        Mage::getSingleton('mtbrave/import_cms')->importCmsItems('cms/page', 'pages', $config);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/mtbrave/"));
    }
    public function widgetsAction() {
        Mage::getSingleton('mtbrave/import_cms')->importWidgetItems('widget/widget_instance', 'widgets', false);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/mtbrave/"));
    }
}
