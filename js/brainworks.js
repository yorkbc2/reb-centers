(function ($) {
  "use strict";

  $(function () {
    console.info('The site developed by BRAIN WORKS digital agency');
    console.info('Сайт разработан маркетинговым агентством BRAIN WORKS');
  
    var html = $('html');
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if(isMobile) {
      html.addClass('is-mobile');
    }
  
    html.removeClass('no-js').addClass('js');

    scrollTop('.js-scroll-top');

    // stick footer
    var footerHeight = $('.footer').outerHeight() + 20;
    $('.page-wrapper').css('padding-bottom', footerHeight + 'px');
    // end stick footer
  
    // Buy one click
    var oneClick = $('.one-click');
    if (oneClick.length) {
      oneClick.on('click', function () {
        $('[data-field-id="field7"]').val($('h1.product_title').text());
      });
    }
    // end buy one click

  });

  /**
   * Scroll Top
   *
   * @example
   * scrollTop('.js-scroll-top');
   * @author Fedor Kudinov <brothersrabbits@mail.ru>
   * @param {(string|Object)} element - selected element
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

})(jQuery);
