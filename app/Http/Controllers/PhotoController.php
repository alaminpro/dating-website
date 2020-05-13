<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function upload()
    {
        if ($this->request->hasFile('file') && auth()->check()) {
            $file = $this->request->file('file');
            if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $fulldestPath = create_folder(auth()->user()->id);
                $random = Str::random('20') . time();
                $name = $random . '.' . $file->getClientOriginalExtension();
                $thumb = $random . '_thumb.' . $file->getClientOriginalExtension();
                $file->move(realpath($fulldestPath), $name);
                $image = Image::make(realpath($fulldestPath) . '/' . $name);
                $height = $image->getHeight();
                $width = $image->getWidth();
                $image->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save(realpath($fulldestPath) . '/' . $thumb);
                $photo = new Photo();
                $photo->file = 'uploads/photos/' . auth()->user()->id . '/' . $name;
                $photo->thumb = 'uploads/photos/' . auth()->user()->id . '/' . $thumb;
                $photo->user_id = auth()->user()->id;
                $photo->height = $height;
                $photo->width = $width;
                $photo->description = $this->request->description;
                $photo->save();
                return response()->json(['status' => 'success', 'id' => $photo->id, 'file' => url('uploads/photos/' . auth()->user()->id . '/' . $name), 'thumb' => url('uploads/photos/' . auth()->user()->id . '/' . $thumb)]);
            }
        }
        return response()->json(['status' => 'error']);
    }
    public function crop_upload_photo()
    { 
        if ($this->request->hasFile('file') && auth()->check()) {
            $file_image = $this->request->file('file');
            if (in_array($file_image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $file = $this->request->image;
                $explode_file = explode(',', $file);
                $decode = base64_decode($explode_file[1]);
                $extension = '';
                if (Str::contains($explode_file[0], 'jpeg')) {
                    $extension = 'jpg';
                } elseif (Str::contains($explode_file[0], 'gif')) {
                    $extension = 'gif';
                } else {
                    $extension = 'png';
                }
                $fulldestPath = create_folder(auth()->user()->id);
                $random = Str::random('20') . time();
                $name = $random . '.' . $extension;
                $thumb = $random . '_thumb.'. $extension;
                
                $imagemain = Image::make($decode); 
                $imagemain->resize(1000, 850, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imagemain->save(realpath($fulldestPath) . '/' . $name);

                $image = Image::make($decode);
                $height = $image->getHeight();
                $width = $image->getWidth();
                $image->resize(350, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save(realpath($fulldestPath) . '/' . $thumb);

                $photo = new Photo();
                $photo->file = 'uploads/photos/' . auth()->user()->id . '/' . $name;
                $photo->thumb = 'uploads/photos/' . auth()->user()->id . '/' . $thumb;
                $photo->user_id = auth()->user()->id;
                $photo->height = $height;
                $photo->width = $width;
                $photo->description = $this->request->description;
                $photo->save();
                return response()->json(['status' => 'success', 'id' => $photo->id, 'file' => url('uploads/photos/' . auth()->user()->id . '/' . $name), 'thumb' => url('uploads/photos/' . auth()->user()->id . '/' . $thumb)]);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function photos($username)
    {
        $user = User::with('photos', 'interests')->where('username', $username)->first();
        // dd($user);
        if ($user) {
            $seo_title = $username . "'s Photos";
            return view('photo.list', compact('seo_title', 'user'));
        } else {
            abort(404);
        }
    }
}
