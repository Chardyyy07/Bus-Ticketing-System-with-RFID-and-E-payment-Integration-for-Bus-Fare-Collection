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

// Check if the form is submitted to update user status
if (isset($_GET['id']) && isset($_GET['action'])) {
    // Store the user ID and action from the URL parameters
    $user_id = $_GET['id'];
    $action = $_GET['action'];

    // Validate and prepare the SQL query to update the user status based on the action
    if ($action === 'deactivate') {
        $status = 0; // Inactive status
    } elseif ($action === 'activate') {
        $status = 1; // Active status
    } else {
        // Invalid action, redirect back to the user list
        header('location: adminuser.php');
        exit;
    }

    // Update the user status in the database
    $sql = "UPDATE `tbl_users` SET `status` = $status WHERE `id` = $user_id";
    mysqli_query($link, $sql);

    // Redirect back to the adminuser.php page
    header('location: adminuser.php');
    exit;
} else {
    // Invalid request, redirect back to the user list
    header('location: adminuser.php');
    exit;
}
