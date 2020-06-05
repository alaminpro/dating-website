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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/custom/setting.js":
/*!****************************************!*\
  !*** ./resources/js/custom/setting.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.noUi-handle').on('click', function () {
    $(this).width(50);
  });
  var rangeSlider = document.getElementById('slider-range');
  var start = [];
  var min = '{{ $user->min_age }}';
  var max = '{{ $user->max_age }}';

  if (min != '' && max != '') {
    start = [min, max];
  } else {
    start = [18, 90];
  }

  noUiSlider.create(rangeSlider, {
    start: start,
    step: 1,
    range: {
      'min': [18],
      'max': [90]
    },
    connect: true,
    format: wNumb({
      decimals: 0
    })
  }); // Set visual min and max values and also update value hidden form inputs

  rangeSlider.noUiSlider.on('update', function (values, handle) {
    document.getElementById('slider-range-value1').innerHTML = values[0];
    document.getElementById('slider-range-value2').innerHTML = values[1];
    var minVal = $('#min-value');
    var maxVal = $('#max-value');
    minVal.val(values[0]);
    maxVal.val(values[1]);
  });
});
$('#location__icon').click(function () {
  $('.location__search').toggle();
});
$('.range').change(function () {
  $('#distance').val($(this).val());
});
var uploadedImageURL = '{!! avatar($user->avatar, $user->gender) !!}';
$(document).ready(function () {
  var token = $('meta[name=csrf_token]').attr('content');
  $('ul.tab__items li').click(function () {
    var tab_id = $(this).attr('data-tab');
    $('ul.tab__items li.tab__item').removeClass('tab__active');
    $('.tab__content').removeClass('current');
    $(this).addClass('tab__active');
    $("#" + tab_id).addClass('current');
  });
  var loader = $('.loader');
  var alert = $('.username-error');
  $('#register-setting-username').on('keyup', function (e) {
    var username = $(this).val();
    loader.empty();
    alert.empty();

    if (username != '') {
      if (username.trim().length >= 6) {
        alert.empty();
        $.ajax({
          url: ajax_url,
          beforeSend: function beforeSend() {
            $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
            alert.empty();
          },
          data: {
            action: 'check_username_setting',
            username: username,
            _token: token
          },
          dataType: 'JSON',
          type: 'POST',
          success: function success(res) {
            alert.empty();

            if (res.status == 'error') {
              $('#tab-2-profile').attr("disabled", true);
              $('<div class="text-danger"></div>').html('Username already exist! Try again.').appendTo(alert);
            } else if (res.status == 'success') {
              $('#tab-2-profile').removeAttr("disabled");
              $('<div class="text-success"></div>').html('Great! You\'r Choose good username.').appendTo(alert);
            } else if (res.status == 'you') {
              $('#tab-2-profile').removeAttr("disabled");
              $('<div class="text-success"></div>').html('Your current username!').appendTo(alert);
            }
          },
          complete: function complete() {
            loader.empty();
          }
        });
      } else {
        $('<div class="text-danger"></div>').html('Please enter at least 6 charecter!').appendTo(alert);
      }
    } else {
      loader.empty();
      alert.empty();
    }
  });
  var password = $("#register-password");
  var c_password = $("#register-password-confirm");
  var old_password = $("#register-password-old");
  var password_error = $('.password-error');
  var c_password_error = $('.c-password-error');
  var old_password_error = $('.old-password-error');
  var loader = $('.loader');
  old_password.on('keyup', function () {
    var old_password = $(this).val();
    loader.empty();

    if (old_password.length >= 6) {
      old_password_error.empty();
      $.ajax({
        url: ajax_url,
        beforeSend: function beforeSend() {
          $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
          old_password_error.empty();
        },
        data: {
          action: 'check_password',
          password: old_password,
          _token: token
        },
        dataType: 'JSON',
        type: 'POST',
        success: function success(res) {
          old_password_error.empty();

          if (res.status == 'error') {
            password.attr("disabled", true);
            c_password.attr("disabled", true);
            $('#tab-3-password').attr("disabled", true);
            $('<div class="text-danger"></div>').html('Old password doesn\'t match!').appendTo(old_password_error);
          } else {
            password.removeAttr("disabled");
            c_password.removeAttr("disabled");
            $('#tab-3-password').removeAttr("disabled");
            $('<div class="text-success"></div>').html('Password match!').appendTo(old_password_error);
          }
        },
        complete: function complete() {
          loader.empty();
        }
      });
    } else {
      old_password_error.empty();
      $('<div class="text-danger"></div>').html('Please enter at least 6 charecter!').appendTo(old_password_error);
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
  });
  $('#tab-3-password').on('click', function () {
    var submited = true;

    if (old_password.val().length >= 6) {
      if (password.val() == '') {
        password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
        return submited = false;
      }

      if (c_password.val() == '') {
        c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
        return submited = false;
      }

      if (password.val() != c_password.val()) {
        c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
        return submited = false;
      }
    }

    return submited;
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
  $('#tab-4-interest').click(function (e) {
    var submited = true;

    if (address.val() == '') {
      address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
      submited = false;
    }

    if (country.val() == '') {
      country_error.html('<div class="text-danger">OPS! Country is required!</div>');
      submited = false;
    }

    return submited;
  }); //start coding for day month year

  var gender = $('#gender');
  var preference = $('#preference');
  var gender_error = $('.gender-error');
  var preference_error = $('.preference-error');
  gender.on('change', function (e) {
    if ($(this).val() == '') {
      gender_error.html('<div class="text-danger">OPS! Gender is required!</div>');
    } else {
      gender_error.empty();
    }
  });
  preference.on('change', function (e) {
    if ($(this).val() == '') {
      preference_error.html('<div class="text-danger">OPS! Preference is required!</div>');
    } else {
      preference_error.empty();
    }
  });
  $('#tab-2-profile').click(function (e) {
    var submited = true;

    if (gender.val() == '') {
      gender_error.html('<div class="text-danger">OPS! Gender is required!</div>');
      submited = false;
    }

    if (preference.val() == '') {
      preference_error.html('<div class="text-danger">OPS! Preference is required!</div>');
      submited = false;
    }

    return submited;
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
  $.ajax({
    url: ajax_url,
    data: {
      action: 'load_user_interest',
      id: '{{auth()->user()->id}}',
      _token: token
    },
    dataType: 'JSON',
    type: 'POST',
    context: this,
    success: function success(res) {
      if (res.status === 'success') {
        interests.val(res.interest_id.join(','));
        selectedInterests = res.interest;
        $.map(res.interest, function (interest) {
          $('<div class="interest__item_selected"></div>').html('<i data-id="' + interest.id + '" class="cross__interest_btn fa fa-times"></i><i class="' + interest.icon + '"></i>\
                                <span>' + interest.text + '</span>').appendTo(selected_interest);
        });
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
    }
  });
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
                var removeOutput = selectedInterests.map(function (_int2) {
                  return _int2.id;
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
  $('#tab-5-interest').click(function (e) {
    var submited = true;

    if (interests.val() == '') {
      interest_error.html('<div class="text-danger">OPS! Interest is required!</div>');
      submited = false;
    }

    return submited;
  });
});

/***/ }),

/***/ 5:
/*!**********************************************!*\
  !*** multi ./resources/js/custom/setting.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\mdala\OneDrive\Desktop\united states website\resources\js\custom\setting.js */"./resources/js/custom/setting.js");


/***/ })

/******/ });