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
    var banner_scroll = setInterval( showNextBanner, 3000 );
  });

  function showNextBanner(){
    // Make sure the mouse isn't on the banner
    if($('.branding:hover').length == 0) {
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
  }

})( jQuery );
