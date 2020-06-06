$(document).ready(function(){
    var token = $('meta[name=csrf_token]').attr('content');    
    var params={};  
    var user_id;  

   function query_string(){
      window.location.search
        .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str,key,value) {
          params[key] = value;
        }
      ); 
   }
   query_string();
    var videoBody = $('.video-call-body');
    if(!params.caller_id){
      $('<div class="py-5 d-flex flex-column justify-content-center align-items-center"></div>')
                  .html('<h2 class="text-center pt-3">Select a Conversation</h2>\
                    <p class="text-center pb-3">Try selecting a conversation or searching for someone specific.</p>\
                    ')
                  .appendTo(videoBody)
    }
     /**
      * every 5 second after get new user
      * return @void
      */
      setInterval(ajaxCall, 10000); 
      var userDataId = $('#user-data');
      function ajaxCall() { 
      
          $.ajax({
                  url: ajax_url,
                  data: {action: 'get_user_video_call', id: '' , _token: token},
                  dataType: 'JSON',
                  type: 'POST',
                  async: false,
                  global: false,
                  success: function(res){
                    userDataId.empty()
                    if(res.status === 'success'){ 
                      if(user_id){
                        var id = res.data.filter(function(data){
                            return data.id === user_id 
                          }).map(function(e){
                            return e.id
                          }) 
                          if($.isEmptyObject(id)){ 
                              window.location = window.location.origin+window.location.pathname
                          }
                      } 
                        $.map( res.data, function(user) { 
                        $('<li id="video-'+user.id+'" data-id="'+user.id+'" class="video__list ' + (params.caller_id == user.id ? 'isActive' : '') + '"></li>').html('<div>\
                                      <img width="50" src="'+user.avatar+'" class="mr-1 border rounded-circle" > \
                                      <span>'+user.username+'</span> \
                                    </div><div class="d-flex align-items-center">' + (user.online ? '<div class="badge__video_online">Live</div> ' : '<div class="badge__video_offline">Away</div>') + '</div>').appendTo(userDataId);
                    }) 
                    }
                  }
              }) 
      }
      ajaxCall() 

    /**
      * Search User Functionality
      * return @void
      */

     var searchUser = $('#search-user');
     var searchData = $('#search-data');
     var userData = $('#user-data');
     var loader = $('.loading');
     searchUser.keyup(function () {
        loader.empty() 
        searchData.empty() 
        var value = $(this).val();
        if(value != ''){ 
          searchData.show();
          userData.hide() 
          $.ajax({
                  url: ajax_url,
                  beforeSend: function(){ 
                    $('<div class="lds-ellipsis"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
                    },
                  data: {action: 'get_user_by_search', username: value , _token: token},
                  dataType: 'JSON',
                  type: 'POST', 
                  global: false,  
                  success: function(res){
                    if(res.status === 'success'){
                      searchData.empty() 
                      var data = res.data
                      if($.isEmptyObject(data)){
                        $('<li class="text-center py-3"></li>').html('No users found!').appendTo(searchData);
                      } 
                      $.map( res.data, function(user) {  
                          $('<li id="video-'+user.id+'" data-id="'+user.id+'" class="video__list"></li>').html('<div>\
                              <img width="30" src="'+user.avatar+'" class="mr-1 border rounded-circle" > \
                              <span>'+user.username+'</span> \
                            </div><div  class="d-flex align-items-center">' + (user.online ? '<div class="badge__video_online">Live</div> ' : '<div class="badge__video_offline">Away</div>') + '</div>').appendTo(searchData);
                      }) 
                    } 
                  },
                  complete: function(){
                    loader.empty() 
                    
                  }
              }) 

        }else{
          searchData.hide();
          userData.show()
          
        }
     });

    /**
      * click show right side data
      * return @void
      */ 
    function get_video_body(el = null, id=null){
      var dataid;
        if(el != null){
          $('.video__list').removeClass('isActive');
          el.addClass('isActive');
        }
        if(el != null){
          dataid = id;
        }else{
          dataid = params.caller_id;
        } 
        $.ajax({
            url:ajax_url,
            data: {action: 'load_user_by_id', id: dataid, _token: token},
            dataType: 'JSON',
            type: 'POST', 
            async: false,
                  global: false,
            success: function (res) {
              videoBody.empty();
                var data = res.data;
                user_id =  data.id;
                if(res.status === 'success'){  
                  $('<div class="py-4 d-flex flex-column justify-content-center align-items-center"></div>')
                  .html('<h2 class="video__username">'+data.username+'</h2>\
                    <div class="image_body" style="background-image: url('+data.avatar+')"></div>\
                    <button type="button" data-id="'+data.id+'" class="start__call_btn">Start Call</button>\
                    ')
                  .appendTo(videoBody)
                }
            }
        }) 
     }
  $(document).on('click', '.video__list', function (event) {
      params = {}  
      var el = $(event.currentTarget);
      var id = el.data('id'); 
      if ('URLSearchParams' in window) {
          var searchParams = new URLSearchParams(window.location.search)
          searchParams.set("foo", "bar"); 
          var newRelativePathQuery = window.location.pathname + '?caller_id=' + id.toString();
          history.pushState(null, '', newRelativePathQuery);
          query_string()
      }
      get_video_body(el, id);
  });
  if(params.caller_id){
    get_video_body(); 
  } 

  $(document).on('click', '.start__call_btn', function (event) {
      var el = $(event.currentTarget);
      var id = el.attr('data-id');
      $.ajax({
          url:ajax_url,
          data: {action: 'startcall', id: id, _token: token},
          dataType: 'JSON',
          type: 'POST',
          success: function (res) { 
              if(res.status === 'success'){ 
                window.location.href = res.url
              }
          }
      })
  });

   }) //end document