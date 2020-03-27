@extends('admin.layout.master')

@section('title')
Admin | Ruangan &mdash; Ubah Penanggung Jawab
@endsection

@section('breadcrumb')
<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('rooms.index')}}">Ruangan</a></div>
<div class="breadcrumb-item active">Ubah Penanggung Jawab</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-md-5">
		@card(['type' => 'warning'])
			<h3 class="text-center">Ubah Penanggung Jawab</h3>
			<hr>
			<form action="{{ route('rooms.update', $rooms->id) }}" method="POST">
				@csrf
				@method('PUT')
				@if($user )
				<input type="hidden" name="id" value="{{ $user->id }}">
				@else
				<input type="hidden" name="id" value="0">
				@endif
				<div class="form-group text-center">
					<label for="">Ruangan</label>
					<h3>{{ $rooms->room }}</h3>
				</div>
				<div class="form-group">
					<label for="">Penanggung Jawab</label>
					<select name="user_id" id="" class="form-control" required>
						<option value="" disabled selected>Pilih</option>
						@foreach($users as $row)

							@if($row->room_id == $rooms->id)
								<option value="{{ $row->id}}" selected>{{ $row->name}}</option>
							@endif

							@if($row->room_id == "0")
								<option value="{{ $row->id}}">{{$row->name}}</option>
							@endif
						@endforeach
							<option value="0">Tidak Ada penanggung Jawab</option>
					</select>
				</div>

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