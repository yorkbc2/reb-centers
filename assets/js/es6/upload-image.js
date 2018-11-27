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
			let parsed = readFile(file)
				.then((data) => {
					preview.attr("src", data);
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
	});
})(jQuery)