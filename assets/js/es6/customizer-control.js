'use strict';

(($, wp) => {

    $(() => {

        const api = wp.customize;

        api.previewer.bind('preview-edit', (data) => {
            const control = api.control(data.name);
            control.focus();
        });

    });

})(jQuery, window.wp);
