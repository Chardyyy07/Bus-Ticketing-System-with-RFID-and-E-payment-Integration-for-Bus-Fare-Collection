<?php
session_start();

require_once 'Database.php';
require_once "StripeHelper.php";
require_once "User.php";

/**
 * Determine the base URL based on the transaction location
 */
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
    // Transaction is in the computer or server (XAMPP)
    $appUrl = "http://localhost/TripsPH_Dashboard/";
} elseif (strpos($_SERVER['REMOTE_ADDR'], '192.xxx.xxx.') !== false) {
    // Transaction is in a different device but same network
    $appUrl = "http://192.xxx.xxx.xxx/TripsPH_Dashboard/";  // change ng IP address ng device (ipconfig) kung san yung server
} else {
    // Transaction is in an unknown location, handle accordingly
    // Set a default base URL
    $appUrl = "http://localhost/TripsPH_Dashboard/";
}

$database = new Database();

/**
 * When registration form submitted
 */
if (isset($_POST['payNowBtn'])) {
    $user = new User();
    $data = $_POST;
    $data['amount'] = $_POST['amount'];
    $user = $user->registerUser($database->connection, $_POST);
    $_SESSION['user_id'] = $database->connection->insert_id;
}

$stripeHelper = new StripeHelper();
$stripe = $stripeHelper->stripeClient;

/**
 * Create product
 */
$product = $stripeHelper->createProducts();

/**
 * Create price for product
 */
$price = $stripeHelper->createProductPrice($product, $data['amount']);

/**
 * Create checkout session and payment link
 */
$stripeSession = $stripe->checkout->sessions->create(
    array(
        'success_url' => $appUrl . 'success.php?session_id={CHECKOUT_SESSION_ID}&next=payment',
        'cancel_url' => $appUrl . 'failed.php?next=payment',
        'payment_method_types' => array('card'),
        'mode' => 'payment',
        'line_items' => array(
            array(
                'price' => $price->id,
                'quantity' => 1,
            )
        )
    )
);

$redirectUrl = $stripeSession->url;

if (isset($_GET['next'])) {
    $nextPage = $_GET['next'];
    if ($nextPage === 'success') {
        header("Location: " . $appUrl . 'success.php');
        exit;
    }
}

header("Location: " . $redirectUrl);
exit;
