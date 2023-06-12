<?php
include "../config.php";
$id = $_GET["id"];
$sql = "DELETE FROM `cardholders` WHERE id = $id";
$result = mysqli_query($link, $sql);

if ($result) {
  header("Location: card_management.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($link);
}
