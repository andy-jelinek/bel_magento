<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
    $installer->getTable('revslider/slider'),
    'status',
    'INT(4) NULL DEFAULT NULL COMMENT "Slider Status"'
);