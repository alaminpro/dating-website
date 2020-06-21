<li  class="{{ $follow->read === 0 ? 'notification__active' : '' }}">
    <div class="d-flex align-items-start">
        <a href="javascript:void(0)" class="notification__link" data-id="{{ $follow->id }}">
            <div class="photo__side">
                <img src="{{  asset($follow->avatar)  }}" class="rounded-circle">
            </div>
            <div class="content__side"> 
                <div class="notify__username">{{  $follow->username  }}</div> 
                <div class="notify__content">{{  $follow->data  }}</div> 
                <div class="notify__time">{{ $follow->created_at->diffForHumans() }}</div>  
            </div>
        </a> 
        @if(auth()->check() && in_array($follow->notify_user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
            <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{!! $data->notify_user->id !!}"><i class="fas fa-check pr-1"></i>&nbsp;Followed</button>
        @else
            <button class="follow__btn_user btn-follow font-weight-bold d-flex align-items-center follow__notification_btn" data-id="{!! $data->notify_user->id !!}">Follow</button>
        @endif 
    </div> 
</li> 