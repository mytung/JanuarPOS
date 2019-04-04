<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use App\Toko as T;
use App\User as U;
use App\Produk as P;
use App\Kategori as K;
use App\Unit as Un;
use App\Bahan as B;
use App\TransaksiSementara as Ts;
use App\TransaksiBeneran as Tb;
use PDF;

class AdminController extends Controller
{

	function mainmenu() {
		return view('mainmenu');
	}
	function alltoko(){
		$data['tokos'] = T::all();
		return view('master/toko.all', $data);
	}

	function savetoko(Request $r){
		$new = new T;
		$new->namainstansi = $r->input('nama');
		$new->telp = $r->input('telepon');
		$new->kodepos = $r->input('kodepos');
		$new->deskripsi = $r->input('deskripsi');
		$new->alamat = $r->input('alamat');

		$new->save();
		return redirect()->route('toko.all');
	}

	function deletetoko($id){
		$toko = T::find($id);
		if (isset($toko)) {
			$toko->delete();
		}else{
			echo "ada kesalahan !";
		}
		return redirect()->route('toko.all');
	}

	function alluser(){
		$data['users'] = U::all();
		$data['no'] = 1;

		return view('master/user.all', $data);
	}

	function deleteuser($id){
		$user = U::find($id);
		if (isset($user)) {
			$user->delete();
		}else{
			echo "ada kesalahann !";
		}
		return redirect()->route('user.all');
	}

	function saveuser(Request $r){
		$new = new U;
		$new->name = $r->input('nama');
		$new->email = $r->input('email');
		$new->password = Hash::make($r->input('password'));
		$new->akses = $r->input('akses');

		$new->save();
		return redirect()->route('user.all');
	}

	function indexinventory(){
		return view('inventory.index');
	}

	function allproduk() {
		$url = basename($_SERVER['REQUEST_URI']);
		// $a = P::where('jumlah', '0')->count();
		// dd($a);
		$data['no'] = 1;
		if($url == "tersedia"){
			$data['kategoris'] = K::all();
			// $data['produks'] = P::all();
			$data['produks'] = P::where('jumlah', '>', '1')->get();
			return view('inventory/produk.all', $data);
		}elseif($url == "habis"){
			$data['produks'] = P::where('jumlah', '<', '1')->get();
			// $data['produks'] = Tb::all();
			$data['kategoris'] = K::all();
			return view('inventory/produk.all', $data);
		}
	}

	function saveproduk(Request $r){
		$panjang = 10;
		$randomString = substr(str_shuffle("0123456789"), 0, $panjang);
		$new = new P;
		$new->kode = "Prd-".str_random(7);
		$new->barcode = $randomString;
		$new->nama = $r->input('nama');
		$new->kategori = $r->input('kategori');
		$new->jumlah = $r->input('jumlah');
		$new->unit = $r->input('unit');
		$new->hargajual = $r->input('hargajual');
		$new->hargabeli = $r->input('hargabeli');

		$new->save();
		return redirect()->route('produk.all');
	}

	function deleteproduk($id){
		$produk = P::find($id);
		if (isset($produk)) {
			$produk->delete();
		}else{
			echo "ada kesalahann !";
		}
		return redirect()->route('produk.all');
	}

	function allkategori(){
		$data['kategoris'] = K::all();
		return view('inventory/config/kategori.all', $data);
	}

	function savekategori(Request $r){
		$new = new K;
		$new->nama = $r->input('nama');
		$new->save();
		return redirect()->route('kategori.all');
	}

	function deletekategori($id){
		$kategori = K::find($id);
		if (isset($kategori)) {
			$kategori->delete();
		}else{
			echo "ada kesalahan !";
		}
		return back();
	}

	function allunit(){
		$data['units'] = Un::all();
		return view('inventory/config/unit.all', $data);
	}

	function saveunit(Request $r){
		$new = new Un;
		$new->nama = $r->input('nama');
		$new->save();
		return redirect()->route('unit.all');
	}

	function deleteunit($id){
		$unit = Un::find($id);
		if (isset($unit)) {
			$unit->delete();
		}else{
			echo "ada kesalahan !";
		}
		return back();
	}

	function allbahan(){
		$data['units'] = Un::all();
		$data['bahans'] = B::all();
		return view('inventory/config/bahan.all', $data);
	}

	function savebahan(Request $r){
		$new = new B;
		$new->nama = $r->input('nama');
		$new->unit = $r->input('unit');
		$new->save();
		return redirect()->route('bahan.all');
	}

	function deletebahan($id){
		$bahan = B::find($id);
		if (isset($bahan)) {
			$bahan->delete();
		}else{
			echo "ada kesalahan !";
		}
		return back();
	}

	function indexpaymentsementara() {
		// $data['produks'] = P::all();
		$data['produks'] = P::where('jumlah', '>', '1')->get();
		$data['trans'] = Ts::all();
		$kodetransaksi = uniqid(10);
		$a = Ts::all();
		$sum = 0;
		foreach ($a as $key => $value) {
			$sum = $sum + ($value->harga * $value->jumlah);
			$transaksisementara = new Ts;
			$transaksisementara->kodetransaksi = "Pos-".$kodetransaksi;
		}
		$data['datatotal'] = $sum;
		return view('pos.index', $data);
	}

	function paymentsementarapos(Request $r){
		$new = new Ts;
		if (Ts::where('nama', $r->input('nama'))->exists()) {
			$a = Ts::where('nama', $r->input('nama'))->first();
			$a->jumlah = $a->jumlah + 1;
			$a->save();
			return back();
		}
		$harga = P::where('nama', $r->input('nama'))->value('hargajual');
		$unit = P::where('nama', $r->input('nama'))->value('unit');
		$new->nama = $r->input('nama');
		$new->harga = $harga;
		$new->unit = $unit;
		$new->jumlah = "1";

		$new->save();
		return back();
	}

	function transaksi(Request $r){
		$transaksi = Ts::all();
		$transaksib['pos'] = Ts::all();
		$kodetransaksi = uniqid(10);
		foreach ($transaksi as $key => $value) {
			$barang = P::where('nama', $value->nama)->first();
			$jumlah = $barang->jumlah - $value->jumlah;
			$barang->jumlah = "".$jumlah."";
			$transaksibeneran = new Tb;
			$transaksibeneran->kodetransaksi = "Pos-".$kodetransaksi;
			$transaksibeneran->nama = $value->nama;
			$transaksibeneran->jumlah = $value->jumlah;
			$transaksibeneran->unit = $value->unit;
			$transaksibeneran->harga = $value->harga;
			$transaksibeneran->hargatotal = $r->input('hargatotal');
			
			$barang->save();
			$transaksibeneran->save();
		}
		Ts::truncate();

		$pdf = PDF::loadView('pos.pdf', $transaksib);
		return $pdf->download('transaksi.pdf');
		return back();
	}

	function deletepaymentsementarapos($id){
		$transsaksisementara = Ts::find($id);
		if (isset($transsaksisementara)) {
			$transsaksisementara->delete();
		}else{
			echo "ada kesalahan !";
		}
		return back();
	}

	function reportpaymentpos(){
		$transaksib['pos'] = Tb::all();

		$pdf = PDF::loadView('pos.pdf', $transaksib);
		return $pdf->download('transaksi.pdf');
	}

	function deletepaymentpos($id){
		$transaksibeneran = Tb::find($id);
		if (isset($transaksibeneran)) {
			$transaksibeneran->delete();
		}else{
			echo "ada kesalahan !";
		}
		return back();
	}

	function deletesemuapaymentpos(){
		Tb::truncate();
		return back();
	}

	function indexpos(){
		$data['pos'] = Tb::all();
		return view('pos.all', $data);
	}

	function barangmasuk(){
		$data['produks'] = P::all();
		return view('laporan.barangmasuk', $data);
	}

	function barangkeluar(){
		$data['produks'] = Tb::all();
		return view('laporan.barangkeluar', $data);
	}
}
