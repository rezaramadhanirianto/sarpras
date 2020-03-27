@extends('admin.layout.master')

@section('title')
Admin | Satuan &mdash; Edit
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('satuan.index')}}">Satuan</a></div>
<div class="breadcrumb-item active">Edit</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-md-5">
		@card(['type' => 'warning'])
			<h3 class="text-center">Edit Data Satuan</h3>
			<hr>
			<form action="{{ route('satuan.update', $satuan->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="">Satuan Barang</label>
					<input type="text" name="satuan" class="form-control {{ $errors->has('satuan') ? 'is-invalid':''}}" value="{{ $satuan->satuan}}">
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
@endsection