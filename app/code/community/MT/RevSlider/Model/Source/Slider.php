<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_RevSlider_Model_Source_Slider{
    public function toOptionArray(){
        $collection = Mage::getModel('revslider/slider')
            ->getCollection();
        $array = array();
        foreach ($collection as $slide){
            $array[] = array(
                'value' => $slide->getId(),
                'label' => $slide->getTitle()
            );
        }
        return $array;
    }
}