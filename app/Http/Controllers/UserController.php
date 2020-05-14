<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\DatingPersistentDataHandler;
use App\Interest;
use App\User;
use Carbon\Carbon;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function quickRegister()
    {
        $rules = array(
            'username' => 'required|alpha_dash|min:6|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'gender' => 'required',
            'country' => 'required'
        );
        $validator = Validator::make(\request()->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array)$validator->errors());
        }
        else{
          // dd($this->request->all());

            $user = new User();
            $user->username = $this->request->get('username');
            $user->email = $this->request->get('email');
            $user->password = Hash::make($this->request->get('password'));
            $user->gender = $this->request->get('gender');
            $user->first_login = 1;
            $user->active = 1;
            $user->country = $this->request->get('country');
            $user->save();
            Auth::login($user);
            
            return redirect()->route('setting');
        }
    }

    public function postRegister()
    {   
            $this->validate($this->request, [ 
                'username' => 'required|alpha_dash|min:6|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'gender' => 'required',
                'preference' => 'required',
                'day' => 'required',
                'month' => 'required',
                'year' => 'required',
                'country' => 'required',
                'interests' => 'required' 
            ],
            [
                'username.required' => __('Username fields is required!'), 
                'interests.required' => __('Interests fields is required!'), 
                'country.required' => __('Country fields is required!'), 
            ]);
         
            $user = new User();
            $user->username = Str::lower($this->request->get('username'));
            $user->email = $this->request->get('email');
            $user->password = Hash::make($this->request->get('password'));
            $user->gender = $this->request->get('gender');
            $user->preference = $this->request->get('preference');
            $user->birthday = $this->request->get('year').'-'.$this->request->get('month').'-'.$this->request->get('day');
            if(Carbon::parse($user->birthday)->age < setting('min_age')){
                return redirect()->back()->with('minimum_age', 'Sorry, only persons over the age of '.setting('min_age').' may enter this site')->withInput();
            }
            if($this->request->has('about')){
                $user->about = $this->request->get('about');
            }
            if($this->request->has('lat')){
                $user->lat = $this->request->get('lat');
            }
            if($this->request->has('lng')){
                $user->lng = $this->request->get('lng');
            }
            $user->ip = $this->request->ip();
            $user->first_login = 0;
            $user->active = 1;
            $user->country = $this->request->get('country');
            $user->address = $this->request->get('address');
            $user->save();
            if($this->request->hasFile('avatar')){
                $avatar = $this->request->file('avatar');
                if(in_array($avatar->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                    $filename = md5($user->username.time()).time();
                    $tempFile= $avatar->getPathname();
                    $targetPath = $this->create_folder($user->id);
                    $targetFile = $targetPath.DIRECTORY_SEPARATOR.$filename.'.'.$avatar->getClientOriginalExtension();
                    $file = compress_image($tempFile, $targetFile, 100);
                    $size = getimagesize($tempFile);
                    $nw = $nh = 600;
                    $x = (int) $this->request->get('x');
                    $y = (int) $this->request->get('y');
                    $w = (int) $this->request->get('w') ? $this->request->get('w') : $size[0];
                    $h = (int) $this->request->get('h') ? $this->request->get('h') : $size[1];
                    $data = file_get_contents($tempFile);
                    $vImg = imagecreatefromstring($data);
                    $dstImg = imagecreatetruecolor($nw, $nh);
                    imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh,$w, $h);
                    imagejpeg($dstImg, $targetFile);
                    imagedestroy($dstImg);
                    $user->avatar = 'uploads/photos/'.$user->id.'/'.$filename.'.'.$avatar->getClientOriginalExtension();
                }
            }
            $user->save();
            if($this->request->has('interests')){
                $user->interests()->attach(explode(',', $this->request->get('interests')));
           
            Auth::login($user);
            return redirect()->route('landing')->with('success_register','Thanks for joining');
        }
    }

    private function create_folder($id)
    {
        $path = base_path('../').DIRECTORY_SEPARATOR.'uploads';
        if(!realpath($path)){
            mkdir($path,0777);
        }
        $path .= DIRECTORY_SEPARATOR.'photos';
        if(!realpath($path)){
            mkdir($path, 0777);
        }
        $path .= DIRECTORY_SEPARATOR.$id;
        if(!realpath($path)){
            mkdir($path, 0777);
        }
        return $path;
    }

    public function register()
    {
        $interests = Interest::orderBy('id','DESC')->get();
        $geoip = geoIP2();
        $seo_title = 'Register';
        return view('register', compact('interests','geoip', 'seo_title'));
    }

    public function facebook()
    {
        try {
            $facebook = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID', '681485032653893'),
                'app_secret' => env('FACEBOOK_SECRET', '208af61fa5ab36985a981ad75baf2973'),
                'default_graph_version' => 'v3.2',
                'persistent_data_handler' => new DatingPersistentDataHandler()
            ]);
            $helper = $facebook->getRedirectLoginHelper();
            $loginUrl = $helper->getLoginUrl(route('loginfacebookcallback'), ['email']);
            return redirect()->to($loginUrl);
        } catch (FacebookSDKException $e) {
            return redirect()->route('home');
        }

    }

    public function facebookcallback()
    {
        try {
            $facebook = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID', '681485032653893'),
                'app_secret' => env('FACEBOOK_SECRET','208af61fa5ab36985a981ad75baf2973'),
                'default_graph_version' => 'v3.2',
                'persistent_data_handler' => new DatingPersistentDataHandler()
            ]);
            $helper = $facebook->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();
            $graph = $facebook->get("/me?fields=name,email", $accessToken);
            $info = $graph->getGraphUser();
            $checkExist = User::where('email', $info['email'])->first();
            if ($checkExist) {
                if(!$checkExist->fb_id){
                    $checkExist->fb_id = $info['id'];
                    $checkExist->save();
                }
                Auth::login($checkExist);
                $user = Auth::user();
                $id = $user->id;
                $input['status'] = 'Online';
                  User::where('id',$id)->update($input);
                return redirect()->route('landing');
            } else {
                $newuser = new User;
                $newuser->email = $info['email'];
                $newuser->firstname = $info['name'];
                $username = $info['name'];
                $username = str_replace(' ', '', $username);
                $username = strtolower($username);
                $newuser->username = $username;
                $newuser->fb_id = $info['id'];
                $newuser->status = "Online";
                $newuser->avatar = 'http://graph.facebook.com/'.$info['id'].'/picture?type=large';
                $newuser->password = Hash::make(Str::random(10));
                $newuser->save();
                Auth::login($newuser);
                return redirect()->route('setting');
            }
        }
        catch (\Exception $e){
            return redirect()->route('home');
        }
    }

    public function twitter()
    {
        $connection = new TwitterOAuth(
            env('TWITTER_KEY','z53nWm9fXiwLtYc5nU3hkfW4B'),
            env('TWITTER_SECRET','GCVCS0val3qmTGegSmVj7p5gqIOZoIkEoO3SX6eTRJkEg7htYe')
        );
        try{
            $request_token = $connection->oauth('oauth/request_token',['oauth_callback'=>route('logintwittercallback')]);
            session()->put('TWITTER_LOGIN_TOKEN', $request_token['oauth_token']);
            session()->put('TWITTER_LOGIN_TOKEN_SECRET', $request_token['oauth_token_secret']);
            if($connection->getLastHttpCode() == 200){
                $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
                return redirect()->to($url);
            }
        }
        catch (\Exception $e){
            return redirect()->route('home');
        }
    }

    public function twittercallback()
    {
        if(session()->has('TWITTER_LOGIN_TOKEN') && session()->has('TWITTER_LOGIN_TOKEN_SECRET')){
            $connection = new TwitterOAuth(
                env('TWITTER_KEY','z53nWm9fXiwLtYc5nU3hkfW4B'),
                env('TWITTER_SECRET','GCVCS0val3qmTGegSmVj7p5gqIOZoIkEoO3SX6eTRJkEg7htYe'),
                session()->get('TWITTER_LOGIN_TOKEN'),
                session()->get('TWITTER_LOGIN_TOKEN_SECRET')
            );
            session()->forget('TWITTER_LOGIN_TOKEN');
            session()->forget('TWITTER_LOGIN_TOKEN_SECRET');
            if($this->request->has('oauth_verifier')) {
                $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $this->request->get('oauth_verifier')]);
                $connection = new TwitterOAuth(
                    env('TWITTER_KEY', 'z53nWm9fXiwLtYc5nU3hkfW4B'),
                    env('TWITTER_SECRET', 'GCVCS0val3qmTGegSmVj7p5gqIOZoIkEoO3SX6eTRJkEg7htYe'),
                    $access_token['oauth_token'],
                    $access_token['oauth_token_secret']
                );

                $user = $connection->get('account/verify_credentials', ['include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true']);
                
                $checkExist = User::where('email', $user->email)->first();
                if ($checkExist) {
                    if(!$checkExist->twitter_id){
                        $checkExist->twitter_id = $user->id;
                        $checkExist->save();
                    }
                    Auth::login($checkExist);
                    $user = Auth::user();
                    $id = $user->id;
                    $input['status'] = 'Online';
                      User::where('id',$id)->update($input);
                    return redirect()->route('landing');
                } else {
                  $newuser = new User;
                  $newuser->email = $user->email;
                  $newuser->firstname = $user->name;
                  $newuser->twitter_id = $user->id;
                  $newuser->username = $user->screen_name;
                  $newuser->status = "Online";
                  $newuser->avatar = str_replace('_normal', '', $user->profile_image_url);
                  $newuser->password = Hash::make(Str::random(10));
                  $newuser->save();
                    Auth::login($newuser);
                    return redirect()->route('setting');
                }
            }
            else return redirect()->route('home');
        }
        else return redirect()->route('home');
    }

    public function setting()
    {
        if(\auth()->check()){
            $user = \auth()->user();
            $seo_title = 'Setting';
            $interests = Interest::all();
            $page_title = 'User Setting';
            return view('users.setting', compact('user', 'seo_title', 'page_title', 'interests'));
        }
        return redirect()->route('home');
    }

    public function postSetting()
    {
    //  return $this->request->all();
     
        if(\auth()->check()){
            $user_id = \auth()->id();
            $validator = Validator::make($this->request->all(), [ 
                'day' => 'required',
                'month' => 'required',
                'year' => 'required',
                'interests' => 'required',
                'preference' => 'required',
                'gender' =>  'required',
                'country' =>  'required',
                'address' =>  'required'
            ],
            [
                'username.required' => __('Username fields is required!'), 
                'username.unique' => __('Username already taken!'), 
                'interests.required' => __('Interests fields is required!'), 
                'day.required' => __('Day fields is required!'), 
                'month.required' => __('Month fields is required!'), 
                'year.required' => __('Year fields is required!'), 
                'preference.required' => __('Preference fields is required!'), 
                'gender.required' => __('Gender fields is required!'), 
                'country.required' => __('Country fields is required!'), 
                'address.required' => __('Address fields is required!'), 
            ]);
        
            if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
             }
            
          
                $birthday = $this->request->year.'-'.$this->request->month.'-'.$this->request->day;
                if(Carbon::parse($birthday)->age < setting('min_age')){
                    return redirect()->back()->with('error_msg', 'Sorry, only persons over the age of '.setting('min_age').' may enter this site')->withInput();
                }
                elseif($this->request->has('password') && !empty($this->request->password) && mb_strlen($this->request->password) < 6){
                    return redirect()->back()->with('error_msg', 'The password must be at least 6 characters')->withInput();
                }
                else{
                    $user = User::with('interests')->where('id', $user_id)->first();
                    $user->gender = $this->request->get('gender');
                    $user->birthday =   $birthday ;
                    $user->preference = $this->request->get('preference');
                    if($this->request->has('firstname')){
                        $user->firstname = $this->request->get('firstname');
                    }
                    if($this->request->has('lastname')){
                        $user->lastname = $this->request->get('lastname');
                    }
                    if($this->request->has('distance')){
                        $user->distance = $this->request->get('distance');
                    }
                    if($this->request->has('username')){ 
                        $user->username = Str::lower($this->request->get('username'));
                    }
                    if($this->request->has('about')){
                        $user->about = $this->request->get('about');
                    }
                    if($this->request->has('min-age')){
                        $user->min_age = $this->request->get('min-age');
                    }
                    if($this->request->has('max-age')){
                        $user->max_age = $this->request->get('max-age');
                    }

                    if($this->request->has('lat')){
                        $user->lat = $this->request->get('lat');
                    }
                    if($this->request->has('lng')){
                        $user->lng = $this->request->get('lng');
                    }
                    if($this->request->has('password') && !empty($this->request->password)){
                        $user->password = Hash::make($this->request->password);
                    }
                    $user->first_login = 0;
                    $user->country = $this->request->get('country');
                    $user->address = $this->request->get('address');
                    if($this->request->hasFile('avatar')){
                        $avatar = $this->request->file('avatar');
                        if(in_array($avatar->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                            $filename = md5($user->username.time()).time();
                            $tempFile= $avatar->getPathname();
                            $targetPath = $this->create_folder($user->id);
                            $targetFile = $targetPath.DIRECTORY_SEPARATOR.$filename.'.'.$avatar->getClientOriginalExtension();
                            $file = compress_image($tempFile, $targetFile, 100);
                            $size = getimagesize($tempFile);
                            $nw = $nh = 600;
                            $x = (int) $this->request->get('x');
                            $y = (int) $this->request->get('y');
                            $w = (int) $this->request->get('w') ? $this->request->get('w') : $size[0];
                            $h = (int) $this->request->get('h') ? $this->request->get('h') : $size[1];
                            $data = file_get_contents($tempFile);
                            $vImg = imagecreatefromstring($data);
                            $dstImg = imagecreatetruecolor($nw, $nh);
                            imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh,$w, $h);
                            imagejpeg($dstImg, $targetFile);
                            imagedestroy($dstImg);
                            $user->avatar = 'uploads/photos/'.$user->id.'/'.$filename.'.'.$avatar->getClientOriginalExtension();
                        }
                    }
                    $user->save();
                    if($this->request->has('interests')){
                        $user->interests()->detach();
                        $user->interests()->attach(explode(',', $this->request->get('interests')));
                    }
                    return redirect()->route('setting')->with('success_msg', 'Updated profile successfully');
             
            }
        }
        else return redirect()->route('home');
    }


    public function logout()
    {
      $user = Auth::user();
      $id = $user->id;
      $input['status'] = 'Offline';
      $input['logout_time'] = Carbon::now();
        User::where('id',$id)->update($input);
        Auth::logout();
        return redirect()->route('home');
    }

    public function profile($username)
    {
        $user = User::with('photos','interests')->where('username',Str::lower($username))->first();

        if($user) {
            $seo_title = \Str::ucfirst($username);
            $nextuser = User::where('id','>', $user->id)->orderBy('id')->first();  
            return view('users.profile',compact('seo_title', 'user', 'nextuser'));
        }
        else{
            abort(404);
        }
    }

    public function custome()
    {
        return view('custome');
    }
}
