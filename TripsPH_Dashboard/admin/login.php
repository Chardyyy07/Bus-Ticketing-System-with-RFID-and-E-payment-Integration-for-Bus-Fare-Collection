<?php
session_start();

require_once('../admin/config.php');

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email     = trim($_POST['email']);
        $password   = trim($_POST['password']);

        $md5Password = md5($password);

        $sql = "select * from tbl_users where email = '" . $email . "' and password = '" . $md5Password . "'";
        $rs = mysqli_query($link, $sql);
        $getNumRows = mysqli_num_rows($rs);

        if ($getNumRows == 1) {
            $getUserRow = mysqli_fetch_assoc($rs);
            unset($getUserRow['password']);

            $_SESSION = $getUserRow;

            header('location:dashboard.php');
            exit;
        } else {
            $errorMsg = "Wrong email or password";
        }
    }
}

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    session_destroy();
    header("location:admin/login.php");
    exit;
}


if (isset($_GET['lmsg']) && $_GET['lmsg'] == true) {
    $errorMsg = "Login required to access dashboard";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>

    <!-- style libraries -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>TripsPH Admin Dashboard</title>
        <link rel="stylesheet" href="../assets/styles1.css">
        <!-- Copied from https://icons8.com/line-awesome/howto then copy the CDN for icons  -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    </head>

<body class="bg-dark">
    <div class="card ">
        <div class="card-header">
            <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>User login</h3>
        </div>
        <div class="card-body">


            <div style="width:450px; margin:0px auto">

                <form class="" action="" method="post">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login" class="btn btn-success">Login</button>
                    </div>


                </form>
            </div>


        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>