<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Export
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
class MT_Export_Block_Adminhtml_Widget extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_widget';
        $this->_blockGroup = 'export';
        $this->_headerText = $this->__('Manage Export Widget');
        parent::__construct();
        $this->_removeButton('add');
    }
}