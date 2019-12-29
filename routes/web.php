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

use App\Zodiac;
use Illuminate\Support\Facades\Gate;
use Telegram\Bot\Laravel\Facades\Telegram;

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (Gate::allows('horoscopes')) {
            $url = route('horoscope.index');
        } elseif (Gate::allows('clients')) {
            $url = route('clients.index');
        } elseif (Gate::allows('chats')) {
            $url = route('chats.index');
        } elseif (Gate::allows('templates')) {
            $url = route('templates.index');
        } elseif (Gate::allows('users')) {
            $url = route('users.index');
        } elseif (Gate::allows('rules')) {
            $url = route('rules.index');
        }

        return redirect($url);
    })->name('index');

    Route::get('/test/{email}', 'IndexController@test');

    Route::prefix('horoscope')->name('horoscope.')->middleware('can:horoscopes')->group(function () {
        Route::get('/', 'HoroscopeController@index')->name('index');
        Route::any('next', 'HoroscopeController@next')->name('next');
        Route::post('upload', 'HoroscopeController@upload')->name('upload');
        Route::get('info', 'HoroscopeController@info')->name('info');
    });

    Route::prefix('templates')->name('templates.')->middleware('can:templates')->group(function () {
        Route::get('/', 'TemplateController@index')->name('index');

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::any('create', 'ChatTemplateController@create')->name('create');
            Route::any('update/{template}', 'ChatTemplateController@update')->name('update');
            Route::get('delete/{template}', 'ChatTemplateController@delete')->name('delete');
            Route::post('sort', 'ChatTemplateController@sort')->name('sort');
        });

        Route::prefix('push')->name('push.')->group(function () {
            Route::any('create', 'PushTemplateController@create')->name('create');
            Route::any('update/{template}', 'PushTemplateController@update')->name('update');
            Route::get('delete/{template}', 'PushTemplateController@delete')->name('delete');
            Route::post('sort', 'PushTemplateController@sort')->name('sort');
        });
    });

    Route::prefix('clients')->name('clients.')->middleware('can:clients')->group(function () {
        Route::get('/', 'ClientController@index')->name('index');
        Route::get('export', 'ClientController@export')->name('export');
    });

    Route::prefix('rules')->name('rules.')->middleware('can:rules')->group(function () {
        Route::get('/', 'RuleController@index')->name('index');
        Route::any('view/{rule}', 'RuleController@view')->name('view');
    });

    Route::prefix('users')->name('users.')->middleware('can:users')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::any('create', 'UserController@create')->name('create');
        Route::any('update/{user}', 'UserController@update')->name('update');
        Route::get('delete/{user}', 'UserController@delete')->name('delete');
    });

    Route::prefix('push')->name('push.')->group(function () {
        Route::get('log', function () {
            $contents = file_get_contents(storage_path('logs/push.log'));

            //return \Storage::url('logs/push.log');
            return str_replace("\n", "<br>", $contents);
        })->name('log');
    });

    Route::get('info', function () {
        phpinfo();

        //dd(Telegram::getUpdates());

        //Telegram::sendChatAction([
        //    'chat_id' => "-329613465",
        //    'action' => 'typing'
        //]);

        //Telegram::sendMessage([
        //    'chat_id' => '-329613465',
        //    'text' => 'Hi!✋ I am a Hora bot. It would be my pleasure to help you!😊 For now I will be only warning you if I\'ll found out that the horoscopes are not ready for tomorrow. But I can learn to do something new!)🤓 If you\'ll have an idea how else I could be helpful please write it to Nikita🤙',
        //]);
    });
});

Route::prefix('chats')->name('chats.')->middleware('can:chats')->group(function () {
    Route::get('/', 'ChatController@index')->name('index');
    Route::any('view/{chat}', 'ChatController@view')->name('view');
});

