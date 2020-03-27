@extends('admin.layout.master')
@section('title')
Admin | Users
@stop
@section('breadcrumb')
<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
<div class="breadcrumb-item active">Users</div>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @card(['type' => 'info'])
        <h3>Data Akun</h3>
        <hr>
        <div class="table-reponsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Ruangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @php $no = 1; @endphp
                    @foreach($users as $user) 
                        <tr>
                            <td>{{ $no++}} </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->room_id == null)
                                Tidak Memegang Ruangan
                                @else
                                {{ $user->room->room}}
                                @endif
                            </td>
                            <td>
                                @if($user->status == "0")
                                    <button class="btn btn-success approved" data-id="{{ $user->id }}">Aktifkan akun</button>
                                @else
                                    <button class="btn btn-default approved" data-id="{{ $user->id }}">Nonaktifkan akun</button>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn btn-sm btn-info edit" data-id="{{ $user->id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                 <form action="{{ route('user.destroy', $user->id )}}" method="POST">
                                     @csrf @method('DELETE')
                                     <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                 </form>   
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        @endcard
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-user') }}" method="post">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name : </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email : </label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="ruangan">Ruangan : </label>

                        <select name="ruangan" id="ruangan" class="form-control">
                            @foreach($rooms as $room)
                            <option value="{{ $room->id}}">{{ $room->room}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>

    $('.approved').click(function () { 
        var id  = $(this).data('id');
        var ini = $(this);
        $.ajax({
            type: "GET",
            url: "user/approved/" + id,
            dataType: "json",
            success: function (response) {                
                if (response == 1) {
                    ini.addClass('btn-default');
                    ini.removeClass('btn-success');
                    ini.text("Nonaktifkan akun");
                }else{
                    ini.removeClass('btn-default');
                    ini.addClass('btn-success');
                    ini.text("Aktifkan akun");
                }
            }
        });
        
    });
        $('.edit').click(function () { 
            var id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "user/" + id + "/edit",
                dataType: "json",
                success: function (response) {
                    $("#id").val(response[0].id);
                    $("#name").val(response[0].name);
                    $("#email").val(response[0].email);
                    $("#ruangan option[value=" + response[0].room_id + "]").attr('selected', 'selected');
                    
                }
            });
            $('.modal ').insertAfter($('body'));
            $('#exampleModal').modal(true);
            
            
        });
    </script>
@stop
