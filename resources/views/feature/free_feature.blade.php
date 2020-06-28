<h2 class="user__title">Hi, {{ $user->username }}!</h2>
<div class="free__photo_user">
    <img width="120" class="rounded-circle" src="{{  avatar($user->avatar,$user->gender)   }}" alt="user photo">
    <div class="free__badge">
        <i class="fab fa-bandcamp"></i>
    </div>
</div> 
<p class="free__premium_text">{{ $admin_feature->text }}</p>
<button type="button" class="free__premium_btn" data-days="{{ $admin_feature->days }}">Get Featured</button>