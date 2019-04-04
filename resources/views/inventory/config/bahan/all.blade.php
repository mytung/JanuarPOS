@extends('master')
@section('content')
<div class="container py-6">
	<!-- START MODAL -->
	<h3 class="text-center">Data Bahan</h3>
	<div id="d-tambahbahan" class="dialog" data-role="dialog">
		<div class="dialog-header">
			<div class="dialog-title text-center">Tambah Bahan</div>
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
							<div class="abc input">
								<select data-role="select" name="unit">
									@foreach($units as $unit)
									<option value="{{$unit->nama}}">{{$unit->nama}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-actions text-right">
				<a href="{{route('bahan.all')}}" class="button js-dialog-close alert"><span class="mif-cancel"></span>&nbsp;Batalkan</a>
				<button type="submit" class="button primary js-dialog-close info" onclick="Metro.notify.create('This is a notify.', 'Title', {keepOpen: false});"><span class="mif-checkmark"></span>&nbsp;Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL -->

<div class="py-2" style="margin-left: 860px;">
	<button type="button" class="button button-info" onclick="Metro.dialog.open('#d-tambahbahan') ">
		<span class="mif-plus icon"></span>
	Tambah Bahan</button><br>
</div>
<table class="table striped table-border mt-4" id="example" data-role="table" data-pagination="true">
	<thead>
		<tr>
			<th class="sortable-column sort-asc text-center">Nama</th>
			<th class="sortable-column sort-asc text-center">Satuan</th>
			<th class="text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($bahans as $bahan)
		<?php $satuan = \App\Unit::where('id', $bahan->id_unit)->value('nama'); ?>
		<tr>
			<td>{{ $bahan->nama }}</td>
			<td>
				{{ $bahan->unit }}
			</td>
			<td class="text-center">
				<a href="{{route('bahan.delete', $bahan->id)}}">Delete</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection