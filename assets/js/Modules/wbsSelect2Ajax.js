function wbsSelect2Ajax(selector = '.is-ajax-select', customParams = []) {
    jQuery(function ($) {
        const elem = $(selector);

        elem.each(function () {
            const action = $(this).attr('data-action');
            $(this).select2({
                width: '100%',
                dir: "rtl",
                language: "fa",
                ajax: {
                    url: wbs_script.AjaxUrl,
                    dataType: 'json',
                    delay: 250,
                    type: 'POST',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            action: action,
                            security: wbs_script.SecurityNonce,
                            customParams: customParams
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {

                            // data is the array of arrays, and each of them contains ID and the Label of the option
                            $.each(data, function (index, text) { // do not forget that "index" is just auto incremented value
                                options.push({id: text[0], text: text[1]});
                            });

                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
        });
    });
}