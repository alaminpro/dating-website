@if(count($datas) > 0)
        <li> 
                <ul class="notification__ul notification__todays">
                    @foreach($datas as $data)
                    <li  class="{{ $data->read === 0 ? 'notification__active' : '' }}">
                        <div class="d-flex align-items-start">
                            <a href="javascript:void(0)" class="notification__link" data-id="{{ $data->id }}">
                                <div class="photo__side">
                                    <img src="{!! asset($data->notify_user->avatar) !!}" class="rounded-circle">
                                </div>
                                <div class="content__side"> 
                                    @if($data->type == 'status')
                                        <div class="notify__username">{!! $data->notify_user->username !!} <span class="font-weight-normal">Updated status</span></div>
                                    @endif 
                                    @if($data->type == 'follow')
                                        <div class="notify__username">{!! $data->notify_user->username !!}</div>
                                    @endif
                                    <div class="notify__content">{!! $data->data !!}</div> 
                                    <div class="notify__time">{{ $data->created_at->diffForHumans() }}</div>  
                                </div>
                            </a>
                            @if($data->type == 'follow')
                                @if(auth()->check() && in_array($data->notify_user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{!! $data->notify_user->id !!}"><i class="fas fa-check pr-1"></i>&nbsp;Followed</button>
                                @else
                                    <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{!! $data->notify_user->id !!}">Follow</button>
                                @endif
                            @endif
                        </div>
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
 

