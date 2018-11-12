"use strict";

(function($, wp) {
    $(function() {
        var api = wp.customize;
        $(document.body).on("click", ".customizer-edit", function() {
            api.preview.send("preview-edit", $(this).data("control"));
        });
        api("blogname", function(control) {
            control.bind(function(value) {
                $(".blogname").html(value);
            });
        });
        api("blogdescription", function(control) {
            control.bind(function(value) {
                $(".blogdescription").html(value);
            });
        });
        api("header_textcolor", function(control) {
            control.bind(function(value) {
                $("h1, h2, h3, h4, h5, h6").css("color", value);
            });
        });
        api("background_color", function(control) {
            control.bind(function(value) {
                $("body").css("background-color", value);
            });
        });
        var scroll_top = $(".scroll-top");
        api("bw_scroll_top_width", function(control) {
            control.bind(function(value) {
                scroll_top.css("width", value);
            });
        });
        api("bw_scroll_top_height", function(control) {
            control.bind(function(value) {
                scroll_top.css("height", value);
            });
        });
        api("bw_scroll_top_shape", function(control) {
            control.bind(function(value) {
                scroll_top.removeClass("is-circle is-rounded is-square").addClass("is-" + value);
            });
        });
        api("bw_scroll_top_position", function(control) {
            control.bind(function(value) {
                scroll_top.removeClass("is-left is-right").addClass("is-" + value);
                var offset = api.get().bw_scroll_top_offset_left_right;
                if (value === "right") {
                    scroll_top.css({
                        right: offset + "px",
                        left: "auto"
                    });
                } else {
                    scroll_top.css({
                        left: offset + "px",
                        right: "auto"
                    });
                }
            });
        });
        api("bw_scroll_top_offset_left_right", function(control) {
            control.bind(function(value) {
                var position = api.get().bw_scroll_top_position;
                if (position === "right") {
                    scroll_top.css({
                        right: value + "px",
                        left: "auto"
                    });
                } else {
                    scroll_top.css({
                        right: "auto",
                        left: value + "px"
                    });
                }
            });
        });
        api("bw_scroll_top_offset_bottom", function(control) {
            control.bind(function(value) {
                scroll_top.css("bottom", value + "px");
            });
        });
        api("bw_scroll_top_border_width", function(control) {
            control.bind(function(value) {
                scroll_top.css("border-width", value + "px");
            });
        });
        api("bw_scroll_top_border_color", function(control) {
            control.bind(function(value) {
                scroll_top.css("border-color", value);
            });
        });
        api("bw_scroll_top_background_color", function(control) {
            control.bind(function(value) {
                scroll_top.css("background-color", value);
            });
        });
        api("bw_scroll_top_background_color_hover", function(control) {
            control.bind(function(value) {
                scroll_top.css("background-color", value);
            });
        });
        api("bw_scroll_top_arrow_color", function(control) {
            control.bind(function(value) {
                scroll_top.find(".scroll-top--arrow").css("border-bottom-color", value);
            });
        });
    });
})(jQuery, window.wp);