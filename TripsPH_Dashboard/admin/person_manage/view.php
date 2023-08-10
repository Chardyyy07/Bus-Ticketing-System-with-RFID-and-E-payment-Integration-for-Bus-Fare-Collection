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
  $sql = "SELECT * FROM `tbl_personnel` WHERE `id` = ?";

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
  <title>User Details</title>
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
            <label for="fullname">Name</label>
            <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="position" class="form-control" value="<?php echo $user['position']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="e_mail" class="form-control" value="<?php echo $user['e_mail']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="mobile">Contact</label>
            <input type="text" name="contact" class="form-control" value="<?php echo $user['contact']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" value="<?php echo $user['address']; ?>" readonly>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col text-left">
                <a href="personnel_management.php" class="btn btn-primary">Go Back</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>