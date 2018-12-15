"use strict";

(function(w, d, $) {
    $(function() {
        console.info("The site developed by BRAIN WORKS digital agency");
        console.info("Сайт разработан маркетинговым агентством BRAIN WORKS");
        var w = $(w);
        var d = $(d);
        var html = $("html");
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        if (isMobile) {
            html.addClass("is-mobile");
        }
        html.removeClass("no-js").addClass("js");
        reviews(".js-reviews");
        scrollTop(".js-scroll-top");
        stickFooter(".js-footer", ".js-container");
        wrapHighlightedElements(".highlighted");
        anotherHamburgerMenu(".js-menu", ".js-hamburger", ".js-menu-close");
        buyOneClick(".one-click", '[data-field-id="field7"]', "h1.page-name");
        scrollToElement();
        d.on("copy", addLink);
        w.on("resize", function() {
            if (w.innerWidth >= 630) {
                removeAllStyles($(".js-menu"));
            }
        });
        if ($(".siema").is("div")) {
            var siemaGallery = new Siema({
                perPage: {
                    1024: 3,
                    768: 2,
                    480: 1
                },
                duration: 400
            });
            $(".rehab-gallery-arrow.prev").on("click", function(e) {
                siemaGallery.prev(1);
            });
            $(".rehab-gallery-arrow.next").on("click", function(e) {
                siemaGallery.next(1);
            });
            var gallery = new BrainWorksCustomGallery(".rehab-gallery");
        }
    });
    var stickFooter = function stickFooter(footer, container) {
        var el = $(footer);
        var height = el.outerHeight() + 20 + "px";
        $(container).css("paddingBottom", height);
    };
    var reviews = function reviews(container) {
        var element = $(container);
        if (element.children().length > 1 && typeof $.fn.slick === "function") {
            element.slick({
                adaptiveHeight: false,
                autoplay: false,
                autoplaySpeed: 3e3,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev">&laquo;</button>',
                nextArrow: '<button type="button" class="slick-next">&raquo;</button>',
                dots: false,
                dotsClass: "slick-dots",
                draggable: true,
                fade: false,
                infinite: true,
                responsive: [],
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 300,
                swipe: true,
                zIndex: 10
            });
        }
    };
    var anotherHamburgerMenu = function anotherHamburgerMenu(menuElement, hamburgerElement, closeTrigger) {
        var Elements = {
            menu: $(menuElement),
            button: $(hamburgerElement),
            close: $(closeTrigger)
        };
        Elements.button.add(Elements.close).on("click", function() {
            Elements.menu.toggleClass("is-active");
        });
        var arrowOpener = function arrowOpener(parent) {
            var activeArrowClass = "menu-item-has-children-arrow-active";
            return $("<button />").addClass("menu-item-has-children-arrow").on("click", function() {
                parent.children(".sub-menu").eq(0).slideToggle(300);
                if ($(this).hasClass(activeArrowClass)) {
                    $(this).removeClass(activeArrowClass);
                } else {
                    $(this).addClass(activeArrowClass);
                }
            });
        };
        var items = Elements.menu.find(".menu-item-has-children, .sub-menu-item-has-children");
        for (var i = 0; i < items.length; i++) {
            items.eq(i).append(arrowOpener(items.eq(i)));
        }
    };
    var removeAllStyles = function removeAllStyles(elementParent) {
        elementParent.find(".sub-menu").removeAttr("style");
    };
    var wrapHighlightedElements = function wrapHighlightedElements(elements) {
        elements = $(elements);
        var i, highlightedHeader;
        for (i = 0; i < elements.length; i++) {
            highlightedHeader = elements.eq(i);
            highlightedHeader.wrap('<div style="display: block;"></div>');
        }
    };
    var buyOneClick = function buyOneClick(button, field, headline) {
        var btn = $(button);
        if (btn.length) {
            btn.on("click", function() {
                $(field).prop("disabled", true).val($(headline).text());
            });
        }
    };
    var scrollTop = function scrollTop(element) {
        var el = $(element);
        el.on("click touchend", function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });
        var scrollPosition;
        $(window).on("scroll", function() {
            scrollPosition = $(this).scrollTop();
            if (scrollPosition > 200) {
                if (!el.hasClass("is-visible")) {
                    el.addClass("is-visible");
                }
            } else {
                el.removeClass("is-visible");
            }
        });
    };
    var addLink = function addLink() {
        var body = document.body || document.getElementsByTagName("body")[0];
        var selection = window.getSelection();
        var page_link = "\n Источник: " + document.location.href;
        var copy_text = selection + page_link;
        var div = document.createElement("div");
        div.style.position = "absolute";
        div.style.left = "-9999px";
        body.appendChild(div);
        div.innerText = copy_text;
        selection.selectAllChildren(div);
        window.setTimeout(function() {
            body.removeChild(div);
        }, 0);
    };
    var scrollToElement = function scrollToElement() {
        var animationSpeed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 400;
        var links = $("a");
        links.each(function(index, element) {
            var $element = $(element), href = $element.attr("href");
            if ($element.parent().parent().hasClass("rehab-tabs")) return false;
            if (href[0] === "#") {
                $element.on("click", function(e) {
                    e.preventDefault();
                    $("html, body").animate({
                        scrollTop: $(href).offset().top
                    }, animationSpeed);
                });
            }
        });
    };
    var BrainWorksCustomGallery = function BrainWorksCustomGallery(selector) {
        if (!$(selector).is("div")) return false;
        var state = {}, $root = $(".gallery-modal"), $image = $root.find("img.gallery-modal-image"), $imageSet = $root.find(".gallery-modal-images"), $source = $(selector), pictures = $source.find("img");
        Object.defineProperty(state, "images", {
            get: function get() {
                return state._images;
            },
            set: function set(images) {
                var parsedImages = [];
                images.each(function(index, image) {
                    var $image = $(image);
                    parsedImages.push({
                        src: $image.attr("src"),
                        width: $image.attr("data-source-width"),
                        height: $image.attr("data-source-height")
                    });
                });
                state._images = parsedImages;
                state._$images = images;
                state.currentImage = state._images[0];
            }
        });
        Object.defineProperty(state, "currentImage", {
            get: function get() {
                return state._currentImage;
            },
            set: function set(_ref) {
                var src = _ref.src, width = _ref.width, height = _ref.height;
                state._currentImage = {
                    src: src,
                    width: width,
                    height: height
                };
                $image.attr("src", src).attr("width", width).attr("height", height);
                return state._currentImage;
            }
        });
        state.images = pictures.each(function(index, picture) {
            var $picture = $(picture);
            $picture.on("click", function(e) {
                state.currentImage = state.images[index];
                $root.toggle();
            }).clone().appendTo($imageSet).on("click", function(e) {
                state.currentImage = state.images[index];
            });
        });
    };
    $(".tabs").each(function(index, tabElement) {
        var $element = $(tabElement), $anchors = $element.find("ul li a"), tabs = {}, $tabs = $element.find(".tab").each(function(index, tab) {
            tab = $(tab);
            tabs["#" + tab.attr("id")] = tab;
        }), current = $anchors.eq(0).attr("href");
        console.log($element);
        $tabs.hide().eq(0).show();
        $anchors.eq(0).addClass("_active");
        $anchors.on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            var $anchor = $(event.target);
            $anchors.removeClass("_active");
            $anchor.addClass("_active");
            $tabs.hide();
            tabs[$anchor.attr("href")].show();
        });
    });
    window.dynamicObject = function(defaultValue) {
        return {
            value: defaultValue,
            events: {},
            on: function on(eventName, callback) {
                this.events[eventName] = callback;
            },
            save: function save(value) {
                this.value = value;
            },
            handle: function handle(eventName, value) {
                this.events[eventName](value, this.save.bind(this));
            },
            get: function get() {
                return this.value;
            }
        };
    };
})(window, document, jQuery);