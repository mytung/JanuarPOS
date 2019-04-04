@extends('master')
@section('content')
<div class="container py-6">
	<!-- START MODAL -->
	<h3 class="text-center">Data POS Sementara</h3>
	<div id="d-tambahbahan" class="dialog" data-role="dialog">
		<div class="dialog-header">
			
		</div>
		<form action="{{route('bahan.save')}}" method="POST">
			<div class="dialog-content">
				<div class="dialog-body">
					@csrf
					<div class="dialog-body">
						<div class='p-2'>
							<div class='abc input'>
								<input type='text' data-role='input' data-prepend='Nama' placeholder='Nama Bahan' data-validate='minlength=3' class=' data-role-input='true' name='nama'>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-actions text-right">
				<a href="{{route('bahan.all')}}" class="button js-dialog-close alert"><span class="mif-cancel"></span>&nbsp;Batalkan</a>
				<button type="submit" class="button primary js-dialog-close info"><span class="mif-checkmark"></span>&nbsp;Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL -->

<div class="py-2">
	<form action="{{route('pos.paymentsementara')}}" method="POST">
		@csrf
		<select data-role="select" name="nama">
			<option value="">Pilih Produk</option>
			@foreach($produks as $produk)
			<option value="{{$produk->nama}}">{{$produk->nama}} || Rp. {{$produk->hargajual}}</option>
			@endforeach
		</select>
		<button type="submit" class="button button-info float-right">Bayar</button><br>
	</form>
</div>
<table class="table hober table-bordered mt-4">
	<thead>
		<tr>
			<th class="sortable-column sort-asc text-center">Nama</th>
			<th class="sortable-column sort-asc text-center">Qty</th>
			<th class="sortable-column sort-asc text-center">Harga</th>
			<th class="sortable-column sort-asc text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($trans as $tran)
		<tr>
			<td>{{$tran->nama}}</td>
			<td>{{$tran->jumlah}} {{$tran->unit}}</td>
			<td>Rp. {{$tran->harga}}</td>
			<td>
				<a href="">Edit</a>
				<a href="{{route('pos.deletepaymentsementara', $tran->id)}}">Hapus</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table><br>
<form action="{{route('pos.transaksi')}}" method="POST">
	@csrf
	<h3>Total : Rp. {{$datatotal}}</h3> <input type="hidden" value="{{$datatotal}}" name="hargatotal">
	<div class="py-2">
		<button type="submit" class="button button-info float-right pembayaran-sementara" style="margin-top: -40px;">
			<span class="mif-add-shopping-cart icon"></span>
		BON</button><br><br>
	</div>
</form>
</div>
@endsection