@extends('admin.layout.master')

@section('title')
	Admin | Laporan Kerusakan
@stop

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></div>
<div class="breadcrumb-item active">Report</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		@card(['type' => 'warning'])
		<h3>Data Kerusakan Barang</h3>
		<hr>
		<div class="table-responsive">
			<table class="table table-hover table-striped" id="table-1">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama Barang</th>
						<th>No Ruangan</th>
						<th>Status</th>
						<th>Alasan</th>
						<th>Nama Pelapor</th>
						<th>Jumlah</th>
						<th>Aksi</th>
					</tr>
				</thead>

				<tbody>
					@foreach($report as $row)
					<tr>
						<td></td>
						<td>{{ $row->roomItem->item->item}}</td>
						<td>{{ $row->roomItem->room->room}}</td>
						<td>
							@if($row->claim == 1)
							<div class="badge badge-light">Belum Konfirmasi</div>
							@elseif($row->claim == 2)
							<div class="badge badge-success">Diterima</div>
							@elseif($row->claim == 3)
							<div class="badge badge-danger">Ditolak</div>
							@endif
						</td>
						<td class="text-center">
							@if($row->reason == null)
							-
							@else
							{{ $row->reason}}
							@endif
						</td>
						<td>{{ $row->user->name}}</td>
						<td>{{ $row->roomItem->total}}</td>
						<td>
							<form action="{{ route('report.approve', $row->id)}}" method="POST">
								@csrf
								@method('PUT')
								<div class="btn-group">
									@if($row->claim == 2)
									Tidak ada aksi
									@elseif($row->claim == 3)
									Tidak ada aksi
									@else
									<button type="submit" class="btn btn-success">Accept</button>
									<button type="button" class="btn btn-danger reject" data-id="{{ $row->id}}" data-toggle="modal" data-target="#exampleModal">
								Reject
							</button>
									@endif
								</div>
							</form>
						</td>
					</tr>
					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h3>Alasan Penolakan</h3>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="{{ route('report.update', $row->id)}}" method="POST">
										@csrf
										@method('PUT')
										<div class="form-group">
											<label for="">Alasan</label>
											<textarea name="reason" id="" cols="30" rows="10" class="form-control"></textarea>
										</div>

										<div class="form-group">
											<button class="btn btn-lg btn-dark"><i class="fa fa-paper-plane"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- End Modal -->
					@endforeach
				</tbody>
			</table>
		</div>
		@endcard
	</div>
</div>

@stop

@section('js')
<script>
	$('.reject').click(function () {
		$('.modal ').insertAfter($('body'));
		var id = $(this).data('id');

	})
</script>
@stop