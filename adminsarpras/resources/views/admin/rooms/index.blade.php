@extends('admin.layout.master')

@section('title')
Admin | Ruangan
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
<div class="breadcrumb-item active">Ruangan</div>
@endsection

@section('content')


<div class="row">
    <div class="col-md-8">
        @card(['type' => 'warning'])
        <h3>Data Ruangan</h3>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ruangan</th>
                        <th>Penanggung Jawab</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @php $no = 1; @endphp
                    @foreach( $rooms as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->room }}</td>

                        @if($row->user)
                            <td>{{ $row->user->name}}</td>
                        @else
                            <td> Tidak ada penanggung jawab </td>
                        @endif
                        <td>
                            <form action="{{ route('rooms.destroy', $row->id )}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group">
                                @if($row->user)
                                <a href="rooms/edit/{{$row->id}}/{{$row->user->id}}" class="btn btn-sm btn-info" title="Ubah penanggung jawab"><i class="fas fa-edit"></i></a>
                                @else
                                <a href="rooms/edit/{{$row->id}}/0" class="btn btn-sm btn-info" title="Ubah penanggung jawab"><i class="fas fa-edit"></i></a>
                                @endif
                                    <button class="btn btn-sm btn-danger" title="Hapus data ruangan"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endcard
    </div>

    <div class="col-md-4">
        @card(['type' => 'warning'])
        <h3>Input Data Ruangan</h3>
        <hr>
        <form action="{{ route('rooms.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Ruangan</label>
                <input type="number" name="room" class="form-control {{ $errors->has('room') ? 'is-invalid':''}}" value="{{ old('room')}}">
                <p class="text-danger">{{ $errors->first('room')}}</p>
            </div>

            <!-- <div class="form-group">
                <label for="">Penanggung Jawab</label>
                <select name="user_id" id="" class="form-control" required>
                    <option value="" disabled selected>Pilih</option>
                    @foreach($users as $row)
                    <option value="{{ $row->id}}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div> -->

            <div class="form-group">
                <button class="btn btn-lg btn-dark">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
        @endcard
    </div>
</div>
@endsection
