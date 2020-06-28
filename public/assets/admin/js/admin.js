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
      $imageCover
        .cropper("destroy")
        .attr("src", originalImageURL)
        .cropper(cropOptions);
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
      crop: function (e) {
        $(".avatar-upload #x").val(e.detail.x);
        $(".avatar-upload #y").val(e.detail.y);
        $(".avatar-upload #w").val(e.detail.width);
        $(".avatar-upload #h").val(e.detail.height);
      },
    };
    $imageCover
      .on({
        ready: function (e) {
          console.log(e.type);
        },
        cropstart: function (e) {
          console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
          console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
          console.log(e.type, e.detail.action);
        },
        crop: function (e) {
          console.log(e.type);
        },
        zoom: function (e) {
          console.log(e.type, e.detail.ratio);
        },
      })
      .cropper(cropOptions);

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
          $imageCover
            .cropper("destroy")
            .attr("src", uploadedImageURL)
            .cropper(cropOptions);
          $(".user .clear-avatar").show();
        } else {
          window.alert("Please choose an image file.");
        }
      }
    });
  }
  $("#summernote").summernote({
    height: 400,
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
      success: function (res) {
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
      },
    });
    return false;
  });
  $(document).on("submit", ".addInterest", function (event) {
    event.preventDefault();
    var text = $(this).find('#text').val();
    var icon = $(this).find('#icon').val();
    var data = {
        text,
        icon
    } 
    $.ajax({
      url: ajax_url,
      data: { action: "add_interest", data, _token: token },
      dataType: "JSON",
      type: "POST",
      success: function (res) {
        if (res.status === "error") {
            alert("Something went wrong!");
          } else {
            window.location.reload();
          }
          return false;
      },
    });
  });
 
  $(".delete-interest").click(function () {
    var id = $(this).attr("data-id");
    var conf = confirm("Are you sure?");
    if (conf) {
      $.ajax({
        url: ajax_url,
        data: { action: "delete_interest", id: id ,_token: token },
        type: "POST",
        dataType: "JSON",
        success: function (res) {
          if (res.status === "error") {
            alert("Something went wrong!");
          } else {
            $("#interest-" + id).remove();
          }
        },
      });
    }
  });


  
    var premium = $('#premimum__feature'); 
    var free = $('#free___feature');  
    var data_default = $('.tab__main').attr('data-tab-default');
    if(data_default){
      if(!location.search){
          if(data_default == 1){
            queryParams('?tab=premium');
          }else{
            queryParams('?tab=free');
          } 
      }  
    }
    var tabs = $('.tab__item');
    $('ul.tab__items li.tab__item').removeClass('active');
    $('.tab__content').removeClass('current'); 
    Array.from(tabs).forEach(function(tab){ 
        var current_tab = $(tab).data('tab'); 
        if(getQueryParams() == current_tab){ 
            $(tab).addClass('active');
		    $("#"+current_tab).addClass('current');
        }
    }) 
    $('ul.tab__items li').click(function(){
        var tab_id = $(this).attr('data-tab'); 
		$('ul.tab__items li.tab__item').removeClass('active');
		$('.tab__content').removeClass('current');
        queryParams('?tab='+tab_id) 
		$(this).addClass('active');
		$("#"+tab_id).addClass('current');
    })

    function queryParams(query){
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + query;
       return window.history.pushState({ path: newurl }, '', newurl);
    }

    function getQueryParams(){
        var queries = {};
        $.each(document.location.search.substr(1).split('&'),function(c,q){
            var i = q.split('=');
            queries[i[0].toString()] = i[1].toString();
        });
        return queries.tab
    }
  
  
});
