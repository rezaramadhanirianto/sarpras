@extends('admin.layout.master')

@section('title')
Admin | Ubah Data Tipe 
@stop

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('tipe.index')}}">Tipe</a></div>
<div class="breadcrumb-item active">Edit</div>
@stop

@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		@card(['type' => 'warning'])
		<h3>Edit Jenis Barang</h3>
		<hr>
		<form action="{{ route('tipe.update', $tipe->id) }}" method="POST">
			@csrf @method('PATCH')
			<div class="form-group">
				<label for="">Jenis Barang</label>
				<input type="text" name="tipe" class="form-control" value="{{ $tipe->tipe}}">
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