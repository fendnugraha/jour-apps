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

        * {
            font-family: "Quicksand", sans-serif;
        }

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
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-form">
            <h4><img src="assets/img/jour-logo.png" height="64rem"> Apps <sup>by</sup> <img src="assets/img/logo-long.png" height="64rem"> &trade;</h4>
            <form action="<?= url('auth'); ?>" method="post">
                <div class="row">
                    <div class="col-sm">
                        <label for="username" class="form-label"><i class="fa-solid fa-face-smile"></i> Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="col-sm">
                        <label for="password" class="form-label"><i class="fa-solid fa-key"></i> Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mt-1">Sign in</button>
            </form>
            <p class="mt-2">Need an account? <a href="/auth/register ">Click here!</a></p>
        </div>

    </div>


    <script src="/assets/js/bootstrap.js"></script>
</body>

</html>