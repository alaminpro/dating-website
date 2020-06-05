<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Pagination\Paginator;
use App\Helpers\General\CollectionHelper;
class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function main()
    {
        return view('home');
    }

    public function postHome()
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make(\request()->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors((array) $validator->errors());
        } else {
            if (Auth::attempt(['username' => $this->request->get('username'), 'password' => $this->request->get('password')])) {
                $user = Auth::user();
                $id = $user->id;
                $input['status'] = 'Online';
                User::where('id', $id)->update($input, ['video_chat' => 0]);
                if ($this->request->has('ref')) {
                    return redirect()->to($this->request->get('ref'));
                } else {
                    return redirect()->route('follow');
                }
            } else {
                return redirect()->back()->with('fail_login', 'Username or password is incorrect!');
            }
        }
    }

    public function landing()
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
        if($this->request->distance){
            $distance = (int) $this->request->distance;
        } 
       $users = User::orderBy('created_at', 'DESC');  

        $this->guestUserPreference($users, $seeking, $gender);

        if (Auth::check()) { 
            if(!$this->request->distance){
                if(auth()->user()->distance){
                    $distance = auth()->user()->distance;
                } 
            } 
            $this->authUserPreference($users, $seeking, $gender);
            $this->authUserDistance($users, $distance);
            $users->whereNotIn('id', [Auth::user()->id]); 
        }else{ 
            $this->guestUserDistance($users, $distance);
        }

        if ($this->request->has('keywords') && $this->request->keywords != '') { 
            $keywords = explode(',',  $this->request->keywords);  
              $terms= array_map('trim', $keywords);
            foreach($keywords  as $keyword){        
                $users->where(function($query) use ($terms){
                    foreach($terms as $term){
                        $query->where('address', 'LIKE', '%'.$term.'%');
                        $query->orWhere('country', 'LIKE', '%'.$term.'%');  
                    }
                }); 
            } 
        }  
         $users = $users->get();
         $collection = collect($users);
        if(Auth::check()){ 
            if(empty($min_age) && empty($max_age)){ 
                if(auth()->user()->min_age && auth()->user()->max_age){  
                    $filtered = $collection->whereBetween('age', [auth()->user()->min_age,  auth()->user()->max_age]); 
                    $users = $filtered->all();
                } 
            } else{ 
                $filtered = $collection->whereBetween('age', [$min_age, $max_age]); 
                $users = $filtered->all();
            }

        }else{
            if(!empty($min_age) && !empty($max_age)){ 
                $filtered = $collection->whereBetween('age', [$min_age, $max_age]); 
                $users = $filtered->all();
            }else{
                 $users =  $collection;
            } 
        } 
     
        $collection = collect($users);
        $total = $collection->count();
        $pageSize = 16;
        $users = CollectionHelper::paginate($collection, $total, $pageSize); 
         return view('landing', compact('users', 'seo_title', 'default_preference'));
    }

    public function authUserDistance($users, $distance)
    {
        if(auth()->user()->lat && auth()->user()->lng){
        $havingSql= '(3959 * acos( cos( radians(' . auth()->user()->lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . auth()->user()->lng . ') ) + sin( radians(' . auth()->user()->lat . ') ) * sin( radians( lat ) ) ) )';
        return $users->select('users.*',
            DB::raw( $havingSql .'AS distance')) 
            ->whereRaw($havingSql . '<= ?', $distance)
            ->orderBy('distance');
        }
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
           return  $users->where('gender', $auth_gender)->where('preference', $auth_preference); 
        }
    }
    public function guestUserDistance($users, $distance)
    {
        $ip =  \Request::ip(); 
        $res = file_get_contents('https://www.iplocate.io/api/lookup/'.$ip);
        $res = json_decode($res); 
        $lat = $res->latitude;
        $lng = $res->longitude;
       if(!empty($lat) && !empty($lng)){
        $havingSql= '(3959 * acos( cos( radians(' .  $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' .  $lng  . ') ) + sin( radians(' .  $lat  . ') ) * sin( radians( lat ) ) ) )';
        return $users->select('users.*',
            DB::raw( $havingSql .'AS distance')) 
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
            } 
            elseif ($gender == 'female' && count($seeking) > 1 && in_array('male', $seeking) && in_array('female', $seeking)) {
                $genders = 2;
                $preference = 3;
            } elseif ($gender == 'male' && count($seeking) > 1 && in_array('female', $seeking) && in_array('male', $seeking)) {
                $genders = 1;
                $preference = 3;
            }
           return  $users->where('gender', $genders)->where('preference', $preference);
        }
    }

    public function forgetPassword(Request $request)
    {
        return view('forget_password');
    }
    public function checkEmail(Request $request)
    {
        // dd($request->all());
        $string = rand(5, 999999999);
        // dd($string);
        $token = $string;
        $email = $request->input('email');
        $toemail = $email;
        $user = User::where('email', '=', $email)->first();
        // dd($toemail);
        if ($user == "") {
            $request->session()->flash('resetAlert', "We can't find a user with that e-mail address.");
            return redirect()->back();
        }
        // $first_name = "waqas";
        // $last_name = "ali";
        $first_name = $user->firstname;
        $last_name = $user->lastname;
        $user_info['forget_token'] = $token;
        // dd($toemail);
        Mail::send('mail.resetpassword', ['u_name' => $first_name . " " . $last_name, 'token' => $token],
            function ($message) use ($toemail) {

                $message->subject('demo.myclouddate.com - Reset Password');
                $message->from('clouddate.dating@gmail.com', 'Singles Dating World');
                $message->to($toemail);
            });
        $user_id = User::where('email', '=', $email)->update($user_info);
        $request->session()->flash('resetSuccess', 'Check your Email to change your password.');
        return redirect('/forget-password');

    }
    public function checkToken(Request $request, $token)
    {
        // dd($token);
        $user = User::where('forget_token', '=', $token)->first();
        if ($user == "") {
            $request->session()->flash('resetAlert', "Your secret code don't match please contact to Admin.");
            return redirect('/forget-password');
        }
        // dd($user);
        return view('reset-password', compact('user'));
    }
    public function ResetPassword(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'password' => 'required|min:6|max:50|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);
        $user_id = $request->input('user_id');
        $pass = Hash::make(trim($request->input('password')));
        // dd($user_id);
        $user = User::where('id', '=', $user_id)->update(array('password' => $pass));
        $request->session()->flash('passwordSuccess', 'Password changed successfully');
        return redirect('/');

    }

}
