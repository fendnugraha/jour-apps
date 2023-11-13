<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App POS - Register</title>
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

    <div class="container d-flex justify-content-center align-items-center gap-3">
        <div class="reg-form">
            <h1>Registrasi User</h1>
            <form action="<?= base_url('auth/register'); ?>" method="post" class="mb-3">
                <div class="mb-1 row">
                    <label for="username" class="col-sm col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username'); ?>">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="fullname" class="col-sm col-form-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="fullname" id="fullname" value="<?= set_value('fullname'); ?>">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="password" class="col-sm col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" id="password" value="<?= set_value('password'); ?>">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="cpassword" class="col-sm col-form-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="cpassword" id="cpassword" value="<?= set_value('cpassword'); ?>">
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
                    <span>Sudah punya akun? <a href="<?= base_url('auth'); ?>">Klik untuk login!</a></span>

                </div>
            </form>

        </div>
        <div>
            <?php echo validation_errors('<div class="alert alert-warning alert-dismissible fade show error" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); ?>

        </div>
    </div>



    <script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
</body>

</html>