<?php
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

// ユーザー認証関連
Route::get('/login', 'UserController@loginForm')->name('login');        // 管理ユーザーログイン画面
Route::post('/login', 'UserController@login')->name('login.post');            // ログイン処理
Route::get('/register', 'UserController@registerForm')->name('register');   // 管理ユーザー新規登録画面
Route::post('/register', 'UserController@register')->name('register.post');      // 新規登録処理

// メニュー
Route::get('/menu', 'MenuController@index')->name('menu');              // メニュー画面
Route::post('/grades/promote', 'GradeController@promote')->name('grades.promote');      // 学年更新

// 学生関連
Route::get('/students', 'StudentController@index')->name('students.index');       // 学生表示画面（一覧）
Route::get('/students/create', 'StudentController@create')->name('students.create'); // 学生登録画面
Route::post('/students', 'StudentController@store')->name('students.store');      // 学生登録処理
Route::get('/students/{id}', 'StudentController@show')->name('students.show');   // 学生詳細表示画面
Route::get('/students/{id}/edit', 'StudentController@edit')->name('students.edit'); // 学生編集画面
Route::put('/students/{id}/update', 'StudentController@update')->name('students.update'); // 学生編集処理
Route::delete('/students/{id}', 'StudentController@destroy')->name('students.destroy'); // 学生削除

// 成績関連
Route::get('/grades/create/{student_id}', 'GradeController@create')->name('grades.create'); // 成績追加画面
Route::post('/grades/store', 'GradeController@store')->name('grades.store');       // 成績登録処理
Route::get('/grades/{id}/edit', 'GradeController@edit')->name('grades.edit');     // 成績編集画面
Route::put('/grades/{id}/update', 'GradeController@update')->name('grades.update'); // 成績編集処理