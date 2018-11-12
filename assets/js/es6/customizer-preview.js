'use strict';

(($, wp) => {

    $(() => {

        const api = wp.customize;

        $(document.body).on('click', '.customizer-edit', function () {
            api.preview.send('preview-edit', $(this).data('control'));
        });

        api('blogname', (control) => {
            control.bind((value) => {
                $('.blogname').html(value);
            });
        });

        api('blogdescription', (control) => {
            control.bind((value) => {
                $('.blogdescription').html(value);
            });
        });

        api('header_textcolor', (control) => {
            control.bind((value) => {
                $('h1, h2, h3, h4, h5, h6').css('color', value);
            });
        });

        api('background_color', (control) => {
            control.bind((value) => {
                $('body').css('background-color', value);
            });
        });

        const scroll_top = $('.scroll-top');

        api('bw_scroll_top_width', (control) => {
            control.bind((value) => {
                scroll_top.css('width', value);
            });
        });

        api('bw_scroll_top_height', (control) => {
            control.bind((value) => {
                scroll_top.css('height', value);
            });
        });

        api('bw_scroll_top_shape', (control) => {
            control.bind((value) => {
                scroll_top.removeClass('is-circle is-rounded is-square').addClass('is-' + value);
            });
        });

        api('bw_scroll_top_position', (control) => {
            control.bind((value) => {
                scroll_top.removeClass('is-left is-right').addClass('is-' + value);

                const offset = api.get().bw_scroll_top_offset_left_right;

                if (value === 'right') {
                    scroll_top.css({
                        'right': offset + 'px',
                        'left': 'auto',
                    });
                } else {
                    scroll_top.css({
                        'left': offset + 'px',
                        'right': 'auto',
                    });
                }
            });
        });

        api('bw_scroll_top_offset_left_right', (control) => {
            control.bind((value) => {

                const position = api.get().bw_scroll_top_position;

                if (position === 'right') {
                    scroll_top.css({
                        'right': value + 'px',
                        'left': 'auto',
                    });
                } else {
                    scroll_top.css({
                        'right': 'auto',
                        'left': value + 'px',
                    });
                }
            });
        });

        api('bw_scroll_top_offset_bottom', (control) => {
            control.bind((value) => {
                scroll_top.css('bottom', value + 'px');
            });
        });

        api('bw_scroll_top_border_width', (control) => {
            control.bind((value) => {
                scroll_top.css('border-width', value + 'px');
            });
        });

        api('bw_scroll_top_border_color', (control) => {
            control.bind((value) => {
                scroll_top.css('border-color', value);
            });
        });

        api('bw_scroll_top_background_color', (control) => {
            control.bind((value) => {
                scroll_top.css('background-color', value);
            });
        });

        api('bw_scroll_top_background_color_hover', (control) => {
            control.bind((value) => {
                scroll_top.css('background-color', value);
            });
        });

        api('bw_scroll_top_arrow_color', (control) => {
            control.bind((value) => {
                scroll_top.find('.scroll-top--arrow').css('border-bottom-color', value);
            });
        });

    });

})(jQuery, window.wp);
