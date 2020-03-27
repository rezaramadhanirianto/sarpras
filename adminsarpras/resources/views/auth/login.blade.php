@extends('admin.layout.auth')

@section('content')
 <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset('img/logo_text.png')}}" alt="logo" width="250px">
            </div>

            <div class="card card-warning">
              <div class="card-body">
                <h3 class="text-center text-dark">Login</h3>
                <hr>
                <!-- @if(session('error'))
                    @alert(['type' => 'danger'])
                        {{ session('error')}}
                    @endalert
                @endif -->

                <form method="POST" action="{{ route('login')}}" class="needs-validation" novalidate="">
                    @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="simple-footer">
              Kerja Project &copy; 2019 <div class="bullet"></div> Sarana & Prasarana
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
