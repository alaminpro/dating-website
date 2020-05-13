@if($user->photos()->count())
<!-- page-title pl-3 -->
    <div class="row load__more_append"><!-- pl-2 -->
        @foreach($user->photos()->orderBy('created_at','DESC')->get()->take(15) as $photo)

        <?php
        $url = url()->full();
        $url2 = substr($url,7,9);
        if ($url2 == 'localhost') {
          $cover = 'http://localhost/dating/'.$photo->thumb;
        }else {
          $cover = $photo->thumb;
        }
         ?>
            <div class="col-md-3 ipad-photo-img content__each" data-id="{!! $photo->id !!}">
                <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border shadow style" style="background-repeat: no-repeat;
                        background-size: cover; background-position: center; background-image: url('{!! url($cover) !!}');">

                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-3 pb-3 d-flex justify-content-center">
        <button data-id="{!! $user->id !!}" class="load_more_photo custom__load_more_btn" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-spinner fa-spin"></i> Load more</button>
    </div>
   
     
@endif