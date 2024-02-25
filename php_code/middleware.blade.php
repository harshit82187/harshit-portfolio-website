******************************* Create Middleware In Laravel **********************************************

1. Write Command In Terminal : php artisan make:middleware Admin


2. In Config/auth.php 

'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'admin' => [
        'drivers' => 'eloquent',
        'model'   => App\Models\Admin::class,
    ],



	'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver'  => 'session',
            'provider' => 'admin',
        ],
    ],



	'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admin' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],






3. In app/http/Middleware/Admin.php

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->user()){
            // dd("hyyy");
            return $next($request);
        }

        return redirect()->route('admin.login');
        
    }
}


4. In app/http/Middleware/Authenticate.php

<?php

namespace App\Http\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated as MiddlewareRedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.login');
    }
}



5. In app/http/Middleware/Middleware/RedirectIfAuthenticated.php

<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if($guard === 'admin'){
                    return redirect()->route('admin.login');
                }

                
            }
        }

        return $next($request);
    }
}




5. In app/Models/admin.php 

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable ,HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class);
    }
}







6. In app/http/kernal.php 


protected $middlewareAliases = [
	'auth' => \App\Http\Middleware\Authenticate::class,
	'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
	'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
	'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
	'can' => \Illuminate\Auth\Middleware\Authorize::class,
	'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
	'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
	'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
	'signed' => \App\Http\Middleware\ValidateSignature::class,
	'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
	'Admin'    => \App\Http\Middleware\Admin::class,
];




7. In web file


use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::match(['get','post'], 'login', [AdminController::class, 'check'])->name('login');

    Route::middleware(Admin::class)->group(function(){

        Route::controller(AdminController::class)->group(function (){
            Route::get('/home', 'home')->name('home');
            Route::get('/logout', 'logout')->name('logout');
        });
    });
});



8. 

public function adminlogout(){ 
    // dd('hi');
    Auth::guard('admin')->logout();
        // dd(Auth::guard('admin')->user());
    return redirect()->route('admin.loginn');

}
























------------------------------------------------------------------------
use Illuminate\Support\Facades\Auth;



public function login(Request $request){
        
    if($request->isMethod('get')){
        
        return view('users.login');
    }
    if($request->isMethod('post')){    
        
    //   dd($request->all());
    try{
            $request->validate([
                'contact' => 'required|numeric|exists:users,contact',
                'password' => 'required',
            ],[
                'contact'  => 'Enter Correct Mobile No',
            ]);
            
                $validator = $request->validate(['contact' => 'required', 'password' => 'required']);
                // dd("hy");
                
                $user = User::where('contact', $request->contact)->first();                   
                if($user->account_status == 'deactive'){                       
                    return back()->with('error','That Client Is In-Active');
                }
                // dd($user->password);
                
                if (Auth::attempt(['email' => $user->email, 'password' => $request->password])){
               
                
                // dd(Auth::User()->name);
                return redirect()->route('user.userdashboard')->with('success', 'Login Successfully');
                }else {
                    return redirect()->route('user.login')->with('error', 'Incorrect Credentials');
                }
        }catch(\Exception $e){ 
                return back()->with('error', 'Warning : ' .$e->getMessage()); }
            }
}