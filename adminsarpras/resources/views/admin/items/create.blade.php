@extends('admin.layout.master')

@section('title')
Admin | Barang &mdash; Tambah Barang
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('items.index')}}">Item</a></div>
<div class="breadcrumb-item active">Create</a></div>
@endsection

@section('content')

@if(session('error'))
    @alert(['type' => 'danger'])
        {!! session('error') !!}
    @endalert
@endif

<div class="col-md-12">
	@card(['type' => 'warning'])
	<h3>Input Data Barang</h3>
	<hr>
	<form action="{{ route('items.store')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label for="">Nama Barang</label>
			<input type="text" name="item" class="form-control {{ $errors->has('item') ? 'is-invalid':''}}" value="{{ old('item')}}">
			<p class="text-danger">{{ $errors->first('item')}}</p>
		</div>

		<div class="form-group">
			<label for="">Merk Barang</label>
			<input type="text" name="merk" class="form-control {{ $errors->has('merk') ? 'is-invalid':''}}" value="{{ old('merk')}}">
			<p class="text-danger">{{ $errors->first('merk')}}</p>
		</div>
		
		<div class="form-group">
			<label for="">Tanggal Barang Masuk</label>
			<input type="date" name="tanggal_barang_masuk" class="form-control {{ $errors->has('tanggal_barang_masuk' ? 'is-invalid':'')}}" value="old('tanggal_barang_masuk')">
			<p class="text-danger">{{ $errors->first('tanggal_barang_masuk')}}</p>
		</div>

		<div class="form-group">
			<label for="">No Ruangan</label>
			<select name="room_id" id="" class="form-control {{ $errors->has('room_id') ? 'is-invalid':''}}"> 
				<option value="" disabled selected>Pilih Ruangan</option>
				@foreach($rooms as $room)
					<option value="{{ $room->id}}">{{ $room->room}}</option>
				@endforeach
				<p class="text-danger">{{ $errors->first('room_id')}}</p>
			</select>
		</div>

		<div class="form-group">
			<label for="">Status Barang</label>
			<select  name="status" class="form-control {{ $errors->has('status') ? 'is-invalid':''}}">
				<option value="" disabled selected>Pilih Status</option>
				<option value="Baik">Baik</option>
				<option value="Rusak">Rusak</option>
			</select>
			<p class="text-danger">{{ $errors->first('status')}}</p>
		</div>

		<div class="form-group">
			<label for="">Tipe Barang</label>
			<select  name="tipe_id" id="tipe_id" class="form-control {{ $errors->has('tipe_id') ? 'is-invalid':''}}">
				<option value="" disabled selected>Pilih Tipe</option>
				@foreach($tipe as $t)
					<option value="{{ $t->id }}">{{$t->tipe}}</option>
				@endforeach
				<p class="text-danger">{{ $errors->first('tipe_id')}}</p>
			</select>
		</div>

		<div class="form-group">
			<label for="">Jumlah</label>
			<input type="text" name="total" class="form-control {{ $errors->has('total') ? 'is-invalid':''}}" value="{{ old('total')}}">
			<p class="text-danger">{{ $errors->first('total')}}</p>
		</div>

		<div class="form-group">
			<label for="">Satuan Barang</label>
			<select name="satuan" id="" class="form-control {{ $errors->has('satuan') ? 'is-invalid':''}}">
				<option value="" disabled selected>Pilih Satuan Barang</option>
				@foreach($satuan as $s)
					<option value="{{ $s->id}}">{{ $s->satuan}}</option>
				@endforeach
				<p class="text-danger">{{ $errors->first('satuan')}}</p>
			</select>
		</div>
		
		<div class="form-group">
			<label for="">Foto</label>
			<input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid':''}}" value="{{ old('image')}}">
			<p class="text-danger">{{ $errors->first('image')}}</p>
			<p class="text-info">max foto dapat di 1MB</p>
		</div>
		<div class="form-group">
			<button class="btn btn-lg btn-dark" type="submit">
				<i class="fas fa-paper-plane"></i>
			</button>
		</div>
	</form>
	@endcard
</div>
@endsection
