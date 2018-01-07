function toggleMenu(index) {
	var element = document.getElementsByClassName("menu-header")[index];
  element.classList.toggle("open");
}

// Expanding header image
(function($) {
  $(document).ready(function() {
    $(window).on('scroll', function() {
      if($(window).scrollTop() < 1000) {
        $('.hero').css('background-size', 100 + parseInt($(window).scrollTop() / 5) + '%');
        $('.hero .branding').css('top', 50 + ($(window).scrollTop() * .1) + '%');
        $('.hero, .hero .branding').css('opacity', 1 - ($(window).scrollTop() * .003));
      }
    });
  });
})( jQuery );