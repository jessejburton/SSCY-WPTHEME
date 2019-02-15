var banner = document.querySelector('.banner');

// Initialize the Animate on Scroll library
AOS.init({
  easing: 'ease-in-quad'
});

// Make sure the header and navigation show up correctly
if (banner) {
  document.querySelectorAll('.banner__container')[0].classList.add('active');
  document.querySelectorAll('.news__container')[0].classList.add('active');

  var icons = document.querySelectorAll('.banner__icon');
  icons.forEach(function(elm) {
    elm.addEventListener('click', function(e) {
      showBannerByIndex(e.target.dataset.banner);
    });
  });

  var newsIcons = document.querySelectorAll('.news__icon');
  newsIcons.forEach(function(elm) {
    elm.addEventListener('click', function(e) {
      showNewsByIndex(e.target.dataset.news);
    });
  });

  document
    .querySelector('.banner__arrow--prev')
    .addEventListener('click', showPrevBanner);
  document
    .querySelector('.banner__arrow--next')
    .addEventListener('click', showNextBanner);

  //var bannerInterval = setInterval(showNextBanner, 6500);
  setTimeout(showNextBanner, 3000);
  var newsInterval = setInterval(showNextNews, 5000);

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

/* END BANNER SCROLLING */

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
    var selector = '.teacher-' + $(this).data('id');

    openModal(selector);
  });

  // Class Details
  $(document).on('click', '.class__name-link', function() {
    var selector = '.class-' + $(this).data('id');
    openModal(selector);
  });

  // Register
  $(document).on('click', '.button--register', function(e) {
    // So that it can be updated later when the person finished registration
    $(this).addClass('active');

    $('.registration-form .class__name').html($(this).data('class-name'));
    $('.registration-form .class__date').html(
      $(this).data('class-date-styled')
    );
    $('.registration-form #class_date').val($(this).data('class-date'));
    $('.registration-form #class_id').val($(this).data('class-id'));

    openModal('.registration-form', closeModal, register);
  });

  // Logout
  $(document).on('click', '.logout', function(e) {
    $.ajax({
      url: '/saltspringcentre/logout.php',
      method: 'POST',
      success: function(response) {
        // refresh the page
        location.reload();
      }
    });
  });

  // Register
  function register() {
    var elm = $('.button--register.active');

    // Prepare the data
    var registrant = {
      name_first: $('.modal #name_first').val(),
      name_last: $('.modal #name_last').val(),
      email: $('.modal #email').val(),
      class_id: $('.modal #class_id').val(),
      class_date: $('.modal #class_date').val(),
      waiver: $('.modal #waiver_checkbox').is(':checked')
    };

    /* ERROR TRAPPING */
    if (!registrant.waiver) {
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
      url: '/saltspringcentre/register.php',
      data: registrant,
      method: 'POST',
      success: function(response) {
        response = JSON.parse(response);
        if (response.success) {
          elm.addClass('button--unregister');
          elm.removeClass('button--register');
          elm.removeClass('.active');
          elm.html('unregister');
          elm.data('registration-id', response.registration_id);
          alert('You have been registered for this class');
          closeModal();
        } else {
          alert(
            'Somthing went wrong. Sorry for the invonvenience. Please try again later.'
          );
        }
      }
    });
  }

  // Register
  $(document).on('click', '.button--unregister', function(e) {
    var elm = $(this);
    var registrationID = elm.data('registration-id');

    // Prepare the data
    var data = {
      registration_id: registrationID
    };

    $.ajax({
      url: '/saltspringcentre/unregister.php',
      data: data,
      method: 'POST',
      success: function(response) {
        response = JSON.parse(response);
        if (response.success) {
          elm.removeClass('button--unregister');
          elm.addClass('button--register');
          elm.html('register');
          alert('You have been unregistered for this class');
        }
      }
    });
  });
})(jQuery);

/* Mobile Menu */
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

// Click handler for Mobile Menu Button
document
  .querySelector('.mobile__button')
  .addEventListener('click', function(e) {
    toggleMenu();
  });

/* Responsive Videos */
// Add a class to any paragraph that contains an iframe (embeded video)
var videos = document.querySelectorAll('iframe').forEach(function(elm) {
  elm.parentElement.classList.add('iframe-container');
});

// Modal
var modalOpen = false;
function openModal(selector, cancel, action) {
  if (cancel === undefined) {
    cancel = closeModal;
  }
  if (action === undefined) {
    action = function() {
      alert('hello');
    };
  }

  // Copy the content
  var modalContent = document.querySelector('.modal__content-html');
  var content = document.querySelector(selector);

  modalContent.innerHTML = content.innerHTML;

  // Add the button handlers if the buttons exist
  var cancelButton = document.querySelector('.modal .modal__cancel');
  var actionButton = document.querySelector('.modal .modal__action');

  if (cancelButton) {
    cancelButton.addEventListener('click', cancel);
  }
  if (actionButton) {
    actionButton.addEventListener('click', action);
  }

  showModal();
}

function showModal() {
  showBlur();

  document.querySelector('.modal').classList.add('open');
}

function closeModal() {
  document.querySelector('.modal').classList.remove('open');

  setTimeout(hideBlur, 500);
}

function toggleBlur() {
  // Find out if the page is blurred
  var isBlur = document.querySelectorAll('.blur').length > 0;

  if (!isBlur) {
    showBlur();
  } else {
    hideBlur();
  }
}

function showBlur() {
  document.querySelector('.main').classList.add('blur');
  document.querySelector('.header').classList.add('blur');
  document.querySelector('.footer').classList.add('blur');
  document.querySelector('body').classList.add('no-scroll');
}

function hideBlur() {
  document.querySelector('.main').classList.remove('blur');
  document.querySelector('.header').classList.remove('blur');
  document.querySelector('.footer').classList.remove('blur');
  document.querySelector('body').classList.remove('no-scroll');
}

// Close click handler
document.querySelector('.modal__close').addEventListener('click', closeModal);

// Psuedo Styling
var UID = {
  _current: 0,
  getNew: function() {
    this._current++;
    return this._current;
  }
};

/* NEWS SCROLLING */

function showNewsByIndex(index) {
  clearInterval(newsInterval);

  var news = document.querySelectorAll('.news__container');
  var icons = document.querySelectorAll('.news__icon');
  var activeIndex = indexOfClass(news, 'active');

  news[activeIndex].classList.remove('active');
  icons[activeIndex].classList.remove('active');

  news[index].classList.add('active');
  icons[index].classList.add('active');
}

function showNextNews() {
  var news = document.querySelectorAll('.news__container');
  var icons = document.querySelectorAll('.news__icon');
  var index = indexOfClass(news, 'active');

  news[index].classList.remove('active');
  icons[index].classList.remove('active');

  var nextNews = news[index + 1];

  if (nextNews !== undefined) {
    nextNews.classList.add('active');
    icons[index + 1].classList.add('active');
  } else {
    showFirstNews();
  }
}

function showPrevBanner() {
  var banners = document.querySelectorAll('.news__container');
  var icons = document.querySelectorAll('.news__icon');
  var index = indexOfClass(banners, 'active');

  news[index].classList.remove('active');
  icons[index].classList.remove('active');

  var prevNews = news[index - 1];

  if (prevNews !== undefined) {
    prevNews.classList.add('active');
    icons[index - 1].classList.add('active');
  } else {
    showLastNews();
  }
}

function showFirstNews() {
  var news = document.querySelectorAll('.news__container');
  var firstNews = news[0];

  firstNews.classList.add('active');
  document.querySelectorAll('.news__icon')[0].classList.add('active');
}

function showLastNews() {
  var banners = document.querySelectorAll('.news__container');
  var lastNews = news[news.length - 1];

  lastNews.classList.add('active');
  document
    .querySelectorAll('.news__icon')
    [news.length - 1].classList.add('active');
}

/* END BANNER SCROLLING */
