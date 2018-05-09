function toggleMenu(index) {
	var element = document.getElementsByClassName("menu-header")[index];
  element.classList.toggle("open");
}

(function($) {
  $(document).ready(function() {
    // Expanding header image
    $(window).on('scroll', function() {
      if($(window).scrollTop() < 1000) {
        $('.hero').css('background-size', 100 + parseInt($(window).scrollTop() / 5) + '%');
        $('.hero').css('opacity', 1 - ($(window).scrollTop() * .003));
      }
    });

    // Banner Clicking
    var banners = $(".branding").length;
    if(banners > 1){
      $(".hero__navigation").css("opacity", 1);
    }
    
    $(".hero__navigation a").on("click", function(){
      clearInterval(banner_scroll);
      $(".hero__navigation a.active").removeClass("active");
      $(this).addClass("active");
      $(".branding.active").removeClass("active");
      $(".branding").eq($(this).index()).addClass("active");
    });

    // Banner Scrolling
    var banner_scroll = setInterval( scrollBanner, 5000 );

    // Banner Arrow Navigating 
    $(document).on("click", ".banner__arrow--left", function(){
      clearInterval(banner_scroll); // stop the scrolling
      showPrevBanner();
    });

    $(document).on("click", ".banner__arrow--right", function(){
      clearInterval(banner_scroll); // stop the scrolling      
      showNextBanner();
    });

  });

  function scrollBanner(){
    if($('.branding:hover').length == 0) {
      showPrevBanner();
    };
  }

  function showNextBanner(){
    // find out which is the next banner to show
    var nextBanner = $(".branding.active").next();
    if(nextBanner.length == 0) {
      nextBanner = $(".branding").eq(0);
    }
  
    // Make the next banner active to show it
    $(".branding.active").removeClass("active");
    nextBanner.addClass("active");

    // select the correct navigation link
    $(".hero__navigation a.active").removeClass("active");
    $(".hero__navigation a").eq($(".branding.active").index()).addClass("active");
  }

  function showPrevBanner(){
    // find out which is the next banner to show
    var prevBanner = $(".branding.active").prev();
    if(prevBanner.length == 0) {
      prevBanner = $(".branding").eq($(".branding").length - 1);
    }
  
    // Make the next banner active to show it
    $(".branding.active").removeClass("active");
    prevBanner.addClass("active");

    // select the correct navigation link
    $(".hero__navigation a.active").removeClass("active");
    $(".hero__navigation a").eq($(".branding.active").index()).addClass("active");
  }

  /* YOGA SCHEDULE */

  // Teacher Details
  $(document).on("click", ".class__teacher_link", function(){
    $(this).parents(".class").next().next().toggleClass("show");
  });

  // Class Details
  $(document).on("click", ".class__description_link", function(){
    $(this).parents(".class").next().toggleClass("show");
  });  

})( jQuery );
