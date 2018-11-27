"use strict";

(function($) {
    var uploadForms = $(".upload-image"), availableTypes = [ "image/jpeg", "image/png" ], readFile = function readFile(file) {
        return new Promise(function(resolve, reject) {
            if (window.File && window.FileReader && window.Blob) {
                var reader = new FileReader();
                reader.onload = function() {
                    resolve(reader.result);
                };
                reader.onerror = function() {
                    reject("Something went wrong while reading!", reader);
                };
                reader.readAsDataURL(file);
            } else {
                reject("This browser doens't support File Readers");
            }
        });
    }, inArray = function inArray(val, arr) {
        return arr.indexOf(val) !== -1;
    };
    uploadForms.each(function(index, form) {
        var $form = $(form), trigger = $form.find(".trigger"), preview = $form.find(".preview"), input = $form.find(".input");
        var choosedImage = dynamicObject(null);
        choosedImage.on("changeValue", function(file, save) {
            readFile(file).then(function(data) {
                preview.attr("src", data);
                trigger.html("Вы выбрали файл ".concat(file.name));
            });
            save(file);
        });
        input.on("change", function(e) {
            var files = e.target.files;
            if (files.length !== 1) {
                console.warn("Input doens't work fine!");
                return;
            }
            var singleFile = files[0];
            if (singleFile.size > 1e7) {
                alert("Maximum image size - 10MB");
                return;
            }
            if (!inArray(singleFile.type, availableTypes)) {
                alert("Please, upload correct image type!");
                return;
            }
            choosedImage.handle("changeValue", files[0]);
        });
        $form.on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData();
            $form.find("input[type=hidden]").each(function(index, field) {
                formData.append(field.name, field.value);
            });
            formData.append("image", choosedImage.get());
            $.ajax({
                url: $form.attr("action"),
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function success(response) {
                    $(".profile-image").attr("src", response);
                }
            });
        });
    });
})(jQuery);