(function (w, d, $) {
    "use strict";

    $(function () {
        console.info('The site developed by BRAIN WORKS digital agency');
        console.info('Сайт разработан маркетинговым агентством BRAIN WORKS');

        var w = $(w);
        var d = $(d);
        var html = $('html');
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        if (isMobile) {
            html.addClass('is-mobile');
        }

        html.removeClass('no-js').addClass('js');

        reviews('.js-reviews');
        scrollTop('.js-scroll-top');
        stickFooter('.footer', '.page-wrapper');
        wrapHighlightedElements('.highlighted');
        // hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
        anotherHamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
        buyOneClick('.one-click', '[data-field-id="field7"]', 'h1.page-name');

        // On Copy
        d.on('copy', addLink);

        w.on('resize', function (e) {
            if (w.innerWidth >= 630) {
                removeAllStyles($('.js-menu'));
            }
        });
    });

    /**
     * Stick Footer
     *
     * @example
     * stickFooter('.js-footer', '.js-wrapper');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     *
     * @param {(string|Object)} footer - footer element
     * @param {(string|Object)} container - container element
     * @returns {void}
     */
    function stickFooter(footer, container) {
        var el = $(footer);
        var height = (el.outerHeight() + 20) + 'px';

        $(container).css('paddingBottom', height);
    }

    /**
     * Reviews - Slick Slider
     *
     * @example
     * reviews('.js-reviews');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} container - reviews container
     * @returns {void}
     */
    function reviews(container) {
        var element = $(container);

        if (element.children().length > 1 && typeof $.fn.slick === 'function') {
            element.slick({
                adaptiveHeight: false,
                autoplay: false,
                autoplaySpeed: 3000,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev">&laquo;</button>',
                nextArrow: '<button type="button" class="slick-next">&raquo;</button>',
                dots: false,
                dotsClass: 'slick-dots',
                draggable: true,
                fade: false,
                infinite: true,
                responsive: [],
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 300,
                swipe: true,
                zIndex: 10,
            });

            element.on('swipe', function (slick, direction) {

            });

            element.on('afterChange', function (slick, currentSlide) {

            });

            element.on('beforeChange', function (slick, currentSlide, nextSlide) {

            });
        }
    }

    /**
     * Hamburger Menu
     *
     * @example
     * hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} menuElement - Selected menu
     * @param {(string|Object)} hamburgerElement - Trigger element for open/close menu
     * @param {(string|Object)} closeTrigger - Trigger element for close opened menu
     * @returns {void}
     */
    function hamburgerMenu(menuElement, hamburgerElement, closeTrigger) {
        var menu = $(menuElement),
            close = $(closeTrigger),
            hamburger = $(hamburgerElement),
            menuAll = hamburger.add(menu);

        hamburger.add(close).on('click', function () {
            menu.toggleClass('is-active');
        });

        $(window).on('load', function (e) {
            if (document.location.hash !== '') {
                scrollToElement(document.location.hash);
            }
        });

        $(window).on('click', function (e) {
            if (!$(e.target).closest(menuAll).length) {
                menu.removeClass('is-active');
            }
        });
    }

    /**
     * Скролл к элементу
     *
     * @param {string|object} elements Элементы, которым добавляем Handler
     * @returns {void}
     */
    function scrollHandlerForButton(elements) {
        elements = $(elements);

        for (var i = 0; i < elements.length; i++) {

            var el = elements.eq(i);

            el.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                scrollToElement($(e.target.hash), function () {
                    document.location.hash = e.target.hash;
                });
            });

        }
    }

    /**
     * Скроллим к элементу
     *
     * @param {object|string} element
     * @param callback
     * @returns {void}
     */
    function scrollToElement(element, callback) {
        element = $(element);

        $('html, body').animate({
            scrollTop: element.offset().top
        }, 600, function () {
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    function anotherHamburgerMenu(menuElement, hamburgerElement, closeTrigger) {
        var Elements = {
            menu: $(menuElement),
            button: $(hamburgerElement),
            close: $(closeTrigger),
        };

        Elements.button.add(Elements.close).on('click', function () {
            Elements.menu.toggleClass('is-active');
        });

        var arrowOpener = function (parent) {
            var activeArrowClass = 'menu-item-has-children-arrow-active';

            return $('<button />')
                .addClass('menu-item-has-children-arrow')
                .on('click', function (ev) {
                    parent.children('.sub-menu').eq(0).slideToggle(300);
                    if ($(this).hasClass(activeArrowClass)) $(this).removeClass(activeArrowClass);
                    else $(this).addClass(activeArrowClass);
                })
        };

        var items = Elements.menu.find('.menu-item-has-children, .sub-menu-item-has-children');

        for (var i = 0; i < items.length; i++) {
            items.eq(i).append(arrowOpener(items.eq(i)));
        }
    }

    function removeAllStyles(elementParent) {
        elementParent.find('.sub-menu').removeAttr('style');
    }

    /**
     * Оборачиваем все Highlighted елементы в блок
     *
     * @param {string|object} elements
     * @returns {void}
     */
    function wrapHighlightedElements(elements) {
        elements = $(elements);

        for (var i = 0; i < elements.length; i++) {
            var highlightedHeader = elements.eq(i);

            highlightedHeader.wrap('<div style="display: block;"></div>');
        }
    }

    /**
     * Buy in one click
     *
     * @example
     * buyOneClick('.one-click', '[data-field-id="field7"]', 'h1.page-name');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} button - The selected button when clicking on which the form of purchase pops up
     * @param {(string|Object)} field - The selected field for writing the value (disabled field)
     * @param {(string|Object)} headline - The element from which we get the value to write to the field
     * @returns {void}
     */
    function buyOneClick(button, field, headline) {
        var btn = $(button);

        if (btn.length) {
            btn.on('click', function () {
                $(field).prop('disabled', true).val($(headline).text());
            });
        }
    }

    /**
     * Scroll Top
     *
     * @example
     * scrollTop('.js-scroll-top');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} element - Selected element
     * @returns {void}
     */
    function scrollTop(element) {
        var el = $(element);

        el.on('click touchend', function () {
            $('html, body').animate({scrollTop: 0}, 'slow');
            return false;
        });

        $(window).on('scroll', function () {
            var scrollPosition = $(this).scrollTop();

            if (scrollPosition > 200) {
                if (!el.hasClass('is-visible')) {
                    el.addClass('is-visible');
                }
            } else {
                el.removeClass('is-visible');
            }
        });
    }

    /**
     * Adding link to the site resource at copying
     *
     * @example
     * document.oncopy = addLink; or $(document).on('copy', addLink);
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @returns {void}
     */
    function addLink() {
        var body = document.body || document.getElementsByTagName('body')[0];
        var selection = window.getSelection();
        var page_link = '\n Источник: ' + document.location.href;
        var copy_text = selection + page_link;
        var div = document.createElement('div');

        div.style.position = 'absolute';
        div.style.left = '-9999px';

        body.appendChild(div);
        div.innerText = copy_text;

        selection.selectAllChildren(div);

        window.setTimeout(function () {
            body.removeChild(div);
        }, 0);
    }

})(window, document, jQuery);
