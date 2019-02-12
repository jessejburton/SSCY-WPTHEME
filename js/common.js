var banner = document.querySelector('.banner');

// Initialize the Animate on Scroll library
AOS.init({
  easing: 'ease-in-quad'
});

// Make sure the header and navigation show up correctly
if (banner) {
  document.querySelectorAll('.banner__container')[0].classList.add('active');

  var icons = document.querySelectorAll('.banner__icon');
  icons.forEach(function(elm) {
    elm.addEventListener('click', function(e) {
      showBannerByIndex(e.target.dataset.banner);
    });
  });

  document
    .querySelector('.banner__arrow--prev')
    .addEventListener('click', showPrevBanner);
  document
    .querySelector('.banner__arrow--next')
    .addEventListener('click', showNextBanner);

  var bannerInterval = setInterval(showNextBanner, 6500);

  setInterval(handleScroll, 10);
}

function handleScroll() {
  fadeHeader();
}

// Fade Header
function fadeHeader() {
  if (window.scrollY > 100) {
    banner.style.opacity = 1 - (window.scrollY - 100) * 0.003;
  } else {
    banner.style.opacity = 1;
  }
}

/* SCROLL TO ANCHOR */

if (window.location.hash.length > 0) {
  var anchor = window.location.hash.replace('#', '');
  var target = document.getElementById(anchor);
}

if (target) {
  var offset = 0,
    y = 0,
    dy;
  var call = setInterval(function() {
    if (Math.abs((dy = offset - y)) > 1) {
      y += dy / 8;
    } else {
      clearInterval(call);
      y = offset;
      scrolling = false;
    }
    document.documentElement.scrollTop = y;
  }, 20);
  offset = target.offsetTop - 50;
  y = document.documentElement.scrollTop;
}

/* BANNER SCROLLING */

function showBannerByIndex(index) {
  clearInterval(bannerInterval);

  var banners = document.querySelectorAll('.banner__container');
  var icons = document.querySelectorAll('.banner__icon');
  var activeIndex = indexOfClass(banners, 'active');

  banners[activeIndex].classList.remove('active');
  icons[activeIndex].classList.remove('active');

  banners[index].classList.add('active');
  icons[index].classList.add('active');
}

function showNextBanner(e) {
  // If this was called from a click then clear the rotating banner
  if (e !== undefined) {
    clearInterval(bannerInterval);
  } else {
    // Don't show next banner if hovering on a button or arrows
    // Tried adding this for hovering on text but feedback was
    // that people sometimes don't notice the transitions
    var activeButton = document.querySelector('.active .banner__button:hover');
    if (activeButton) return;
    var activeArrow = document.querySelector('.banner__arrow:hover');
    if (activeArrow) return;
  }

  var banners = document.querySelectorAll('.banner__container');
  var icons = document.querySelectorAll('.banner__icon');
  var index = indexOfClass(banners, 'active');

  banners[index].classList.remove('active');
  icons[index].classList.remove('active');

  var nextBanner = banners[index + 1];

  if (nextBanner !== undefined) {
    nextBanner.classList.add('active');
    icons[index + 1].classList.add('active');
  } else {
    showFirstBanner();
  }
}

function showPrevBanner() {
  // If this was called from a click then clear the rotating banner
  if (e !== undefined) {
    clearInterval(bannerInterval);
  }
  var banners = document.querySelectorAll('.banner__container');
  var icons = document.querySelectorAll('.banner__icon');
  var index = indexOfClass(banners, 'active');

  banners[index].classList.remove('active');
  icons[index].classList.remove('active');

  var prevBanner = banners[index - 1];

  if (prevBanner !== undefined) {
    prevBanner.classList.add('active');
    icons[index - 1].classList.add('active');
  } else {
    showLastBanner();
  }
}

function showFirstBanner() {
  var banners = document.querySelectorAll('.banner__container');
  var firstBanner = banners[0];

  firstBanner.classList.add('active');
  document.querySelectorAll('.banner__icon')[0].classList.add('active');
}

function showLastBanner() {
  var banners = document.querySelectorAll('.banner__container');
  var lastBanner = banners[banners.length - 1];

  lastBanner.classList.add('active');
  document
    .querySelectorAll('.banner__icon')
    [banners.length - 1].classList.add('active');
}

function indexOfClass(nodeList, className) {
  var counter = 0;
  var index = -1;

  nodeList.forEach(function(elm) {
    if (elm.classList.contains(className)) {
      index = counter;
    } else {
      counter++;
    }
  });

  return index;
}

/* END SCROLL TO ANCHOR */

/* YOGA SCHEDULE */
(function($) {
  // Teacher Details
  $(document).on('click', '.class__teacher-link', function() {
    $(this)
      .parents('.class')
      .next()
      .next()
      .toggleClass('show');
  });

  // Class Details
  $(document).on('click', '.class__name-link', function() {
    $(this)
      .parents('.class')
      .next()
      .toggleClass('show');
  });

  // Modal
  $(document).on('click', '.register-button', function(e) {
    // So that it can be updated later when the person finished registration
    $(this).addClass('active');

    $('.modal .class__name').html($(this).data('class-name'));
    $('.modal .class__date').html($(this).data('class-date-styled'));
    $('#class_date').val($(this).data('class-date'));
    $('#class_id').val($(this).data('class-id'));

    openDialog();
  });

  // Logout
  $(document).on('click', '.logout', function(e) {
    $.ajax({
      url: '/logout.php',
      method: 'POST',
      success: function(response) {
        // refresh the page
        location.reload();
      }
    });
  });

  // Register
  $(document).on('click', '.class-register', function(e) {
    var elm = $('.register-button.active');

    // Prepare the data
    var registrant = {
      name_first: $('#name_first').val(),
      name_last: $('#name_last').val(),
      email: $('#email').val(),
      class_id: $('#class_id').val(),
      class_date: $('#class_date').val()
    };

    /* ERROR TRAPPING */
    if (!document.getElementById('waiver_checkbox').checked) {
      alert(
        'Please make sure to read the terms and check the waiver checkbox.'
      );
      return false;
    }

    if (registrant.name_first.length == 0) {
      alert(
        'Please make sure to enter your first name. This information is required to validate signing the waiver.'
      );
      return false;
    }

    if (registrant.name_last.length == 0) {
      alert(
        'Please make sure to enter your last name. This information is required to validate signing the waiver.'
      );
      return false;
    }

    if (registrant.email.length == 0) {
      alert(
        'Please make sure to enter your email address. This information is required to validate signing the waiver.'
      );
      return false;
    }

    $.ajax({
      url: '/register.php',
      data: registrant,
      method: 'POST',
      success: function(response) {
        response = JSON.parse(response);
        if (response.success) {
          elm.addClass('un-register-button');
          elm.removeClass('register-button');
          elm.removeClass('.active');
          elm.html('unregister');
          elm.data('registration-id', response.registration_id);
          closeDialog();
          alert('You have been registered for this class');
        }
      }
    });
  });

  // Register
  $(document).on('click', '.un-register-button', function(e) {
    var elm = $(this);
    var registrationID = elm.data('registration-id');

    // Prepare the data
    var data = {
      registration_id: registrationID
    };

    $.ajax({
      url: '/unregister.php',
      data: data,
      method: 'POST',
      success: function(response) {
        response = JSON.parse(response);
        if (response.success) {
          elm.removeClass('un-register-button');
          elm.addClass('register-button');
          elm.html('register');
          alert('You have been unregistered for this class');
        }
      }
    });
  });

  $(document).on('click', '.modal__cancel', closeDialog);
})(jQuery);

function openDialog() {
  // Open the modal dialog
  document.getElementsByClassName('modal')[0].style.height = '100vh';
  document.getElementsByClassName('modal__window')[0].style.left = '15vw';
}

function closeDialog() {
  // Close the modal dialog
  document.getElementsByClassName('modal')[0].style.height = '0vh';
  document.getElementsByClassName('modal__window')[0].style.left = '100%';
}

var menuOpen = false;
function toggleMenu() {
  if (!menuOpen) {
    //document.querySelector('body').classList.add('open');
    document.querySelector('.mobile__button').classList.add('open');
    document.querySelector('.mobile__menu-background').classList.add('open');
    document.querySelector('.mobile__menu').classList.add('open');

    menuOpen = true;
  } else {
    //document.querySelector('body').classList.remove('open');
    document.querySelector('.mobile__button').classList.remove('open');
    document.querySelector('.mobile__menu-background').classList.remove('open');
    document.querySelector('.mobile__menu').classList.remove('open');

    menuOpen = false;
  }
}

document
  .querySelector('.mobile__button')
  .addEventListener('click', function(e) {
    toggleMenu();
  });

// Add a class to any paragraph that contains an iframe (embeded video)
var videos = document.querySelectorAll('iframe').forEach(function(elm) {
  elm.parentElement.classList.add('iframe-container');
});
