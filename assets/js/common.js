var currentBackground = 0;

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

    // change the background image
    currentBackground = !currentBackground;

    if(currentBackground == 0){
      $("body .hero").css("background-image", "url(images/intro-background.jpg)");
    } else {
      $("body .hero").css("background-image", "url(images/Lotus_Background.jpg)");
    }
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

      // change the background image
      currentBackground = !currentBackground;

      if(currentBackground == 0){
        $("body .hero").css("background-image", "url(images/intro-background.jpg)");
      } else {
        $("body .hero").css("background-image", "url(images/Lotus_Background.jpg)");
      }
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

  // Modal
  $(document).on("click", ".register-button", function(e){

    // So that it can be updated later when the person finished registration
    $(this).addClass("active");

    $(".modal .class__name").html($(this).data("class-name"));
    $(".modal .class__date").html($(this).data("class-date-styled"));
    $("#class_date").val($(this).data("class-date"));
    $("#class_id").val($(this).data("class-id"));

    openDialog();

  });

  // Logout
  $(document).on("click", ".logout", function(e){
    $.ajax({
        url: "/sandbox/logout.php",
        method: "POST",
        success: function(response){
          // refresh the page
          location.reload();
        }	
		});
  });

  // Register
  $(document).on("click", ".class-register", function(e){

    var elm = $(".register-button.active");
    
    // Prepare the data
    var registrant = {
      "name_first": $("#name_first").val(),
      "name_last": $("#name_last").val(),
      "email": $("#email").val(),
      "class_id": $("#class_id").val(),
      "class_date": $("#class_date").val()
    }

    $.ajax({
      url: "/wp-content/themes/saltspringcentre/sscy/register.php",
      data: registrant,
      method: "POST",
      success: function(response){
        response = JSON.parse(response);
        if(response.success){
          elm.addClass("un-register-button");
          elm.removeClass("register-button");
          elm.removeClass(".active");
          elm.html("unregister");
          elm.data("registration-id", response.registration_id);
          closeDialog();
          alert("You have been registered for this class");
        }
      }	
		});

  });

  // Register
  $(document).on("click", ".un-register-button", function(e){
    
    var elm = $(this);
    var registrationID = elm.data("registration-id");

    // Prepare the data
    var data = {
      "registration_id": registrationID
    }

    $.ajax({
      url: "/sandbox/unregister.php",
      data: data,
      method: "POST",
      success: function(response){
        response = JSON.parse(response);
        if(response.success){
          elm.removeClass("un-register-button");
          elm.addClass("register-button");
          elm.html("register");
          alert("You have been unregistered for this class");
        }
      }	
		});

  });

  $(document).on("click", ".modal__cancel", closeDialog);

})( jQuery );

function openDialog(){
  // Open the modal dialog
  document.getElementsByClassName("modal")[0].style.height = "100vh";
  document.getElementsByClassName("modal__window")[0].style.left = "15vw";
}

function closeDialog(){
  // Close the modal dialog
  document.getElementsByClassName("modal")[0].style.height = "0vh";
  document.getElementsByClassName("modal__window")[0].style.left = "100%";  
}