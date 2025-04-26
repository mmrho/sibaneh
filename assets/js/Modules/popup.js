jQuery(document).ready(function ($) {
    $('body').on('click', '.wbs-popup-panel .wbs-popup .close-popup', function () {
        wbsPopupClose();
    });
});

/**
 *
 * @param content
 * @param sizeClass
 * @param hasCloseButton
 * @param className
 * @returns {boolean}
 */
function wbsPopup(content, sizeClass = 'col-md-12', hasCloseButton = true, className = '') {
    let popupContent;
    if (hasCloseButton) {
        popupContent = '<div class="wbs-popup-panel '+ className +'"><div class="container">\n' +
            '        <div class="row justify-content-center">\n' +
            '            <div class="' + sizeClass + '">\n' +
            '                <div class="wbs-popup">\n' +
            '                    <span class="close-popup">×</span>\n' +
            '                    <div class="popup-content">\n' +
            '                       \n' + content +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div></div>';
    } else {
        popupContent = '<div class="wbs-popup-panel '+ className +'"><div class="container">\n' +
            '        <div class="row justify-content-center">\n' +
            '            <div class="' + sizeClass + '">\n' +
            '                <div class="wbs-popup">\n' +
            '                    <div class="popup-content">\n' +
            '                       \n' + content +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div></div>';
    }

    $('body').append(popupContent);
    $('.wbs-popup-panel:not(.not-remove)').fadeIn().css('display', 'flex');
    return true;
}

function wbsPopupClose() {
    $('.wbs-popup-panel').fadeOut('normal', function () {
        $('.wbs-popup-panel:not(.not-remove)').remove();
    });
}
