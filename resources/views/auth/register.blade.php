<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jour Apps - {{ $title }}</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <style>
        html,
        body,
        .container {
            height: 100vh;
            width: 100vw;
        }

        .reg-form {
            width: 40vw;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center gap-3">
        <div class="reg-form">
            <h1>Registrasi User</h1>
            <form action="/auth/register" method="post" class="mb-3">
                @csrf
                <div class="mb-1 row">
                    <label for="email" class="col-sm col-form-label">Email Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}">
                        @error('email')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="name" class="col-sm col-form-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="password" class="col-sm col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="">
                        @error('password')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="cpassword" class="col-sm col-form-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" id="cpassword" value="">
                        @error('cpassword')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="role" class="col-sm col-form-label">Role</label>
                    <div class="col-sm-8">
                        <select name="role" class="form-control" id="role">
                            <!-- <option value="1">Administrator</option> -->
                            <option value="2">Kasir</option>
                            <option value="3">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <span>Sudah punya akun? <a href="/">Klik untuk login!</a></span>

                </div>
            </form>

        </div>
    </div>



    <script src="/assets/js/bootstrap.js"></script>
</body>

</html>