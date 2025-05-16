<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the Razorpay PHP library
require '../vendor/autoload.php'; // Ensure this points to the correct path for Razorpay SDK


// Razorpay API Keys
$apiKey = 'rzp_test_KSuwHLjb1B4BeO';  // Your Razorpay API Key
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3';  // Your Razorpay API Secret

use Razorpay\Api\Api;

// Initialize the Razorpay API client with your API key and secret
$api = new Api($apiKey, $apiSecret);

// Check if customer ID is passed via POST request
if (isset($_POST['id'])) {
    $customerId = $_POST['id']; // Get the customer ID
   
    try {
        $customer = $api->customer->fetch($customerId);
        $customer->delete();
    
        echo 'Customer deleted successfully';
    } catch (Exception $e) {
        echo 'Error deleting customer: ' . $e->getMessage();
    }
    

} else {
    echo 'Error: No customer ID provided.';
}
?>
