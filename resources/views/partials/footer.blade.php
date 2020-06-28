<div class="ads">
    {!! $ads->value !!}
</div>
<footer class="footer">
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
</footer>
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

@auth

<div class="modal" id="modal__feature_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="search__feature_users">
                    <h2>Search users:</h2>
                    <input type="text" class="feature__search_input" placeholder="Search by username, interest">
                    <div class="clear__field  mr-1"><i class="far fa-times-circle"></i> Clear filter</div>
                    @php
                        $feature = \App\Feature::where('logged_id', auth()->user()->id)->where('finished_date', '>', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))->get();
                    @endphp
                    <div class="border-left ml-1 pl-2 font-weight-bold">Selected: <span class="selected__count">{{ count($feature) }}</span></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body feature__modal_scrool">
                <div class="feature__search_loader"></div>
                <div class="feature__search_content"></div>
                <div class="feature__content"></div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="users__feature_cancel" data-dismiss="modal" aria-label="Close">
                    Cancel
                </button>
                <button class="users__feature_btn" type="button">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal__feature_date_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="search__feature_users">
                    <h2>For how many days</h2> 
                </div>
                <button type="button" class="close date__time_modal_cencel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <input type="text" id="feature__date_time"/> 
            </div>
            <div class="modal-footer"> 
                <button type="button" class="users__feature_cancel date__time_modal_cencel" >
                    Cancel
                </button>
                <button class="users__feature_date_time" type="button">ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal__free_premium" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ setting('feature_upgrade') == 1   ? 'modal-lg' : 'modal-sm' }}" role="document">
        <div class="modal-content"> 
            <div class="modal__free_premium_main"> 
                <button type="button" class="close modal__free_premium_header" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal__free_premium_body">
                  
                </div>
            </div>
        </div>
    </div>
</div>


@endauth

 

 