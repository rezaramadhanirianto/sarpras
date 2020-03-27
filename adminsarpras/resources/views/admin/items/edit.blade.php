@extends('admin.layout.master')

@section('title')
	Admin | Ubah Data Barang
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('items.index')}}">Item</a></div>
<div class="breadcrumb-item active">Edit</div>
@endsection


@section('content')
<div class="col-md-12">
	@card(['type' => 'warning'])
	<h3>Ubah Data Barang</h3>
	<hr>
	<form action="{{ route('items.update', $items->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="form-group">
			<label for="">Nama Barang</label>
			<input type="text" name="item" class="form-control {{ $errors->has('item') ? 'is-invalid':''}}"  value="{{ $items->item }}">
			<p class="text-danger">{{ $errors->first('item')}}</p>
		</div>

		<div class="form-group">
			<label for="">Merk Barang</label>
			<input type="text" name="merk" class="form-control {{ $errors->has('merk') ? 'is-invalid':''}}" value="{{ $items->roomItem->merk}}">
			<p class="text-danger">{{ $errors->first('merk')}}</p>
		</div>
		
		<div class="form-group">
			<label for="">Tanggal Barang Masuk</label>
			<input type="date" name="tanggal_barang_masuk" class="form-control {{ $errors->has('tanggal_barang_masuk' ? 'is-invalid':'')}}" value="{{ $items->roomItem->tanggal_barang_masuk}}">
			<p class="text-danger">{{ $errors->first('tanggal_barang_masuk')}}</p>
		</div>

		<div class="form-group">
			<label for="">No Ruangan</label>
			<select name="room_id" id="" class="form-control {{ $errors->has('room_id') ? 'is-invalid':''}}" >
				@foreach($rooms as $room)
				<option value="{{ $room->id}}" {{ $items->id == $items->room_id ? 'selected':''}}>{{ ucfirst($room->room) }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="">Tipe</label>
			<select name="tipe_id" id="" class="form-control" >
				@foreach($tipe as $t)
				<option value="{{ $t->id}}" {{ $t->id == $items->tipe_id ? 'selected':''}}>{{ ucfirst($t->tipe) }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="">Status Barang</label>
			<!-- <input type="textbox" value="{{ $items->status }}"> -->
			<select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid': ''}}" >
				@php $statusArray = ["Baik", "Rusak"]; @endphp
				@foreach($statusArray as $s)
					<option value="{{ $s}}" {{ $s == $items->status ? 'selected':''}}>{{ ucfirst($s) }}</option>
				@endforeach

			</select>
			<p class="text-danger">	{{ $errors->first('status')}}</p>
		</div>

		<div class="form-group">
			<label for="">Jumlah</label>
			<input type="text" name="total" class="form-control {{ $errors->has('total')}}"  value="{{ $items->roomItem->total }}">
			<p class="text-danger">{{ $errors->first('total')}}</p>
		</div>

		<div class="form-group">
			<label for="">Satuan Barang</label>
			<select name="satuan_id" id="" class="form-control">
				@foreach($satuan as $st)
					<option value="{{ $st->id }}" {{ $st->id == $items->satuan_id ? 'selected':'' }}> {{ ucfirst($st->satuan) }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="">Foto</label>
			<input type="file" name="image" class="form-control">
			<p class="text-danger">{{ $errors->first('image')}}</p>
			@if(!empty($items->image))
			<hr>
			<img src="{{ asset('upload/' . $items->image) }}" alt="{{ $items->item}}" width="200px" height="200px">
			@endif
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
