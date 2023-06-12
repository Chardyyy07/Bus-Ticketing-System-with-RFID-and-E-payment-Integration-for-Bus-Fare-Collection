<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tripsph');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function getUserAccessRoleByID($id)
{
    global $link;

    $query = "select user_role from tbl_user_role where  id = " . $id;

    $rs = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($rs);

    return $row['user_role'];
}
