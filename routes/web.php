<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/show/{user_id}', function ($user_id) {
    $user = User::findOrFail($user_id);
    foreach ($user->roles as $role) {
        echo $role->name . '<br>';
    }
});

Route::get('/create/{user_id}/{role}', function ($user_id, $role) {
    $user = User::findOrFail($user_id);

    $user->roles()->save(new Role(['name' => $role]));
});

Route::get('/update/{user_id}/{role_name}', function ($user_id, $role_name) {
    $user = User::findOrFail($user_id);

    if ($user->has('roles')) {
        foreach ($user->roles as $role) {
            $role->name = $role_name;
            $role->save();
        }
    }
});

Route::get('/delete/{user_id}', function ($user_id) {
    $user = User::findOrFail($user_id);

    if ($user->has('roles')) {
        foreach ($user->roles as $role) {
            $role->delete();
        }
    }
});

Route::get('/attach/{user_id}/{role_id}', function ($user_id, $role_id) {
    $user = User::findOrFail($user_id);
    $user->roles()->attach($role_id);
});
Route::get('/detach/{user_id}/{role_id}', function ($user_id, $role_id) {
    $user = User::findOrFail($user_id);
    $user->roles()->detach($role_id);
});
Route::get('/sync/{user_id}/{role_id}', function ($user_id, $role_id) {
    $user = User::findOrFail($user_id);
    $user->roles()->sync($role_id);
});
