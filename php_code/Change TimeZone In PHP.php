******************************* Change TimeZone In Database **********************************************

open app.php file

	'timezone' => 'Asia\Kolkata',



open web file


	Route::get('/', function(){
		dd(date_default_timezone_get());
		return view('index');
	})->name('index')




Harshit Cauhan
