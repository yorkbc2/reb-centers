(function ($) {
	"use strict";

	$(document).ready(function() {
        console.info("The site developed by BRAIN WORKS digital agency");
        console.info("Сайт разработан маркетинговым агентством BRAIN WORKS");
        
        //prefooter height
        var prefooterHeight = jQuery("#prefooter").height();
        var footerHeight = jQuery("#page-footer").height();
        var footerAndPreFooterSum = prefooterHeight + footerHeight + 50;
        jQuery(".page-wrapper").css({
            "padding-bottom": footerAndPreFooterSum + "px"
        });
        //prefooter height end
	});
}(jQuery));



