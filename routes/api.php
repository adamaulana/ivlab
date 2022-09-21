<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// BUMDES
Route::post('registrasi', 'BumdesController@apiregis');
Route::post('tugas', 'BumdesController@apitugas');
Route::post('login', 'BumdesController@apilogin');
Route::post('update', 'BumdesController@apiupdate');
Route::get('getProvinsi', 'BumdesController@getProvinsi');
Route::get('getKabupaten/{id_provinsi}', 'BumdesController@getKabupaten');
Route::get('getKecamatan/{id_kecamatan}', 'BumdesController@getKecamatan');

// Produk
Route::get('getProduk', 'ProdukController@apigetProduk');
Route::get('getProdukById/{id}', 'ProdukController@getProdukById');
Route::get('getProdukByIdBumdes/{id}', 'ProdukController@getProdukByIdBumdes');
Route::get('getProdukByKategori/{id_kategori}', 'ProdukController@getProdukByKategori');
Route::post('tambahproduk', 'ProdukController@apiuploadproduk');
Route::post('searchProduk', 'ProdukController@searchProduk');
Route::post('searchingProduk', 'ProdukController@searchingProduk');

//Master Kategori
Route::get('getKategori', 'KategoriController@getKategori');
Route::post('uploadKategori', 'KategoriController@uploadKategori');

// Pelatihan
Route::get('getPelatihan', 'PelatihanController@getPelatihan');
Route::get('getAllPelatihan', 'PelatihanController@getAllPelatihan');
Route::get('getPelatihanById/{id}', 'PelatihanController@getPelatihanById');
Route::get('getPelatihanByEnroll/{id}', 'PelatihanController@getPelatihanByEnroll');
Route::get('getDetailPelatihan/{id}', 'PelatihanController@getDetailPelatihan');
Route::get('getDetailMateri/{id_materi}', 'PelatihanController@getDetailMateri');
Route::post('enrollPelatihan', 'PelatihanController@enrollPelatihan');
Route::post('searchingPelatihan', 'PelatihanController@searchingPelatihan');