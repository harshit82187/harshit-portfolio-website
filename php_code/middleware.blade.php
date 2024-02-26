
/////////////////////////////// Run Command //////////////////////////////////////////////////////

php artisan make:middleware AdminMiddleware



////////////////////////////// app\Http\Middleware\AdminMiddleware //////////////////////////////
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 121) {
            // User is authenticated and has the required role
            return $next($request);
        }

        // Redirect to login page or show an error message
        return redirect()->route('admin.login')->with('error', 'Unauthorized access');
    }
}




//////////////////////////// app\http\kernal.php /////////////////////////////////////////////////
protected $middlewareAliases = [

  'admin'    => \App\Http\Middleware\AdminMiddleware::class,
];




///////////////////////// web.php //////////////////////////////////////////////////////////////


Route::prefix('admin')->name('admin.')->group(function (){
  Route::match(['get','post'], 'login', [AuthController::class, 'login'])->name('login');

  Route::middleware('admin')->group(function (){
      Route::controller(AuthController::class)->group(function(){
          Route::get('dashboard', 'dashboard')->name('dashboard');

          Route::get('logout', 'logout')->name('logout');        

      });
     
  });

});



