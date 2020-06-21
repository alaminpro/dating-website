<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification = Notification::with('notify_user')->where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)->where('read', 0)->count();
        $count = $notification == 0 ? '' : "($notification)";
        $seo_title = "$count Your Notifications";
        return view('notifications.index', compact('seo_title'));
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

    public function notification_count()
    {
        $notification = Notification::where('user_id', '!=', auth()->user()->id)->where('read', 0)->where('user_to_notify', auth()->user()->id)->count();
        return response()->json(['status' => 'success', 'data' => $notification]);
    }
    /**
     * get latest notification
     */
    public function get_latest_notification()
    {
        $todays_data = $earlier_data = '';
        $todays_data = Notification::with('notify_user')->where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->where('date', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        $count_today_data = count($todays_data);

        if ($count_today_data <= 30) {
            $data_left = $count_today_data - 30;
            $earlier_data = Notification::with('notify_user')->where('user_id', '!=', auth()->user()->id)
                ->where('user_to_notify', auth()->user()->id)
                ->where('date', '!=', Carbon::today())
                ->orderBy('created_at', 'desc')
                ->take($data_left)
                ->get();
        }

        $merge_data = [
            'today' => $todays_data,
            'earlier' => $earlier_data,
        ];
        $html = view('notifications.lists', compact('merge_data'))->render();
        $this->delete__notification_after_7_days();
        return response()->json(['status' => 'success', 'html' => $html, 'datas' => $merge_data]);
    }

    private function delete__notification_after_7_days()
    {
        $notifications = Notification::where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->where('created_at', '<', Carbon::now()
                    ->subDays(7))
            ->get();
        foreach ($notifications as $notification) {
            $notification->delete();
        }
    }
    /**
     * get all notification
     */
    public function get_all_notification()
    {
        $datas = Notification::with('notify_user')->where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        $html = view('notifications.all_lists', compact('datas'))->render();
        $this->delete__notification_after_7_days();
        return response()->json(['status' => 'success', 'html' => $html, 'datas' => $datas]);
    }

    /**
     * delete notification
     */
    public function delete__notification()
    {
        $notification = Notification::where('id', $this->request->id)->delete();
        if ($notification) {
            return response()->json(['status' => 'success']);
        }
    }
    /**
     * latest single notification get
     */
    public function latest_single_notification()
    {
        $notification = Notification::with('notify_user')
            ->where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->latest('created_at')->first();
        if ($notification) {
            $html = view('notifications.single_latest', compact('notification'))->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
    }
    /**
     * coding mark as read
     */
    public function markas__read()
    {
        $notification = Notification::where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->where('id', $this->request->id)
            ->update(['read' => $this->request->data]);
        if ($notification) {
            $data = Notification::where('id', $this->request->id)->select('read')->first();
            return response()->json(['status' => 'success', 'data' => $data]);
        }
    }
    /**
     * coding all mark as read
     */
    public function all__markasread()
    {
        $notification = Notification::where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->update(['read' => 1]);
        if ($notification) {
            return response()->json(['status' => 'success']);
        }
    }
    /**
     * View Notification
     */
    public function notification_view()
    {
        $notification = Notification::where('user_id', '!=', auth()->user()->id)
            ->where('user_to_notify', auth()->user()->id)
            ->where('id', $this->request->id)
            ->update(['read' => 1]);

        if ($notification) {
            $url = Notification::where('user_id', '!=', auth()->user()->id)
                ->where('user_to_notify', auth()->user()->id)
                ->where('id', $this->request->id)->select('redirect_url')
                ->first();
            return response()->json(['status' => 'success', 'url' => $url]);
        }
    }
    /**
     * start coding for who to follow
     */
    public function who_to_follow()
    {

        // $follows = new User();
        // $follows->following();
        // return $follows;
        // if ($follows) {
        //     $html = view('notifications.who_to_follow', compact('follows'))->render();
        //     return response()->json(['status' => 'success', 'html' => $html, 'datas' => $follows]);
        // }
    }
    /**
     * start coding for Main search
     */
    public function main__search()
    {
        if ($this->request->keyword) {
            $keywords = explode(',', $this->request->keyword);

            $terms = array_map('trim', $keywords);

            $users = User::with('interests');

            foreach ($keywords as $keyword) {
                $users->where(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('username', 'LIKE', '%' . $term . '%');
                        $query->orWhere('email', 'LIKE', '%' . $term . '%');
                        $query->orWhere('address', 'LIKE', '%' . $term . '%');
                        $query->orWhere('user_status', 'LIKE', '%' . $term . '%');
                        $query->orWhereHas('interests', function ($query) use ($term) {
                            $query->where('text', 'LIKE', "%$term%");
                        });
                    }
                });
            }
        }
        $users = $users->get();
        if ($users) {
            $html = view('search.index', compact('users'))->render();
            return response()->json(['status' => 'success', 'html' => $html, 'datas' => $users]);
        }

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
            $check = Notification::where('date', '=', Carbon::today())->where('type', 'follow')
                ->where('user_id', '=', $user_id)
                ->where('user_to_notify', '=', $follow_id)->count();
            if (!$check > 0) {
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
    public function page_like_notification()
    {
        $user_id = $this->request->id;
        $notify_id = $this->request->notify_id;
        if ($user_id) {
            $check = Notification::where('date', '=', Carbon::today())->where('type', 'page_like')->where('user_id', '=', $user_id)->where('user_to_notify', '=', $notify_id)->count();
            if (!$check > 0) {
                $user = User::where('id', $user_id)->first();
                $notify = new Notification();
                $notify->user_id = $user_id;
                $notify->user_to_notify = $notify_id;
                $notify->type = 'page_like';
                $notify->data = 'Liked your page';
                $notify->read = 0;
                $notify->date = Carbon::now()->format("Y-m-d");
                $notify->redirect_url = route('profile', $user->username);
                $notify->save();
                return response()->json(['status' => 'success']);
            }
        }
    }
    public function photo_like_notification()
    {
        $photo_id = $this->request->photo_id;
        $user_id = $this->request->user_id;
        $auth_id = auth()->user()->id;
        if ($user_id !== $auth_id && $photo_id) {
            $check = Notification::where('date', '=', Carbon::today())
                ->where('type', 'likes')->where('user_id', '=', $auth_id)
                ->where('data', '=', $photo_id)
                ->count();
            if (!$check > 0) {
                $user = User::where('id', $user_id)->select('id', 'birthday')->with(['photos' => function ($q) use ($photo_id) {
                    $q->where('id', $photo_id);
                }])->first();

                $notify = new Notification();
                $notify->user_id = $auth_id;
                $notify->user_to_notify = $user_id;
                $notify->type = 'likes';
                $notify->data = $photo_id;
                $notify->read = 0;
                $notify->date = Carbon::now()->format("Y-m-d");
                $notify->redirect_url = $user->photos[0]->file;
                $notify->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        }
    }

    public function photo_comment_notification()
    {
        $photo_id = $this->request->photo_id;
        $user_id = $this->request->user_id;
        $auth_id = auth()->user()->id;
        if ($user_id !== $auth_id && $photo_id) {
            $check = Notification::where('date', '=', Carbon::today())
                ->where('type', 'comment')->where('user_id', '=', $auth_id)
                ->where('data', '=', $photo_id)
                ->count();
            if (!$check > 0) {
                $user = User::where('id', $user_id)->select('id', 'birthday')->with(['photos' => function ($q) use ($photo_id) {
                    $q->where('id', $photo_id);
                }])->first();

                $notify = new Notification();
                $notify->user_id = $auth_id;
                $notify->user_to_notify = $user_id;
                $notify->type = 'comment';
                $notify->data = $photo_id;
                $notify->read = 0;
                $notify->date = Carbon::now()->format("Y-m-d");
                $notify->redirect_url = $user->photos[0]->file;
                $notify->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        }
    }
}
