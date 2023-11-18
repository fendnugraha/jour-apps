<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jour Apps</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        /* * {
            font-family: "Quicksand", sans-serif;
        } */

        html,
        body,
        .container {
            height: 100vh;
        }

        body {
            background: rgb(255, 255, 255);
            background: linear-gradient(180deg, rgba(255, 255, 255, 1) 70%, rgba(255, 147, 45, 1) 95%, rgba(245, 81, 81, 1) 100%);
        }

        a {
            text-decoration: none;
            color: blue;
        }

        a:hover {
            font-weight: bold;
        }
    </style>
</head>

<body>
    @if(session()->has('login_error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Holy guacamole!</strong> {{session('login_error')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-form" style="width: 30vw">
            <h4 class="text-center"><img src="assets/img/jour-logo.png" height="74rem">
                <sup>by <img src="assets/img/logo-long.png" height="20rem"></sup>
            </h4>
            <form action="/" method="post" class="mt-3">
                @csrf
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{old('email')}}" required>
                        @error('email')
                          <div class="invalid-feedback">
                              <small>{{ $message }}</small>
                          </div>
                          @enderror
                        <label for="email">Email address</label>
                      </div>
                      <div class="form-floating">
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        @error('password')
                          <div class="invalid-feedback">
                              <small>{{ $message }}</small>
                          </div>
                          @enderror
                        <label for="password">Password</label>
                      </div>
                <button type="submit" class="btn btn-dark mt-2">Sign in</button>
            </form>
            <p class="mt-2">Need an account? <a href="/auth/register ">Click here!</a></p>
        </div>

    </div>


    <script src="/assets/js/bootstrap.js"></script>
</body>

</html>