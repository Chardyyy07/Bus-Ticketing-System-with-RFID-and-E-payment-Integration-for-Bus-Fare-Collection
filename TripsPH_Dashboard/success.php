<?php
session_start();
require_once "Database.php";
require_once "StripeHelper.php";
require_once "User.php";

$stripeHelper = new StripeHelper();
if (isset($_SESSION['user_id'])) {
  $user = new User();
  $database = new Database();
  $sessionId = $_GET['session_id'];
  $userId = $_SESSION['user_id'];
  $checkoutSession = $stripeHelper->getSession($sessionId);

  // Check if the payment is successfully completed
  if ($checkoutSession->payment_status === 'paid') {
    // Fetch additional information from the tbl_reload_history table
    $stmt = $database->connection->prepare("SELECT rfid, email, amount, created_at FROM tbl_reload_history WHERE payment_intent = ?");
    $stmt->bind_param("s", $checkoutSession->payment_intent);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $rfid = $row['rfid'];
      $email = $row['email'];
      $amount = $row['amount'];
      $created_at = $row['created_at'];
    } else {
      // If no additional information is found, set them to empty strings
      $rfid = '';
      $email = '';
      $amount = '';
      $created_at = '';
    }

    // Update the payment status in the user's record
    $user->updatePaymentStatus($database->connection, $checkoutSession->payment_intent, $userId);
  } else {
    // Redirect to payment page if payment is not successful
    header("Location: payment.php");
    exit; // Make sure to stop further execution
  }
} else {
  header("Location: payment.php");
  exit; // Make sure to stop further execution
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  <title>Success | </title>
  <style>
    body,
    html {
      height: 100%;
      background-image: linear-gradient(blue, cyan);
      background-repeat: no-repeat;
      background-size: cover;
    }

    .card-body {
      border-radius: 20px;
      background-color: whitesmoke;
      padding-bottom: 30px;
    }

    .container {
      text-align: center;
    }

    p {
      font-size: 10px solid #23e323;
      text-align: center;
    }

    .amount p {
      font-size: 15px;
      text-align: left;
      margin-bottom: 20px;
    }

    h1 {
      text-align: center;
      margin-top: 10px;
      color: limegreen;
    }

    h1 {
      color: #88B04B;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
      text-align: center;
    }

    p {
      color: #404F5E;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-size: 20px;
      margin: 0;
    }

    i {
      color: #9ABC66;
      font-size: 60px;
      margin-left: -10px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 2px 3px #C8D0D8;
      display: inline-block;
    }

    .button {
      text-align: center;
      display: inline-block;
      font-size: 30px;
      cursor: pointer;
      transition-duration: 0.4s;
      transition-duration: 0.4s;
    }

    .button2:hover {
      box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">


            <!-- ... Rest of the card content ... -->
            <div class="card">
              <div style="border-radius:100px; height:100px; width:100px; background: #F8FAF5; margin:0 auto;">
                <i class="checkmark">✓</i>
              </div>
              <h1 class="card-title">Payment</h1>
              <h1>Success</h1>
              <p>“You have successfully loaded your TripsPH card"</p>
              <p>Thank You!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="index.php">
      <button class="button button2" href=>Done</button>
    </a>
  </div>

</body>

</html>