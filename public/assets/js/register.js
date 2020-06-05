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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/custom/register.js":
/*!*****************************************!*\
  !*** ./resources/js/custom/register.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  var token = $('meta[name=csrf_token]').attr('content');

  function isValidEmail(email) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(email);
  }

  ;
  var register__step_one = $('#register__step_one');
  var register__step_two = $('#register__step_two');
  var register__step_three = $('#register__step_three');
  var register__step_four = $('#register__step_four');
  var register__step_five = $('#register__step_five');
  var bar__one = $('#bar__one');
  var bar__two = $('#bar__two');
  var bar__three = $('#bar__three');
  var bar__four = $('#bar__four'); // coding for password and confirm password

  var password = $("#register-password");
  var c_password = $("#register-password-confirm");
  var password_error = $('.password-error');
  var c_password_error = $('.c-password-error');
  $('#step-btn-1').on('click', function () {
    var username = $("#register-username").val();
    var email = $("#register-email").val();

    if (username == '') {
      $('.username-error').html('<div class="text-danger">OPS!  Username is required!</div>');
    } else if (username.trim().length <= 5) {
      $('.username-error').empty();
      $('.username-error').html('<div class="text-danger">Please enter at least 6 charecter!</div>');
    }

    if (email == '') {
      $('.email-error').html('<div class="text-danger">OPS!  Email is required!</div>');
    } else if (!isValidEmail(email)) {
      $('.email-error').empty();
      $('.email-error').html('<div class="text-danger">Please enter valid email address!</div>');
    }

    if (password.val() == '') {
      password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
    }

    if (c_password.val() == '') {
      c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
    }

    if (password.val() != c_password.val()) {
      c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
    } else {
      if (username != '' && email != '' && password.val() != '' && c_password.val() != '') {
        password_error.empty();
        $('.username-error').empty();
        $('.email-error').empty();
        c_password_error.empty();
        $('.step-1').removeClass('active-step');
        $('.step-2').addClass('active-step');
        bar__one.addClass('step__bar_complete');
        bar__two.addClass('step__bar_active');
        register__step_two.addClass('step__active');
      }
    }
  });
  password.on('keyup', function (e) {
    var password_val = $(this).val();

    if (password_val.length >= 6) {
      if (password_val != '') {
        password_error.empty();
      } else {
        password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
      }
    } else {
      password_error.empty();
      password_error.html('<div class="text-danger">OPS!  Password must be 6 charecter!</div>');
    }
  });
  c_password.on('keyup', function (e) {
    var c_password_val = $(this).val();

    if (c_password_val.length >= 6) {
      if (c_password_val != '') {
        password_error.empty();

        if (password.val() != c_password_val) {
          c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
        } else {
          c_password_error.empty();
        }
      } else {
        c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
      }
    } else {
      c_password_error.empty();
      c_password_error.html('<div class="text-danger">OPS! Confirm Password must be 6 charecter!</div>');
    }
  }); //start coding for gender and preference

  var gender = $('#register-gender');
  var preference = $('#register-preference');
  var gender_error = $('.gender-error');
  var preference_error = $('.preference-error');
  gender.on('change', function (e) {
    if ($(this).val() == '') {
      gender_error.html('<div class="text-danger">OPS!  Gender is required!</div>');
    } else {
      gender_error.empty();
    }
  });
  preference.on('change', function (e) {
    if ($(this).val() == '') {
      preference_error.html('<div class="text-danger">OPS! Perference is required!</div>');
    } else {
      preference_error.empty();
    }
  }); //start coding for day month year

  var day = $('#register-day');
  var month = $('#register-month');
  var year = $('#register-year');
  var date_error = $('.date-error');
  day.on('change', function (e) {
    if ($(this).val() == '') {
      date_error.html('<div class="text-danger">OPS! All field is required!</div>');
    } else {
      date_error.empty();
    }
  });
  month.on('change', function (e) {
    if ($(this).val() == '') {
      date_error.html('<div class="text-danger">OPS! All field is required!</div>');
    } else {
      date_error.empty();
    }
  });
  year.on('change', function (e) {
    if ($(this).val() == '') {
      date_error.html('<div class="text-danger">OPS! All field is required!</div>');
    } else {
      date_error.empty();
    }
  }); //start coding for day month year

  var address = $('#register-address');
  var country = $('#register-country');
  var address_error = $('.address-error');
  var country_error = $('.country-error');
  address.on('keyup', function (e) {
    if ($(this).val() == '') {
      address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
    } else {
      address_error.empty();
    }
  });
  country.on('change', function (e) {
    if ($(this).val() == '') {
      country_error.html('<div class="text-danger">OPS! Country is required!</div>');
    } else {
      country_error.empty();
    }
  });
  $('#step-btn-2').on('click', function () {
    if (gender.val() == '') {
      gender_error.html('<div class="text-danger">OPS!  Gender is required!</div>');
    }

    if (preference.val() == '') {
      preference_error.html('<div class="text-danger">OPS! Perference is required!</div>');
    }

    if (preference.val() != '' && gender.val() != '') {
      gender_error.empty();
      preference_error.empty();
      $('.step-5').removeClass('active-step'); // $('.step-5').addClass('active-step');
    }

    if (day.val() != '' && month.val() != '' && year.val() != '') {
      date_error.empty();
    } else {
      date_error.html('<div class="text-danger">OPS! All field is required!</div>');
    }

    if (address.val() == '') {
      address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
    }

    if (country.val() == '') {
      country_error.html('<div class="text-danger">OPS! Country is required!</div>');
    }

    if (preference.val() != '' && gender.val() != '' && country.val() != '' && address.val() != '' && day.val() != '' && month.val() != '' && year.val() != '') {
      address_error.empty();
      country_error.empty();
      $('.step-2').removeClass('active-step');
      $('.step-3').addClass('active-step');
      bar__two.addClass('step__bar_complete');
      bar__three.addClass('step__bar_active');
      register__step_three.addClass('step__active');
    }
  });
  $('#step-back-1').on('click', function () {
    $('.step-1').addClass('active-step');
    $('.step-2').removeClass('active-step');
    bar__one.removeClass('step__bar_complete');
    bar__two.removeClass('step__bar_active');
    register__step_two.removeClass('step__active');
  });
  $('#step-back-2').on('click', function () {
    $('.step-2').addClass('active-step');
    $('.step-3').removeClass('active-step');
    bar__two.removeClass('step__bar_complete');
    bar__three.removeClass('step__bar_active');
    register__step_three.removeClass('step__active');
  });
  $('#step-back-3').on('click', function () {
    $('.step-3').addClass('active-step');
    $('.step-4').removeClass('active-step');
    bar__three.removeClass('step__bar_complete');
    bar__four.removeClass('step__bar_active');
    register__step_four.removeClass('step__active');
  });
  $('#step-back-4').on('click', function () {
    $('.step-4').addClass('active-step');
    $('.step-5').removeClass('active-step');
    bar__four.removeClass('step__bar_complete');
    bar__five.removeClass('step__bar_active');
    register__step_five.removeClass('step__active');
  }); // start coding for interest  

  var selectedInterests = [];
  var selected_interest = $('.selected__interest');
  var interests = $('#register-interests-input');
  var search_interest = $('#search_interest');
  var interest_search_available = $('.search_interest_available');
  var loader = $('.loader');
  var interest_error = $('.interest-error');
  search_interest.on('keyup', function (e) {
    var search = $(this).val();
    loader.empty();
    interest_error.empty();
    interest_search_available.empty();

    if (search != '') {
      interest_search_available.empty();
      $.ajax({
        url: ajax_url,
        beforeSend: function beforeSend() {
          $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
          interest_search_available.empty();
        },
        data: {
          action: 'search_interest',
          search: search,
          _token: token
        },
        dataType: 'JSON',
        type: 'POST',
        success: function success(res) {
          interest_search_available.empty();

          if ($.isEmptyObject(res.data)) {
            $('<div class="text-center text-danger"></div>').html('Interest not found!').appendTo(interest_search_available);
          }

          if (res.status === 'success') {
            var results = res.data.filter(function (o1) {
              return !selectedInterests.some(function (o2) {
                return o1.id === o2.id;
              });
            });
            $.map(results, function (interest) {
              $('<div class="interest__item" data-id="' + interest.id + '"></div>').html('<i class="' + interest.icon + '"></i>\
                                    <span>' + interest.text + '</span>').appendTo(interest_search_available);
            });
          }

          setTimeout(function () {
            $(document).off('click').on('click', '.interest__item', function () {
              var id = $(this).data('id');
              $.ajax({
                url: ajax_url,
                data: {
                  action: 'interest_by_id',
                  id: id,
                  _token: token
                },
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function success(res) {
                  if (res.status === 'success') {
                    $(this).remove();
                    interest_error.empty();
                    selectedInterests.push(res.data);
                  }

                  setTimeout(function () {
                    var uniqueInterest = selectedInterests;
                    selectedInterests.filter(function (item) {
                      var i = uniqueInterest.findIndex(function (x) {
                        return x.id == item.id;
                      });

                      if (i <= -1) {
                        uniqueInterest.push(item);
                      }

                      return null;
                    });

                    if (!$.isEmptyObject(uniqueInterest)) {
                      selected_interest.empty();
                      var outputs = [];
                      $.map(uniqueInterest, function (output) {
                        outputs.push(output.id);
                        $('<div class="interest__item_selected"></div>').html('<i data-id="' + output.id + '" class="cross__interest_btn fa fa-times"></i><i class="' + output.icon + '"></i>\
                                                        <span>' + output.text + '</span>').appendTo(selected_interest);
                      });
                      interests.val(outputs.join(','));
                      $('.cross__interest_btn').click(function () {
                        interests.val('');
                        var id = $(this).data('id');

                        if (id) {
                          var deleteint = selectedInterests.find(function (interest) {
                            return interest.id === id;
                          });
                          var index = selectedInterests.indexOf(deleteint);
                          selectedInterests.splice(index, 1);
                          $(this).parent().remove();
                          var removeOutput = selectedInterests.map(function (_int) {
                            return _int.id;
                          });
                          interests.val(removeOutput.join(','));
                          $('<div class="interest__item" data-id="' + deleteint.id + '"></div>').html('<i class="' + deleteint.icon + '"></i>\
                                                            <span>' + deleteint.text + '</span>').appendTo(interest_search_available);
                        }
                      });
                    }
                  }, 50);
                }
              });
            });
          }, 100);
        },
        complete: function complete() {
          loader.empty();
        }
      });
    } else {
      loader.empty();
      interest_search_available.empty();
    }
  });
  $('#step-btn-3').on('click', function () {
    if (interests.val() != '') {
      $('.step-3').removeClass('active-step');
      $('.step-4').addClass('active-step');
      bar__three.addClass('step__bar_complete');
      register__step_four.addClass('step__active');
    } else {
      interest_error.html('<div class="text-danger">OPS! Interest is required!</div>');
    }
  });
  $('#step-btn-4').on('click', function () {
    $('.step-4').removeClass('active-step');
    $('.step-5').addClass('active-step');
    bar__four.addClass('step__bar_complete');
    register__step_five.addClass('step__active');
  });
});

/***/ }),

/***/ 6:
/*!***********************************************!*\
  !*** multi ./resources/js/custom/register.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\mdala\OneDrive\Desktop\united states website\resources\js\custom\register.js */"./resources/js/custom/register.js");


/***/ })

/******/ });