@extends('admin.layout.master')

@section('title')
Admin | Satuan
@stop

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item active">Satuan</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-8">
		@card(['type' => 'warning'])
			<h3>Data Satuan Barang</h3>
			<hr>
			<div class="table-responsive">
				<table class="table table-hover table-striped" id="table-1">
					<thead>
						<tr>
							<th>#</th>
							<th>Satuan Barang</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						@php $no = 1; @endphp
						@foreach($satuan as $row)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $row->satuan }}</td>
							<td>
								<div class="btn-group">
									<a href="{{ route('satuan.edit', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
									<form action="{{ route('satuan.destroy', $row->id) }}" method="POST">
										@csrf
										@method('DELETE')
									<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endcard
	</div>
	<div class="col-md-4">
		@card(['type' => 'warning'])
			<h3 class="text-center">Tambah Satuan Barang</h3>
			<hr>
			<form action="{{ route('satuan.store')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="">Satuan Barang</label>
					<input type="text" name="satuan" class="form-control {{ $errors->has('satuan') ? 'is-invalid':''}}" autofocus="on">
					<p class="text-danger">{{ $errors->first('satuan')}}</p>
				</div>
				<div class="form-group">
					<button class="btn btn-lg btn-dark"><i class="fa fa-paper-plane"></i></button>
				</div>
			</form>
		@endcard
	</div>
</div>
@stop
