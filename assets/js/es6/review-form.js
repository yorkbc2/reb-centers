'use strict';

(($) => {
	const MAX_VALUE_LENGTH = 360,
		MIN_VALUE_LENGTH   = 0,
		REVIEW_CREATE_API  = "/wp-json/brainworks/reviews/add";
	
	let forms   = $(".review-form"),
		error   = "";

	forms.each((index, form) => {
		$(form).on("submit", (e) => {
			e.preventDefault();
			let fields  = $(form).find("textarea, input"),
				data    = {},
				isValid = true;

			fields.each((index, field) => {
				let name = field.name,
					value = field.value,
					type  = field.type;
				console.log(value, type)
				if (!name || !value) return isValid = false;
				if (!type || type != "hidden" && value.length < MIN_VALUE_LENGTH || value.length > MAX_VALUE_LENGTH) return isValid = false;

				data[name] = value;
			});

			if (isValid === true)
			{
				$.post(REVIEW_CREATE_API, data)
					.done((response) => {
						console.log(response);
					});
			}
		});

		
	});

})(jQuery);