<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use App\Photo;
use App\User;
use App\VideoCall;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class VideoController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function videos()
    {  
        $users  = User::where('status','Online')->where('video_chat', 1)->get();
        return view('videos.all', compact('users'));
    }
  

    public function video($id)
    {
        $video = VideoCall::with('receive','sender')->where('id', $id)->where('created_at','>', time()-40)->first();
        if($video) {
            return view('videos.video', compact('video'));
        }
        else {
            VideoCall::where('id', $id)->delete();
            return redirect()->route('videos');
        }
    }
}
