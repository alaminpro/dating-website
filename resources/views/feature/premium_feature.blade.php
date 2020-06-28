<p class="premium__title">You have <strong>{{ $coins }}</strong> coins</p>
<ul class="premium__ul">
    @foreach($admin_features as $data)
    <li class="premium__area " data-days="{{ $data->days }}" data-coin="{{ $data->value }}"> 
            <div class="feature__icon">
                <i class="far fa-check-circle"></i>
             </div>
            <p class="premium__text">{{ $data->text }}</p>
            <h3 class="premium__coin">{{ $data->coin }}</h3> 
    </li>
    @endforeach
</ul>
<button type="button" class="free__premium_btn" >Get Featured</button>