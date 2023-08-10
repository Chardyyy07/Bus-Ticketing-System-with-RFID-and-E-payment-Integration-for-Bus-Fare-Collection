<?php
include "../../admin/config.php";
$id = $_GET["id"];
$id = mysqli_real_escape_string($link, $id); // Escape the user input to prevent SQL injection

$sql = "DELETE FROM `tbl_personnel` WHERE id = '$id'"; // Fix the SQL statement

$result = mysqli_query($link, $sql);

if ($result) {
    header("Location: personnel_management.php?msg=Data deleted successfully");
    exit; // Add an exit statement after redirecting to prevent further code execution
} else {
    echo "Failed: " . mysqli_error($link);
}
