jQuery(document).ready(function( $ ) {


    $(".dropdown-menu").each(function() {
        $(this).css({
           'left' : '60%',
           'margin-left' : $(this).width() / 2 * - 1 + 'px'
        });
    });
    $('li.menu-item-has-children > a').after('<div class="mobile-menu-toggle"><i class="fal fa-angle-down"></i></div>');


    //Mobile Stuff
    $(window).resize(function() {
         if ($(window).width() < 768) {

        } else {
            //Centering submenus to parent links

            $(".dropdown-menu").each(function() {
                $(this).css({
                   'left' : '60%',
                   'margin-left' : $(this).width() / 2 * - 1 + 'px'
                });
            });
        }
    });

    $('.unfolded-content').width($(window).width());


    //Adding class when scrolled
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
         //>=, not <=
        if (scroll >= 1) {
            //clearHeader, not clearheader - caps H
            $(".header").addClass("fixed");
        } else {
            $(".header").removeClass("fixed");
        }
    }); //missing );

    //Service Slideshow
    $('.service-slider').each(function(){
        var id = $(this).attr('id');
        // var ul = $('#'+id).find('ul');
        // console.log(id);

        var sSlider = new Swiper('.slide-'+id, {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoHeight: true,

            // If we need pagination
            pagination: {
              el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
              el: '.swiper-scrollbar',
            },
        });
    });

    //Home page slideshow
    var mySwiper = new Swiper ('.swiper-container', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,

      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },

      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

      // And if we need scrollbar
      scrollbar: {
        el: '.swiper-scrollbar',
      },
    })

    $('#accordion').collapse({
      toggle: false
    })
    //Subsidiary Picker
    $('.folding-menu').foldingContent({
      menuSelector: '.folding-menu',
      menuItemSelector: '.menu-item',
      contentSelector: '.folding-content',
      unfoldBeforeMarkup: '<li>',
      unfoldAfterMarkup: '</li>',
      closeMarkup: '<span class="your-icon-class">X</span>'
    });
   //
   $('#toggleAccordions-show').on('click', function(e) {
      $('#accordion .collapse').attr('aria-expanded', 'true');
      $('.card-header button').attr('aria-expanded', 'true');
      $('#accordion .collapse').addClass('show');
  })
  $('#toggleAccordions-hide').on('click', function(e) {
      $('#accordion .collapse').attr('aria-expanded', 'true');
      $('.card-header button').attr('aria-expanded', 'false');
      $('#accordion .collapse').collapse('hide');
  })

    $(".collapse.show").each(function(){
        $(this).prev(".card-header").find(".fas").addClass("fa-caret-up").removeClass("fa-caret-down");
    });

    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".card-header").find(".fas").removeClass("fa-caret-down").addClass("fa-caret-up");
    }).on('hide.bs.collapse', function(){
        $(this).prev(".card-header").find(".fas").removeClass("fa-caret-up").addClass("fa-caret-down");
    });
});
