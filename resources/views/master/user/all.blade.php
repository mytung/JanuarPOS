@extends('master')
@section('content')
<div class="container py-6">
	<!-- START MODAL -->
	<h3 class="text-center">Data Toko</h3>
	<div id="d-tambahToko" class="dialog" data-role="dialog">
		<div class="dialog-header">
			<div class="dialog-title text-center">Tambah User</div>
		</div>
		<form action="{{route('user.save')}}" method="POST">
			<div class="dialog-content">
				<div class="dialog-body">
					@csrf
					<div class="dialog-body">
						<div class='p-2'>
							<div class='abc input'>
								<input type='text' data-role='input' data-prepend='Nama' placeholder='Nama User' data-validate='minlength=3' class=' data-role-input='true' name='nama'>
							</div>
							<div class='abc input'>
								<input type='email' data-role='input' data-prepend='Email' placeholder='Email' data-validate='minlength=6' class=' data-role-input='true' name='email'>
							</div>
							<div class='abc input'>
								<input type='password' data-role='input' data-prepend='Password' placeholder='Password' data-validate='minlength=4' class=' data-role-input='true' name='password'>
							</div>
							<div class='abc input'>
								<!-- <input type='text' data-role='input' data-prepend='Akses' placeholder='Akses' data-validate='minlength=4' class=' data-role-input='true' name='akses'> -->
								@csrf
								<select data-role="select" name="akses">
									@foreach($users as $user)
										@if($user->akses == 'SuperAdmin')
										@else
										<option value="{{$user->akses}}">{{$user->akses, $user->id}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-actions text-right">
				<a href="{{route('user.all')}}" class="button js-dialog-close alert"><span class="mif-cancel"></span>&nbsp;Batalkan</a>
				<button type="submit" class="button primary js-dialog-close info" onclick="Metro.notify.create('This is a notify.', 'Title', {keepOpen: false});"><span class="mif-checkmark"></span>&nbsp;Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL -->

<div class="py-2" style="margin-left: 860px;">
	<button type="button" class="button button-info" onclick="Metro.dialog.open('#d-tambahToko') ">
		<span class="mif-plus icon"></span>
	Tambah User</button><br>
</div>
<table class="table striped table-border mt-4" id="example" data-role="table" data-pagination="true">
	<thead>
		<tr>
			<th class="sortable-column sort-asc text-center">No.</th>
			<th class="sortable-column sort-asc text-center">Nama</th>
			<th class="sortable-column sort-desc text-center">Email</th>
			<th class="sortable-column text-center">Anggota Sejak</th>
			<th class="sortable-column text-center">Akses</th>
			<th class="text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)

		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $user->name }}</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->created_at }}</td>
			<td>{{ $user->akses }}</td>
			<td class="text-center">
				@if($user->akses == 'SuperAdmin')
                    <a class="btn btn-default disabled" href="#" data-nama="{{$user->namainstansi}}" onclick="Metro.dialog.open('#d-editUser')">Edit</a>
                    <a class="btn btn-default disabled" href="{{route('user.delete', $user->id)}}">Delete</a>

                @else
                	<a href="#" data-nama="{{$user->namainstansi}}" onclick="Metro.dialog.open('#d-editUser')">Edit</a>
                	<a href="{{route('user.delete', $user->id)}}">Delete</a>
                @endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection