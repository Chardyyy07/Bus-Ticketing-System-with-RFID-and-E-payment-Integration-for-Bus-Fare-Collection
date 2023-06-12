<?php
include "../config.php";

if (isset($_POST["submit"])) {
   $id = $_POST['id'];
   $bus_fare_id = $_POST['bus_fare_id'];
   $cardholder_email = $_POST['cardholder_email'];
   $card_number = $_POST['card_number'];
   $balance = $_POST['balance'];
   $STATUS = $_POST['STATUS'];
   $origin = $_POST['origin'];
   $destination = $_POST['destination'];
   $total_fare = $_POST['total_fare'];
   $date_created = $_POST['date_created'];

   $sql = "INSERT INTO `bus_fare_collection` (`id`, `bus_fare_id`, `cardholder_email`, `card_number`, `balance`, `STATUS`, `origin`, `destination`, `total_fare`, `date_created`) 
    VALUES ('$id', '$bus_fare_id', '$cardholder_email', '$card_number', '$balance', '$STATUS', '$origin', '$destination', '$total_fare', '$date_created')";

   $result = mysqli_query($link, $sql);

   if ($result) {
      header("Location: bus_fare_collection.php?msg=New record created successfully");
      exit();
   } else {
      echo "Failed: " . mysqli_error($link);
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>PHP CRUD Application</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New Bus Fare Collection</h3>
         <p class="text-muted">Complete the form below to add a new record</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">ID:</label>
                  <input type="text" class="form-control" name="id" placeholder="1" required>
               </div>
               <div class="col">
                  <label class="form-label">Bus Fare ID:</label>
                  <input type="text" class="form-control" name="bus_fare_id" placeholder="BF1001" required>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Cardholder Email:</label>
                  <input type="email" class="form-control" name="cardholder_email" placeholder="cardholder@example.com" required>
               </div>
               <div class="col">
                  <label class="form-label">Card Number:</label>
                  <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" required>
               </div>
            </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Balance:</label>
                  <input type="number" class="form-control" name="balance" placeholder="Balance" required>
               </div>

               <div class="col">
                  <label class="form-label">Status:</label>
                  <select class="form-select" name="STATUS" required>
                     <option value="in">Entry</option>
                     <option value="out">Out</option>
                  </select>
               </div>
            </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Origin:</label>
                  <input type="text" class="form-control" name="origin" placeholder="Origin" required>
               </div>
               <div class="col">
                  <label class="form-label">Destination:</label>
                  <input type="text" class="form-control" name="destination" placeholder="Destination" required>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Total Fare:</label>
                  <input type="number" class="form-control" name="total_fare" placeholder="₱" required>
               </div>
               <div class="col">
                  <label class="form-label">Date Created:</label>
                  <input type="date" class="form-control" name="date_created" required>
               </div>
            </div>
            <div>
               <button type="submit" class="btn btn-success" name="submit">Save</button>
               <a href="bus_fare_collection.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>