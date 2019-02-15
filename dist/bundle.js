/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "..";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(2);

__webpack_require__(3);

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


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
  icons.forEach(function (elm) {
    elm.addEventListener('click', function (e) {
      showBannerByIndex(e.target.dataset.banner);
    });
  });

  var newsIcons = document.querySelectorAll('.news__icon');
  newsIcons.forEach(function (elm) {
    elm.addEventListener('click', function (e) {
      showNewsByIndex(e.target.dataset.news);
    });
  });

  document.querySelector('.banner__arrow--prev').addEventListener('click', showPrevBanner);
  document.querySelector('.banner__arrow--next').addEventListener('click', showNextBanner);

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
  var call = setInterval(function () {
    if (Math.abs(dy = offset - y) > 1) {
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
  document.querySelectorAll('.banner__icon')[banners.length - 1].classList.add('active');
}

/* END BANNER SCROLLING */

function indexOfClass(nodeList, className) {
  var counter = 0;
  var index = -1;

  nodeList.forEach(function (elm) {
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
(function ($) {
  // Teacher Details
  $(document).on('click', '.class__teacher-link', function () {
    var selector = '.teacher-' + $(this).data('id');

    openModal(selector);
  });

  // Class Details
  $(document).on('click', '.class__name-link', function () {
    var selector = '.class-' + $(this).data('id');
    openModal(selector);
  });

  // Register
  $(document).on('click', '.button--register', function (e) {
    // So that it can be updated later when the person finished registration
    $(this).addClass('active');

    $('.registration-form .class__name').html($(this).data('class-name'));
    $('.registration-form .class__date').html($(this).data('class-date-styled'));
    $('.registration-form #class_date').val($(this).data('class-date'));
    $('.registration-form #class_id').val($(this).data('class-id'));

    openModal('.registration-form', closeModal, register);
  });

  // Logout
  $(document).on('click', '.logout', function (e) {
    $.ajax({
      url: '/saltspringcentre/logout.php',
      method: 'POST',
      success: function success(response) {
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
      alert('Please make sure to read the terms and check the waiver checkbox.');
      return false;
    }

    if (registrant.name_first.length == 0) {
      alert('Please make sure to enter your first name. This information is required to validate signing the waiver.');
      return false;
    }

    if (registrant.name_last.length == 0) {
      alert('Please make sure to enter your last name. This information is required to validate signing the waiver.');
      return false;
    }

    if (registrant.email.length == 0) {
      alert('Please make sure to enter your email address. This information is required to validate signing the waiver.');
      return false;
    }

    $.ajax({
      url: '/saltspringcentre/register.php',
      data: registrant,
      method: 'POST',
      success: function success(response) {
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
          alert('Somthing went wrong. Sorry for the invonvenience. Please try again later.');
        }
      }
    });
  }

  // Register
  $(document).on('click', '.button--unregister', function (e) {
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
      success: function success(response) {
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
document.querySelector('.mobile__button').addEventListener('click', function (e) {
  toggleMenu();
});

/* Responsive Videos */
// Add a class to any paragraph that contains an iframe (embeded video)
var videos = document.querySelectorAll('iframe').forEach(function (elm) {
  elm.parentElement.classList.add('iframe-container');
});

// Modal
var modalOpen = false;
function openModal(selector, cancel, action) {
  if (cancel === undefined) {
    cancel = closeModal;
  }
  if (action === undefined) {
    action = function action() {
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
  getNew: function getNew() {
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
  document.querySelectorAll('.news__icon')[news.length - 1].classList.add('active');
}

/* END BANNER SCROLLING */

/***/ })
/******/ ]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAgODkwYzUyMDBmYTM1MzdmNzdjZDIiLCJ3ZWJwYWNrOi8vLy4vc3JjL21haW4uanMiLCJ3ZWJwYWNrOi8vLy4vc3JjL3N0eWxlcy9zdHlsZS5zY3NzIiwid2VicGFjazovLy8uL2pzL2NvbW1vbi5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiYmFubmVyIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiQU9TIiwiaW5pdCIsImVhc2luZyIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJjbGFzc0xpc3QiLCJhZGQiLCJpY29ucyIsImZvckVhY2giLCJlbG0iLCJhZGRFdmVudExpc3RlbmVyIiwiZSIsInNob3dCYW5uZXJCeUluZGV4IiwidGFyZ2V0IiwiZGF0YXNldCIsIm5ld3NJY29ucyIsInNob3dOZXdzQnlJbmRleCIsIm5ld3MiLCJzaG93UHJldkJhbm5lciIsInNob3dOZXh0QmFubmVyIiwic2V0VGltZW91dCIsIm5ld3NJbnRlcnZhbCIsInNldEludGVydmFsIiwic2hvd05leHROZXdzIiwiaGFuZGxlU2Nyb2xsIiwiZmFkZUhlYWRlciIsIndpbmRvdyIsInNjcm9sbFkiLCJzdHlsZSIsIm9wYWNpdHkiLCJsb2NhdGlvbiIsImhhc2giLCJsZW5ndGgiLCJhbmNob3IiLCJyZXBsYWNlIiwiZ2V0RWxlbWVudEJ5SWQiLCJvZmZzZXQiLCJ5IiwiZHkiLCJjYWxsIiwiTWF0aCIsImFicyIsImNsZWFySW50ZXJ2YWwiLCJzY3JvbGxpbmciLCJkb2N1bWVudEVsZW1lbnQiLCJzY3JvbGxUb3AiLCJvZmZzZXRUb3AiLCJpbmRleCIsImJhbm5lckludGVydmFsIiwiYmFubmVycyIsImFjdGl2ZUluZGV4IiwiaW5kZXhPZkNsYXNzIiwicmVtb3ZlIiwidW5kZWZpbmVkIiwiYWN0aXZlQnV0dG9uIiwiYWN0aXZlQXJyb3ciLCJuZXh0QmFubmVyIiwic2hvd0ZpcnN0QmFubmVyIiwicHJldkJhbm5lciIsInNob3dMYXN0QmFubmVyIiwiZmlyc3RCYW5uZXIiLCJsYXN0QmFubmVyIiwibm9kZUxpc3QiLCJjbGFzc05hbWUiLCJjb3VudGVyIiwiY29udGFpbnMiLCIkIiwib24iLCJzZWxlY3RvciIsImRhdGEiLCJvcGVuTW9kYWwiLCJhZGRDbGFzcyIsImh0bWwiLCJ2YWwiLCJjbG9zZU1vZGFsIiwicmVnaXN0ZXIiLCJhamF4IiwidXJsIiwibWV0aG9kIiwic3VjY2VzcyIsInJlc3BvbnNlIiwicmVsb2FkIiwicmVnaXN0cmFudCIsIm5hbWVfZmlyc3QiLCJuYW1lX2xhc3QiLCJlbWFpbCIsImNsYXNzX2lkIiwiY2xhc3NfZGF0ZSIsIndhaXZlciIsImlzIiwiYWxlcnQiLCJKU09OIiwicGFyc2UiLCJyZW1vdmVDbGFzcyIsInJlZ2lzdHJhdGlvbl9pZCIsInJlZ2lzdHJhdGlvbklEIiwialF1ZXJ5IiwibWVudU9wZW4iLCJ0b2dnbGVNZW51IiwidmlkZW9zIiwicGFyZW50RWxlbWVudCIsIm1vZGFsT3BlbiIsImNhbmNlbCIsImFjdGlvbiIsIm1vZGFsQ29udGVudCIsImNvbnRlbnQiLCJpbm5lckhUTUwiLCJjYW5jZWxCdXR0b24iLCJhY3Rpb25CdXR0b24iLCJzaG93TW9kYWwiLCJzaG93Qmx1ciIsImhpZGVCbHVyIiwidG9nZ2xlQmx1ciIsImlzQmx1ciIsIlVJRCIsIl9jdXJyZW50IiwiZ2V0TmV3IiwibmV4dE5ld3MiLCJzaG93Rmlyc3ROZXdzIiwicHJldk5ld3MiLCJzaG93TGFzdE5ld3MiLCJmaXJzdE5ld3MiLCJsYXN0TmV3cyJdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOzs7QUFHQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxhQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxtQ0FBMkIsMEJBQTBCLEVBQUU7QUFDdkQseUNBQWlDLGVBQWU7QUFDaEQ7QUFDQTtBQUNBOztBQUVBO0FBQ0EsOERBQXNELCtEQUErRDs7QUFFckg7QUFDQTs7QUFFQTtBQUNBOzs7Ozs7Ozs7Ozs7Ozs7OztBQzdEQTs7QUFFQUEsbUJBQU9BLENBQUMsQ0FBUixFOzs7Ozs7QUNGQSx5Qzs7Ozs7Ozs7O0FDQUEsSUFBSUMsU0FBU0MsU0FBU0MsYUFBVCxDQUF1QixTQUF2QixDQUFiOztBQUVBO0FBQ0FDLElBQUlDLElBQUosQ0FBUztBQUNQQyxVQUFRO0FBREQsQ0FBVDs7QUFJQTtBQUNBLElBQUlMLE1BQUosRUFBWTtBQUNWQyxXQUFTSyxnQkFBVCxDQUEwQixvQkFBMUIsRUFBZ0QsQ0FBaEQsRUFBbURDLFNBQW5ELENBQTZEQyxHQUE3RCxDQUFpRSxRQUFqRTtBQUNBUCxXQUFTSyxnQkFBVCxDQUEwQixrQkFBMUIsRUFBOEMsQ0FBOUMsRUFBaURDLFNBQWpELENBQTJEQyxHQUEzRCxDQUErRCxRQUEvRDs7QUFFQSxNQUFJQyxRQUFRUixTQUFTSyxnQkFBVCxDQUEwQixlQUExQixDQUFaO0FBQ0FHLFFBQU1DLE9BQU4sQ0FBYyxVQUFTQyxHQUFULEVBQWM7QUFDMUJBLFFBQUlDLGdCQUFKLENBQXFCLE9BQXJCLEVBQThCLFVBQVNDLENBQVQsRUFBWTtBQUN4Q0Msd0JBQWtCRCxFQUFFRSxNQUFGLENBQVNDLE9BQVQsQ0FBaUJoQixNQUFuQztBQUNELEtBRkQ7QUFHRCxHQUpEOztBQU1BLE1BQUlpQixZQUFZaEIsU0FBU0ssZ0JBQVQsQ0FBMEIsYUFBMUIsQ0FBaEI7QUFDQVcsWUFBVVAsT0FBVixDQUFrQixVQUFTQyxHQUFULEVBQWM7QUFDOUJBLFFBQUlDLGdCQUFKLENBQXFCLE9BQXJCLEVBQThCLFVBQVNDLENBQVQsRUFBWTtBQUN4Q0ssc0JBQWdCTCxFQUFFRSxNQUFGLENBQVNDLE9BQVQsQ0FBaUJHLElBQWpDO0FBQ0QsS0FGRDtBQUdELEdBSkQ7O0FBTUFsQixXQUNHQyxhQURILENBQ2lCLHNCQURqQixFQUVHVSxnQkFGSCxDQUVvQixPQUZwQixFQUU2QlEsY0FGN0I7QUFHQW5CLFdBQ0dDLGFBREgsQ0FDaUIsc0JBRGpCLEVBRUdVLGdCQUZILENBRW9CLE9BRnBCLEVBRTZCUyxjQUY3Qjs7QUFJQTtBQUNBQyxhQUFXRCxjQUFYLEVBQTJCLElBQTNCO0FBQ0EsTUFBSUUsZUFBZUMsWUFBWUMsWUFBWixFQUEwQixJQUExQixDQUFuQjs7QUFFQUQsY0FBWUUsWUFBWixFQUEwQixFQUExQjtBQUNEOztBQUVELFNBQVNBLFlBQVQsR0FBd0I7QUFDdEJDO0FBQ0Q7O0FBRUQ7QUFDQSxTQUFTQSxVQUFULEdBQXNCO0FBQ3BCLE1BQUlDLE9BQU9DLE9BQVAsR0FBaUIsR0FBckIsRUFBMEI7QUFDeEI3QixXQUFPOEIsS0FBUCxDQUFhQyxPQUFiLEdBQXVCLElBQUksQ0FBQ0gsT0FBT0MsT0FBUCxHQUFpQixHQUFsQixJQUF5QixLQUFwRDtBQUNELEdBRkQsTUFFTztBQUNMN0IsV0FBTzhCLEtBQVAsQ0FBYUMsT0FBYixHQUF1QixDQUF2QjtBQUNEO0FBQ0Y7O0FBRUQ7O0FBRUEsSUFBSUgsT0FBT0ksUUFBUCxDQUFnQkMsSUFBaEIsQ0FBcUJDLE1BQXJCLEdBQThCLENBQWxDLEVBQXFDO0FBQ25DLE1BQUlDLFNBQVNQLE9BQU9JLFFBQVAsQ0FBZ0JDLElBQWhCLENBQXFCRyxPQUFyQixDQUE2QixHQUE3QixFQUFrQyxFQUFsQyxDQUFiO0FBQ0EsTUFBSXJCLFNBQVNkLFNBQVNvQyxjQUFULENBQXdCRixNQUF4QixDQUFiO0FBQ0Q7O0FBRUQsSUFBSXBCLE1BQUosRUFBWTtBQUNWLE1BQUl1QixTQUFTLENBQWI7QUFBQSxNQUNFQyxJQUFJLENBRE47QUFBQSxNQUVFQyxFQUZGO0FBR0EsTUFBSUMsT0FBT2pCLFlBQVksWUFBVztBQUNoQyxRQUFJa0IsS0FBS0MsR0FBTCxDQUFVSCxLQUFLRixTQUFTQyxDQUF4QixJQUE4QixDQUFsQyxFQUFxQztBQUNuQ0EsV0FBS0MsS0FBSyxDQUFWO0FBQ0QsS0FGRCxNQUVPO0FBQ0xJLG9CQUFjSCxJQUFkO0FBQ0FGLFVBQUlELE1BQUo7QUFDQU8sa0JBQVksS0FBWjtBQUNEO0FBQ0Q1QyxhQUFTNkMsZUFBVCxDQUF5QkMsU0FBekIsR0FBcUNSLENBQXJDO0FBQ0QsR0FUVSxFQVNSLEVBVFEsQ0FBWDtBQVVBRCxXQUFTdkIsT0FBT2lDLFNBQVAsR0FBbUIsRUFBNUI7QUFDQVQsTUFBSXRDLFNBQVM2QyxlQUFULENBQXlCQyxTQUE3QjtBQUNEOztBQUVEOztBQUVBLFNBQVNqQyxpQkFBVCxDQUEyQm1DLEtBQTNCLEVBQWtDO0FBQ2hDTCxnQkFBY00sY0FBZDs7QUFFQSxNQUFJQyxVQUFVbEQsU0FBU0ssZ0JBQVQsQ0FBMEIsb0JBQTFCLENBQWQ7QUFDQSxNQUFJRyxRQUFRUixTQUFTSyxnQkFBVCxDQUEwQixlQUExQixDQUFaO0FBQ0EsTUFBSThDLGNBQWNDLGFBQWFGLE9BQWIsRUFBc0IsUUFBdEIsQ0FBbEI7O0FBRUFBLFVBQVFDLFdBQVIsRUFBcUI3QyxTQUFyQixDQUErQitDLE1BQS9CLENBQXNDLFFBQXRDO0FBQ0E3QyxRQUFNMkMsV0FBTixFQUFtQjdDLFNBQW5CLENBQTZCK0MsTUFBN0IsQ0FBb0MsUUFBcEM7O0FBRUFILFVBQVFGLEtBQVIsRUFBZTFDLFNBQWYsQ0FBeUJDLEdBQXpCLENBQTZCLFFBQTdCO0FBQ0FDLFFBQU13QyxLQUFOLEVBQWExQyxTQUFiLENBQXVCQyxHQUF2QixDQUEyQixRQUEzQjtBQUNEOztBQUVELFNBQVNhLGNBQVQsQ0FBd0JSLENBQXhCLEVBQTJCO0FBQ3pCO0FBQ0EsTUFBSUEsTUFBTTBDLFNBQVYsRUFBcUI7QUFDbkJYLGtCQUFjTSxjQUFkO0FBQ0QsR0FGRCxNQUVPO0FBQ0w7QUFDQTtBQUNBO0FBQ0EsUUFBSU0sZUFBZXZELFNBQVNDLGFBQVQsQ0FBdUIsK0JBQXZCLENBQW5CO0FBQ0EsUUFBSXNELFlBQUosRUFBa0I7QUFDbEIsUUFBSUMsY0FBY3hELFNBQVNDLGFBQVQsQ0FBdUIsc0JBQXZCLENBQWxCO0FBQ0EsUUFBSXVELFdBQUosRUFBaUI7QUFDbEI7O0FBRUQsTUFBSU4sVUFBVWxELFNBQVNLLGdCQUFULENBQTBCLG9CQUExQixDQUFkO0FBQ0EsTUFBSUcsUUFBUVIsU0FBU0ssZ0JBQVQsQ0FBMEIsZUFBMUIsQ0FBWjtBQUNBLE1BQUkyQyxRQUFRSSxhQUFhRixPQUFiLEVBQXNCLFFBQXRCLENBQVo7O0FBRUFBLFVBQVFGLEtBQVIsRUFBZTFDLFNBQWYsQ0FBeUIrQyxNQUF6QixDQUFnQyxRQUFoQztBQUNBN0MsUUFBTXdDLEtBQU4sRUFBYTFDLFNBQWIsQ0FBdUIrQyxNQUF2QixDQUE4QixRQUE5Qjs7QUFFQSxNQUFJSSxhQUFhUCxRQUFRRixRQUFRLENBQWhCLENBQWpCOztBQUVBLE1BQUlTLGVBQWVILFNBQW5CLEVBQThCO0FBQzVCRyxlQUFXbkQsU0FBWCxDQUFxQkMsR0FBckIsQ0FBeUIsUUFBekI7QUFDQUMsVUFBTXdDLFFBQVEsQ0FBZCxFQUFpQjFDLFNBQWpCLENBQTJCQyxHQUEzQixDQUErQixRQUEvQjtBQUNELEdBSEQsTUFHTztBQUNMbUQ7QUFDRDtBQUNGOztBQUVELFNBQVN2QyxjQUFULEdBQTBCO0FBQ3hCO0FBQ0EsTUFBSVAsTUFBTTBDLFNBQVYsRUFBcUI7QUFDbkJYLGtCQUFjTSxjQUFkO0FBQ0Q7QUFDRCxNQUFJQyxVQUFVbEQsU0FBU0ssZ0JBQVQsQ0FBMEIsb0JBQTFCLENBQWQ7QUFDQSxNQUFJRyxRQUFRUixTQUFTSyxnQkFBVCxDQUEwQixlQUExQixDQUFaO0FBQ0EsTUFBSTJDLFFBQVFJLGFBQWFGLE9BQWIsRUFBc0IsUUFBdEIsQ0FBWjs7QUFFQUEsVUFBUUYsS0FBUixFQUFlMUMsU0FBZixDQUF5QitDLE1BQXpCLENBQWdDLFFBQWhDO0FBQ0E3QyxRQUFNd0MsS0FBTixFQUFhMUMsU0FBYixDQUF1QitDLE1BQXZCLENBQThCLFFBQTlCOztBQUVBLE1BQUlNLGFBQWFULFFBQVFGLFFBQVEsQ0FBaEIsQ0FBakI7O0FBRUEsTUFBSVcsZUFBZUwsU0FBbkIsRUFBOEI7QUFDNUJLLGVBQVdyRCxTQUFYLENBQXFCQyxHQUFyQixDQUF5QixRQUF6QjtBQUNBQyxVQUFNd0MsUUFBUSxDQUFkLEVBQWlCMUMsU0FBakIsQ0FBMkJDLEdBQTNCLENBQStCLFFBQS9CO0FBQ0QsR0FIRCxNQUdPO0FBQ0xxRDtBQUNEO0FBQ0Y7O0FBRUQsU0FBU0YsZUFBVCxHQUEyQjtBQUN6QixNQUFJUixVQUFVbEQsU0FBU0ssZ0JBQVQsQ0FBMEIsb0JBQTFCLENBQWQ7QUFDQSxNQUFJd0QsY0FBY1gsUUFBUSxDQUFSLENBQWxCOztBQUVBVyxjQUFZdkQsU0FBWixDQUFzQkMsR0FBdEIsQ0FBMEIsUUFBMUI7QUFDQVAsV0FBU0ssZ0JBQVQsQ0FBMEIsZUFBMUIsRUFBMkMsQ0FBM0MsRUFBOENDLFNBQTlDLENBQXdEQyxHQUF4RCxDQUE0RCxRQUE1RDtBQUNEOztBQUVELFNBQVNxRCxjQUFULEdBQTBCO0FBQ3hCLE1BQUlWLFVBQVVsRCxTQUFTSyxnQkFBVCxDQUEwQixvQkFBMUIsQ0FBZDtBQUNBLE1BQUl5RCxhQUFhWixRQUFRQSxRQUFRakIsTUFBUixHQUFpQixDQUF6QixDQUFqQjs7QUFFQTZCLGFBQVd4RCxTQUFYLENBQXFCQyxHQUFyQixDQUF5QixRQUF6QjtBQUNBUCxXQUNHSyxnQkFESCxDQUNvQixlQURwQixFQUVHNkMsUUFBUWpCLE1BQVIsR0FBaUIsQ0FGcEIsRUFFdUIzQixTQUZ2QixDQUVpQ0MsR0FGakMsQ0FFcUMsUUFGckM7QUFHRDs7QUFFRDs7QUFFQSxTQUFTNkMsWUFBVCxDQUFzQlcsUUFBdEIsRUFBZ0NDLFNBQWhDLEVBQTJDO0FBQ3pDLE1BQUlDLFVBQVUsQ0FBZDtBQUNBLE1BQUlqQixRQUFRLENBQUMsQ0FBYjs7QUFFQWUsV0FBU3RELE9BQVQsQ0FBaUIsVUFBU0MsR0FBVCxFQUFjO0FBQzdCLFFBQUlBLElBQUlKLFNBQUosQ0FBYzRELFFBQWQsQ0FBdUJGLFNBQXZCLENBQUosRUFBdUM7QUFDckNoQixjQUFRaUIsT0FBUjtBQUNELEtBRkQsTUFFTztBQUNMQTtBQUNEO0FBQ0YsR0FORDs7QUFRQSxTQUFPakIsS0FBUDtBQUNEOztBQUVEOztBQUVBO0FBQ0EsQ0FBQyxVQUFTbUIsQ0FBVCxFQUFZO0FBQ1g7QUFDQUEsSUFBRW5FLFFBQUYsRUFBWW9FLEVBQVosQ0FBZSxPQUFmLEVBQXdCLHNCQUF4QixFQUFnRCxZQUFXO0FBQ3pELFFBQUlDLFdBQVcsY0FBY0YsRUFBRSxJQUFGLEVBQVFHLElBQVIsQ0FBYSxJQUFiLENBQTdCOztBQUVBQyxjQUFVRixRQUFWO0FBQ0QsR0FKRDs7QUFNQTtBQUNBRixJQUFFbkUsUUFBRixFQUFZb0UsRUFBWixDQUFlLE9BQWYsRUFBd0IsbUJBQXhCLEVBQTZDLFlBQVc7QUFDdEQsUUFBSUMsV0FBVyxZQUFZRixFQUFFLElBQUYsRUFBUUcsSUFBUixDQUFhLElBQWIsQ0FBM0I7QUFDQUMsY0FBVUYsUUFBVjtBQUNELEdBSEQ7O0FBS0E7QUFDQUYsSUFBRW5FLFFBQUYsRUFBWW9FLEVBQVosQ0FBZSxPQUFmLEVBQXdCLG1CQUF4QixFQUE2QyxVQUFTeEQsQ0FBVCxFQUFZO0FBQ3ZEO0FBQ0F1RCxNQUFFLElBQUYsRUFBUUssUUFBUixDQUFpQixRQUFqQjs7QUFFQUwsTUFBRSxpQ0FBRixFQUFxQ00sSUFBckMsQ0FBMENOLEVBQUUsSUFBRixFQUFRRyxJQUFSLENBQWEsWUFBYixDQUExQztBQUNBSCxNQUFFLGlDQUFGLEVBQXFDTSxJQUFyQyxDQUNFTixFQUFFLElBQUYsRUFBUUcsSUFBUixDQUFhLG1CQUFiLENBREY7QUFHQUgsTUFBRSxnQ0FBRixFQUFvQ08sR0FBcEMsQ0FBd0NQLEVBQUUsSUFBRixFQUFRRyxJQUFSLENBQWEsWUFBYixDQUF4QztBQUNBSCxNQUFFLDhCQUFGLEVBQWtDTyxHQUFsQyxDQUFzQ1AsRUFBRSxJQUFGLEVBQVFHLElBQVIsQ0FBYSxVQUFiLENBQXRDOztBQUVBQyxjQUFVLG9CQUFWLEVBQWdDSSxVQUFoQyxFQUE0Q0MsUUFBNUM7QUFDRCxHQVpEOztBQWNBO0FBQ0FULElBQUVuRSxRQUFGLEVBQVlvRSxFQUFaLENBQWUsT0FBZixFQUF3QixTQUF4QixFQUFtQyxVQUFTeEQsQ0FBVCxFQUFZO0FBQzdDdUQsTUFBRVUsSUFBRixDQUFPO0FBQ0xDLFdBQUssOEJBREE7QUFFTEMsY0FBUSxNQUZIO0FBR0xDLGVBQVMsaUJBQVNDLFFBQVQsRUFBbUI7QUFDMUI7QUFDQWxELGlCQUFTbUQsTUFBVDtBQUNEO0FBTkksS0FBUDtBQVFELEdBVEQ7O0FBV0E7QUFDQSxXQUFTTixRQUFULEdBQW9CO0FBQ2xCLFFBQUlsRSxNQUFNeUQsRUFBRSwwQkFBRixDQUFWOztBQUVBO0FBQ0EsUUFBSWdCLGFBQWE7QUFDZkMsa0JBQVlqQixFQUFFLG9CQUFGLEVBQXdCTyxHQUF4QixFQURHO0FBRWZXLGlCQUFXbEIsRUFBRSxtQkFBRixFQUF1Qk8sR0FBdkIsRUFGSTtBQUdmWSxhQUFPbkIsRUFBRSxlQUFGLEVBQW1CTyxHQUFuQixFQUhRO0FBSWZhLGdCQUFVcEIsRUFBRSxrQkFBRixFQUFzQk8sR0FBdEIsRUFKSztBQUtmYyxrQkFBWXJCLEVBQUUsb0JBQUYsRUFBd0JPLEdBQXhCLEVBTEc7QUFNZmUsY0FBUXRCLEVBQUUseUJBQUYsRUFBNkJ1QixFQUE3QixDQUFnQyxVQUFoQztBQU5PLEtBQWpCOztBQVNBO0FBQ0EsUUFBSSxDQUFDUCxXQUFXTSxNQUFoQixFQUF3QjtBQUN0QkUsWUFDRSxtRUFERjtBQUdBLGFBQU8sS0FBUDtBQUNEOztBQUVELFFBQUlSLFdBQVdDLFVBQVgsQ0FBc0JuRCxNQUF0QixJQUFnQyxDQUFwQyxFQUF1QztBQUNyQzBELFlBQ0UseUdBREY7QUFHQSxhQUFPLEtBQVA7QUFDRDs7QUFFRCxRQUFJUixXQUFXRSxTQUFYLENBQXFCcEQsTUFBckIsSUFBK0IsQ0FBbkMsRUFBc0M7QUFDcEMwRCxZQUNFLHdHQURGO0FBR0EsYUFBTyxLQUFQO0FBQ0Q7O0FBRUQsUUFBSVIsV0FBV0csS0FBWCxDQUFpQnJELE1BQWpCLElBQTJCLENBQS9CLEVBQWtDO0FBQ2hDMEQsWUFDRSw0R0FERjtBQUdBLGFBQU8sS0FBUDtBQUNEOztBQUVEeEIsTUFBRVUsSUFBRixDQUFPO0FBQ0xDLFdBQUssZ0NBREE7QUFFTFIsWUFBTWEsVUFGRDtBQUdMSixjQUFRLE1BSEg7QUFJTEMsZUFBUyxpQkFBU0MsUUFBVCxFQUFtQjtBQUMxQkEsbUJBQVdXLEtBQUtDLEtBQUwsQ0FBV1osUUFBWCxDQUFYO0FBQ0EsWUFBSUEsU0FBU0QsT0FBYixFQUFzQjtBQUNwQnRFLGNBQUk4RCxRQUFKLENBQWEsb0JBQWI7QUFDQTlELGNBQUlvRixXQUFKLENBQWdCLGtCQUFoQjtBQUNBcEYsY0FBSW9GLFdBQUosQ0FBZ0IsU0FBaEI7QUFDQXBGLGNBQUkrRCxJQUFKLENBQVMsWUFBVDtBQUNBL0QsY0FBSTRELElBQUosQ0FBUyxpQkFBVCxFQUE0QlcsU0FBU2MsZUFBckM7QUFDQUosZ0JBQU0seUNBQU47QUFDQWhCO0FBQ0QsU0FSRCxNQVFPO0FBQ0xnQixnQkFDRSwyRUFERjtBQUdEO0FBQ0Y7QUFuQkksS0FBUDtBQXFCRDs7QUFFRDtBQUNBeEIsSUFBRW5FLFFBQUYsRUFBWW9FLEVBQVosQ0FBZSxPQUFmLEVBQXdCLHFCQUF4QixFQUErQyxVQUFTeEQsQ0FBVCxFQUFZO0FBQ3pELFFBQUlGLE1BQU15RCxFQUFFLElBQUYsQ0FBVjtBQUNBLFFBQUk2QixpQkFBaUJ0RixJQUFJNEQsSUFBSixDQUFTLGlCQUFULENBQXJCOztBQUVBO0FBQ0EsUUFBSUEsT0FBTztBQUNUeUIsdUJBQWlCQztBQURSLEtBQVg7O0FBSUE3QixNQUFFVSxJQUFGLENBQU87QUFDTEMsV0FBSyxrQ0FEQTtBQUVMUixZQUFNQSxJQUZEO0FBR0xTLGNBQVEsTUFISDtBQUlMQyxlQUFTLGlCQUFTQyxRQUFULEVBQW1CO0FBQzFCQSxtQkFBV1csS0FBS0MsS0FBTCxDQUFXWixRQUFYLENBQVg7QUFDQSxZQUFJQSxTQUFTRCxPQUFiLEVBQXNCO0FBQ3BCdEUsY0FBSW9GLFdBQUosQ0FBZ0Isb0JBQWhCO0FBQ0FwRixjQUFJOEQsUUFBSixDQUFhLGtCQUFiO0FBQ0E5RCxjQUFJK0QsSUFBSixDQUFTLFVBQVQ7QUFDQWtCLGdCQUFNLDJDQUFOO0FBQ0Q7QUFDRjtBQVpJLEtBQVA7QUFjRCxHQXZCRDtBQXdCRCxDQXBJRCxFQW9JR00sTUFwSUg7O0FBc0lBO0FBQ0EsSUFBSUMsV0FBVyxLQUFmO0FBQ0EsU0FBU0MsVUFBVCxHQUFzQjtBQUNwQixNQUFJLENBQUNELFFBQUwsRUFBZTtBQUNiO0FBQ0FsRyxhQUFTQyxhQUFULENBQXVCLGlCQUF2QixFQUEwQ0ssU0FBMUMsQ0FBb0RDLEdBQXBELENBQXdELE1BQXhEO0FBQ0FQLGFBQVNDLGFBQVQsQ0FBdUIsMEJBQXZCLEVBQW1ESyxTQUFuRCxDQUE2REMsR0FBN0QsQ0FBaUUsTUFBakU7QUFDQVAsYUFBU0MsYUFBVCxDQUF1QixlQUF2QixFQUF3Q0ssU0FBeEMsQ0FBa0RDLEdBQWxELENBQXNELE1BQXREOztBQUVBMkYsZUFBVyxJQUFYO0FBQ0QsR0FQRCxNQU9PO0FBQ0w7QUFDQWxHLGFBQVNDLGFBQVQsQ0FBdUIsaUJBQXZCLEVBQTBDSyxTQUExQyxDQUFvRCtDLE1BQXBELENBQTJELE1BQTNEO0FBQ0FyRCxhQUFTQyxhQUFULENBQXVCLDBCQUF2QixFQUFtREssU0FBbkQsQ0FBNkQrQyxNQUE3RCxDQUFvRSxNQUFwRTtBQUNBckQsYUFBU0MsYUFBVCxDQUF1QixlQUF2QixFQUF3Q0ssU0FBeEMsQ0FBa0QrQyxNQUFsRCxDQUF5RCxNQUF6RDs7QUFFQTZDLGVBQVcsS0FBWDtBQUNEO0FBQ0Y7O0FBRUQ7QUFDQWxHLFNBQ0dDLGFBREgsQ0FDaUIsaUJBRGpCLEVBRUdVLGdCQUZILENBRW9CLE9BRnBCLEVBRTZCLFVBQVNDLENBQVQsRUFBWTtBQUNyQ3VGO0FBQ0QsQ0FKSDs7QUFNQTtBQUNBO0FBQ0EsSUFBSUMsU0FBU3BHLFNBQVNLLGdCQUFULENBQTBCLFFBQTFCLEVBQW9DSSxPQUFwQyxDQUE0QyxVQUFTQyxHQUFULEVBQWM7QUFDckVBLE1BQUkyRixhQUFKLENBQWtCL0YsU0FBbEIsQ0FBNEJDLEdBQTVCLENBQWdDLGtCQUFoQztBQUNELENBRlksQ0FBYjs7QUFJQTtBQUNBLElBQUkrRixZQUFZLEtBQWhCO0FBQ0EsU0FBUy9CLFNBQVQsQ0FBbUJGLFFBQW5CLEVBQTZCa0MsTUFBN0IsRUFBcUNDLE1BQXJDLEVBQTZDO0FBQzNDLE1BQUlELFdBQVdqRCxTQUFmLEVBQTBCO0FBQ3hCaUQsYUFBUzVCLFVBQVQ7QUFDRDtBQUNELE1BQUk2QixXQUFXbEQsU0FBZixFQUEwQjtBQUN4QmtELGFBQVMsa0JBQVc7QUFDbEJiLFlBQU0sT0FBTjtBQUNELEtBRkQ7QUFHRDs7QUFFRDtBQUNBLE1BQUljLGVBQWV6RyxTQUFTQyxhQUFULENBQXVCLHNCQUF2QixDQUFuQjtBQUNBLE1BQUl5RyxVQUFVMUcsU0FBU0MsYUFBVCxDQUF1Qm9FLFFBQXZCLENBQWQ7O0FBRUFvQyxlQUFhRSxTQUFiLEdBQXlCRCxRQUFRQyxTQUFqQzs7QUFFQTtBQUNBLE1BQUlDLGVBQWU1RyxTQUFTQyxhQUFULENBQXVCLHVCQUF2QixDQUFuQjtBQUNBLE1BQUk0RyxlQUFlN0csU0FBU0MsYUFBVCxDQUF1Qix1QkFBdkIsQ0FBbkI7O0FBRUEsTUFBSTJHLFlBQUosRUFBa0I7QUFDaEJBLGlCQUFhakcsZ0JBQWIsQ0FBOEIsT0FBOUIsRUFBdUM0RixNQUF2QztBQUNEO0FBQ0QsTUFBSU0sWUFBSixFQUFrQjtBQUNoQkEsaUJBQWFsRyxnQkFBYixDQUE4QixPQUE5QixFQUF1QzZGLE1BQXZDO0FBQ0Q7O0FBRURNO0FBQ0Q7O0FBRUQsU0FBU0EsU0FBVCxHQUFxQjtBQUNuQkM7O0FBRUEvRyxXQUFTQyxhQUFULENBQXVCLFFBQXZCLEVBQWlDSyxTQUFqQyxDQUEyQ0MsR0FBM0MsQ0FBK0MsTUFBL0M7QUFDRDs7QUFFRCxTQUFTb0UsVUFBVCxHQUFzQjtBQUNwQjNFLFdBQVNDLGFBQVQsQ0FBdUIsUUFBdkIsRUFBaUNLLFNBQWpDLENBQTJDK0MsTUFBM0MsQ0FBa0QsTUFBbEQ7O0FBRUFoQyxhQUFXMkYsUUFBWCxFQUFxQixHQUFyQjtBQUNEOztBQUVELFNBQVNDLFVBQVQsR0FBc0I7QUFDcEI7QUFDQSxNQUFJQyxTQUFTbEgsU0FBU0ssZ0JBQVQsQ0FBMEIsT0FBMUIsRUFBbUM0QixNQUFuQyxHQUE0QyxDQUF6RDs7QUFFQSxNQUFJLENBQUNpRixNQUFMLEVBQWE7QUFDWEg7QUFDRCxHQUZELE1BRU87QUFDTEM7QUFDRDtBQUNGOztBQUVELFNBQVNELFFBQVQsR0FBb0I7QUFDbEIvRyxXQUFTQyxhQUFULENBQXVCLE9BQXZCLEVBQWdDSyxTQUFoQyxDQUEwQ0MsR0FBMUMsQ0FBOEMsTUFBOUM7QUFDQVAsV0FBU0MsYUFBVCxDQUF1QixTQUF2QixFQUFrQ0ssU0FBbEMsQ0FBNENDLEdBQTVDLENBQWdELE1BQWhEO0FBQ0FQLFdBQVNDLGFBQVQsQ0FBdUIsU0FBdkIsRUFBa0NLLFNBQWxDLENBQTRDQyxHQUE1QyxDQUFnRCxNQUFoRDtBQUNBUCxXQUFTQyxhQUFULENBQXVCLE1BQXZCLEVBQStCSyxTQUEvQixDQUF5Q0MsR0FBekMsQ0FBNkMsV0FBN0M7QUFDRDs7QUFFRCxTQUFTeUcsUUFBVCxHQUFvQjtBQUNsQmhILFdBQVNDLGFBQVQsQ0FBdUIsT0FBdkIsRUFBZ0NLLFNBQWhDLENBQTBDK0MsTUFBMUMsQ0FBaUQsTUFBakQ7QUFDQXJELFdBQVNDLGFBQVQsQ0FBdUIsU0FBdkIsRUFBa0NLLFNBQWxDLENBQTRDK0MsTUFBNUMsQ0FBbUQsTUFBbkQ7QUFDQXJELFdBQVNDLGFBQVQsQ0FBdUIsU0FBdkIsRUFBa0NLLFNBQWxDLENBQTRDK0MsTUFBNUMsQ0FBbUQsTUFBbkQ7QUFDQXJELFdBQVNDLGFBQVQsQ0FBdUIsTUFBdkIsRUFBK0JLLFNBQS9CLENBQXlDK0MsTUFBekMsQ0FBZ0QsV0FBaEQ7QUFDRDs7QUFFRDtBQUNBckQsU0FBU0MsYUFBVCxDQUF1QixlQUF2QixFQUF3Q1UsZ0JBQXhDLENBQXlELE9BQXpELEVBQWtFZ0UsVUFBbEU7O0FBRUE7QUFDQSxJQUFJd0MsTUFBTTtBQUNSQyxZQUFVLENBREY7QUFFUkMsVUFBUSxrQkFBVztBQUNqQixTQUFLRCxRQUFMO0FBQ0EsV0FBTyxLQUFLQSxRQUFaO0FBQ0Q7QUFMTyxDQUFWOztBQVFBOztBQUVBLFNBQVNuRyxlQUFULENBQXlCK0IsS0FBekIsRUFBZ0M7QUFDOUJMLGdCQUFjckIsWUFBZDs7QUFFQSxNQUFJSixPQUFPbEIsU0FBU0ssZ0JBQVQsQ0FBMEIsa0JBQTFCLENBQVg7QUFDQSxNQUFJRyxRQUFRUixTQUFTSyxnQkFBVCxDQUEwQixhQUExQixDQUFaO0FBQ0EsTUFBSThDLGNBQWNDLGFBQWFsQyxJQUFiLEVBQW1CLFFBQW5CLENBQWxCOztBQUVBQSxPQUFLaUMsV0FBTCxFQUFrQjdDLFNBQWxCLENBQTRCK0MsTUFBNUIsQ0FBbUMsUUFBbkM7QUFDQTdDLFFBQU0yQyxXQUFOLEVBQW1CN0MsU0FBbkIsQ0FBNkIrQyxNQUE3QixDQUFvQyxRQUFwQzs7QUFFQW5DLE9BQUs4QixLQUFMLEVBQVkxQyxTQUFaLENBQXNCQyxHQUF0QixDQUEwQixRQUExQjtBQUNBQyxRQUFNd0MsS0FBTixFQUFhMUMsU0FBYixDQUF1QkMsR0FBdkIsQ0FBMkIsUUFBM0I7QUFDRDs7QUFFRCxTQUFTaUIsWUFBVCxHQUF3QjtBQUN0QixNQUFJTixPQUFPbEIsU0FBU0ssZ0JBQVQsQ0FBMEIsa0JBQTFCLENBQVg7QUFDQSxNQUFJRyxRQUFRUixTQUFTSyxnQkFBVCxDQUEwQixhQUExQixDQUFaO0FBQ0EsTUFBSTJDLFFBQVFJLGFBQWFsQyxJQUFiLEVBQW1CLFFBQW5CLENBQVo7O0FBRUFBLE9BQUs4QixLQUFMLEVBQVkxQyxTQUFaLENBQXNCK0MsTUFBdEIsQ0FBNkIsUUFBN0I7QUFDQTdDLFFBQU13QyxLQUFOLEVBQWExQyxTQUFiLENBQXVCK0MsTUFBdkIsQ0FBOEIsUUFBOUI7O0FBRUEsTUFBSWlFLFdBQVdwRyxLQUFLOEIsUUFBUSxDQUFiLENBQWY7O0FBRUEsTUFBSXNFLGFBQWFoRSxTQUFqQixFQUE0QjtBQUMxQmdFLGFBQVNoSCxTQUFULENBQW1CQyxHQUFuQixDQUF1QixRQUF2QjtBQUNBQyxVQUFNd0MsUUFBUSxDQUFkLEVBQWlCMUMsU0FBakIsQ0FBMkJDLEdBQTNCLENBQStCLFFBQS9CO0FBQ0QsR0FIRCxNQUdPO0FBQ0xnSDtBQUNEO0FBQ0Y7O0FBRUQsU0FBU3BHLGNBQVQsR0FBMEI7QUFDeEIsTUFBSStCLFVBQVVsRCxTQUFTSyxnQkFBVCxDQUEwQixrQkFBMUIsQ0FBZDtBQUNBLE1BQUlHLFFBQVFSLFNBQVNLLGdCQUFULENBQTBCLGFBQTFCLENBQVo7QUFDQSxNQUFJMkMsUUFBUUksYUFBYUYsT0FBYixFQUFzQixRQUF0QixDQUFaOztBQUVBaEMsT0FBSzhCLEtBQUwsRUFBWTFDLFNBQVosQ0FBc0IrQyxNQUF0QixDQUE2QixRQUE3QjtBQUNBN0MsUUFBTXdDLEtBQU4sRUFBYTFDLFNBQWIsQ0FBdUIrQyxNQUF2QixDQUE4QixRQUE5Qjs7QUFFQSxNQUFJbUUsV0FBV3RHLEtBQUs4QixRQUFRLENBQWIsQ0FBZjs7QUFFQSxNQUFJd0UsYUFBYWxFLFNBQWpCLEVBQTRCO0FBQzFCa0UsYUFBU2xILFNBQVQsQ0FBbUJDLEdBQW5CLENBQXVCLFFBQXZCO0FBQ0FDLFVBQU13QyxRQUFRLENBQWQsRUFBaUIxQyxTQUFqQixDQUEyQkMsR0FBM0IsQ0FBK0IsUUFBL0I7QUFDRCxHQUhELE1BR087QUFDTGtIO0FBQ0Q7QUFDRjs7QUFFRCxTQUFTRixhQUFULEdBQXlCO0FBQ3ZCLE1BQUlyRyxPQUFPbEIsU0FBU0ssZ0JBQVQsQ0FBMEIsa0JBQTFCLENBQVg7QUFDQSxNQUFJcUgsWUFBWXhHLEtBQUssQ0FBTCxDQUFoQjs7QUFFQXdHLFlBQVVwSCxTQUFWLENBQW9CQyxHQUFwQixDQUF3QixRQUF4QjtBQUNBUCxXQUFTSyxnQkFBVCxDQUEwQixhQUExQixFQUF5QyxDQUF6QyxFQUE0Q0MsU0FBNUMsQ0FBc0RDLEdBQXRELENBQTBELFFBQTFEO0FBQ0Q7O0FBRUQsU0FBU2tILFlBQVQsR0FBd0I7QUFDdEIsTUFBSXZFLFVBQVVsRCxTQUFTSyxnQkFBVCxDQUEwQixrQkFBMUIsQ0FBZDtBQUNBLE1BQUlzSCxXQUFXekcsS0FBS0EsS0FBS2UsTUFBTCxHQUFjLENBQW5CLENBQWY7O0FBRUEwRixXQUFTckgsU0FBVCxDQUFtQkMsR0FBbkIsQ0FBdUIsUUFBdkI7QUFDQVAsV0FDR0ssZ0JBREgsQ0FDb0IsYUFEcEIsRUFFR2EsS0FBS2UsTUFBTCxHQUFjLENBRmpCLEVBRW9CM0IsU0FGcEIsQ0FFOEJDLEdBRjlCLENBRWtDLFFBRmxDO0FBR0Q7O0FBRUQsMEIiLCJmaWxlIjoiYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7XG4gXHRcdFx0XHRjb25maWd1cmFibGU6IGZhbHNlLFxuIFx0XHRcdFx0ZW51bWVyYWJsZTogdHJ1ZSxcbiBcdFx0XHRcdGdldDogZ2V0dGVyXG4gXHRcdFx0fSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiLi5cIjtcblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSAwKTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyB3ZWJwYWNrL2Jvb3RzdHJhcCA4OTBjNTIwMGZhMzUzN2Y3N2NkMiIsImltcG9ydCAnLi9zdHlsZXMvc3R5bGUuc2Nzcyc7XHJcblxyXG5yZXF1aXJlKCcuLi9qcy9jb21tb24uanMnKTtcclxuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vc3JjL21haW4uanMiLCIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vc3JjL3N0eWxlcy9zdHlsZS5zY3NzXG4vLyBtb2R1bGUgaWQgPSAyXG4vLyBtb2R1bGUgY2h1bmtzID0gMCIsInZhciBiYW5uZXIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYmFubmVyJyk7XHJcblxyXG4vLyBJbml0aWFsaXplIHRoZSBBbmltYXRlIG9uIFNjcm9sbCBsaWJyYXJ5XHJcbkFPUy5pbml0KHtcclxuICBlYXNpbmc6ICdlYXNlLWluLXF1YWQnXHJcbn0pO1xyXG5cclxuLy8gTWFrZSBzdXJlIHRoZSBoZWFkZXIgYW5kIG5hdmlnYXRpb24gc2hvdyB1cCBjb3JyZWN0bHlcclxuaWYgKGJhbm5lcikge1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5iYW5uZXJfX2NvbnRhaW5lcicpWzBdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5uZXdzX19jb250YWluZXInKVswXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxuXHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpO1xyXG4gIGljb25zLmZvckVhY2goZnVuY3Rpb24oZWxtKSB7XHJcbiAgICBlbG0uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgIHNob3dCYW5uZXJCeUluZGV4KGUudGFyZ2V0LmRhdGFzZXQuYmFubmVyKTtcclxuICAgIH0pO1xyXG4gIH0pO1xyXG5cclxuICB2YXIgbmV3c0ljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2ljb24nKTtcclxuICBuZXdzSWNvbnMuZm9yRWFjaChmdW5jdGlvbihlbG0pIHtcclxuICAgIGVsbS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgc2hvd05ld3NCeUluZGV4KGUudGFyZ2V0LmRhdGFzZXQubmV3cyk7XHJcbiAgICB9KTtcclxuICB9KTtcclxuXHJcbiAgZG9jdW1lbnRcclxuICAgIC5xdWVyeVNlbGVjdG9yKCcuYmFubmVyX19hcnJvdy0tcHJldicpXHJcbiAgICAuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBzaG93UHJldkJhbm5lcik7XHJcbiAgZG9jdW1lbnRcclxuICAgIC5xdWVyeVNlbGVjdG9yKCcuYmFubmVyX19hcnJvdy0tbmV4dCcpXHJcbiAgICAuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBzaG93TmV4dEJhbm5lcik7XHJcblxyXG4gIC8vdmFyIGJhbm5lckludGVydmFsID0gc2V0SW50ZXJ2YWwoc2hvd05leHRCYW5uZXIsIDY1MDApO1xyXG4gIHNldFRpbWVvdXQoc2hvd05leHRCYW5uZXIsIDMwMDApO1xyXG4gIHZhciBuZXdzSW50ZXJ2YWwgPSBzZXRJbnRlcnZhbChzaG93TmV4dE5ld3MsIDUwMDApO1xyXG5cclxuICBzZXRJbnRlcnZhbChoYW5kbGVTY3JvbGwsIDEwKTtcclxufVxyXG5cclxuZnVuY3Rpb24gaGFuZGxlU2Nyb2xsKCkge1xyXG4gIGZhZGVIZWFkZXIoKTtcclxufVxyXG5cclxuLy8gRmFkZSBIZWFkZXJcclxuZnVuY3Rpb24gZmFkZUhlYWRlcigpIHtcclxuICBpZiAod2luZG93LnNjcm9sbFkgPiAxMDApIHtcclxuICAgIGJhbm5lci5zdHlsZS5vcGFjaXR5ID0gMSAtICh3aW5kb3cuc2Nyb2xsWSAtIDEwMCkgKiAwLjAwMztcclxuICB9IGVsc2Uge1xyXG4gICAgYmFubmVyLnN0eWxlLm9wYWNpdHkgPSAxO1xyXG4gIH1cclxufVxyXG5cclxuLyogU0NST0xMIFRPIEFOQ0hPUiAqL1xyXG5cclxuaWYgKHdpbmRvdy5sb2NhdGlvbi5oYXNoLmxlbmd0aCA+IDApIHtcclxuICB2YXIgYW5jaG9yID0gd2luZG93LmxvY2F0aW9uLmhhc2gucmVwbGFjZSgnIycsICcnKTtcclxuICB2YXIgdGFyZ2V0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoYW5jaG9yKTtcclxufVxyXG5cclxuaWYgKHRhcmdldCkge1xyXG4gIHZhciBvZmZzZXQgPSAwLFxyXG4gICAgeSA9IDAsXHJcbiAgICBkeTtcclxuICB2YXIgY2FsbCA9IHNldEludGVydmFsKGZ1bmN0aW9uKCkge1xyXG4gICAgaWYgKE1hdGguYWJzKChkeSA9IG9mZnNldCAtIHkpKSA+IDEpIHtcclxuICAgICAgeSArPSBkeSAvIDg7XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICBjbGVhckludGVydmFsKGNhbGwpO1xyXG4gICAgICB5ID0gb2Zmc2V0O1xyXG4gICAgICBzY3JvbGxpbmcgPSBmYWxzZTtcclxuICAgIH1cclxuICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AgPSB5O1xyXG4gIH0sIDIwKTtcclxuICBvZmZzZXQgPSB0YXJnZXQub2Zmc2V0VG9wIC0gNTA7XHJcbiAgeSA9IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3A7XHJcbn1cclxuXHJcbi8qIEJBTk5FUiBTQ1JPTExJTkcgKi9cclxuXHJcbmZ1bmN0aW9uIHNob3dCYW5uZXJCeUluZGV4KGluZGV4KSB7XHJcbiAgY2xlYXJJbnRlcnZhbChiYW5uZXJJbnRlcnZhbCk7XHJcblxyXG4gIHZhciBiYW5uZXJzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9fY29udGFpbmVyJyk7XHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpO1xyXG4gIHZhciBhY3RpdmVJbmRleCA9IGluZGV4T2ZDbGFzcyhiYW5uZXJzLCAnYWN0aXZlJyk7XHJcblxyXG4gIGJhbm5lcnNbYWN0aXZlSW5kZXhdLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xyXG4gIGljb25zW2FjdGl2ZUluZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuXHJcbiAgYmFubmVyc1tpbmRleF0uY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgaWNvbnNbaW5kZXhdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG59XHJcblxyXG5mdW5jdGlvbiBzaG93TmV4dEJhbm5lcihlKSB7XHJcbiAgLy8gSWYgdGhpcyB3YXMgY2FsbGVkIGZyb20gYSBjbGljayB0aGVuIGNsZWFyIHRoZSByb3RhdGluZyBiYW5uZXJcclxuICBpZiAoZSAhPT0gdW5kZWZpbmVkKSB7XHJcbiAgICBjbGVhckludGVydmFsKGJhbm5lckludGVydmFsKTtcclxuICB9IGVsc2Uge1xyXG4gICAgLy8gRG9uJ3Qgc2hvdyBuZXh0IGJhbm5lciBpZiBob3ZlcmluZyBvbiBhIGJ1dHRvbiBvciBhcnJvd3NcclxuICAgIC8vIFRyaWVkIGFkZGluZyB0aGlzIGZvciBob3ZlcmluZyBvbiB0ZXh0IGJ1dCBmZWVkYmFjayB3YXNcclxuICAgIC8vIHRoYXQgcGVvcGxlIHNvbWV0aW1lcyBkb24ndCBub3RpY2UgdGhlIHRyYW5zaXRpb25zXHJcbiAgICB2YXIgYWN0aXZlQnV0dG9uID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmFjdGl2ZSAuYmFubmVyX19idXR0b246aG92ZXInKTtcclxuICAgIGlmIChhY3RpdmVCdXR0b24pIHJldHVybjtcclxuICAgIHZhciBhY3RpdmVBcnJvdyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5iYW5uZXJfX2Fycm93OmhvdmVyJyk7XHJcbiAgICBpZiAoYWN0aXZlQXJyb3cpIHJldHVybjtcclxuICB9XHJcblxyXG4gIHZhciBiYW5uZXJzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9fY29udGFpbmVyJyk7XHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpO1xyXG4gIHZhciBpbmRleCA9IGluZGV4T2ZDbGFzcyhiYW5uZXJzLCAnYWN0aXZlJyk7XHJcblxyXG4gIGJhbm5lcnNbaW5kZXhdLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xyXG4gIGljb25zW2luZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuXHJcbiAgdmFyIG5leHRCYW5uZXIgPSBiYW5uZXJzW2luZGV4ICsgMV07XHJcblxyXG4gIGlmIChuZXh0QmFubmVyICE9PSB1bmRlZmluZWQpIHtcclxuICAgIG5leHRCYW5uZXIuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgICBpY29uc1tpbmRleCArIDFdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gIH0gZWxzZSB7XHJcbiAgICBzaG93Rmlyc3RCYW5uZXIoKTtcclxuICB9XHJcbn1cclxuXHJcbmZ1bmN0aW9uIHNob3dQcmV2QmFubmVyKCkge1xyXG4gIC8vIElmIHRoaXMgd2FzIGNhbGxlZCBmcm9tIGEgY2xpY2sgdGhlbiBjbGVhciB0aGUgcm90YXRpbmcgYmFubmVyXHJcbiAgaWYgKGUgIT09IHVuZGVmaW5lZCkge1xyXG4gICAgY2xlYXJJbnRlcnZhbChiYW5uZXJJbnRlcnZhbCk7XHJcbiAgfVxyXG4gIHZhciBiYW5uZXJzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9fY29udGFpbmVyJyk7XHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpO1xyXG4gIHZhciBpbmRleCA9IGluZGV4T2ZDbGFzcyhiYW5uZXJzLCAnYWN0aXZlJyk7XHJcblxyXG4gIGJhbm5lcnNbaW5kZXhdLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xyXG4gIGljb25zW2luZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuXHJcbiAgdmFyIHByZXZCYW5uZXIgPSBiYW5uZXJzW2luZGV4IC0gMV07XHJcblxyXG4gIGlmIChwcmV2QmFubmVyICE9PSB1bmRlZmluZWQpIHtcclxuICAgIHByZXZCYW5uZXIuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgICBpY29uc1tpbmRleCAtIDFdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gIH0gZWxzZSB7XHJcbiAgICBzaG93TGFzdEJhbm5lcigpO1xyXG4gIH1cclxufVxyXG5cclxuZnVuY3Rpb24gc2hvd0ZpcnN0QmFubmVyKCkge1xyXG4gIHZhciBiYW5uZXJzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9fY29udGFpbmVyJyk7XHJcbiAgdmFyIGZpcnN0QmFubmVyID0gYmFubmVyc1swXTtcclxuXHJcbiAgZmlyc3RCYW5uZXIuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpWzBdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG59XHJcblxyXG5mdW5jdGlvbiBzaG93TGFzdEJhbm5lcigpIHtcclxuICB2YXIgYmFubmVycyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5iYW5uZXJfX2NvbnRhaW5lcicpO1xyXG4gIHZhciBsYXN0QmFubmVyID0gYmFubmVyc1tiYW5uZXJzLmxlbmd0aCAtIDFdO1xyXG5cclxuICBsYXN0QmFubmVyLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gIGRvY3VtZW50XHJcbiAgICAucXVlcnlTZWxlY3RvckFsbCgnLmJhbm5lcl9faWNvbicpXHJcbiAgICBbYmFubmVycy5sZW5ndGggLSAxXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxufVxyXG5cclxuLyogRU5EIEJBTk5FUiBTQ1JPTExJTkcgKi9cclxuXHJcbmZ1bmN0aW9uIGluZGV4T2ZDbGFzcyhub2RlTGlzdCwgY2xhc3NOYW1lKSB7XHJcbiAgdmFyIGNvdW50ZXIgPSAwO1xyXG4gIHZhciBpbmRleCA9IC0xO1xyXG5cclxuICBub2RlTGlzdC5mb3JFYWNoKGZ1bmN0aW9uKGVsbSkge1xyXG4gICAgaWYgKGVsbS5jbGFzc0xpc3QuY29udGFpbnMoY2xhc3NOYW1lKSkge1xyXG4gICAgICBpbmRleCA9IGNvdW50ZXI7XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICBjb3VudGVyKys7XHJcbiAgICB9XHJcbiAgfSk7XHJcblxyXG4gIHJldHVybiBpbmRleDtcclxufVxyXG5cclxuLyogRU5EIFNDUk9MTCBUTyBBTkNIT1IgKi9cclxuXHJcbi8qIFlPR0EgU0NIRURVTEUgKi9cclxuKGZ1bmN0aW9uKCQpIHtcclxuICAvLyBUZWFjaGVyIERldGFpbHNcclxuICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnLmNsYXNzX190ZWFjaGVyLWxpbmsnLCBmdW5jdGlvbigpIHtcclxuICAgIHZhciBzZWxlY3RvciA9ICcudGVhY2hlci0nICsgJCh0aGlzKS5kYXRhKCdpZCcpO1xyXG5cclxuICAgIG9wZW5Nb2RhbChzZWxlY3Rvcik7XHJcbiAgfSk7XHJcblxyXG4gIC8vIENsYXNzIERldGFpbHNcclxuICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnLmNsYXNzX19uYW1lLWxpbmsnLCBmdW5jdGlvbigpIHtcclxuICAgIHZhciBzZWxlY3RvciA9ICcuY2xhc3MtJyArICQodGhpcykuZGF0YSgnaWQnKTtcclxuICAgIG9wZW5Nb2RhbChzZWxlY3Rvcik7XHJcbiAgfSk7XHJcblxyXG4gIC8vIFJlZ2lzdGVyXHJcbiAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgJy5idXR0b24tLXJlZ2lzdGVyJywgZnVuY3Rpb24oZSkge1xyXG4gICAgLy8gU28gdGhhdCBpdCBjYW4gYmUgdXBkYXRlZCBsYXRlciB3aGVuIHRoZSBwZXJzb24gZmluaXNoZWQgcmVnaXN0cmF0aW9uXHJcbiAgICAkKHRoaXMpLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuXHJcbiAgICAkKCcucmVnaXN0cmF0aW9uLWZvcm0gLmNsYXNzX19uYW1lJykuaHRtbCgkKHRoaXMpLmRhdGEoJ2NsYXNzLW5hbWUnKSk7XHJcbiAgICAkKCcucmVnaXN0cmF0aW9uLWZvcm0gLmNsYXNzX19kYXRlJykuaHRtbChcclxuICAgICAgJCh0aGlzKS5kYXRhKCdjbGFzcy1kYXRlLXN0eWxlZCcpXHJcbiAgICApO1xyXG4gICAgJCgnLnJlZ2lzdHJhdGlvbi1mb3JtICNjbGFzc19kYXRlJykudmFsKCQodGhpcykuZGF0YSgnY2xhc3MtZGF0ZScpKTtcclxuICAgICQoJy5yZWdpc3RyYXRpb24tZm9ybSAjY2xhc3NfaWQnKS52YWwoJCh0aGlzKS5kYXRhKCdjbGFzcy1pZCcpKTtcclxuXHJcbiAgICBvcGVuTW9kYWwoJy5yZWdpc3RyYXRpb24tZm9ybScsIGNsb3NlTW9kYWwsIHJlZ2lzdGVyKTtcclxuICB9KTtcclxuXHJcbiAgLy8gTG9nb3V0XHJcbiAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgJy5sb2dvdXQnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAkLmFqYXgoe1xyXG4gICAgICB1cmw6ICcvc2FsdHNwcmluZ2NlbnRyZS9sb2dvdXQucGhwJyxcclxuICAgICAgbWV0aG9kOiAnUE9TVCcsXHJcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgLy8gcmVmcmVzaCB0aGUgcGFnZVxyXG4gICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xyXG4gICAgICB9XHJcbiAgICB9KTtcclxuICB9KTtcclxuXHJcbiAgLy8gUmVnaXN0ZXJcclxuICBmdW5jdGlvbiByZWdpc3RlcigpIHtcclxuICAgIHZhciBlbG0gPSAkKCcuYnV0dG9uLS1yZWdpc3Rlci5hY3RpdmUnKTtcclxuXHJcbiAgICAvLyBQcmVwYXJlIHRoZSBkYXRhXHJcbiAgICB2YXIgcmVnaXN0cmFudCA9IHtcclxuICAgICAgbmFtZV9maXJzdDogJCgnLm1vZGFsICNuYW1lX2ZpcnN0JykudmFsKCksXHJcbiAgICAgIG5hbWVfbGFzdDogJCgnLm1vZGFsICNuYW1lX2xhc3QnKS52YWwoKSxcclxuICAgICAgZW1haWw6ICQoJy5tb2RhbCAjZW1haWwnKS52YWwoKSxcclxuICAgICAgY2xhc3NfaWQ6ICQoJy5tb2RhbCAjY2xhc3NfaWQnKS52YWwoKSxcclxuICAgICAgY2xhc3NfZGF0ZTogJCgnLm1vZGFsICNjbGFzc19kYXRlJykudmFsKCksXHJcbiAgICAgIHdhaXZlcjogJCgnLm1vZGFsICN3YWl2ZXJfY2hlY2tib3gnKS5pcygnOmNoZWNrZWQnKVxyXG4gICAgfTtcclxuXHJcbiAgICAvKiBFUlJPUiBUUkFQUElORyAqL1xyXG4gICAgaWYgKCFyZWdpc3RyYW50LndhaXZlcikge1xyXG4gICAgICBhbGVydChcclxuICAgICAgICAnUGxlYXNlIG1ha2Ugc3VyZSB0byByZWFkIHRoZSB0ZXJtcyBhbmQgY2hlY2sgdGhlIHdhaXZlciBjaGVja2JveC4nXHJcbiAgICAgICk7XHJcbiAgICAgIHJldHVybiBmYWxzZTtcclxuICAgIH1cclxuXHJcbiAgICBpZiAocmVnaXN0cmFudC5uYW1lX2ZpcnN0Lmxlbmd0aCA9PSAwKSB7XHJcbiAgICAgIGFsZXJ0KFxyXG4gICAgICAgICdQbGVhc2UgbWFrZSBzdXJlIHRvIGVudGVyIHlvdXIgZmlyc3QgbmFtZS4gVGhpcyBpbmZvcm1hdGlvbiBpcyByZXF1aXJlZCB0byB2YWxpZGF0ZSBzaWduaW5nIHRoZSB3YWl2ZXIuJ1xyXG4gICAgICApO1xyXG4gICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICB9XHJcblxyXG4gICAgaWYgKHJlZ2lzdHJhbnQubmFtZV9sYXN0Lmxlbmd0aCA9PSAwKSB7XHJcbiAgICAgIGFsZXJ0KFxyXG4gICAgICAgICdQbGVhc2UgbWFrZSBzdXJlIHRvIGVudGVyIHlvdXIgbGFzdCBuYW1lLiBUaGlzIGluZm9ybWF0aW9uIGlzIHJlcXVpcmVkIHRvIHZhbGlkYXRlIHNpZ25pbmcgdGhlIHdhaXZlci4nXHJcbiAgICAgICk7XHJcbiAgICAgIHJldHVybiBmYWxzZTtcclxuICAgIH1cclxuXHJcbiAgICBpZiAocmVnaXN0cmFudC5lbWFpbC5sZW5ndGggPT0gMCkge1xyXG4gICAgICBhbGVydChcclxuICAgICAgICAnUGxlYXNlIG1ha2Ugc3VyZSB0byBlbnRlciB5b3VyIGVtYWlsIGFkZHJlc3MuIFRoaXMgaW5mb3JtYXRpb24gaXMgcmVxdWlyZWQgdG8gdmFsaWRhdGUgc2lnbmluZyB0aGUgd2FpdmVyLidcclxuICAgICAgKTtcclxuICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgfVxyXG5cclxuICAgICQuYWpheCh7XHJcbiAgICAgIHVybDogJy9zYWx0c3ByaW5nY2VudHJlL3JlZ2lzdGVyLnBocCcsXHJcbiAgICAgIGRhdGE6IHJlZ2lzdHJhbnQsXHJcbiAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXNwb25zZSkge1xyXG4gICAgICAgIHJlc3BvbnNlID0gSlNPTi5wYXJzZShyZXNwb25zZSk7XHJcbiAgICAgICAgaWYgKHJlc3BvbnNlLnN1Y2Nlc3MpIHtcclxuICAgICAgICAgIGVsbS5hZGRDbGFzcygnYnV0dG9uLS11bnJlZ2lzdGVyJyk7XHJcbiAgICAgICAgICBlbG0ucmVtb3ZlQ2xhc3MoJ2J1dHRvbi0tcmVnaXN0ZXInKTtcclxuICAgICAgICAgIGVsbS5yZW1vdmVDbGFzcygnLmFjdGl2ZScpO1xyXG4gICAgICAgICAgZWxtLmh0bWwoJ3VucmVnaXN0ZXInKTtcclxuICAgICAgICAgIGVsbS5kYXRhKCdyZWdpc3RyYXRpb24taWQnLCByZXNwb25zZS5yZWdpc3RyYXRpb25faWQpO1xyXG4gICAgICAgICAgYWxlcnQoJ1lvdSBoYXZlIGJlZW4gcmVnaXN0ZXJlZCBmb3IgdGhpcyBjbGFzcycpO1xyXG4gICAgICAgICAgY2xvc2VNb2RhbCgpO1xyXG4gICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICBhbGVydChcclxuICAgICAgICAgICAgJ1NvbXRoaW5nIHdlbnQgd3JvbmcuIFNvcnJ5IGZvciB0aGUgaW52b252ZW5pZW5jZS4gUGxlYXNlIHRyeSBhZ2FpbiBsYXRlci4nXHJcbiAgICAgICAgICApO1xyXG4gICAgICAgIH1cclxuICAgICAgfVxyXG4gICAgfSk7XHJcbiAgfVxyXG5cclxuICAvLyBSZWdpc3RlclxyXG4gICQoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuYnV0dG9uLS11bnJlZ2lzdGVyJywgZnVuY3Rpb24oZSkge1xyXG4gICAgdmFyIGVsbSA9ICQodGhpcyk7XHJcbiAgICB2YXIgcmVnaXN0cmF0aW9uSUQgPSBlbG0uZGF0YSgncmVnaXN0cmF0aW9uLWlkJyk7XHJcblxyXG4gICAgLy8gUHJlcGFyZSB0aGUgZGF0YVxyXG4gICAgdmFyIGRhdGEgPSB7XHJcbiAgICAgIHJlZ2lzdHJhdGlvbl9pZDogcmVnaXN0cmF0aW9uSURcclxuICAgIH07XHJcblxyXG4gICAgJC5hamF4KHtcclxuICAgICAgdXJsOiAnL3NhbHRzcHJpbmdjZW50cmUvdW5yZWdpc3Rlci5waHAnLFxyXG4gICAgICBkYXRhOiBkYXRhLFxyXG4gICAgICBtZXRob2Q6ICdQT1NUJyxcclxuICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHtcclxuICAgICAgICByZXNwb25zZSA9IEpTT04ucGFyc2UocmVzcG9uc2UpO1xyXG4gICAgICAgIGlmIChyZXNwb25zZS5zdWNjZXNzKSB7XHJcbiAgICAgICAgICBlbG0ucmVtb3ZlQ2xhc3MoJ2J1dHRvbi0tdW5yZWdpc3RlcicpO1xyXG4gICAgICAgICAgZWxtLmFkZENsYXNzKCdidXR0b24tLXJlZ2lzdGVyJyk7XHJcbiAgICAgICAgICBlbG0uaHRtbCgncmVnaXN0ZXInKTtcclxuICAgICAgICAgIGFsZXJ0KCdZb3UgaGF2ZSBiZWVuIHVucmVnaXN0ZXJlZCBmb3IgdGhpcyBjbGFzcycpO1xyXG4gICAgICAgIH1cclxuICAgICAgfVxyXG4gICAgfSk7XHJcbiAgfSk7XHJcbn0pKGpRdWVyeSk7XHJcblxyXG4vKiBNb2JpbGUgTWVudSAqL1xyXG52YXIgbWVudU9wZW4gPSBmYWxzZTtcclxuZnVuY3Rpb24gdG9nZ2xlTWVudSgpIHtcclxuICBpZiAoIW1lbnVPcGVuKSB7XHJcbiAgICAvL2RvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ2JvZHknKS5jbGFzc0xpc3QuYWRkKCdvcGVuJyk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubW9iaWxlX19idXR0b24nKS5jbGFzc0xpc3QuYWRkKCdvcGVuJyk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubW9iaWxlX19tZW51LWJhY2tncm91bmQnKS5jbGFzc0xpc3QuYWRkKCdvcGVuJyk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubW9iaWxlX19tZW51JykuY2xhc3NMaXN0LmFkZCgnb3BlbicpO1xyXG5cclxuICAgIG1lbnVPcGVuID0gdHJ1ZTtcclxuICB9IGVsc2Uge1xyXG4gICAgLy9kb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5JykuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xyXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vYmlsZV9fYnV0dG9uJykuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xyXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vYmlsZV9fbWVudS1iYWNrZ3JvdW5kJykuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xyXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vYmlsZV9fbWVudScpLmNsYXNzTGlzdC5yZW1vdmUoJ29wZW4nKTtcclxuXHJcbiAgICBtZW51T3BlbiA9IGZhbHNlO1xyXG4gIH1cclxufVxyXG5cclxuLy8gQ2xpY2sgaGFuZGxlciBmb3IgTW9iaWxlIE1lbnUgQnV0dG9uXHJcbmRvY3VtZW50XHJcbiAgLnF1ZXJ5U2VsZWN0b3IoJy5tb2JpbGVfX2J1dHRvbicpXHJcbiAgLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xyXG4gICAgdG9nZ2xlTWVudSgpO1xyXG4gIH0pO1xyXG5cclxuLyogUmVzcG9uc2l2ZSBWaWRlb3MgKi9cclxuLy8gQWRkIGEgY2xhc3MgdG8gYW55IHBhcmFncmFwaCB0aGF0IGNvbnRhaW5zIGFuIGlmcmFtZSAoZW1iZWRlZCB2aWRlbylcclxudmFyIHZpZGVvcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ2lmcmFtZScpLmZvckVhY2goZnVuY3Rpb24oZWxtKSB7XHJcbiAgZWxtLnBhcmVudEVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnaWZyYW1lLWNvbnRhaW5lcicpO1xyXG59KTtcclxuXHJcbi8vIE1vZGFsXHJcbnZhciBtb2RhbE9wZW4gPSBmYWxzZTtcclxuZnVuY3Rpb24gb3Blbk1vZGFsKHNlbGVjdG9yLCBjYW5jZWwsIGFjdGlvbikge1xyXG4gIGlmIChjYW5jZWwgPT09IHVuZGVmaW5lZCkge1xyXG4gICAgY2FuY2VsID0gY2xvc2VNb2RhbDtcclxuICB9XHJcbiAgaWYgKGFjdGlvbiA9PT0gdW5kZWZpbmVkKSB7XHJcbiAgICBhY3Rpb24gPSBmdW5jdGlvbigpIHtcclxuICAgICAgYWxlcnQoJ2hlbGxvJyk7XHJcbiAgICB9O1xyXG4gIH1cclxuXHJcbiAgLy8gQ29weSB0aGUgY29udGVudFxyXG4gIHZhciBtb2RhbENvbnRlbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubW9kYWxfX2NvbnRlbnQtaHRtbCcpO1xyXG4gIHZhciBjb250ZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3Rvcik7XHJcblxyXG4gIG1vZGFsQ29udGVudC5pbm5lckhUTUwgPSBjb250ZW50LmlubmVySFRNTDtcclxuXHJcbiAgLy8gQWRkIHRoZSBidXR0b24gaGFuZGxlcnMgaWYgdGhlIGJ1dHRvbnMgZXhpc3RcclxuICB2YXIgY2FuY2VsQnV0dG9uID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vZGFsIC5tb2RhbF9fY2FuY2VsJyk7XHJcbiAgdmFyIGFjdGlvbkJ1dHRvbiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5tb2RhbCAubW9kYWxfX2FjdGlvbicpO1xyXG5cclxuICBpZiAoY2FuY2VsQnV0dG9uKSB7XHJcbiAgICBjYW5jZWxCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBjYW5jZWwpO1xyXG4gIH1cclxuICBpZiAoYWN0aW9uQnV0dG9uKSB7XHJcbiAgICBhY3Rpb25CdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBhY3Rpb24pO1xyXG4gIH1cclxuXHJcbiAgc2hvd01vZGFsKCk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIHNob3dNb2RhbCgpIHtcclxuICBzaG93Qmx1cigpO1xyXG5cclxuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubW9kYWwnKS5jbGFzc0xpc3QuYWRkKCdvcGVuJyk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIGNsb3NlTW9kYWwoKSB7XHJcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vZGFsJykuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xyXG5cclxuICBzZXRUaW1lb3V0KGhpZGVCbHVyLCA1MDApO1xyXG59XHJcblxyXG5mdW5jdGlvbiB0b2dnbGVCbHVyKCkge1xyXG4gIC8vIEZpbmQgb3V0IGlmIHRoZSBwYWdlIGlzIGJsdXJyZWRcclxuICB2YXIgaXNCbHVyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmJsdXInKS5sZW5ndGggPiAwO1xyXG5cclxuICBpZiAoIWlzQmx1cikge1xyXG4gICAgc2hvd0JsdXIoKTtcclxuICB9IGVsc2Uge1xyXG4gICAgaGlkZUJsdXIoKTtcclxuICB9XHJcbn1cclxuXHJcbmZ1bmN0aW9uIHNob3dCbHVyKCkge1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5tYWluJykuY2xhc3NMaXN0LmFkZCgnYmx1cicpO1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5oZWFkZXInKS5jbGFzc0xpc3QuYWRkKCdibHVyJyk7XHJcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvb3RlcicpLmNsYXNzTGlzdC5hZGQoJ2JsdXInKTtcclxuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5JykuY2xhc3NMaXN0LmFkZCgnbm8tc2Nyb2xsJyk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIGhpZGVCbHVyKCkge1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5tYWluJykuY2xhc3NMaXN0LnJlbW92ZSgnYmx1cicpO1xyXG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5oZWFkZXInKS5jbGFzc0xpc3QucmVtb3ZlKCdibHVyJyk7XHJcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvb3RlcicpLmNsYXNzTGlzdC5yZW1vdmUoJ2JsdXInKTtcclxuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5JykuY2xhc3NMaXN0LnJlbW92ZSgnbm8tc2Nyb2xsJyk7XHJcbn1cclxuXHJcbi8vIENsb3NlIGNsaWNrIGhhbmRsZXJcclxuZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm1vZGFsX19jbG9zZScpLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgY2xvc2VNb2RhbCk7XHJcblxyXG4vLyBQc3VlZG8gU3R5bGluZ1xyXG52YXIgVUlEID0ge1xyXG4gIF9jdXJyZW50OiAwLFxyXG4gIGdldE5ldzogZnVuY3Rpb24oKSB7XHJcbiAgICB0aGlzLl9jdXJyZW50Kys7XHJcbiAgICByZXR1cm4gdGhpcy5fY3VycmVudDtcclxuICB9XHJcbn07XHJcblxyXG4vKiBORVdTIFNDUk9MTElORyAqL1xyXG5cclxuZnVuY3Rpb24gc2hvd05ld3NCeUluZGV4KGluZGV4KSB7XHJcbiAgY2xlYXJJbnRlcnZhbChuZXdzSW50ZXJ2YWwpO1xyXG5cclxuICB2YXIgbmV3cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5uZXdzX19jb250YWluZXInKTtcclxuICB2YXIgaWNvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubmV3c19faWNvbicpO1xyXG4gIHZhciBhY3RpdmVJbmRleCA9IGluZGV4T2ZDbGFzcyhuZXdzLCAnYWN0aXZlJyk7XHJcblxyXG4gIG5ld3NbYWN0aXZlSW5kZXhdLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xyXG4gIGljb25zW2FjdGl2ZUluZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuXHJcbiAgbmV3c1tpbmRleF0uY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgaWNvbnNbaW5kZXhdLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG59XHJcblxyXG5mdW5jdGlvbiBzaG93TmV4dE5ld3MoKSB7XHJcbiAgdmFyIG5ld3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubmV3c19fY29udGFpbmVyJyk7XHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2ljb24nKTtcclxuICB2YXIgaW5kZXggPSBpbmRleE9mQ2xhc3MobmV3cywgJ2FjdGl2ZScpO1xyXG5cclxuICBuZXdzW2luZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuICBpY29uc1tpbmRleF0uY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJyk7XHJcblxyXG4gIHZhciBuZXh0TmV3cyA9IG5ld3NbaW5kZXggKyAxXTtcclxuXHJcbiAgaWYgKG5leHROZXdzICE9PSB1bmRlZmluZWQpIHtcclxuICAgIG5leHROZXdzLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gICAgaWNvbnNbaW5kZXggKyAxXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxuICB9IGVsc2Uge1xyXG4gICAgc2hvd0ZpcnN0TmV3cygpO1xyXG4gIH1cclxufVxyXG5cclxuZnVuY3Rpb24gc2hvd1ByZXZCYW5uZXIoKSB7XHJcbiAgdmFyIGJhbm5lcnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubmV3c19fY29udGFpbmVyJyk7XHJcbiAgdmFyIGljb25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2ljb24nKTtcclxuICB2YXIgaW5kZXggPSBpbmRleE9mQ2xhc3MoYmFubmVycywgJ2FjdGl2ZScpO1xyXG5cclxuICBuZXdzW2luZGV4XS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcclxuICBpY29uc1tpbmRleF0uY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJyk7XHJcblxyXG4gIHZhciBwcmV2TmV3cyA9IG5ld3NbaW5kZXggLSAxXTtcclxuXHJcbiAgaWYgKHByZXZOZXdzICE9PSB1bmRlZmluZWQpIHtcclxuICAgIHByZXZOZXdzLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xyXG4gICAgaWNvbnNbaW5kZXggLSAxXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxuICB9IGVsc2Uge1xyXG4gICAgc2hvd0xhc3ROZXdzKCk7XHJcbiAgfVxyXG59XHJcblxyXG5mdW5jdGlvbiBzaG93Rmlyc3ROZXdzKCkge1xyXG4gIHZhciBuZXdzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2NvbnRhaW5lcicpO1xyXG4gIHZhciBmaXJzdE5ld3MgPSBuZXdzWzBdO1xyXG5cclxuICBmaXJzdE5ld3MuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2ljb24nKVswXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxufVxyXG5cclxuZnVuY3Rpb24gc2hvd0xhc3ROZXdzKCkge1xyXG4gIHZhciBiYW5uZXJzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5ld3NfX2NvbnRhaW5lcicpO1xyXG4gIHZhciBsYXN0TmV3cyA9IG5ld3NbbmV3cy5sZW5ndGggLSAxXTtcclxuXHJcbiAgbGFzdE5ld3MuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XHJcbiAgZG9jdW1lbnRcclxuICAgIC5xdWVyeVNlbGVjdG9yQWxsKCcubmV3c19faWNvbicpXHJcbiAgICBbbmV3cy5sZW5ndGggLSAxXS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcclxufVxyXG5cclxuLyogRU5EIEJBTk5FUiBTQ1JPTExJTkcgKi9cclxuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vanMvY29tbW9uLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==