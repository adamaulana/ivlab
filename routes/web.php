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

Route::get('/', 'LandingController@index');
Route::post('/reg', 'BumdesController@regis');
Route::post('/signin', 'BumdesController@login');
Route::post('/updateBumdes', 'BumdesController@updateBumdes');
Route::post('/updateFotoBumdes', 'BumdesController@updateFotoBumdes');
Route::get('/dashboard', 'BumdesController@dashboard');
Route::get('/profile', 'BumdesController@profil');
Route::get('/produkku', 'ProdukController@produkByIdBumdes');
Route::get('/sharing', 'PelatihanController@getSharingbyIdBumdes');

// Route::get('/sharing', 'BumdesController@sharing');
Route::get('/dashboard_detail_produk/{id}', 'BumdesController@detailsharing');
Route::get('/dashboard_detail_pelatihan/{id}', 'PelatihanController@detailpelatihan');
Route::get('/dashboard_detail_pelatihan_user/{id}', 'PelatihanController@detailpelatihanuser');
Route::get('/detail_pelatihan/{id}', 'BumdesController@detailpelatihanuser');
Route::get('/detail_produk/{id}', 'BumdesController@detailprodukuser');
Route::get('/detail_materi/{pelatihan}/{id}', 'BumdesController@detailmateri');
Route::get('/logout', 'BumdesController@logout');

Route::get('/login',function(){ return view('page/login');});
Route::get('/pendaftaran',function(){ return view('page/register');});
// Route::get('/shadesa',function(){ return view('page/shadesa');});
Route::get('/shadesa','ShadesaController@getProduk');
Route::get('/enroll/{id}','ShadesaController@enrollPelatihan');

// produk
Route::post('/tambahPotensi','ProdukController@uploadProduk');
Route::post('/tambahProduk','ProdukController@uploadProduk');
Route::post('/editProduk','ProdukController@editProdukBumdes');
//pelatihan
Route::post('/tambahPelatihan','PelatihanController@uploadPelatihan');
Route::post('/tambahMateri','BumdesController@tambahMateri');
Route::post('/tambahVideo','PelatihanController@tambahMateri');
Route::get('/video/{id}/{id_pelatihan}','PelatihanController@seeVideo');


// api
// Route::get('/api/getProduk', 'ShadesaController@apigetProduk');