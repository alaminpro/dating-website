<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * view index pages
     */
    public function index()
    {
        $seo_title = 'Dashboard';
        return view('dashboard.index', compact('seo_title'));
    }

    /**
     * main
     */
    public function main(Request $request)
    {
        if ($this->request->has('action')) {
            $action = $this->request->get('action');
            if (method_exists($this, $action)) {
                return $this->$action();
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function get_followers()
    {

        $user_id = $this->request->id;
        $logged_user_id = $this->request->logged_id;

        $follower = User::with(['following' => function ($query) {
            $query->select(['id', 'avatar', 'username', 'birthday']);
        }])->where('id', $user_id)->select('id', 'birthday')->first();

        $logged_follower = User::where('id', $logged_user_id)->select('id', 'birthday')->first();

        if ($follower) {
            $new_follower = [];
            foreach ($follower->following as $follow) {
                if ($logged_follower) {
                    if ($logged_follower->id === $follow['id']) {
                        $new_follower[] = [
                            'id' => $follow['id'],
                            'username' => $follow['username'],
                            'avatar' => $follow['avatar'],
                            'follow' => '',
                        ];
                    } else {
                        $new_follower[] = [
                            'id' => $follow['id'],
                            'username' => $follow['username'],
                            'avatar' => $follow['avatar'],
                            'follow' => $logged_follower->isFollows($logged_follower)->contains($follow['id']) ? 'following' : 'follow',
                        ];
                    }

                } else {
                    $new_follower[] = [
                        'id' => $follow['id'],
                        'username' => $follow['username'],
                        'avatar' => $follow['avatar'],
                        'follow' => $follower->isFollows($follower)->contains($follow['id']) ? 'following' : 'follow',
                    ];
                }

            }
            if ($this->request->data_id && $this->request->item) {
                $data = array_map('intval', $this->request->data_id);
                $data = collect($new_follower)->whereNotIn('id', $data)->take($this->request->item);
                return response()->json(['status' => 'success', 'datas' => $data]);
            }
            $collection = collect($new_follower);
            $chunk = $collection->take(10);
            return response()->json(['status' => 'success', 'datas' => $chunk]);
        }
        return response()->json(['status' => 'error']);
    }

    public function follow_following()
    {
        $user_id = $this->request->id;

        $follower = auth()->user();
        if (!$follower->isFollowing($user_id)) {
            $follower->follow($user_id);
            return response()->json(['status' => 'success', 'data' => 'Following']);
        } else {
            $follower->unfollow($user_id);
            return response()->json(['status' => 'success', 'data' => 'Follow']);
        }
        return response()->json(['status' => 'error']);
    }

    public function get_following()
    {
        $logged_user_id = $this->request->logged_id;
        $user_id = $this->request->id;
        $follower = User::with(['follows' => function ($query) {
            $query->select(['id', 'avatar', 'username', 'birthday']);
        }])->where('id', $user_id)->select('id', 'birthday')->first();
        $logged_follower = User::where('id', $logged_user_id)->select('id', 'birthday')->first();
        if ($follower) {
            $new_follower = [];
            foreach ($follower->follows as $follow) {
                if ($logged_follower) {
                    if ($logged_follower->id === $follow['id']) {
                        $new_follower[] = [
                            'id' => $follow['id'],
                            'username' => $follow['username'],
                            'avatar' => $follow['avatar'],
                            'follow' => '',
                        ];
                    } else {
                        $new_follower[] = [
                            'id' => $follow['id'],
                            'username' => $follow['username'],
                            'avatar' => $follow['avatar'],
                            'follow' => $logged_follower->isFollows($logged_follower)->contains($follow['id']) ? 'following' : 'follow',
                        ];
                    }
                } else {
                    $new_follower[] = [
                        'id' => $follow['id'],
                        'username' => $follow['username'],
                        'avatar' => $follow['avatar'],
                        'follow' => $follower->isFollowing($user_id) ? 'following' : 'Unfollowing',
                    ];
                }
            }
            if ($this->request->data_id && $this->request->item) {
                $data = array_map('intval', $this->request->data_id);
                $data = collect($new_follower)->whereNotIn('id', $data)->take($this->request->item);
                return response()->json(['status' => 'success', 'datas' => $data]);
            }
            $collection = collect($new_follower);
            $chunk = $collection->take(10);
            return response()->json(['status' => 'success', 'datas' => $chunk]);
        }
        return response()->json(['status' => 'error']);
    }
    public function unfollowing()
    {
        $user_id = $this->request->id;

        $follower = auth()->user();
        if ($follower->isFollowing($user_id)) {
            $follower->unfollow($user_id);
            return response()->json(['status' => 'success', 'data' => 'Follow']);
        }
        return response()->json(['status' => 'error']);
    }

    public function updateStatus()
    {
        if ($this->request->status != '') {
            $user_id = $this->request->id;
            $user = User::where('id', $user_id)->update(['user_status' => $this->request->status]);
            $user = User::where('id', $user_id)->first();
            return response()->json(['status' => 'success', 'user' => $user]);
        }
        return response()->json(['status' => 'error']);
    }
    public function update_status_notification()
    {
        $user_id = $this->request->id;
        if ($user_id) {
            $followers = User::find($user_id)->following;
            foreach ($followers as $follower) {
                $notify = new Notification();
                $notify->user_id = $user_id;
                $notify->user_to_notify = $follower->id;
                $notify->type = 'status';
                $notify->data = $this->request->message;
                $notify->read = 0;
                $notify->date = Carbon::now()->format("Y-m-d");
                $notify->redirect_url = route('profile', auth()->user()->username);
                $notify->save();
            }
            return response()->json(['status' => 'success']);
        }
    }

    public function update_follow_notification()
    {
        $user_id = $this->request->id;
        $follow_id = $this->request->follow_id;
        if ($user_id) {
            $user = User::where('id', $user_id)->first();
            $notify = new Notification();
            $notify->user_id = $user_id;
            $notify->user_to_notify = $follow_id;
            $notify->type = 'follow';
            $notify->data = 'Followed you';
            $notify->read = 0;
            $notify->date = Carbon::now()->format("Y-m-d");
            $notify->redirect_url = route('profile', $user->username);
            $notify->save();
            return response()->json(['status' => 'success']);
        }
    }
}
