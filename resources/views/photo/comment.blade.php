<li>
    <div class="media">
      <?php
      $avatar = avatar($comment->user->avatar, $comment->user->gender);
      // dd($avatar);
      $url = url()->full();
      $url2 = substr($url,7,9);
      if ($url2 == 'localhost') {
        $avatar = substr($avatar,34);
        $avatar ='http://localhost/dating/'.$avatar;
      }
      ?>
        <img src="{!! $avatar !!}">
        <div class="media-body position-relative">
            <h3 class="font-weight-bold"><a href="{!! route('profile',['username'=>$comment->user->username]) !!}">{!! fullname($comment->user->firstname, $comment->user->lastname, $comment->user->username) !!}</a></h3>
            <div class="d-flex justify-content-between align-items-center py-2">
              <div class="edit-option">
              <p class="p-0 m-0 comment-hide">{!! $comment->comment !!}</p>
                <div class="edit-comment-option">
                  <textarea name="comment" cols=80 wrap="virtual" rows="2" class="edit-comment edit-comment-text"  data-comment-id="{{$comment->id}}">{{ trim($comment->comment) }}</textarea>
                </div>
              </div>
              @if(auth()->check() && (auth()->user()->id == $comment->user_id || auth()->user()->is_admin == 1))

              <div class="edit-delete-comment">
                <i class="fas fa-ellipsis-v"></i>
                <div class="show-edit-delete-btn">
                  <span class="d-block edit-comment" data-comment-id="{{ $comment->id}}">edit</span>
                  <span class="d-block delete-comment" data-comment-id="{{ $comment->id}}">delete</span>
                </div>
              </div>
              @endif
          </div>
        </div>
    </div>
</li>
