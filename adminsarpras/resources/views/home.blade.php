@extends('admin.layout.master')

@section('title')
    Admin | Home
@endsection

    @section('content_header')
    Dashboard
    @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                Welcome to the admin page!     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
