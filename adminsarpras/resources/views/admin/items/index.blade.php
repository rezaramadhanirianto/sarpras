 @extends('admin.layout.master')

@section('title')
Admin | Item
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="">Dashboard</a></div>
<div class="breadcrumb-item active">Item</div>
@endsection


@section('content')
<div class="col-md-12">
	@card(['type' => 'warning'])
		<div class="row">
			<div class="col-md-6">
				<h3>Data Barang</h3>
			</div>
			<div class="col-md-6">
				<a href="{{ route('items.create')}}" class="btn btn-md btn-primary float-sm-right">
					<i class="ion-plus"></i>
				</a>
			</div>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table table-hover table-striped" id="table-2">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama Barang</th>
						<th>No Ruangan</th>
						<th>Status</th>
						<th>Total</th>
						<th>Satuan</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($items as $row)
					<tr>
						<td>
							
							<button type="button" class="btn-icon btn camera" data-name="{{$row->item}}" data-image="{{asset('upload/'.$row->image)}}" data-toggle="modal" data-target="#exampleModal">
								<i class="fas fa-camera"></i>
							</button>
							
						</td>
						<td>{{ $row->item }}</td>
						<td>{{ $row->roomItem->room->room }}</td>
						<td>{{ $row->status }}</td>
						<td>{{ $row->roomItem->total }}</td>
						<td>{{ $row->satuan->satuan }}</td>
						<td>
							<a href="{{ route('items.show', $row->id)}}" class="btn btn-sm btn-outline-dark">Detail</a>
							<!-- End Modal -->
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endcard
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 id="nama_item"></h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<img src="" alt="Responsive Image" class="img-fluid" id="image">
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal -->
	</div>
<script>
	
	$('.camera').click(function () {
		$('.modal ').insertAfter($('body'));
		var image = $(this).data('image');	
		var nama_barang = $(this).data('name');
		$('modal-header #nama_item').val( nama_barang );
		$('#image').attr('src', $(this).data('image'));
	})
	$('.generate').click(function () {
		
		$('.modal ').insertAfter($('body'));
		$('#QrModal' + $(this).data('id')).modal(true);
		
	})


</script>
@endsection

