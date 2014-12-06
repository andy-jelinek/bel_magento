/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
document.observe('dom:loaded', function(){
    $$('.attr-image img').each(function(img){
        img.observe('mouseover', function(ev){
            var photo = img.readAttribute('origin');
            if (photo){
                var target = img.up('.item').down('a img');
                if (target) target.src = photo;
            }
        });
    });
});