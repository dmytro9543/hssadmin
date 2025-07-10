<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Lang;
use Auth;
use DB;
use Illuminate\Auth\Crypt;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    // use AuthenticatesAndRegistersUsers;
    use ThrottlesLogins;
    use RedirectsUsers;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';
    
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'uid' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'uid' => $data['uid'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // Login Controller

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return $this->showLoginForm();
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
        return view('auth.login', compact('nonce'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }


  
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => '', 'password' => '',
        ]);


        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        $isToken = $request->get("isToken");
        $uid = $request->get("userId");
        if($isToken == "0"){
            $password = $request->get("password", "");
            if (Auth::guard($this->getGuard())->attempt(["uid"=>$uid, "password"=> $password]))
                return $this->handleUserWasAuthenticated($request, $throttles, $isToken);
        }

        else {
            $signData = $request->get("signData");
            $cert = $request->get("cert");

            $pwd = "";
            $user_row = DB::table("users")->where("uid", '=', $uid)->get();
            if(!empty($user_row)){
                $pwd = $user_row[0]->password;
                session_start();
                $plainData = ($uid.$pwd.$_SESSION['random']);

                $ret = openssl_verify($plainData, base64_decode($signData), $cert, OPENSSL_ALGO_SHA256);
                
                //$ret = $this->verify($request, $uid, $plainData);
                if($ret==1){
                    if(Auth::guard($this->getGuard())->attempt(["password"=>$pwd])){
                        return $this->handleUserWasAuthenticated($request, $throttles, $isToken);
                    }
                }
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

        /**
     * Send the 
     *
     * @param  \Illuminate\Http\Request  $request

     * @return bool
     */
    function verify(Request $request, $uid, $plainData){
        $username = $request->get("userId");
        $requestMethod = 'POST';
        $userurl = urlencode($_SERVER['REQUEST_URI']);
        $signData = $request->get("signData");
        
        $certData = $request->get("cert");
		//echo $certData;exit();
        $policyOid = urlencode($request->get('policyoid'));

        $is= http_build_query(
            array(
                'username' => $username,
                'userurl' => $userurl,
                'requestMethod' => $requestMethod ,
                'plainData' => $plainData,
                'signData' => $signData,
                'certData' => $certData,
                'policyOid' => $policyOid
               )
        );
        $opts = array('http' =>
           array(
               'method'  => 'POST',
               'header'  => 'Content-type: application/x-www-form-urlencoded',
               'content' => $is
           )
        );

        $context  = stream_context_create($opts);
        $url = "http://172.16.37.33:8080/servercomm/certtest";

        $response = file_get_contents($url, false, $context);

        $response = json_decode($response, true);
        if (!is_array($response))
            $response = json_decode($response, true);
        if (empty($response['resp']) || $response['resp'] != 'Success'){
            return false;
        }
        return true;
    }
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles, $isToken)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
        
        /*$last_change_pwd = strtotime(Auth::user()->last_change_pwd);
        if(time() - $last_change_pwd >= 30 * 24 * 3600){
           return view("auth.register");
        }*/
        $remote_Ip = $_SERVER['REMOTE_ADDR'];
        $user_row = DB::table("users")->where("uid", "=", Auth::user()->uid)->get();
        $ip = $user_row[0]->ipAddr;
        if(!empty($ip)){
            if($ip!="" && $ip != $remote_Ip){
                return $this->sendLoginPage($request);
            }
        }
        //echo Auth::user()->uid;
        $info['uid'] = Auth::user()->uid;
        $info['ipAddr'] = $remote_Ip;
        $info['isToken'] = $isToken;
        DB::table('loginhistory')->insert($info);
        return redirect()->intended($this->redirectPath());
    }



    protected function sendLoginPage(Request $request){
        Auth::guard($this->getGuard())->logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/register')->withErrors([
                $this->loginUsername() => $this->getFailedIPAddrMessage(),
            ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::get('auth.failed');
    }

     protected function getFailedIPAddrMessage()
    {
        return 'Access denied';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        return $this->logout();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/register');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'uid';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

    // Register Controller

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $this->create($request->all());

        return redirect('/login');
        //Auth::login();

        //return redirect($this->redirectPath());
    }
}
