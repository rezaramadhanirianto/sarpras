@extends('admin.layout.master')

@section('title')
    Admin | Tipe
@endsection
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item active">Tipe</div>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-8">
			@card(['type' => 'warning'])
			<h3>Data Jenis Barang</h3>
			<hr>
			<div class="table-responsive">
				<table class="table table-striped table-hover" id="table-1">
					<thead>
						<tr>
							<th>#</th>
							<th>Jenis Barang</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1; @endphp
						@forelse($tipe as $row)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $row->tipe}}</td>
							<td>
								<form action="{{ route('tipe.destroy', $row->id)}}" method="POST">
									@csrf
									@method('DELETE')
									<div class="btn-group">
										<a href="{{ route('tipe.edit', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
										<button class="btn btn-sm btn-danger">
											<i class="fa fa-trash"></i>
										</button>
									</div>
								</form>
							</td>
						</tr>

						@empty
						<td class="text-center" colspan="3">Tidak ada data</td>
						@endforelse
					</tbody>
				</table>
			</div>
			@endcard
		</div>

		<div class="col-md-4">
			@card(['type' => 'warning'])
			<h3>Tambah Jenis Barang</h3>
			<hr>
			<form action="{{ route('tipe.store')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="">Jenis Barang</label>
					<input type="text" name="tipe" class="form-control {{ $errors->has('tipe') ? 'is-invalid':''}}" autofocus="on">
					<p class="text-danger">{{ $errors->first('tipe')}}</p>
				</div>

				<div class="form-group">
					<button class="btn btn-lg btn-dark">
						<i class="fas fa-paper-plane"></i>
					</button>
				</div>
			</form>
			@endcard
		</div>
	</div>
@stop