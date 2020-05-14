@if($user->photos()->count())
<!-- page-title pl-3 -->
    <div class="row load__more_append users-photo"><!-- pl-2 -->
        @if((auth()->check() && auth()->user()->id == $user->id)) 
        <div class="col-md-3 ipad-photo-img content__each">
            <div class="photo-item custom_photo_upload  add-photo" >
                <img src="{{ asset('uploads/static/plus--v2.png') }}" alt="Upload photo icon" width="120">
            </div>
        </div>
        @endif
     
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
                <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo" style="background-repeat: no-repeat;
                        background-size: cover; background-position: center; background-image: url('{!! url($cover) !!}');"> 
                </div>
            </div>
        @endforeach
        <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload photo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="upload-progress progress">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <form id="formUpload" action="{!! route('crop_upload_photo') !!}"
                                            enctype="multipart/form-data" method="post">
                                            {!! csrf_field() !!}
                                            <input id="upload-photo" name="file" type="file" accept="image/*"
                                                class="d-none">
                                            <div class="photo-cropper">
                                                <div class="cropper-wrapper">
                                                    <div id="canvas"></div>
                                                </div>
                                                <div id="result" class=" mt-2 mb-2 image-cropper-result"></div>
                                                <input type="button" id="btnCrop" class="crop-button" value="Crop" />
                                                <input type="button" id="btnRestore" class="restore-button"
                                                    value="Restore" />
                                                <input type="hidden" name="image" id="upload-image" required>
                                                <div class="alert-image d-block"></div>
                                            </div>
                                            <div class="btn__description">
                                                <div class="form-group">
                                                    <textarea class="form-control custom-text-area"
                                                        placeholder="Writing something for photo" name="description"
                                                        rows="2"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button id="upload-btn" class="btn btn-sm btn-primary btn-block custom_btn"
                                                        type="submit">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>
    <div class="text-center mt-3 pb-3 d-flex justify-content-center">
        <button data-id="{!! $user->id !!}" class="load_more_photo custom__load_more_btn" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-spinner fa-spin"></i> Load more</button>
    </div>
   
     
@endif