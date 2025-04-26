/**
 *
 * @param parent
 * @param size
 * @param style
 * @param otherClass
 * @returns {boolean}
 */
let txt;

function wbs_loading_start(parent, size = 'small', otherClass = '', style = '', removeText = false) {
    jQuery(function ($) {
        if ($(parent).find('.wbsloading').length > 0) {
            return false;
        }
        if (removeText) {
            txt = $(parent).text();
            $(parent).text('');
            style += 'position: relative;';
        }
        $(parent).css('position', 'relative').append('<div class="wbsloading ' + otherClass + '" style="' + style + '"><span class="wbsloader ' + size + '"></span></div>');
        $('.wbsloading').fadeIn().css('display', 'flex');
    });
}

function wbs_loading_end(parent = '') {
    jQuery(function ($) {
        if (parent.length > 0) {
            $(parent).find('.wbsloading').fadeOut(function () {
                $(parent).find('.wbsloading').remove();
            });

            if (txt !== '') {
                $(parent).text(txt);
            }
        } else {
            $('.wbsloading').fadeOut(function () {
                $('.wbsloading').remove();
            });
        }
    });
}
