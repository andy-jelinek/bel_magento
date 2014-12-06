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
class MagenThemes_MTBrave_Block_Adminhtml_Product_Layout_Layout extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        $html = parent::_getElementHtml($element);
        $imgParth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/wysiwyg/magenthemes/mtbrave/product/layout/';
        $js = $this->getJsUrl('magenthemes/jquery/jquery-1.8.2.min.js');
        $html .= '
                <script type="text/javascript" src="'. $js .'"></script>
                <script type="text/javascript">jQuery.noConflict();</script>
                ';
        $html .= '<br/><div id="layout_'.$element->getHtmlId().'" class="layout_preview" style="min-height: 210px;"></div>';
        $html .= '
            <script type="text/javascript">
                jQuery(window).load(function(){
                    var layout = jQuery("#'.$element->getHtmlId().' option:selected").val();
                    jQuery("#'.$element->getHtmlId().'")
                        .change(function() {
                            var imageLayout = "";
                            jQuery( "#'.$element->getHtmlId().' option:selected" ).each(function() {
                            imageLayout += "'.$imgParth.'"+jQuery( this ).val()+".png";
                        });
                        jQuery("#layout_'.$element->getHtmlId().'").html("<img src="+imageLayout+" />");
                    }).trigger("change");
                });
            </script>';
        return $html;
    }
}
?>