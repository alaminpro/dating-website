@if(count($merge_data['today']) > 0)
        <li>
            <div class="notification__nav_title">NEW</div> 
                <ul class="notification__ul notification__todays">
                    @foreach($merge_data['today'] as $data) 
                    <li  class="{{ $data->read === 0 ? 'notification__active' : '' }}"> 
                     
                        <div class="d-flex align-items-start">
                            @if($data->type == 'likes' || $data->type == 'comment')
                            <div class="notification__likes view-photo" data-id="{{ $data->data }}" data-url="{{ asset($data->redirect_url) }}">
                                @else
                                <a href="javascript:void(0)" class="notification__link" data-id="{{ $data->id }}">
                                @endif
                                <div class="photo__side">
                                    <img src="{{  avatar($data->notify_user->avatar,$data->notify_user->gender)   }}" class="rounded-circle">
                                </div>
                                <div class="content__side"> 
                                    @if($data->type == 'status')
                                        <div class="notify__username">{{  $data->notify_user->username  }} <span class="font-weight-normal">Updated status</span></div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">{{ $data->created_at->diffForHumans() }}</div>  
                                    @endif 
                                    @if($data->type == 'follow')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">{{ $data->created_at->diffForHumans() }}</div>  
                                    @endif
                                    @if($data->type == 'likes')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">Likes your photo</div> 
                                        <div class="notify__time">
                                            <span class="notify__likes"><i class="fas fa-thumbs-up"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                    @if($data->type == 'comment')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">Comment your photo</div> 
                                        <div class="notify__time">
                                            <span class="notify__comment"><i class="fas fa-comment-alt"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                    @if ($data->type == 'page_like')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">
                                            <span class="notify__page_like"><i class="fas fa-heart"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                   
                               
                                </div>
                                @if($data->type == 'likes' || $data->type == 'comment')
                            </div>
                            @else
                        </a>
                                @endif
                            @if($data->type == 'page_like')
                                <button  class="btn-love active mr-2 mt-2"><i class="fas fa-heart"></i></button>
                            @endif
                            @if($data->type == 'likes' || $data->type == 'comment' )
                                    <img class="mr-3" src="{{ asset($data->redirect_url) }}" width='50' alt="photo">
                            @endif
                            @if($data->type == 'follow')
                                @if(auth()->check() && in_array($data->notify_user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{{  $data->notify_user->id  }}"><i class="fas fa-check"></i>&nbsp;Followed</button>
                                @else
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{{  $data->notify_user->id  }}">Follow</button>
                                @endif
                            @endif
                        </>
                        <div class="notify__action">
                        <div class="notify__option">
                            <i class="fas fa-ellipsis-v"></i>
                            <div class="notify__popup">
                                <button type="button" class="notify__icon" data-id="{{ $data->id }}">
                                    delete
                                </button>
                            </div>
                        </div>
                        <div class="mark__as_option" data-id="{{ $data->id }}"> 
                            @if($data->read == 0) 
                                <span  tooltip="Mark as read" flow="left" data-read="1"> <i class="far fa-envelope"></i> </span> 
                            @else 
                                <span tooltip="Mark as unread" flow="left" data-read="0">  <i class="far fa-envelope-open"></i></span> 
                            @endif
                        </div>
                        </div>
                    </li> 
                    @endforeach
                </ul> 
        </li>  
        @endif
        @if(count($merge_data['earlier']) > 0)
        <li>
            <div class="notification__nav_title">EARLIER</div> 
                <ul class="notification__ul">
                    @foreach($merge_data['earlier'] as $data)
                    <li  class="{{ $data->read === 0 ? 'notification__active' : '' }}"> 
                     
                        <div class="d-flex align-items-start">
                            @if($data->type == 'likes' || $data->type == 'comment')
                            <div class="notification__likes view-photo" data-id="{{ $data->data }}" data-url="{{ asset($data->redirect_url) }}">
                            @else
                            <a href="javascript:void(0)" class="notification__link" data-id="{{ $data->id }}">
                                @endif
                                <div class="photo__side">
                                    <img src="{{  avatar($data->notify_user->avatar,$data->notify_user->gender)   }}" class="rounded-circle">
                                </div>
                                <div class="content__side"> 
                                    @if($data->type == 'status')
                                        <div class="notify__username">{{  $data->notify_user->username  }} <span class="font-weight-normal">Updated status</span></div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">{{ $data->created_at->diffForHumans() }}</div>  
                                    @endif 
                                    @if($data->type == 'follow')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">{{ $data->created_at->diffForHumans() }}</div>  
                                    @endif
                                    @if($data->type == 'likes')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">Likes your photo</div> 
                                        <div class="notify__time">
                                            <span class="notify__likes"><i class="fas fa-thumbs-up"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                    @if($data->type == 'comment')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">Comment your photo</div> 
                                        <div class="notify__time">
                                            <span class="notify__likes"><i class="fas fa-comment-alt"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                    @if ($data->type == 'page_like')
                                        <div class="notify__username">{{  $data->notify_user->username  }}</div>
                                        <div class="notify__content">{{  $data->data  }}</div> 
                                        <div class="notify__time">
                                            <span class="notify__page_like"><i class="fas fa-heart"></i></span>
                                            <span>{{ $data->created_at->diffForHumans() }}</span>
                                        </div>  
                                    @endif
                                   
                               
                                </div>
                                @if($data->type == 'likes' || $data->type == 'comment')
                            </div>
                                @else
                            </a>
                                @endif
                            @if($data->type == 'page_like')
                                <button  class="btn-love active mr-2 mt-2"><i class="fas fa-heart"></i></button>
                            @endif
                            @if($data->type == 'likes' || $data->type == 'comment' )
                            <img class="mr-3" src="{{ asset($data->redirect_url) }}" width='50' alt="photo">
                    @endif
                            @if($data->type == 'follow')
                                @if(auth()->check() && in_array($data->notify_user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{{  $data->notify_user->id  }}"><i class="fas fa-check"></i>&nbsp;Followed</button>
                                @else
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{{  $data->notify_user->id  }}">Follow</button>
                                @endif
                            @endif
                        </>
                        <div class="notify__action">
                        <div class="notify__option">
                            <i class="fas fa-ellipsis-v"></i>
                            <div class="notify__popup">
                                <button type="button" class="notify__icon" data-id="{{ $data->id }}">
                                    delete
                                </button>
                            </div>
                        </div>
                        <div class="mark__as_option" data-id="{{ $data->id }}"> 
                            @if($data->read == 0) 
                                <span  tooltip="Mark as read" flow="left" data-read="1"> <i class="far fa-envelope"></i> </span> 
                            @else 
                                <span tooltip="Mark as unread" flow="left" data-read="0">  <i class="far fa-envelope-open"></i></span> 
                            @endif
                        </div>
                        </div>
                    </li> 
                    @endforeach
                </ul> 
        </li>  
        @endif

