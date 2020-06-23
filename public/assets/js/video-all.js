$(document).ready(function(){var a,e=$("meta[name=csrf_token]").attr("content"),i={};function t(){window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(a,e,t){i[e]=t})}t();var n=$(".video-call-body");i.caller_id||$('<div class="py-5 d-flex flex-column justify-content-center align-items-center"></div>').html('<h2 class="text-center pt-3">Select a Conversation</h2>                    <p class="text-center pb-3">Try selecting a conversation or searching for someone specific.</p>                    ').appendTo(n),setInterval(d,1e4);var s=$("#user-data");function d(){$.ajax({url:ajax_url,data:{action:"get_user_video_call",id:"",_token:e},dataType:"JSON",type:"POST",async:!1,global:!1,success:function(e){if(s.empty(),"success"===e.status){if(a){var t=e.data.filter(function(e){return e.id===a}).map(function(a){return a.id});$.isEmptyObject(t)&&(window.location=window.location.origin+window.location.pathname)}$.map(e.data,function(a){$('<li id="video-'+a.id+'" data-id="'+a.id+'" class="video__list '+(i.caller_id==a.id?"isActive":"")+'"></li>').html('<div>                                      <img width="50" src="'+a.avatar+'" class="mr-1 border rounded-circle" >                                       <span>'+a.username+'</span>                                     </div><div class="d-flex align-items-center">'+(a.online?'<div class="badge__video_online">Live</div> ':'<div class="badge__video_offline">Away</div>')+"</div>").appendTo(s)})}}})}d();var c=$("#search-user"),l=$("#search-data"),o=$("#user-data"),r=$(".loading");function u(t=null,s=null){var d;null!=t&&($(".video__list").removeClass("isActive"),t.addClass("isActive")),d=null!=t?s:i.caller_id,$.ajax({url:ajax_url,data:{action:"load_user_by_id",id:d,_token:e},dataType:"JSON",type:"POST",async:!1,global:!1,success:function(e){n.empty();var i=e.data;a=i.id,"success"===e.status&&$('<div class="py-4 d-flex flex-column justify-content-center align-items-center"></div>').html('<h2 class="video__username">'+i.username+'</h2>                    <div class="image_body" style="background-image: url('+i.avatar+')"></div>                    <button type="button" data-id="'+i.id+'" class="start__call_btn">Start Call</button>                    ').appendTo(n)}})}c.keyup(function(){r.empty(),l.empty();var a=$(this).val();""!=a?(l.show(),o.hide(),$.ajax({url:ajax_url,beforeSend:function(){$('<div class="lds-ellipsis"></div>').html("<div></div><div></div><div></div><div></div>").appendTo(r)},data:{action:"get_user_by_search",username:a,_token:e},dataType:"JSON",type:"POST",global:!1,success:function(a){if("success"===a.status){l.empty();var e=a.data;$.isEmptyObject(e)&&$('<li class="text-center py-3"></li>').html("No users found!").appendTo(l),$.map(a.data,function(a){$('<li id="video-'+a.id+'" data-id="'+a.id+'" class="video__list"></li>').html('<div>                              <img width="30" src="'+a.avatar+'" class="mr-1 border rounded-circle" >                               <span>'+a.username+'</span>                             </div><div  class="d-flex align-items-center">'+(a.online?'<div class="badge__video_online">Live</div> ':'<div class="badge__video_offline">Away</div>')+"</div>").appendTo(l)})}},complete:function(){r.empty()}})):(l.hide(),o.show())}),$(document).on("click",".video__list",function(a){i={};var e=$(a.currentTarget),n=e.data("id");if("URLSearchParams"in window){new URLSearchParams(window.location.search).set("foo","bar");var s=window.location.pathname+"?caller_id="+n.toString();history.pushState(null,"",s),t()}u(e,n)}),i.caller_id&&u(),$(document).on("click",".start__call_btn",function(a){var i=$(a.currentTarget).attr("data-id");$.ajax({url:ajax_url,data:{action:"startcall",id:i,_token:e},dataType:"JSON",type:"POST",success:function(a){"success"===a.status&&(window.location.href=a.url)}})})});
