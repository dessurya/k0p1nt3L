<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontController@home')
	->name('main.home');

Route::get('/about-company', 'FrontController@about')
	->name('main.about');
Route::get('/certification-call-list', 'FrontController@certificationCallList')
	->name('main.certification.cl');

Route::get('/news-event', 'FrontController@newsevent')
	->name('main.newsevent');
Route::get('/news-event-call-list', 'FrontController@newseventCallList')
	->name('main.newsevent.cl');

Route::get('/news-event/{slug}', 'FrontController@newseventView')
	->name('main.newsevent.view');

Route::get('/portofolio', 'FrontController@portofolio')
	->name('main.portofolio');
Route::get('/portofolio/{slug}', 'FrontController@portofolioGaleri')
	->name('main.portofolio.galeri');
Route::get('/portofolio/{slug}/call-list', 'FrontController@portofolioGaleriCallList')
	->name('main.portofolio.galeri.cl');

Route::get('/career', 'FrontController@career')
	->name('main.career');
Route::get('/career-call-list', 'FrontController@careerCallList')
	->name('main.career.cl');

Route::get('/contact', 'FrontController@contact')
	->name('main.contact');
Route::post('/contact/send-message', 'FrontController@sendMessage')
	->name('main.contact.send');

Route::get('locale/{lang}', function($lang){ // test nya pada dashboard
	if(in_array($lang,array('id', 'en'))){
		session()->put('locale', $lang);
	}
	else{
		session()->put('locale', 'id');
	}
	return back();
})->name('locale.change');

Route::prefix('administrator')->group(function(){

	// new user default
		Route::get('adduser', function(){
			$confirmation_code = str_random(30).time();
			$user = new App\Models\Administrator;
			$user->name = 'adam';
			$user->email = 'fourline66@gmail.com';
			$user->confirmed = 'Y';
			$user->login_count = 0;
			$user->password = Hash::make('asdasd');
			$user->confirmation_code = $confirmation_code;
			$user->save();
			// dd('succes');
			return redirect()
				->route('adm.auth.login.from', ['mail' => 'fourline66@gmail.com'])
				->with('notif', 'success to add adam');
		});

		Route::get('addlogs', function(){
			for($a=0; $a<=4; $a++){
				$logs = new App\Models\AdministratorLogs;
				$logs->administrator_id = 2;
				$logs->logs = 'El snort testosterone trophy driving gloves handsome gerry Richardson helvetica tousled street art master testosterone trophy driving gloves handsome gerry Richardson';
				$logs->save();
			}
			dd('succes');
		});

		Route::get('addinbox', function(){
			for($a=0; $a<=4; $a++){
				$inbox = new App\Models\Inbox;
				$inbox->name = 'bubud';
				$inbox->email = 'budbud@gmail.com';
				$inbox->message = 'percobaan input data';
				$inbox->save();
			}
			dd('succes');
		});
	// new user default

	// auth
		Route::get('login', 'Administrator\Auth\LoginController@loginForm')
			->name('adm.auth.login.from');
		Route::post('login/action', 'Administrator\Auth\LoginController@loginAction')
			->name('adm.auth.login.action');
	// auth

	// Middleware Auth
		Route::middleware('administrator')->group(function(){

			Route::post('logout', 'Administrator\Auth\LoginController@logout')
				->name('adm.auth.logout.action');

			Route::get('dashborad', 'Administrator\DashboardController@index')
				->name('adm.mid.dashboard');

			Route::prefix('account')->group(function(){
				Route::get('me', 'Administrator\AccountController@profile')
					->name('adm.mid.account.me');
				Route::get('me/logs', 'Administrator\AccountController@meLogs')
					->name('adm.mid.account.me.logs');
				Route::post('me/update', 'Administrator\AccountController@profileUpdate')
					->name('adm.mid.account.me.update');

				Route::post('add', 'Administrator\AccountController@add')
					->name('adm.mid.account.add');
					
				Route::get('list', 'Administrator\AccountController@list')
					->name('adm.mid.account.list');
				Route::get('list/data', 'Administrator\AccountController@listData')
					->name('adm.mid.account.list.data');
				Route::get('list/data/{action}', 'Administrator\AccountController@listDataAction')
					->name('adm.mid.account.list.data.action');

				Route::get('logs', 'Administrator\AccountController@logs')
					->name('adm.mid.account.logs');
				Route::get('logs/list', 'Administrator\AccountController@logsList')
					->name('adm.mid.account.logs.list');
			});

			Route::prefix('inbox')->group(function(){
				Route::get('{index}', 'Administrator\InboxController@index')
					->name('adm.mid.inbox');
				Route::get('{index}/data', 'Administrator\InboxController@data')
					->name('adm.mid.inbox.data');
				Route::get('action/{id}', 'Administrator\InboxController@action')
					->name('adm.mid.inbox.action');
			});

			Route::prefix('content')->group(function(){
				Route::get('{index}', 'Administrator\ContentController@index')
					->name('adm.mid.content');
				Route::get('{index}/data', 'Administrator\ContentController@data')
					->name('adm.mid.content.data');

				Route::post('portofolio-galeri/form', 'Administrator\ContentController@StorePortofolioGaleri');

				Route::get('{index}/form', 'Administrator\ContentController@openForm')
					->name('adm.mid.content.form');
				Route::post('{index}/form', 'Administrator\ContentController@openFormStore')
					->name('adm.mid.content.form.store');


				Route::get('{index}/action', 'Administrator\ContentController@action')
					->name('adm.mid.content.action');
			});

		});
	// Middleware Auth
});