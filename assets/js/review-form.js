"use strict";

(function($) {
    var MAX_VALUE_LENGTH = 360, MIN_VALUE_LENGTH = 0, REVIEW_CREATE_API = "/wp-json/brainworks/reviews/add";
    var forms = $(".review-form"), error = "";
    forms.each(function(index, form) {
        $(form).on("submit", function(e) {
            e.preventDefault();
            var fields = $(form).find("textarea, input"), data = {}, isValid = true;
            fields.each(function(index, field) {
                var name = field.name, value = field.value, type = field.type;
                console.log(value, type);
                if (!name || !value) return isValid = false;
                if (!type || type != "hidden" && value.length < MIN_VALUE_LENGTH || value.length > MAX_VALUE_LENGTH) return isValid = false;
                data[name] = value;
            });
            if (isValid === true) {
                $.post(REVIEW_CREATE_API, data).done(function(response) {
                    console.log(response);
                });
            }
        });
    });
})(jQuery);