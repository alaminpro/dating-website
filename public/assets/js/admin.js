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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/admin.js":
/*!*************************************!*\
  !*** ./resources/js/admin/admin.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  var token = $("meta[name=csrf_token]").attr("content");
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar, #content").toggleClass("active");
    $(".collapse.in").toggleClass("in");
    $("a[aria-expanded=true]").attr("aria-expanded", "false");
  });

  if ($("#avatarPreview").length) {
    var height = $("#avatarPreview").height();
    var $inputImage = $("#uploadImage");
    var $imageCover = $("#uploadPreview");
    var originalImageURL = $imageCover.attr("src");
    $(".change-avatar").click(function () {
      $inputImage.click();
    });
    $(".user .clear-avatar").click(function () {
      $inputImage.val("");
      $imageCover.cropper("destroy").attr("src", originalImageURL).cropper(cropOptions);
      $(this).hide();
    });
    var cropOptions = {
      aspectRatio: 1 / 1,
      cropBoxResizable: false,
      minCropBoxWidth: height,
      minContainerWidth: height,
      minContainerHeight: height,
      viewMode: 3,
      minCropBoxHeight: height,
      crop: function crop(e) {
        $(".avatar-upload #x").val(e.detail.x);
        $(".avatar-upload #y").val(e.detail.y);
        $(".avatar-upload #w").val(e.detail.width);
        $(".avatar-upload #h").val(e.detail.height);
      }
    };
    $imageCover.on({
      ready: function ready(e) {
        console.log(e.type);
      },
      cropstart: function cropstart(e) {
        console.log(e.type, e.detail.action);
      },
      cropmove: function cropmove(e) {
        console.log(e.type, e.detail.action);
      },
      cropend: function cropend(e) {
        console.log(e.type, e.detail.action);
      },
      crop: function crop(e) {
        console.log(e.type);
      },
      zoom: function zoom(e) {
        console.log(e.type, e.detail.ratio);
      }
    }).cropper(cropOptions);
    $inputImage.change(function () {
      var files = this.files;
      var file;

      if (!$imageCover.data("cropper")) {
        return;
      }

      if (files && files.length) {
        file = files[0];

        if (/^image\/\w+$/.test(file.type)) {
          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }

          uploadedImageURL = URL.createObjectURL(file);
          $imageCover.cropper("destroy").attr("src", uploadedImageURL).cropper(cropOptions);
          $(".user .clear-avatar").show();
        } else {
          window.alert("Please choose an image file.");
        }
      }
    });
  }

  $("#summernote").summernote({
    height: 400
  });
  $(".editInterest").on("submit", function (e) {
    var data = $(this).serialize();
    var id = $(this).find("input[name=id]").val();
    var text = $(this).find("input[name=text]").val();
    var icon = $(this).find("input[name=icon]").val();
    $.ajax({
      url: ajax_url,
      data: data,
      type: "POST",
      dataType: "JSON",
      success: function success(res) {
        if (res.status === "error") {
          alert("Something went wrong!");
        } else {
          $("#modal-interest-" + id).modal("hide");
          var tr = $("#interest-" + id);
          tr.find(".icon i").removeClass();
          tr.find(".icon i").addClass(icon);
          tr.find(".name").html(text);
        }

        return false;
      }
    });
    return false;
  });
  $(document).on("submit", ".addInterest", function (event) {
    event.preventDefault();
    var text = $(this).find('#text').val();
    var icon = $(this).find('#icon').val();
    var data = {
      text: text,
      icon: icon
    };
    $.ajax({
      url: ajax_url,
      data: {
        action: "add_interest",
        data: data,
        _token: token
      },
      dataType: "JSON",
      type: "POST",
      success: function success(res) {
        if (res.status === "error") {
          alert("Something went wrong!");
        } else {
          window.location.reload();
        }

        return false;
      }
    });
  });
  $(".delete-interest").click(function () {
    var id = $(this).attr("data-id");
    var conf = confirm("Are you sure?");

    if (conf) {
      $.ajax({
        url: ajax_url,
        data: {
          action: "delete_interest",
          id: id,
          _token: token
        },
        type: "POST",
        dataType: "JSON",
        success: function success(res) {
          if (res.status === "error") {
            alert("Something went wrong!");
          } else {
            $("#interest-" + id).remove();
          }
        }
      });
    }
  });
});

/***/ }),

/***/ 1:
/*!*******************************************!*\
  !*** multi ./resources/js/admin/admin.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\mdala\OneDrive\Desktop\united states website\resources\js\admin\admin.js */"./resources/js/admin/admin.js");


/***/ })

/******/ });