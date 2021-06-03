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

// SUPER ADMIN Capabilities...
Route::group(['middleware' => ['superadmin']], function(){
	// Wilayah...
	Route::get('/admin/wilayah', 'WilayahController@index');
	Route::get('/admin/wilayah/tambah', 'WilayahController@create');
	Route::post('/admin/wilayah/store', 'WilayahController@store');
	Route::get('/admin/wilayah/edit/{id}', 'WilayahController@edit');
	Route::post('/admin/wilayah/update', 'WilayahController@update');
	Route::get('/admin/wilayah/delete/{id}', 'WilayahController@delete');
	
	// Pelatihan...
	Route::get('/admin/pelatihan/wilayah/{wilayah}', 'PelatihanController@data_per_wilayah');
	
	// Mentor...
	Route::get('/admin/mentor/wilayah/{wilayah}', 'MentorController@data_per_wilayah');
	
	// Bidang...
	Route::get('/admin/bidang/umkm/{id}/wilayah/{wilayah}', 'BidangController@detail_per_wilayah');
	
	// Usaha...
	Route::get('/admin/umkm/wilayah/{wilayah}', 'UsahaController@data_per_wilayah');
	
	// KPI...
	Route::get('/admin/kpi-program/wilayah/{wilayah}', 'KpiController@data_per_wilayah');
	
	// Omset...
	Route::get('/admin/omset/tahun/{tahun}/wilayah/{wilayah}', 'OmsetController@omset_per_wilayah');
});

// SUPER ADMIN and ADMIN Capabilities...
Route::group(['middleware' => ['admin']], function(){
	// Dashboard...
	Route::get('/admin', 'PageController@index');

	// Pelatihan...
	Route::get('/admin/pelatihan', 'PelatihanController@index');
	Route::get('/admin/pelatihan/tambah', 'PelatihanController@create');
	Route::post('/admin/pelatihan/store', 'PelatihanController@store');
	Route::get('/admin/pelatihan/peserta/{id}', 'PelatihanController@detail');
	Route::get('/admin/pelatihan/edit/{id}', 'PelatihanController@edit');
	Route::post('/admin/pelatihan/update', 'PelatihanController@update');
	Route::get('/admin/pelatihan/delete/{id}', 'PelatihanController@delete');
	Route::post('/admin/pelatihan/tambah-peserta', 'PelatihanController@add_participant');
	Route::post('/admin/pelatihan/delete-peserta', 'PelatihanController@delete_participant');

	// Mentor...
	Route::get('/admin/mentor', 'MentorController@index');
	Route::get('/admin/mentor/tambah', 'MentorController@create');
	Route::post('/admin/mentor/store', 'MentorController@store');
	Route::get('/admin/mentor/mentee/{id}', 'MentorController@detail');
	Route::get('/admin/mentor/edit/{id}', 'MentorController@edit');
	Route::post('/admin/mentor/update', 'MentorController@update');
	Route::get('/admin/mentor/delete/{id}', 'MentorController@delete');
	Route::post('/admin/mentor/tambah-mentee', 'MentorController@add_mentee');
	Route::post('/admin/mentor/delete-mentee', 'MentorController@delete_mentee');

	// Bidang...
	Route::get('/admin/bidang', 'BidangController@index');
	Route::get('/admin/bidang/tambah', 'BidangController@create');
	Route::post('/admin/bidang/store', 'BidangController@store');
	Route::get('/admin/bidang/umkm/{id}', 'BidangController@detail');
	Route::get('/admin/bidang/edit/{id}', 'BidangController@edit');
	Route::post('/admin/bidang/update', 'BidangController@update');
	Route::get('/admin/bidang/delete/{id}', 'BidangController@delete');
	Route::post('/admin/bidang/tambah-umkm', 'BidangController@add_umkm');
	Route::post('/admin/bidang/delete-umkm', 'BidangController@delete_umkm');

	// Usaha...
	Route::get('/admin/umkm', 'UsahaController@index');
	Route::get('/admin/umkm/tambah', 'UsahaController@create');
	Route::post('/admin/umkm/store', 'UsahaController@store');
	Route::get('/admin/umkm/edit/{id}', 'UsahaController@edit');
	Route::post('/admin/umkm/update', 'UsahaController@update');
	Route::get('/admin/umkm/delete/{id}', 'UsahaController@delete');
	Route::post('/admin/umkm/tambah-program', 'UsahaController@add_program');
	Route::post('/admin/umkm/delete-program', 'UsahaController@delete_program');
	Route::get('/admin/umkm/foto/{id}', 'UsahaController@photo');
	Route::post('/admin/umkm/upload-foto', 'UsahaController@upload_photo');
	Route::post('/admin/umkm/delete-foto', 'UsahaController@delete_photo');

	// Omset...
	Route::get('/admin/omset/tahun/{tahun}', 'OmsetController@index');
	Route::get('/admin/omset/edit/{usaha_id}/{bulan}/{tahun}', 'OmsetController@edit');
	Route::post('/admin/omset/update', 'OmsetController@update');
	Route::get('/admin/omset/grafik', 'OmsetController@form');
	Route::get('/admin/omset/grafik/{usaha_id}/{tahun}', 'OmsetController@detail');
	Route::post('/admin/omset-per-tahun', 'OmsetController@omset_per_tahun');
	
	// KPI Program...
	Route::get('/admin/kpi-program', 'KpiController@index');
	Route::post('/admin/kpi-program/update', 'KpiController@update');

	// User...
	Route::get('/admin/user', 'UserController@index');
	Route::get('/admin/user/tambah', 'UserController@create');
	Route::post('/admin/user/store', 'UserController@store');
	Route::get('/admin/user/edit/{id}', 'UserController@edit');
	Route::post('/admin/user/update', 'UserController@update');
	Route::get('/admin/user/delete/{id}', 'UserController@delete');

	// Logout...
	Route::post('/logout', 'UserLoginController@logout');
});

// SUPER ADMIN and ADMIN Capabilities...
Route::group(['middleware' => ['guest']], function(){
	// Route::get('/', function () {
	//     return view('welcome');
	// });

	// Login...
	Route::get('/', 'UserLoginController@showLoginForm');
	Route::post('/login', 'UserLoginController@login');
});