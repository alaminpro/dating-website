<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Conversation;
use App\Helpers\General\CollectionHelper;
use App\Interest;
use App\Message;
use App\Photo;
use App\User;
use App\VideoCall;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class AjaxController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function main(Request $request)
    {
        // dd($this->request->get('action'));
        if ($this->request->has('action')) {
            $action = $this->request->get('action');
            if (method_exists($this, $action)) {
                return $this->$action();
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function check_username()
    {
        if ($this->request->has('username')) {
            $check = User::where('username', $this->request->get('username'))->first();
            if ($check) {
                return response()->json(['status' => 'error']);
            } else {
                return response()->json(['status' => 'success']);
            }

        }
        return response()->json(['status' => 'error']);
    }
    public function check_username_setting()
    {
        if ($this->request->has('username')) {
            $check = User::where('username', $this->request->get('username'))->first();
            $user = User::where('id', auth()->user()->id)->first();

            if ($check) {
                if ($check->username === $user->username) {
                    return response()->json(['status' => 'you']);
                }
                return response()->json(['status' => 'error']);
            } else {
                return response()->json(['status' => 'success']);
            }

        }
        return response()->json(['status' => 'error']);
    }

    public function check_email()
    {
        if ($this->request->has('email')) {
            $check = User::where('email', $this->request->get('email'))->first();
            if ($check) {
                return response()->json(['status' => 'error']);
            } else {
                return response()->json(['status' => 'success']);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function search_more()
    {
        $distance = 1000;
        $seo_title = 'Search';
        if (Auth::check()) {
            $user = Auth::user();
            $default_gender = $user->gender;
            $default_preference = $user->preference == 3 ? [1, 2] : [$user->preference];
        } else {
            $default_gender = 1;
            $default_preference = [2];
        }
        $gender = $this->request->get('gender');
        $seeking = $this->request->get('seeking');
        $min_age = $this->request->get('min_age');
        $max_age = $this->request->get('max_age');

        if ($this->request->has('gender') && ($gender == 'male' || $gender == 'female')) {
            $default_gender = $gender == 'male' ? 1 : 2;
        }
        if ($seeking && is_array($seeking) && in_array('male', $seeking)) {
            $default_preference = [1];
        }
        if ($seeking && is_array($seeking) && in_array('female', $seeking)) {
            $default_preference = [2];
        }
        if ($seeking && is_array($seeking) && in_array('female', $seeking) && in_array('male', $seeking)) {
            $default_preference = [1, 2];
        }
        if ($this->request->distance) {
            $distance = (int) $this->request->distance;
        }
        $users = User::orderBy('created_at', 'DESC');

        $this->guestUserPreference($users, $seeking, $gender);

        if (Auth::check()) {
            if (!$this->request->distance) {
                if (auth()->user()->distance) {
                    $distance = auth()->user()->distance;
                }
            }

            $this->authUserPreference($users, $seeking, $gender);
            $this->authUserDistance($users, $distance);
            $users->whereNotIn('id', [Auth::user()->id]);
        } else {
            $this->guestUserDistance($users, $distance);
        }
        if ($this->request->has('country') && $this->request->country != '') {
            $users->where('country', $this->request->country);
        }
        $users = $users->get();
        $collection = collect($users);
        if (Auth::check()) {
            if (empty($min_age) && empty($max_age)) {
                if (auth()->user()->min_age && auth()->user()->max_age) {
                    $filtered = $collection->whereBetween('age', [auth()->user()->min_age, auth()->user()->max_age]);
                    $users = $filtered->all();
                }
            } else {
                $filtered = $collection->whereBetween('age', [$min_age, $max_age]);
                $users = $filtered->all();
            }

        } else {
            if (!empty($min_age) && !empty($max_age)) {
                $filtered = $collection->whereBetween('age', [$min_age, $max_age]);
                $users = $filtered->all();
            } else {
                $users = $collection;
            }
        }

        $collection = collect($users);
        $total = $collection->count();
        $pageSize = 16;
        $users = CollectionHelper::paginate($collection, $total, $pageSize);
        return view('ajax_filter', compact('users'));
    }
    public function authUserDistance($users, $distance)
    {
        $havingSql = '(3959 * acos( cos( radians(' . auth()->user()->lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . auth()->user()->lng . ') ) + sin( radians(' . auth()->user()->lat . ') ) * sin( radians( lat ) ) ) )';
        return $users->select('users.*',
            DB::raw($havingSql . 'AS distance'))
            ->whereRaw($havingSql . '<= ?', $distance)
            ->orderBy('distance');
    }
    public function authUserPreference($users, $seeking, $gender)
    {
        if (!$seeking && !$gender) {
            $auth_gender = $auth_preference = '';
            if (auth()->user()->gender == 1 && auth()->user()->preference == 2) {
                $auth_gender = 2;
                $auth_preference = 1;
            } elseif (auth()->user()->gender == 2 && auth()->user()->preference == 1) {
                $auth_gender = 1;
                $auth_preference = 2;
            } elseif (auth()->user()->gender == 2 && auth()->user()->preference == 2) {
                $auth_gender = 2;
                $auth_preference = 2;
            } elseif (auth()->user()->gender == 1 && auth()->user()->preference == 1) {
                $auth_gender = 1;
                $auth_preference = 1;
            } elseif (auth()->user()->gender == 2 && auth()->user()->preference == 3) {
                $auth_gender = 2;
                $auth_preference = 3;
            } elseif (auth()->user()->gender == 1 && auth()->user()->preference == 3) {
                $auth_gender = 1;
                $auth_preference = 3;
            }
            return $users->where('gender', $auth_gender)->where('preference', $auth_preference);
        }
    }
    public function guestUserDistance($users, $distance)
    {
        $ip = \Request::ip();
        $res = file_get_contents('https://www.iplocate.io/api/lookup/' . $ip);
        $res = json_decode($res);
        $lat = $res->latitude;
        $lng = $res->longitude;
        if (!empty($lat) && !empty($lng)) {
            $havingSql = '(3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) )';
            return $users->select('users.*',
                DB::raw($havingSql . 'AS distance'))
                ->whereRaw($havingSql . '<= ?', $distance)
                ->orderBy('distance');
        }
    }

    public function guestUserPreference($users, $seeking, $gender)
    {
        $genders = $preference = '';
        if ($seeking && $gender) {
            if ($gender == 'male' && in_array('female', $seeking) && count($seeking) <= 1) {
                $genders = 2;
                $preference = 1;
            } elseif ($gender == 'female' && in_array('male', $seeking) && count($seeking) <= 1) {
                $genders = 1;
                $preference = 2;
            } elseif ($gender == 'female' && in_array('female', $seeking) && count($seeking) <= 1) {
                $genders = 2;
                $preference = 2;
            } elseif ($gender == 'male' && in_array('male', $seeking) && count($seeking) <= 1) {
                $genders = 1;
                $preference = 1;
            } elseif ($gender == 'female' && count($seeking) > 1 && in_array('male', $seeking) && in_array('female', $seeking)) {
                $genders = 2;
                $preference = 3;
            } elseif ($gender == 'male' && count($seeking) > 1 && in_array('female', $seeking) && in_array('male', $seeking)) {
                $genders = 1;
                $preference = 3;
            }
            return $users->where('gender', $genders)->where('preference', $preference);
        }
    }

    public function delete_photo()
    {

        if ($this->request->has('id')) {
            $photo = Photo::where('id', $this->request->id)->first();
            if ($photo) {
                $thumb = $photo->thumb;
                $file = $photo->file;
                $storage_path_thumb = $thumb;
                $storage_path_file = $file;

                if (\File::exists($storage_path_thumb)) {
                    unlink($storage_path_thumb);
                }
                if (\File::exists($storage_path_file)) {
                    unlink($storage_path_file);
                }
                $photo->delete();
            }
        }
        return response()->json(['status' => 'deleted']);

    }
    public function delete_comment()
    {
        if ($this->request->has('id')) {
            Comment::where('id', $this->request->id)->delete();
        }
        return response()->json(['status' => 'deleted']);
    }
    public function update_description()
    {
        if ($this->request->has('id')) {
            Photo::where('id', $this->request->id)->update([
                'description' => $this->request->text,
            ]);
        }
        return response()->json(['status' => 'success', 'text' => $this->request->text]);
    }
    public function update_comment()
    {
        if ($this->request->has('id')) {
            Comment::where('id', $this->request->id)->update([
                'comment' => $this->request->text,
            ]);
        }
        return response()->json(['status' => 'success', 'text' => $this->request->text]);
    }

    public function view_cover_photo()
    {
        if ($this->request->has('id')) {
            $photo = User::where('id', $this->request->id)->first();
            $type = "cover";
            if ($photo) {
                $html = view('photo.view', compact('photo', 'type'))->render();
                return response()->json(['status' => 'success', 'height' => $photo->height, 'width' => $photo->width, 'html' => $html]);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function view_photo()
    {
        if ($this->request->has('id')) {
            $get_user = Photo::with('comments', 'likes', 'user')->where('id', $this->request->id)->first();
            $user_id = $get_user->user_id;
            $id = $get_user->id;
            $photos = Photo::with('comments', 'likes', 'user')->where('user_id', $user_id)->get();
            $type = '';
            if ($photos) {
                $html = view('photo.view2', compact('photos', 'type', 'id'))->render();
                return response()->json(['status' => 'success', 'height' => $photos[0]->height, 'width' => $photos[0]->width, 'html' => $html]);
            }
        }
        return response()->json(['status' => 'error']);
    }
    public function like_photo()
    {
        if ($this->request->has('id') && \auth()->check()) {
            $photo = Photo::with('likes')->where('id', $this->request->id)->first();
            if ($photo) {
                if (in_array(auth()->id(), collect($photo->likes()->get())->pluck('id')->all())) {
                    $photo->likes()->detach(auth()->id());
                    return response()->json(['status' => 'success', 'type' => 'dislike']);
                } else {
                    $photo->likes()->attach(auth()->id());
                    return response()->json(['status' => 'success', 'type' => 'like']);
                }
            }
        }
        return response()->json(['status' => 'login']);
    }

    public function follow()
    {
        if ($this->request->has('id') && \auth()->check()) {
            $user = \auth()->user();
            if ($this->request->id == \auth()->id()) {
                return response()->json(['status' => 'success', 'type' => 'self']);
            } elseif (in_array($this->request->id, collect($user->follows()->get())->pluck('id')->all())) {
                $user->follows()->detach($this->request->id);
                return response()->json(['status' => 'success', 'type' => 'unfollow']);
            } else {
                $user->follows()->attach($this->request->id);
                return response()->json(['status' => 'success', 'type' => 'follow']);
            }
        }
        return response()->json(['status' => 'login']);
    }

    public function comment_photo()
    {
        if ($this->request->has('id') && $this->request->has('text') && \auth()->check()) {
            $comment = new Comment();
            $comment->user_id = \auth()->id();
            $comment->comment = $this->request->text;
            $comment->object_id = $this->request->id;
            $comment->object_type = 'photo';
            $comment->save();
            $html = view('photo.comment', compact('comment'))->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        return response()->json(['status' => 'login']);
    }

    public function love()
    {
        if ($this->request->has('id') && $this->request->has('type') && \auth()->check()) {
            $user = \auth()->user();
            if ($user->likes()->where('id', $this->request->id)->first()) {
                $old_type = $user->likes()->where('id', $this->request->id)->first()->pivot->type;
                $user->likes()->detach($this->request->id);
                if ($old_type != $this->request->type) {
                    $user->likes()->attach($this->request->id, ['type' => $this->request->type]);
                }
                return response()->json(['status' => 'success', 'type' => 'old']);
            } else {
                $user->likes()->sync($this->request->id, ['type' => $this->request->type]);
                return response()->json(['status' => 'success', 'type' => 'new']);
            }
        }
        return response()->json(['status' => 'login']);
    }

    public function load_photo()
    {
        if ($this->request->id && $this->request->page) {
            $user = User::with('photos')->where('id', $this->request->id)->first();
            if ($user) {
                $photos = $user->photos()->orderBy('created_at', 'DESC')->paginate(16);
                if ($photos->count()) {
                    $html = view('photo.load', compact('photos'))->render();
                    return response()->json(['status' => 'success', 'html' => $html]);
                }
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function send_message()
    {
        if ($this->request->id && $this->request->text) {
            if (\auth()->check()) {
                $conversation = Conversation::where('id', $this->request->id)->first();
                if ($conversation) {
                    if (\auth()->id() == $conversation->sender_id && $conversation->waiting == 1 && !empty($conversation->last_message)) {
                        return response()->json(['status' => 'wait']);
                    } else {
                        $receive_id = $conversation->receive_id;
                        $sender_id = $conversation->sender_id;
                        if (\auth()->id() === $conversation->receive_id) {
                            $sender_id = $conversation->receive_id;
                            $receive_id = $conversation->sender_id;
                        }
                        // Send email or sms to receive user
                        // end send email
                        $message = new Message();
                        $message->message = $this->request->text;
                        $message->user_id = \auth()->id();
                        $message->conversation_id = $conversation->id;
                        $message->seen = 0;
                        $message->save();
                        if (\auth()->id() != $conversation->sender_id) {
                            $conversation->waiting = 0;
                        }
                        $conversation->last_message = $this->request->text;
                        $conversation->updated_at = date('Y-m-d H:i:s');
                        $conversation->save();
                        $conv = $conversation;
                        $html = view('messages.message', compact('message'))->render();
                        $html_receive = true;
                        $receive_html = view('messages.message', compact('message', 'html_receive'))->render();
                        $notice_html = view('messages.notice', compact('message'))->render();
                        $conversation_html = view('messages.item', compact('conv', 'html_receive'))->render();
                        return response()->json([
                            'status' => 'success',
                            'html' => $html,
                            'id' => $message->id,
                            'receive_html' => $receive_html,
                            'conversation_html' => $conversation_html,
                            'notice_html' => $notice_html,
                            'message' => $message->message,
                        ]);
                    }
                }
            } else {
                return response()->json(['status' => 'login']);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function load_messages()
    {
        if ($this->request->id && $this->request->page && \auth()->check()) {
            $conversation = Conversation::with('messages', 'sender', 'receive')->where('id', $this->request->id)->where(function (Builder $query) {
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if ($conversation) {
                $messages = $conversation->messages()->paginate(20);
                if ($messages->count()) {
                    $html = '';
                    foreach ($messages->reverse() as $message) {
                        $html .= view('messages.message', compact('message'))->render();
                    }
                    return response()->json(['status' => 'success', 'html' => $html]);
                } else {
                    return response()->json(['status' => 'empty']);
                }
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function check_messages()
    {
        if (\auth()->check()) {
            $conversations = Conversation::with('messages')->where(function (Builder $query) {
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->whereHas('messages', function (Builder $query) {
                $query->where('seen', 0)->where('user_id', '!=', \auth()->id());
            })->orderBy('updated_at', "DESC")->get();
            if ($conversations->count()) {
                $result = [];
                foreach ($conversations as $key => $conv) {
                    $result[$key]['id'] = $conv->id;
                    $result[$key]['messages'] = [];
                    $result[$key]['html'] = view('messages.item', compact('conv'))->render();
                    $result[$key]['last_message'] = $conv->last_message;
                    $messages = $conv->messages()->where('seen', 0)->where('user_id', '!=', \auth()->id())->get();
                    foreach ($messages->reverse() as $keym => $message) {
                        if ($this->request->id && $this->request->id == $message->conversation_id) {
                            $message->seen();
                        }
                        $result[$key]['messages'][$keym]['id'] = $message->id;
                        $result[$key]['messages'][$keym]['html'] = view('messages.message', compact('message'))->render();
                    }
                }
                return response()->json(['status' => 'success', 'result' => $result]);
            } else {
                return response()->json(['status' => 'empty']);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function load_conversation()
    {
        if ($this->request->id && \auth()->check()) {
            $conversation = Conversation::with('messages', 'sender', 'receive')->where('id', $this->request->id)->where(function (Builder $query) {
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if ($conversation) {
                Message::where('conversation_id', $conversation->id)->where('user_id', '!=', \auth()->id())->update(['seen' => 1]);
                $html = view('messages.conversation', compact('conversation'))->render();
                return response()->json(['status' => 'success', 'html' => $html, 'unread' => \auth()->user()->unread()->count(), 'url' => route('message', ['id' => $conversation->id])]);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function seen()
    {
        if ($this->request->id && \auth()->check()) {
            Message::where('id', $this->request->id)->update(['seen' => 1]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }

    public function delete_conversation()
    {
        if ($this->request->id && \auth()->check()) {
            $conversation = Conversation::where('id', $this->request->id)->where(function (Builder $builder) {
                $builder->where('sender_id', auth()->id())->orWhere('receive_id', auth()->id());
            })->first();

            if ($conversation) {
                Message::where('conversation_id', $this->request->id)->delete();
                $conversation->delete();
            }
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }

    public function update_user_video()
    {
        $Q1 = User::find($this->request->data['id']);
        $Q1->video_chat = $this->request->data['video'];
        $Q1->save();
        return response()->json(['status' => 'success']);
    }

    public function get_user_video_call()
    {
        $users = User::where('id', '!=', auth()->user()->id)->where('video_chat', 1)->get();
        $newUser = [];
        foreach ($users as $user) {
            if (auth()->user()->isFollowEach($user->id)) {
                $newUser[] = [
                    'id' => $user->id,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'online' => $user->isOnline(),
                ];
            }

        }

        return response()->json(['status' => 'success', 'data' => $newUser]);
    }
    public function get_user_by_search()
    {
        $users = User::where('id', '!=', auth()->user()->id)
            ->where('video_chat', 1)
            ->where('username', 'like', '%' . $this->request->username . '%')
            ->get();

        $newUser = [];
        foreach ($users as $user) {
            if (auth()->user()->isFollowEach($user->id)) {
                $newUser[] = [
                    'id' => $user->id,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'online' => $user->isOnline(),
                ];
            }
        }

        return response()->json(['status' => 'success', 'data' => $newUser]);
    }

    public function load_user_by_id()
    {
        $user = User::where('id', $this->request->id)
            ->where('video_chat', 1)
            ->first();

        return response()->json(['status' => 'success', 'data' => $user]);
    }
    public function permission()
    {
        if ($this->request->id) {
            $user = User::find($this->request->id);
            $user->video_chat = 1;
            $user->save();
            if ($user) {
                return $this->startcall();
            }
        }
    }

    public function startcall()
    {
        $receive = User::where('id', $this->request->id)->first();
        $sender = auth()->user();
        $room_script = sha1(rand(1111111, 9999999));
        $accountSid = config('services.twilio.sid');
        $apiKeySid = config('services.twilio.key');
        $apiKeySecret = config('services.twilio.secret');
        $room_script = sha1(rand(1111111, 9999999));
        $call_id = substr(md5(microtime()), 0, 15);
        $call_id_2 = substr(md5(time()), 0, 15);
        $token = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id);
        $grant = new VideoGrant();
        $grant->setRoom($room_script);
        $token->addGrant($grant);
        $token_ = $token->toJWT();
        $token2 = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id_2);
        $grant2 = new VideoGrant();
        $grant2->setRoom($room_script);
        $token2->addGrant($grant2);
        $token_2 = $token2->toJWT();
        VideoCall::where('sender_id', $sender->id)->orWhere('receive_id', $sender->id)->delete();
        $video = new VideoCall();
        $video->access_token = $token_;
        $video->access_token_2 = $token_2;
        $video->sender_id = $sender->id;
        $video->receive_id = $receive->id;
        $video->room_name = $room_script;
        $video->created_at = time();
        $video->save();

        return response()->json(['status' => 'success', 'url' => route('video', ['id' => $video->id])]);

    }

    public function load_audio()
    {
        return response()->json(['status' => 1]);
    }

    public function search_interest()
    {
        $interests = Interest::where('text', 'like', '%' . $this->request->search . '%')
            ->get();

        return response()->json(['status' => 'success', 'data' => $interests]);
    }
    public function interest_by_id()
    {
        $interest = Interest::where('id', $this->request->id)
            ->first();

        return response()->json(['status' => 'success', 'data' => $interest]);
    }
    public function load_user_interest()
    {
        $user = User::where('id', $this->request->id)->first();
        $interest_id = collect($user->interests()->get())->pluck('id')->all();
        $interest = $user->interests()->get();
        return response()->json(['status' => 'success', 'interest' => $interest, 'interest_id' => $interest_id]);
    }
    public function check_password()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $match = \Hash::check($this->request->password, $user->password);
        if ($match) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }

    }
    public function about_us_section()
    {
        $user = User::where('id', $this->request->id)->first();

        if ($user) {
            $html = view('users.about', compact('user'))->render();

            return response()->json(['status' => 'success', 'html' => $html]);
        } else {
            return response()->json(['status' => 'error']);
        }

    }

    public function fetch_user_photos()
    {
        if ($this->request->has('id')) {
            $user = User::with('photos')->where('id', $this->request->id)->select('id', 'birthday')->first();

            if ($user) {
                $html = view('photo.photo-post', compact('user'))->render();
                return response()->json(['status' => 'success', 'html' => $html, 'user' => $user]);
            }
        }
        return response()->json(['status' => 'error']);
    }
    public function load_more_photo()
    {

        $user_id = $this->request->id;
        if ($user_id) {
            $user = User::with('photos')->where('id', $user_id)->select('id', 'birthday')->first();
            if ($user) {
                $new_photos = [];
                foreach ($user->photos as $data) {
                    $new_photos[] = [
                        'id' => $data['id'],
                        'file' => $data['file'],
                        'thumb' => $data['thumb'],
                    ];
                }

                if ($this->request->data_id && $this->request->item) {
                    $data = array_map('intval', $this->request->data_id);
                    $photos = collect($new_photos)->whereNotIn('id', $data)->take($this->request->item);
                    $html = view('photo.load', compact('photos'))->render();
                    return response()->json(['status' => 'success', 'html' => $html, 'datas' => $photos]);
                }
            }
        }
        return response()->json(['status' => 'error']);
    }
    /**
     *
     * start coding for siderbar users feature area
     */
    public function get__feature()
    {
        $auth_id = auth()->user()->id;
        $users = User::where('id', $auth_id)
            ->select('id', 'birthday')
            ->with('following')->first();

        $collection = collect($users->following);
        $users = $collection->take(10);
        $users->all();
        if ($users) {
            $html = view('feature.get__feature', compact('users'))->render();
            return response()->json(['status' => 'success', 'html' => $html, 'datas' => $users]);
        }
    }
    public function feature_users__search()
    {
        if ($this->request->keyword) {
            $keywords = explode(',', $this->request->keyword);
            $terms = array_map('trim', $keywords);
            $auth_id = auth()->user()->id;
            $users = User::where('id', $auth_id)
                ->select('id', 'birthday')
                ->with('following')->first();

            $collection = collect($users->following);
            foreach ($keywords as $keyword) {
                $collection->where(function ($query) use ($terms) {
                    // foreach ($terms as $term) {
                    //     $query->where('username', 'LIKE', '%' . $term . '%');
                    //     $query->orWhereHas('interests', function ($query) use ($term) {
                    //         $query->where('text', 'LIKE', "%$term%");
                    //     });
                    // }
                });
            }

        }
        return $users = $collection->all();
        // if ($users) {
        //     $html = view('search.index', compact('users'))->render();
        //     return response()->json(['status' => 'success', 'html' => $html, 'datas' => $users]);
        // }

    }

}
