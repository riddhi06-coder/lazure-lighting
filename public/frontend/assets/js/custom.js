// Banner Carousel / Owl Carousel 
  if ($('.banner-carousel').length) {
    $('.banner-carousel').owlCarousel({
      animateOut: 'fadeOut',
        animateIn: 'fadeIn',
      loop:true,
      margin:0,
      nav:true,
      mouseDrag: false,
      smartSpeed: 1000,
      autoHeight: true,
      autoplay: true,
      autoplayTimeout:10000,
      navText: ['<img src="https://mbihosting.in/lazure/html/images/icons/left-arrow-white.svg">', '<img src="https://mbihosting.in/lazure/html/images/icons/right-arrow-white.svg">'],
      responsive:{
        0:{
          items:1,
          nav:false,
        },
        991:{
          items:1,
        },
        1024:{
          items:1
        },
      }
    }); 
  }


$(document).ready(function() {
  var owl = $('.products');
  owl.owlCarousel({
    margin: 20,
    loop: true,
    dots: true,
    autoplay: false,
    autoplayTimeout: 4500,
    navText: ['<img src="https://mbihosting.in/lazure/html/images/icons/left-arrow-white.svg">', '<img src="https://mbihosting.in/lazure/html/images/icons/right-arrow-white.svg">'],
    responsive: {
      0: {
          items: 1
      },
      576: {
          items: 1
      },
      768: {
          items: 2,
          nav: true,
      },
      992: {
          items: 3,
          nav: true,
      },
      1200: {
          items: 3,
          nav: true,
      },
      1440: {
          items: 3,
          nav: true,
      }
    }
  })
})


// Portfolio Home owlCarousel
$(".projects-wrap-carousel").owlCarousel({
  loop: true,
  margin: 30,
  autoHeight: false,
  autoplayTimeout: 5000,
  dots: true,
  nav: true,
  navText: ['<img src="https://mbihosting.in/lazure/html/images/icons/left-arrow-white.svg">', '<img src="https://mbihosting.in/lazure/html/images/icons/right-arrow-white.svg">'],
  responsiveClass: true,
  responsive: {
      0: {
          dots: true,
          items: 1,
      },
      600: {
          dots: true,
          items: 1,
      },
      1000: {
          dots: true,
          items: 2,
      }
  }
});

$(".related-product-carousel").owlCarousel({
  loop: true,
  margin: 30,
  autoHeight: false,
  autoplayTimeout: 5000,
  dots: true,
  nav: true,
  navText: ['<img src="https://mbihosting.in/lazure/html/images/icons/left-arrow-white.svg">', '<img src="https://mbihosting.in/lazure/html/images/icons/right-arrow-white.svg">'],
  responsiveClass: true,
  responsive: {
      0: {
          dots: true,
          items: 1,
      },
      600: {
          dots: true,
          items: 1,
      },
      1000: {
          dots: true,
          items: 3,
      }
  }
});


 $('.articales-carousel').owlCarousel({
  loop: true,
  margin: 20,
  mouseDrag: true,
  autoplay: false,
  dots: true,
  autoplayHoverPause: true,
  nav: false,
  navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
  responsiveClass: true,
  responsive: {
      0: {
          items: 1,
      },
      600: {
          items: 2
      },
      1000: {
          items: 3
      }
  }
});


   // if($('.service-block-two .inner-box').length) {
   //    const $boxes = $('.service-block-two .inner-box');

   //    if ($boxes.length) {
   //      $boxes.on('click', function () {
   //        $boxes.removeClass('active');
   //        $('.service-block-two .content-box').slideUp().removeClass('active');

   //        $(this).addClass('active');
   //        $(this).find('.content-box').slideDown().addClass('active');
   //      });
   //    }
   //  }


if ($(".title-anim").length) {
  let staggerAmount = 0.01,
  delayValue = 0.1,
  easeType = "power1.inout",
  animatedTitleElements = document.querySelectorAll(".title-anim");

  animatedTitleElements.forEach(element => {
    let animatedTitleElements = new SplitText(element, {
        types: "lines, words",
    });
    gsap.from(animatedTitleElements.chars, {
        y: "100%",
        duration: 0.5,
        delay: delayValue,
        autoAlpha: 0,
        stagger: staggerAmount,
        ease: easeType,
        scrollTrigger: { trigger: element, start: "top 85%" },
    });
  });
}


AOS.init({
  once: true
})


$('.detail').owlCarousel({
  loop:true,
  margin:10,
  nav:true,
  autoplay: true,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})

$(document).ready(function () {
  $('#lightSlider').lightSlider({
    item: 1,
    loop: true,
    slideMargin: 0,
    gallery: true,
    thumbItem: 5
  });
});


// Sections background image from data background
    var pageSection = $(".bg-img, section");
    pageSection.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });