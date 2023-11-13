<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi berhasil</title>
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.css">
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

    <div class="container d-flex justify-content-center align-items-center">
        <div class="reg-success">
            <h1 class="text-success">Perdaftaran akun berhasil !</h1>
            <p>Silahkan kembali ke halaman <a href="<?= base_url('auth'); ?>">Login</a> untuk melanjutkan.</p>


        </div>
    </div>