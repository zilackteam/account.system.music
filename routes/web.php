<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::post('/login', function (Request $request) {
    $data = $request->all();
    $result = login_api($data);

    if ($result['result']) {
        session(['api_token' => $result['token']]);
        session(['user' => $result['user']]);

        return redirect()->route('charge');
    } else {
        return redirect()->route('home')->with('error', $result['message']);
    }
})->name('login');

Route::post('/login_fb', function (Request $request) {
    $data = $request->all();

    $result = login_fb_api($data);
    if ($result['result']) {
        session(['api_token' => $result['token']]);
        session(['user' => $result['user']]);

        return 1;
    } else {
        return 0;
    }
})->name('login_fb');

Route::get('/logout', function () {
    session()->forget('api_token');
    return redirect()->route('home');
})->name('logout');

Route::get('/charge', function () {
    $user = session('user');

    return view('charge', ['user' => $user]);
})->name('charge')->middleware('token');

Route::post('/charge', function (Request $request) {
    $user = session('user');

    $data = $request->all();
    $result = charge_api($data);

    if ($result['result']) {
        session(['user' => $result['user']]);
        return redirect()->route('charge')->with('success', 'Nạp thẻ thành công');
    } else {
        return redirect()->route('charge')->with('error', $result['message']);
    }

})->name('charge.store')->middleware('token');
