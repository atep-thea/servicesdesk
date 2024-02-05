<?php



namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;



use Auth;

use DB;

use App\User;

use Facebook;

use Session;

use Mail;

use App\Mail\ForgetPassword;

use Illuminate\Support\Facades\Log;


class LoginController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

    */



    use AuthenticatesUsers;



    /**

     * Show the application's login form.

     *

     * @return \Illuminate\Http\Response

     */

    public function showLoginForm()

    {

        return view('adminlte::auth.login');
    }



    public function showPublicLoginForm()
    {

        return view('auth.login');
    }



    public function forget_password()

    {

        return view('public.forget_password');
    }



    public function verifikasi_email($token)

    {

        return view('public.change_password', compact('token'));
    }



    

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/login';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest', ['except' => 'logout']);
    }



    public function login(Request $request)

    {



        $this->validateLogin($request);



        // If the class is using the ThrottlesLogins trait, we can automatically throttle

        // the login attempts for this application. We'll key this by the username and

        // the IP address of the client making these requests into this application.

        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);



            return $this->sendLockoutResponse($request);
        }



        $credentials = $request->only('name', 'password');

        $user = User::where('name', $credentials['name'])->first();



        if ($user) {



            if (Auth::attempt($credentials)) {

                $request->session()->regenerate();

                Log::info($user->role_user);

                $this->clearLoginAttempts($request);

                if ($user->role_user == 'Admin') {
                    return redirect()->intended('/login');
                } 
                elseif ($user->role_user == 'Helpdesk') {
                    return redirect('home');
                }
                elseif ($user->role_user == 'User') {
                    return redirect('user_portal');
                } 
                elseif ($user->role_user == 'Helpdesk Eksternal') {
                    return redirect('user_portal');
                }
            }

            $this->incrementLoginAttempts($request);



            return redirect()->back()->withErrors(['Username atau Password salah']);
        } else {

            return redirect()->back()->withErrors(['Username atau Password salah']);
        }
    }



    public function publicLogin(Request $request)

    {

        //$this->validateLogin($request);



        // If the class is using the ThrottlesLogins trait, we can automatically throttle

        // the login attempts for this application. We'll key this by the username and

        // the IP address of the client making these requests into this application.

        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);



            return $this->sendLockoutResponse($request);
        }



        $credentials = $request->only('name', 'password');

        $user = User::where('name', $credentials['name'])->first();



        if ($user) {


            if ($user->hasRole('admin'))  return redirect()->back()->with('failed', 'Username atau Password salah');



            if (Auth::attempt($credentials)) {

                $request->session()->regenerate();



                $this->clearLoginAttempts($request);



                if ($request->ajax()) return response()->json([

                    'status' => 'success'

                ], 200);



                return redirect()->route('profile.show');
            }

            return redirect()->back()->with('failed', 'Username atau Password salah');
        } else {

            //dd("abc");

            return redirect()->back()->with('failed', 'Username atau Password salah');
        }



        // If the login attempt was unsuccessful we will increment the number of attempts

        // to login and redirect the user back to the login form. Of course, when this

        // user surpasses their maximum number of attempts they will get locked out.

        $this->incrementLoginAttempts($request);



        if ($request->ajax()) return response()->json([

            'error' => 'invalid-credentials'

        ]);



        return $this->sendFailedLoginResponse($request);
    }
}
