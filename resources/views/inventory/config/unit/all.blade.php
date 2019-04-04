@extends('master')
@section('content')
<div class="container py-6">
	<!-- START MODAL -->
	<h3 class="text-center">Data Unit</h3>
	<div id="d-tambahunit" class="dialog" data-role="dialog">
		<div class="dialog-header">
			<div class="dialog-title text-center">Tambah Unit</div>
		</div>
		<form action="{{route('unit.save')}}" method="POST">
			<div class="dialog-content">
				<div class="dialog-body">
					@csrf
					<div class="dialog-body">
						<div class='p-2'>
							<div class='abc input'>
								<input type='text' data-role='input' data-prepend='Nama' placeholder='Nama Unit' data-validate='minlength=3' class=' data-role-input='true' name='nama'>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-actions text-right">
				<a href="{{route('unit.all')}}" class="button js-dialog-close alert"><span class="mif-cancel"></span>&nbsp;Batalkan</a>
				<button type="submit" class="button primary js-dialog-close info" onclick="Metro.notify.create('This is a notify.', 'Title', {keepOpen: false});"><span class="mif-checkmark"></span>&nbsp;Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL -->

<div class="py-2" style="margin-left: 860px;">
	<button type="button" class="button button-info" onclick="Metro.dialog.open('#d-tambahunit') ">
		<span class="mif-plus icon"></span>
	Tambah Unit</button><br>
</div>
<table class="table striped table-border mt-4" id="example" data-role="table" data-pagination="true">
	<thead>
		<tr>
			<th class="sortable-column sort-asc text-center">Nama</th>
			<th class="text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($units as $unit)
		<?php $no = 1; ?>
		<tr>
			<td>{{ $unit->nama }}</td>
			<td class="text-center">
				<a href="{{route('unit.delete', $unit->id)}}">Delete</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection