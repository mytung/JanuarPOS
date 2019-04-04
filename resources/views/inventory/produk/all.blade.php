@extends('master')
@section('content')
<div class="container py-6">
	<!-- START MODAL -->
	<h3 class="text-center">Data Produk</h3>
	<div id="d-tambahProduk" class="dialog" data-role="dialog">
		<div class="dialog-header">
			<div class="dialog-title text-center">Tambah Produk</div>
		</div>
		<form action="{{route('produk.save')}}" method="POST">
			<div class="dialog-content">
				<div class="dialog-body">
					@csrf
					<div class="dialog-body">
						<div class='p-2'>
							<div class='abc input'>
								<input type='text' data-role='input' data-prepend='Nama' placeholder='Nama Produk' data-validate='minlength=3' class=' data-role-input='true' name='nama'>
							</div>	
							<div class='abc input'>
								<select data-role="select" name="kategori">
									<option value="">Pilih Kategori</option>
									@foreach($kategoris as $kategori)
									<option value="{{$kategori->nama}}">{{$kategori->nama}}</option>
									@endforeach
								</select>
							</div>	
							<div class='abc input'>
								<input type='number' data-role='input' data-prepend='Jumlah' placeholder='Jumlah' data-validate='minlength=6' class=' data-role-input='true' name='jumlah'>
							</div>
							<div class='abc input'>
								<label class="checkbox" for="checkbox-pcs">
									<input type="checkbox" data-role="checkbox" data-caption="Checkbox" id="checkbox-pcs" class="" data-role-checkbox="true" value="Pcs" name="unit">
									<span class="check"></span>
									<span class="caption">Picis</span>
								</label>
								<label class="checkbox" for="checkbox-pck">
									<input type="checkbox" data-role="checkbox" data-caption="Checkbox" id="checkbox-pck" class="" data-role-checkbox="true" value="Pck" name="unit">
									<span class="check"></span>
									<span class="caption">Pack</span>
								</label>
								<label class="checkbox" for="checkbox-ls">
									<input type="checkbox" data-role="checkbox" data-caption="Checkbox" id="checkbox-ls" class="" data-role-checkbox="true" value="Ls" name="unit">
									<span class="check"></span>
									<span class="caption">Lusin</span>
								</label>
								<label class="checkbox" for="checkbox-bh">
									<input type="checkbox" data-role="checkbox" data-caption="Checkbox" id="checkbox-bh" class="" data-role-checkbox="true" value="Bh" name="unit">
									<span class="check"></span>
									<span class="caption">Buah</span>
								</label>
							</div>
							<div class='abc input'>
								<input type='number' data-role='input' data-prepend='Harga Beli' placeholder='Harga Beli' data-validate='minlength=5' class=' data-role-input='true' name='hargabeli'>
							</div>
							<div class='abc input'>
								<input type='number' data-role='input' data-prepend='Harga Jual' placeholder='Harga Jual' data-validate='minlength=5' class=' data-role-input='true' name='hargajual'>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-actions text-right">
				<a href="{{route('produk.all')}}" class="button js-dialog-close alert"><span class="mif-cancel"></span>&nbsp;Batalkan</a>
				<button type="submit" class="button primary js-dialog-close info" onclick="Metro.notify.create('This is a notify.', 'Title', {keepOpen: false});"><span class="mif-checkmark"></span>&nbsp;Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL -->

<div class="py-2" style="margin-left: 840px;">
	<button type="button" class="button button-info" onclick="Metro.dialog.open('#d-tambahProduk') ">
		<span class="mif-plus icon"></span>
	Tambah Produk</button><br>
</div>
<table class="table striped table-border mt-4" id="example" data-role="table" data-pagination="true">
	<thead>
		<tr>
			<th class="sortable-column sort-asc text-center">No.</th>
			<th class="sortable-column sort-asc text-center">Kode</th>
			<th class="sortable-column sort-desc text-center">Barcode</th>
			<th class="sortable-column text-center">Nama</th>
			<th class="sortable-column text-center">Kategori</th>
			<th class="sortable-column text-center">Stok</th>
			<th class="sortable-column text-center">Harga Beli</th>
			<th class="sortable-column text-center">Harga Jual</th>
			<th class="text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($produks as $produk)

		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $produk->kode }}</td>
			<td>{{ $produk->barcode }}</td>
			<td>{{ $produk->nama }}</td>
			<td>{{ $produk->kategori }}</td>
			<td>{{ $produk->jumlah }} <i>{{ $produk->unit }}</i></td>
			<td>{{ $produk->hargabeli }}</td>
			<td>{{ $produk->hargajual }}</td>
			<td class="text-center">
				<a href="#" data-nama="{{$produk->nama}}" onclick="Metro.dialog.open('#d-editProduk')">Edit</a>
				<a href="{{route('produk.delete', $produk->id)}}">Delete</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection