@extends('admin.layout.master')

@section('title')
Admin | Laporan
@stop

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashobard</a></div>
<div class="breadcrumb-item active">Laporan</div>
@stop

@section('content')

<div class="row justify-content-center">
	<div class="col-md-10">
		@card(['type' => 'warning'])
		<h3>Laporan Data Barang di Ruangan</h3>
		<hr>
		<div class="table-responsive">
			<table class="table table-hover table-striped" id="table-1">
				<thead>
					<tr>
						<th>#</th>
						<th>Nomor Ruangan</th>
						<th>Nama Penanggung Jawab</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					@php $no = 1; @endphp
					@foreach($room as $ri)

					<tr>
						<td>{{ $no++}}</td>
						<td>{{ $ri->room}}</td>
						@if($ri->user)
							<td>{{ $ri->user->name }}</td>
						@else
							<td>Tidak Ada Penanggung Jawab</td>
						@endif
						<td>
							<a href="{{ route('laporan.print', $ri->id )}}" target="_blank" class="btn btn-info">Print</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endcard
	</div>
</div>
@stop
