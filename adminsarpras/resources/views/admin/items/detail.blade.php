@extends('admin.layout.master')

@section('title')
Admin | Detail Barang
@stop

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('items.index')}}">Item</a></div>
<div class="breadcrumb-item">Detail</div>
@stop

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		@card(['type' => 'warning'])
		<h3 class="text-center">Detail Barang</h3>
		<hr>
		<div class="row">
			<div class="col-sm-4">
				{!! QrCode::size(225)->generate($items->id); !!}
			</div>

			<div class="col-sm-8 mt-5 ">

				<table class="ml-3">
					<tr>
						<th>Nama Barang</th>
						<td>:</td>
						<td>{{ $items->item }}</td>
					</tr>
					
					<tr>
						<th>Merk Barang</th>
						<td>:</td>
						<td>{{ $items->roomItem->merk }}</td>
					</tr>

					<tr>
						<th>Tanggal Barang Masuk</th>
						<td>:</td>
						<td>{{ date('d-M-Y', strtotime($items->roomItem->tanggal_barang_masuk)) }}</td>
					</tr>

					<tr>
						<th>Status Barang</th>
						<td>:</td>
						<td>
							@if($items->status == 'Baik')
							<div class="badge badge-success">Baik</div>
							@else
							<div class="badge badge-danger">Rusak</div>
							@endif
						</td>
					</tr>

					<tr>
						<th>Ruangan</th>
						<td>:</td>
						<td>{{ $items->roomItem->room->room}}</td>
					</tr>

					<tr>
						<th>Jumlah & Satuan</th>
						<td>:</td>
						<td>{{ $items->roomItem->total }} {{ $items->satuan->satuan }}</td>
					</tr>

					<tr>
						<th>Tipe Barang</th>
						<td>:</td>
						<td>{{ $items->tipe->tipe }}</td>
					</tr>

				</table>
				<br>
				<div class="row ml-5">
					<form action="{{ route('items.destroy', $items->id)}}" method="POST">
						@csrf
						@method('DELETE')
						<a href="{{ route('items.edit', $items->id)}}" class="btn btn-md btn-info">Edit</a>
						<button class="btn btn-md btn-danger">Hapus</button>
					</form>					
				</div>
			</div>

		</div>
		@endcard
	</div>
</div>
@stop

@section('')

@stop

