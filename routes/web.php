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

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('mainmenu', 'AdminController@mainmenu')->name('mainmenu');
// Route::get('master', function() {
// 	return view('master/toko.all');
// });
Route::view('a', 'modals');
Route::middleware(['superadmin'])->group(function() {
	Route::prefix('master')->group(function() {
		Route::prefix('toko')->group(function() {
			Route::get('/', 'AdminController@alltoko')->name('toko.all');
			Route::post('save', 'AdminController@savetoko')->name('toko.save');
			Route::get('edit/{id?}', function($id) {
				$a = \App\Toko::find($id);

				return Response::json($a);
			});
			Route::get('delete/{id}', 'AdminController@deletetoko')->name('toko.delete');
		});
		Route::prefix('user')->group(function() {
			Route::get('/', 'AdminController@alluser')->name('user.all');
			Route::post('save', 'AdminController@saveuser')->name('user.save');
			Route::get('delete/{id}', 'AdminController@deleteuser')->name('user.delete');
		});
	});
});
Route::middleware(['admin'] || [ 'superadmin'])->group(function() {
	Route::prefix('inventory')->group(function() {
		Route::get('/', 'AdminController@indexinventory')->name('inventory.index');
		Route::prefix('produk')->group(function() {
			Route::get('/tersedia', 'AdminController@allproduk')->name('produk.all');
			Route::get('/habis', 'AdminController@allproduk')->name('produk.habis');
			Route::post('save', 'AdminController@saveproduk')->name('produk.save');
			Route::get('delete/{id}', 'AdminController@deleteproduk')->name('produk.delete');
		});
		Route::prefix('config')->group(function() {
			Route::prefix('kategori')->group(function() {
				Route::get('/', 'AdminController@allkategori')->name('kategori.all');
				Route::post('save', 'AdminController@savekategori')->name('kategori.save');
				Route::get('delete/{id}', 'AdminController@deletekategori')->name('kategori.delete');
			});
			Route::prefix('unit')->group(function() {
				Route::get('/', 'AdminController@allunit')->name('unit.all');
				Route::post('save', 'AdminController@saveunit')->name('unit.save');
				Route::get('delete/{id}', 'AdminController@deleteunit')->name('unit.delete');
			});
			Route::prefix('bahan')->group(function() {
				Route::get('/', 'AdminController@allbahan')->name('bahan.all');
				Route::post('save', 'AdminController@savebahan')->name('bahan.save');
				Route::get('delete/{id}', 'AdminController@deletebahan')->name('bahan.delete');
			});
		});
	});
});
Route::middleware(['kasir'] || ['superadmin'])->group(function() {
	Route::prefix('pos')->group(function(){
		Route::get('/index', 'AdminController@indexpos')->name('pos.index');
		Route::get('/indexsementara', 'AdminController@indexpaymentsementara')->name('pos.paymentsementara-index');
		Route::post('pembayaran', 'AdminController@transaksi')->name('pos.transaksi');
		Route::post('/paymentsementara', 'AdminController@paymentsementarapos')->name('pos.paymentsementara');
		Route::get('/paymentsementara/delete/{id}', 'AdminController@deletepaymentsementarapos')->name('pos.deletepaymentsementara');
		Route::get('/payment/delete/{id}', 'AdminController@deletepaymentpos')->name('pos.deletepayment');
		Route::post('/payment/deletesemua', 'AdminController@deletesemuapaymentpos')->name('pos.deletesemuapayment');
		Route::post('laporan', 'AdminController@reportpaymentpos')->name('pos.reportpayment');
	});
	Route::prefix('laporan')->group(function(){
		Route::get('/barangmasuk', 'AdminController@barangmasuk')->name('barangmasuk.all');
		Route::get('/barangkeluar', 'AdminController@barangkeluar')->name('barangkeluar.all');
	});
});