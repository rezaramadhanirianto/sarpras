@extends('admin.layout.template')

@section('judul')
    Admin | Items
@stop

@section('content')
<!-- <img src="{{ asset('upload/1569754746_list.png') }}" alt=""> -->
    <form action="items/add" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
        <div class="form-group">
          <label for="item">Items : </label>
          <input type="text" name="item" id="item" class="form-control" placeholder="Items">
        </div>
        <div class="form-group">
          <label for="room">Room : </label>
          <input type="text" name="room" id="room" class="form-control" placeholder="Room">
        </div>
        <div class="form-group">
          <label for="status">Status : </label>
          <input type="text" name="status" id="status" class="form-control" placeholder="Status">
        </div>
        <div class="form-group">
          <label for="total">Total : </label>
          <input type="text" name="total" id="total" class="form-control" placeholder="Total">
        </div>
        <div class="form-group">
          <label for="file">Image : </label>
          <input type="file" name="file" id="file" class="form-control" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop