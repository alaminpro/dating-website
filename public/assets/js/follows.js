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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/custom/follows.js":
/*!****************************************!*\
  !*** ./resources/js/custom/follows.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var token = $('meta[name=csrf_token]').attr('content');
$(document).ready(function () {
  var socket = io(socket_url, {
    path: '/node/socket.io',
    transports: ['polling', 'websocket']
  });
  var user_id = $('#main__user_id').data('id');
  var loader = $('.loader');
  var followers = $('.follow__followers');
  var following = $('.follow__following');
  var contents = $('.contents');
  var not_found = $('.not_found');

  if (!location.search) {
    queryParams('?tab=followers');
  }

  if (getQueryParams() === 'followers' || getQueryParams() === 'following') {
    var follow = getQueryParams();

    if (follow === 'followers') {
      ajax_follow('get_followers');
    } else {
      ajax_following('get_following');
    }
  }

  if (getQueryParams() === 'followers') {
    followers.addClass('follow__tab_active');
    following.removeClass('follow__tab_active');
  } else {
    following.addClass('follow__tab_active');
    followers.removeClass('follow__tab_active');
  }

  followers.off('click').on('click', function () {
    $(this).addClass('follow__tab_active');
    following.removeClass('follow__tab_active');
    queryParams('?tab=followers');
    ajax_follow('get_followers');
    not_found.empty();
  });
  following.off('click').on('click', function () {
    $(this).addClass('follow__tab_active');
    followers.removeClass('follow__tab_active');
    queryParams('?tab=following');
    ajax_following('get_following');
    not_found.empty();
  });

  function queryParams(query) {
    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + query;
    return window.history.pushState({
      path: newurl
    }, '', newurl);
  }

  function getQueryParams() {
    var queries = {};
    $.each(document.location.search.substr(1).split('&'), function (c, q) {
      var i = q.split('=');
      queries[i[0].toString()] = i[1].toString();
    });
    return queries.tab;
  }

  function ajax_follow(method) {
    return $.ajax({
      url: ajax_url_follow,
      beforeSend: function beforeSend() {
        $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
        contents.empty();
      },
      data: {
        action: method,
        id: logged_id,
        _token: token
      },
      dataType: 'JSON',
      type: 'POST',
      context: this,
      success: function success(res) {
        if (res.status === 'success') {
          if ($.isEmptyObject(res.datas)) {
            $('<div class="text-center text-danger w-100"></div>').html('You have no followers at the moment').appendTo(contents);
          }

          $.map(res.datas, function (data) {
            if (data.avatar) {
              $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                <a href="/u/' + data.username + '" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/' + data.avatar + '" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                    <button type="button" class="follow__btn" data-id="' + data.id + '">\
                                            <div class="btn_text">' + data.follow + '</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
            } else {
              $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                <a href="/u/' + data.username + '" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="assets/images/1.jpg" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                    <button type="button" class="follow__btn" data-id="' + data.id + '">\
                                            <div class="btn_text">' + data.follow + '</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
            }
          });
          var btn_text = $('.btn_text');
          var loading = $('.loading');
          $('.follow__btn').on('click', function () {
            var id = $(this).data('id');
            var btn = $(this);
            $.ajax({
              url: ajax_url_follow,
              data: {
                action: "follow_following",
                id: id,
                _token: token
              },
              dataType: 'JSON',
              type: 'POST',
              context: this,
              success: function success(res) {
                if (res.status === 'success') {
                  btn.html(res.data);
                }
              }
            });
          });
          /**
          *  load more hide and show
          * */

          var count = [];
          $(".follow__content").each(function () {
            count.push($(this).data('id'));
          });
          var load = $('#load__more_main');

          if (count.length >= 10) {
            $('<button class="custom__load_more_btn  mb-4" id="load__more"></button>').html('Load more').appendTo(load);
          } else {
            load.empty();
          }
          /**
          *  load more 
          * */


          $('#load__more').on('click', function () {
            var data_id = [];
            $(".follow__content").each(function () {
              data_id.push($(this).data('id'));
            });
            var item = 10;
            $.ajax({
              url: ajax_url_follow,
              beforeSend: function beforeSend() {
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
              },
              data: {
                action: 'get_followers',
                id: logged_id,
                data_id: data_id,
                item: item,
                _token: token
              },
              dataType: 'JSON',
              type: 'POST',
              context: this,
              success: function success(res) {
                not_found.empty();

                if (res.status === 'success') {
                  if ($.isEmptyObject(res.datas)) {
                    $('<div class="text-center text-danger"></div>').html('No data found!').appendTo(not_found);
                  }

                  $.map(res.datas, function (data) {
                    if (data.avatar) {
                      $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                                <a href="/u/' + data.username + '" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/' + data.avatar + '" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                                    <button type="button" class="follow__btn" data-id="' + data.id + '">\
                                                            <div class="btn_text">' + data.follow + '</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                    } else {
                      $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                                <a href="/u/' + data.username + '" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="assets/images/1.jpg" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                                    <button type="button" class="follow__btn" data-id="' + data.id + '">\
                                                            <div class="btn_text">' + data.follow + '</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                    }
                  });
                }
              },
              complete: function complete() {
                loader.empty();
              }
            });
          });
        }
      },
      complete: function complete() {
        loader.empty();
      }
    });
  }

  function ajax_following(method) {
    return $.ajax({
      url: ajax_url_follow,
      beforeSend: function beforeSend() {
        $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
        contents.empty();
      },
      data: {
        action: method,
        id: logged_id,
        _token: token
      },
      dataType: 'JSON',
      type: 'POST',
      context: this,
      success: function success(res) {
        if (res.status === 'success') {
          if ($.isEmptyObject(res.datas)) {
            $('<div class="text-center text-danger w-100"></div>').html('You follow no one at the moment!').appendTo(contents);
          }

          $.map(res.datas, function (data) {
            if (data.avatar) {
              $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                <a href="/u/' + data.username + '" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="' + data.avatar + '" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                    <button type="button" class="following__btn" data-id="' + data.id + '">\
                                            <div class="btn_text">' + data.follow + '</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
            } else {
              $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                <a href="/u/' + data.username + '" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="assets/images/1.jpg" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                    <button type="button" class="following__btn" data-id="' + data.id + '">\
                                            <div class="btn_text">' + data.follow + '</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
            }
          });
          var btn_text = $('.btn_text');
          var loading = $('.loading');
          $('.contents').delegate('.following__btn', 'click', function () {
            var id = $(this).data('id');
            var btn = $(this);
            $.ajax({
              url: ajax_url_follow,
              data: {
                action: "unfollowing",
                id: id,
                _token: token
              },
              dataType: 'JSON',
              type: 'POST',
              context: this,
              success: function success(res) {
                if (res.status === 'success') {
                  btn.html(res.data);
                  btn.closest(".col-lg-3").remove();
                }
              }
            });
          });
          /**
          *  load more hide and show
          * */

          var count = [];
          $(".follow__content").each(function () {
            count.push($(this).data('id'));
          });
          var load = $('#load__more_main');

          if (count.length >= 10) {
            $('<button class="custom__load_more_btn  mb-4" id="load__more"></button>').html('Load more').appendTo(load);
          } else {
            load.empty();
          }
          /**
          *  load more 
          * */


          $('#load__more').on('click', function () {
            var data_id = [];
            $(".follow__content").each(function () {
              data_id.push($(this).data('id'));
            });
            var item = 10;
            $.ajax({
              url: ajax_url_follow,
              beforeSend: function beforeSend() {
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
              },
              data: {
                action: 'get_following',
                id: logged_id,
                data_id: data_id,
                item: item,
                _token: token
              },
              dataType: 'JSON',
              type: 'POST',
              context: this,
              success: function success(res) {
                not_found.empty();

                if (res.status === 'success') {
                  if ($.isEmptyObject(res.datas)) {
                    $('<div class="text-center text-danger"></div>').html('Thats it!').appendTo(not_found);
                  }

                  $.map(res.datas, function (data) {
                    if (data.avatar) {
                      $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                                <a href="/u/' + data.username + '" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/' + data.avatar + '" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                                    <button type="button" class="following__btn" data-id="' + data.id + '">\
                                                            <div class="btn_text">' + data.follow + '</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                    } else {
                      $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="' + data.id + '">\
                                                <a href="/u/' + data.username + '" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="assets/images/1.jpg" alt="' + data.username + '" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/' + data.username + '" ><p class="follo__user_name">' + data.username + '</p></a>\
                                                    <button type="button" class="following__btn" data-id="' + data.id + '">\
                                                            <div class="btn_text">' + data.follow + '</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                    }
                  });
                }
              },
              complete: function complete() {
                loader.empty();
              }
            });
          });
        }
      },
      complete: function complete() {
        loader.empty();
      }
    });
  }

  function setCookie(name, value, maxAgeSeconds) {
    var maxAgeSegment = "; max-age=" + maxAgeSeconds;
    document.cookie = encodeURI(name) + "=" + encodeURI(value) + maxAgeSegment;
  }

  $('#status__input').on('keypress', function (e) {
    if (e.which === 13) {
      var value = $(e.currentTarget).val();
      $.ajax({
        url: ajax_url_follow,
        data: {
          action: "updateStatus",
          id: user_id,
          status: value,
          _token: token
        },
        dataType: 'JSON',
        type: 'POST',
        context: this,
        success: function success(res) {
          if (res.status === 'success') {
            socket.emit('notifications', res.user.username);
            $('#status__input').val('');
            setCookie("update-status", "status", 5);
            window.location.href = '/u/' + res.user.username;
          }
        }
      });
    }
  });
});

/***/ }),

/***/ 3:
/*!**********************************************!*\
  !*** multi ./resources/js/custom/follows.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\mdala\OneDrive\Desktop\united states website\resources\js\custom\follows.js */"./resources/js/custom/follows.js");


/***/ })

/******/ });