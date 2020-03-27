@extends('admin.layout.master')

@section('title')
Admin | Item
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="">Dashboard</a></div>
<div class="breadcrumb-item active">Peminjaman</div>
@endsection

@section('content_header')
    Pengembalian Barang
@endsection

@section('content')

<div class="col-md-12">
	@card(['type' => 'info'])
		<div class="row">
			<div class="col-md-6">
				<h3>Data Pengembalian</h3>
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
						<th>Total</th>
                        <th>Status</th>
                        <th>Peminjam</th>
						<th>Tanggal</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
                    @php $no = 1; @endphp
                    @foreach($returned as $r)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $r->borrowed->roomitem->item->item }}</td>
                        <td>{{ $r->borrowed->roomitem->room->room }}</td>
                        <td>{{ $r->borrowed->quantity }}</td>
                        @if($r->status_item == 1)
                            <td>Baik</td>
                        @else
                            <td>Rusak</td>
                        @endif
                        <td>{{ $r->borrowed->person }}</td>
                        @php 
                            $date = explode(' ', $r->created_at);
                        @endphp
                        <td>{{ $date[0] }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary look" data-id="{{ $r->id }}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                Lihat
                            </button>
                        </td>
                    </tr>
                    @endforeach
				</tbody>
			</table>
		</div>
		@endcard

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" alt="" class="responsive-img rounded-circle" id="detail_img" style="width: 30vh !important">
                </div>
                <table class="d-flex justify-content-center">
                    <tr>
                        <td>Nama Barang </td>
                        <td>:</td>
                        <td>
                            <h5 class="mt-2" id="item"></h5>
                        </td>
                    </tr>
                    <tr>
                
                        <td>Satuan </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="satuan"></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipe </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="tipe"></h6>    
                        </td>
                    </tr>
                    <tr>
                        <td>Status </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="status"></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>Ruangan </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="ruangan"></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>Total </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="total"></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>Peminjam</td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="peminjam"></h6>
                        </td>
                    </tr>
                     <tr>
                        <td>Tanggal Peminjaman </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="tgl_peminjaman"></h6>
                        </td>
                    </tr>
                                        <tr>
                        <td>Tanggal Pengembalian </td>
                        <td>:</td>
                        <td>
                            <h6 class="mt-2" id="kembali"></h6>                            
                        </td>
                    </tr>
                </table>
            
            </div>
            <div class="modal-footer" style="margin-top: -5vh">
            </div>
        </div>
    </div>
</div>

<script>

    $('.look').click(function () {
        $('#exampleModal').insertAfter($('body'));
        $('#exampleModal').modal(true);
        var id = $(this).data('id');
        $.ajax({
            type: "get",
            url: "return/detail/" + id,
            dataType: "json",
            success: function (data) {
                $("#detail_img").attr('src', "{{asset('')}}/upload/" + data['item']['image'])
                $('#item').text(data['item']['item']);
                $('#satuan').text(data['satuan']);
                $('#tipe').text(data['tipe']);
                $('#status').text(data['item']['status']);
                $('#ruangan').text(data['room']['room']);
                $('#total').text(data['total']);
                $('#peminjam').text(data['person']);
                $('#kembali').text(data['date']);
                $('#tgl_peminjaman').text(data['tgl_pinjam']);

            }
        });

    })

</script>
@endsection

