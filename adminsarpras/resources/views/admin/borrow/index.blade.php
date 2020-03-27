@extends('admin.layout.master')

@section('title')
Admin | Item
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="">Dashboard</a></div>
<div class="breadcrumb-item active">Peminjaman</div>
@endsection

@section('content_header')
    Peminjaman Barang
@endsection

@section('content')
<style>
    .hide{
        display: none;
    }
</style>
<div class="col-md-12">
	@card(['type' => 'info'])
		<div class="row">
			<div class="col-md-6">
				<h3>Peminjaman Barang</h3>
			</div>
			<div class="col-md-6">
				<a href="#" id="add" class="btn btn-md btn-primary float-sm-right">
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
						<th>Total</th>
                        <th>Peminjam</th>
						<th>Tanggal</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
                @php $no = 1; @endphp
                    @foreach($borrowed as $b)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $b->roomitem->item->item }}</td>
                        <td>{{ $b->roomitem->room->room }}</td>
                        <td>{{ $b->quantity }}</td>
                        <td>{{ $b->person }}</td>
                        <td>{{ date($b->created_at) }}</td>
                        <td>
                            @if($b->returned)
                                <Button class="btn btn-secondary text-dark"> Sudah Dikembalikan </Button>
                            @else
                                <Button class="btn btn-primary edit" data-id="{{ $b->id }}">Edit</Button>
                                <Button type="submit" class="btn btn-success kembali" data-id="{{ $b->id }}">Kembalikan</Button>
                            @endif

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
                    <h3 id="title-modal">Peminjaman</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('borrow.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="room">Ruangan</label>
                            <select name="room" id="room" class="form-control">
                                <option value="" disabled selected>PILIH RUANGAN</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form">
                            <div class="form-group">
                                <label for="item">Barang</label>
                                <select name="item" id="item" class="form-control">
                                    <option value="">PILIH BARANG</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="total">Jumlah</label>
                                <input type="number" id="total" class="form-control" name="total">
                            </div>
                            <div class="form-group">
                                <label for="user">Peminjam</label>
                                <input type="text" class="form-control" id="user" name="user">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-dark"><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->

<div class="modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="title-modal">Status</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengembalian-barang') }}" method="post">
                    @csrf
                        <input type="hidden" name="id" id="idpeminjaman"> 
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Baik</option>
                                <option value="0">Rusak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
    $('.kembali').click(function () { 
        $('#firstModal').insertAfter($('body'));
        $('#firstModal').modal(true);
        var id = $(this).data('id');
        $('#idpeminjaman').val(id);
    });
    $('#form').addClass('hide');
	$('#add').click(function () {
        $('#id').val("");
        $('#title-modal').text("Tambah Peminjam") ;
        $('#form').addClass('hide');
        $('#room').val("");
        $('#item').val("");
        $("#total").val("");
        $("#user").val("");
		$('#exampleModal').insertAfter($('body'));
        $('#exampleModal').modal(true);
	})
    $("#room").change(function(){
        $('#form').addClass('hide');
        $('#item').empty();

        $.ajax({
            url: "borrow/" + $(this).val() + "/edit",
            dataType: "json",
            method: "get",
            success: function (data) {

                $('#form').removeClass('hide');
                var option = "<option value='' disabled selected>PILIH BARANG</option>";
                for (let i = 0; i < data.length; i++) {
                    option += "<option value='" + data[i]['id'] + "'>" + data[i]['item'] + "</option>"
                }
                $('#item').append(option);
            }
        })
    });
    $('.edit').click(function () {
        $('#title-modal').text("Edit Peminjam") ;
        $('#exampleModal').insertAfter($('body'));
        $('#exampleModal').modal(true);
        $.ajax({
            url: 'borrow/edit-borrowed/' + $(this).data('id'),
            dataType: "json",
            method: "get",
            success: function (data) {


                $("#item").empty();
                $('#id').val(data[0]["id"]);
                // $('#room option[value='+ data[1]["room"] +']').attr('selected', 'selected');
                $('#room').val(data[0]["room"]);
                var option = "<option value='' disabled selected>PILIH BARANG</option>";
                for (let i = 0; i < data[1].length; i++) {
                    if(data[0]["item"] == data[1][i]['id']){
                        option += "<option value='" + data[1][i]['id'] + "' selected>" + data[1][i]['item'] + "</option>"
                    }else{
                        option += "<option value='" + data[1][i]['id'] + "'>" + data[1][i]['item'] + "</option>"
                    }


                }
                $('#item').append(option);
                $('#total').val(data[0]['quantity']);
                $('#user').val(data[0]['person']);
                $('#form').removeClass('hide');

            }
        });
    });
</script>
@endsection
