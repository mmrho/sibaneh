/**
 *
 * @param action
 * @param data
 * @param dataType
 * @param successCallback
 * @param errorCallback
 * @param completeCallback
 */
let xhr;

function wbsAjax(action, data, dataType, successCallback = null, errorCallback = null, completeCallback = null) {
    jQuery(function ($) {
        var sendData = {};
        sendData.action = action;
        sendData.security = wbs_script.SecurityNonce;
        sendData.fields = data;
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
        xhr = $.ajax({
            url: wbs_script.AjaxUrl,
            type: 'POST',
            dataType: dataType,
            data: sendData,
            success: function (response) {
                successCallback(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (errorCallback !== null) {
                    errorCallback(thrownError);
                }
            },
            complete: function () {
                if (completeCallback !== null) {
                    completeCallback();
                }
            }
        });
    });
}
