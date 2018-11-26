'use strict';

(($) => {
	const MAX_VALUE_LENGTH = 360,
		MIN_VALUE_LENGTH   = 0,
		REVIEW_CREATE_API  = "/wp-json/brainworks/reviews/add";
	
	let forms   = $(".review-form"),
		error   = "";

	forms.each((index, form) => {
		let $form = $(form);
		$form.on("submit", (e) => {
			e.preventDefault();
			let fields  = $form.find("textarea, input[type=hidden]"),
				data    = {},
				isValid = true,
				rating  = $form.find("input[name=rating]:checked");
			fields.each((index, field) => {
				let name = field.name,
					value = field.value,
					type  = field.type;
				if (field.tagName.toLowerCase() === "textarea")
				{
					type = "TEXT";
				}
				if (!name || !value) return isValid = false;
				if (!type || type != "hidden" || type != "radio" && (value.length < MIN_VALUE_LENGTH || value.length > MAX_VALUE_LENGTH)) 
				if ((value.length < MIN_VALUE_LENGTH || value.length > MAX_VALUE_LENGTH) && (type != "hidden" && type != "radio"))
				{
					return isValid = false;
				}

				data[name] = value;
			});

			data.rating = rating.val();			
			if (isValid === true)
			{
				
				$.post(REVIEW_CREATE_API, data)
					.done((response) => {
						let parent = $form.parent();
						$form.remove();
						parent
							.css("text-align", "center")
							.append(
								$("<p/>").html("Спасибо, за то что оставили отзыв! Вы получили +10 к карме!")
							);
					});
			}
		});

		
	});

	$(".rating-input").each((index, element) => {
		let el    = $(element),
			stars = el.find("label"),
			len   = stars.length,
			choosed = false;
		
		el.on("mouseout", (e) => {
			if(!choosed)
			{
				stars.find("i").removeClass("fa").addClass("fal")
			}
		});

		stars.each((index, star) => {
			$(star).on("mouseover", (e) => {
				for (let i = 0; i < len; i++) {
					if (i <= index)
					{
						stars[i].querySelector("i").classList.remove("fal");
						stars[i].querySelector("i").classList.add("fa");
					}
					else
					{
						stars[i].querySelector("i").classList.add("fal");
						stars[i].querySelector("i").classList.remove("fa");
					}
				}
			}).on("click", (e) => {
				choosed = true;
				el.find("input").each((inputIndex, input) => {	
					input.checked = inputIndex !== index;
				});	
			});	
		});
	})

})(jQuery);