@extends('include.main')

@section('container')
    @if(session()->has('login_error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Login failed!</strong> {{session('login_error')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="container-fluid"
        style="background-image: url(/assets/img/wpp.jpg);background-repeat: no-repeat;background-size: cover;backdrop-filter: blur(15px);">
        <div class="row d-flex justify-content-center align-items-center vh-100 vw-100">
            <div class="col-lg-5">
                <div class="card"
                    style=" background-color: rgba(255, 255, 255, 0.495); border-radius: 15px;backdrop-filter: blur(5px);">
                    <div class="card-body">

                        <h1 class="text-center mb-3">Sign in to <img src="/assets/img/jour-logo.png" alt="" width="150"
                                class="">
                        </h1>
                        <form action="/" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="floatingInput"
                                    placeholder="name@example.com" name="email">
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" id="floatingPassword"
                                    placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                        </form>
                        <small class="text-muted text-center d-block">Don't have an account? <a
                                href="/auth/register">Register</a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted text-center d-block">&copy; 2023 Jour by <img src="/assets/img/logo-long.png"
                                alt="" width="60"> All rights reserved.</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection