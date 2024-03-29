<?php
session_start();

require_once('../admin/config.php');

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Use bcrypt to hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM tbl_users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $rs = mysqli_stmt_get_result($stmt);
        $getUserRow = mysqli_fetch_assoc($rs);

        if ($getUserRow) {
            if ($getUserRow['status'] == 1 && password_verify($password, $getUserRow['password'])) {
                unset($getUserRow['password']);

                $_SESSION = $getUserRow;

                header('Location: dashboard.php');
                exit;
            } elseif ($getUserRow['status'] == 0) {
                $errorMsg = "Your account is deactivated. Please contact the administrator.";
            } else {
                $errorMsg = "Wrong email or password";
            }
        } else {
            $errorMsg = "Wrong email or password";
        }
    }
}

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    session_destroy();
    header("Location: admin/login.php");
    exit;
}

if (isset($_GET['lmsg']) && $_GET['lmsg'] == true) {
    $errorMsg = "Login required to access the dashboard";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/styles1.css">
    <!-- Copied from https://icons8.com/line-awesome/howto then copy the CDN for icons  -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #212529;
        }

        .card {
            width: 450px;
        }

        .title {
            text-align: center;
            font-size: 28px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .title span {
            background-color: #0066ff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .title span:first-child {
            color: white;
        }

        .title span:last-child {
            color: white;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="title"><span>TRIPS PH</span> Admin</span></h3>
        </div>
        <div class="card-body">
            <div>
                <form class="" action="" method="post">
                    <?php if (isset($errorMsg)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorMsg; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login" class="btn btn-info">Login</button>
                        <a href="../index.php" class="btn btn-secondary">Go back to main website</a>
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