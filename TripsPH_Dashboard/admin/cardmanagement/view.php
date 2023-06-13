<?php
include "../config.php";

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Fetch the data from the database based on the ID
    $sql = "SELECT * FROM `users` WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    
    // Check if a record was found
    if($row) {
        $id = $row["id"];
        $username = $row["username"];
        $password = $row["password"];
        $username = $row["username"];
        $created_at = $row["created_at"];
        
        // Display the data in the modal dialog
        echo '<div style="background-color: #f9f9f9; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
        echo '<h2>RFID Card UID:</h2>';
        echo '<p>' . $id . '</p>';

        echo '<h2>Card Holder\'s Name:</h2>';
        echo '<p>' . $username . '</p>';

        echo '<h2>Card Balance:</h2>';
        echo '<p>' . $password . '</p>';

        echo '<h2>Card Status:</h2>';
        echo '<p>' . $username . '</p>';

        echo '<h2>Created at:</h2>';
        echo '<p>' . $created_at . '</p>';

        echo '</div>';
    } else {
        echo 'No record found.';
    }
} else {
    echo 'Invalid request.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <!-- Dialog Box -->
        <div id="dialogBox" class="dialog-box">
            <div class="dialog-content">
                <span class="close">&times;</span>
                <div id="dialogData"></div>
            </div>
        </div>
</body>
</html>