<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('Location: ../../admin/login.php?lmsg=true');
    exit;
}

// Include the config file
require_once('../../admin/config.php');

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Verify if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        $errorMessage = "New password and confirm password do not match.";
    } else {
        // Get the user ID from the session
        $userId = $_SESSION['id'];

        // Check if the old password matches the one in the database
        $query = "SELECT `password` FROM `tbl_users` WHERE `id` = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashedPassword);
        mysqli_stmt_fetch($stmt);

        // Verify the old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Generate a new hashed password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Free the result set
            mysqli_stmt_free_result($stmt);

            // Update the password in the database
            $updateQuery = "UPDATE `tbl_users` SET `password` = ? WHERE `id` = ?";
            $updateStmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "si", $newHashedPassword, $userId);

            if (mysqli_stmt_execute($updateStmt)) {
                // Password updated successfully
                $successMessage = "Password updated successfully.";
            } else {
                $errorMessage = "Error updating password. Please try again.";
            }

            mysqli_stmt_close($updateStmt);
        } else {
            $errorMessage = "Incorrect current password.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Change Password</title>
    <link rel="stylesheet" href="../assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3>Change your password <span class="float-right"><a href="#" class="btn btn-primary" onclick="goBack()">Back</a></span></h3>
            <script>
                function goBack() {
                    history.back();
                }
            </script>
        </div>
        <div class="card-body">
            <div style="width:600px; margin:0px auto">
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php endif; ?>
                <?php if (isset($successMessage)) : ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                <?php endif; ?>
                <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="old_password">Current Password</label>
                        <input type="password" name="old_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="changepass" class="btn btn-success">Change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>