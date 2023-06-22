<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
  header('location: ../../admin/login.php?lmsg=true');
  exit;
}

// Include the config file
require_once('../../admin/config.php');

// Check if the ID parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $userId = $_GET['id'];

  // Prepare the SQL query to fetch user details
  $sql = "SELECT u.*, r.user_role FROM `tbl_users` u INNER JOIN `tbl_user_role` r ON u.user_role_id = r.id WHERE u.id = ?";

  // Prepare and execute the statement
  $stmt = $link->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Check if user exists
  if ($result->num_rows === 1) {
    // Fetch user details
    $user = $result->fetch_assoc();
  } else {
    // User not found, redirect to user list
    header('location: ../admin/adminuser.php');
    exit;
  }
} else {
  // ID parameter not provided, redirect to user list
  header('location: ../admin/adminuser.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>View User</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="../../assets/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/styles1.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
  <div class="card">
    <div class="card-header">
      <h3 class="text-center">User Details</h3>
    </div>
    <div class="card-body">
      <div style="width:600px; margin:0px auto">
        <form class="" action="" method="post">
          <div class="form-group pt-3">
            <label for="name">Your name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="username">Your username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile']; ?>" readonly>
          </div>
          <div class="form-group">
            <div class="form-group">
              <label for="sel1">User Role</label>
              <input type="text" class="form-control" value="<?php echo $user['user_role']; ?>" readonly>
            </div>
          </div>
          <div>
            <a href="adminuser.php" class="btn btn-primary">Go Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>