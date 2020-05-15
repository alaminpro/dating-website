<style>
.ads {
    padding: 10px 15px;
    margin-bottom: 5px;
}
</style>
<div class="ads">
    {!! $ads->value !!}
</div>
<div class="footer">
    <div class="container">
        <div class="text-center">
            <ul class="list-unstyled menu-footer clearfix mb-1">
                <li><a href="/">Home</a></li>
                @foreach($pages as $page)
                <li><a href="{{route('page',$page->slug)}}">{{$page->title}}</a></li>
                @endforeach
                <li><a href="{{route('blogPost')}}">Blog</a></li>
                <li><a href="{!! route('landing') !!}">Search</a></li>
            </ul>
            <p class="mb-1">&copy; 2020 Singles Dating World</p>
        </div>
    </div>
</div>
<div class="modal" id="modalLogin" tabindex="-1" data-backdrop="static"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{!! route('login') !!}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" value="{!! request()->fullUrl() !!}" name="ref">
                    <div class="form-group">
                        <input class="form-control second bg-mute" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control second bg-mute" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-sm btn-primary">Login</button>
                    </div>
                </form>
                <p class="text-center">OR</p>
                <div class="d-flex justify-content-center">
                    <div class="social__login">
                        <a href="{!! route('loginfacebook') !!}" class="btn-facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="{!! route('logintwitter') !!}" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalPhoto" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
            </div>
        </div>
    </div>
</div>
<audio src="{!! url('assets/message.mp3') !!}" id="message_audio"></audio> 
<audio id="calling_audio" loop controls style="display:none">
  <source src="{!! url('assets/tone.mp3') !!}" type="audio/mpeg"> 
</audio> 
<div class="notifications"> </div>
