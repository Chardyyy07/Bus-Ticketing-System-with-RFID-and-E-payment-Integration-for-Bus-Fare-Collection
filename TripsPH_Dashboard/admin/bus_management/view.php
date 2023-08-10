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
  $busId = $_GET['id'];

  // Prepare the SQL query to fetch bus details
  $sql = "SELECT * FROM `tbl_bus_management` WHERE `id` = ?";

  // Prepare and execute the statement
  $stmt = $link->prepare($sql);
  $stmt->bind_param("i", $busId);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Check if bus exists
  if ($result->num_rows === 1) {
    // Fetch bus details
    $bus = $result->fetch_assoc();
  } else {
    // Bus not found, redirect to bus list
    header('location: ../admin/adminuser.php');
    exit;
  }
} else {
  // ID parameter not provided, redirect to bus list
  header('location: ../admin/adminuser.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>View Bus</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="../../assets/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/styles1.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
  <div class="card">
    <div class="card-header">
      <h3 class="text-center">Bus Details</h3>
    </div>
    <div class="card-body">
      <div style="width:600px; margin:0px auto">
        <form class="" action="" method="post">
          <div class="form-group pt-3">
            <label for="busno">Bus Number</label>
            <input type="text" name="busno" class="form-control" value="<?php echo $bus['busno']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" class="form-control" value="<?php echo $bus['type']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="purchdate">Purchase Date</label>
            <input type="date" name="purchdate" class="form-control" value="<?php echo $bus['purchdate']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="operator">Operator</label>
            <input type="text" name="operator" class="form-control" value="<?php echo $bus['operator']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" class="form-control" value="<?php echo $bus['status']; ?>" readonly>
          </div>
          <div>
            <a href="bus_management.php" class="btn btn-primary">Go Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>