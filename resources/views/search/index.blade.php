 @foreach($users as $user)
        <div class="col-lg-4 col-sm-6">
            <div class="search__users"> 
                <div class="img-div m-0">
                    <a href="{!! route('profile',['username'=> $user->username]) !!}?type=about" class="profile__photo">
                          @if($user->isOnline())
                           <span class="online-class"></span>
                          @endif
                          <img width="200" src="{!! asset($user->avatar) !!}" class="border rounded-circle img-responsive">
                      </a>
                </div>
                <div class="user__info m-0 d-flex align-items-center flex-column">
                      <p class="font-weight-bold m-0 profile__username">
                        <a href="{!! route('profile',['username'=> $user->username]) !!}?type=about" class="text-dark username_search">{!! $user->username !!} </a>
                      </p>
                      <span class="seeking">
                          {!!
                              $user->gender == 1 ? 'Male' : 'Female' !!} Seeking {!!
                              $user->preference == 1 ? ' Male' : ($user->preference == 2 ? ' Female': ' Male
                              and Female') !!}
                      </span>
                      @if(count($user->interests) > 0)
                      <div class="w-100 d-flex justify-content-center">
                        <p class="m-0 text-center"><strong>Interest: </strong>
                            @foreach($user->interests as $interest)
                                {{ $interest->text . ',' }}
                            @endforeach
                        </p>
                      </div>
                      @endif
                      @if(!empty($user->user_status))
                          <p class="m-0 mb-3"><strong>Status: </strong> {{$user->user_status}}</p>
                      @endif
                  </div>
                  <div class="ml-3">
                      @if(auth()->check() && auth()->user()->id === $user->id)
                      <a href="{{ route('setting') }}"  class="follow__btn_user btn-follow font-weight-bold m-0">Edit Profile</a>
                      @else
                          @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                              <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check pr-1"></i>&nbsp;Followed</button>
                          @else
                              <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;">Follow</button>
                          @endif
                      @endif
                  </div>
              </div>
        </div>
    @endforeach
