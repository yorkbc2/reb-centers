(function ($) {
    "use strict";

    $(function () {

        var api = wp.customize;

        api.previewer.bind('preview-edit', function (data) {
            var control = api.control(data.name);
            control.focus();
        });

    });

})(jQuery);