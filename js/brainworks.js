(function ($) {
	"use strict";

	$(function() {
        console.info("The site developed by BRAIN WORKS digital agency");
        console.info("Сайт разработан маркетинговым агентством BRAIN WORKS");

        $('html').removeClass('no-js').addClass('js');

        // prefooter height
        var prefooterHeight = $("#prefooter").outerHeight();
        var footerHeight = $("#page-footer").outerHeight();
        var footerAndPreFooterSum = prefooterHeight + footerHeight + 50;
        $(".page-wrapper").css({
            "padding-bottom": footerAndPreFooterSum + "px"
        });
        // prefooter height end
  });
})(jQuery);
