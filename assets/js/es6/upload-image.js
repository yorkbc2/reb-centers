'use strict';

(($) => {
	const uploadForms = $(".upload-image"),
		availableTypes = ["image/jpeg", "image/png"],
		readFile = (file) => {
			return new Promise((resolve, reject) => {
				if (window.File && window.FileReader && window.Blob)
				{
					const reader = new FileReader();
					reader.onload = () => {
						resolve(reader.result);
					};
					reader.onerror = () => {
						reject("Something went wrong while reading!", reader);
					}
					reader.readAsDataURL(file);
				}
				else
				{
					reject("This browser doens't support File Readers");
				}
			});
		},
		inArray = (val, arr) => {
			return arr.indexOf(val) !== -1;
		};

	uploadForms.each((index, form) => {
		const $form = $(form),
			trigger = $form.find(".trigger"),
			preview = $form.find(".preview"),
			input   = $form.find(".input");
		
		let choosedImage = dynamicObject(null);

		choosedImage.on("changeValue", (file, save) => {
			readFile(file)
				.then((data) => {
					preview.attr("src", data);
					trigger.html(`Вы выбрали файл ${file.name}`);
				});
			save(file);
		});

		input.on("change", (e) => {
			const {files} = e.target;
			if (files.length !== 1)
			{
				console.warn("Input doens't work fine!");
				return;
			}
			const singleFile = files[0];
			if (singleFile.size > 10e6)
			{
				alert("Maximum image size - 10MB");
				return;
			}
			if (!inArray(singleFile.type, availableTypes))
			{
				alert("Please, upload correct image type!");
				return;
			}
			choosedImage.handle("changeValue", files[0]);
		});

		$form.on("submit", (e) => {
			e.preventDefault();
			
			const formData = new FormData();
			
			$form.find("input[type=hidden]").each((index, field) => {
				formData.append(field.name, field.value);
			});
			formData.append("image", choosedImage.get());

			$.ajax({
				url: $form.attr("action"), 
				data: formData,
				processData: false,
				contentType: false,
				type: 'POST',
				success: (response) => {
					$(".profile-image").attr("src", response);
				}
			})
		})
	});

	const $hide = (jqueryElement) => () => jqueryElement.hide();

	$(".modal-window").each((index, modal) => {
		let $modal = $(modal);
		$modal.find(".modal-background").on("click", $hide($modal));
		$modal.find(".modal-close").on("click", $hide($modal));
	});

	$(".modal-trigger").each((index, trigger) => {
		let $trigger = $(trigger);
		let $modal = $($trigger.attr("data-modal"));
		$trigger.on("click", () => {
			$modal.toggle();
		});
	});
})(jQuery)