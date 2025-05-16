<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Razorpay API Keys
$apiKey = 'rzp_test_KSuwHLjb1B4BeO';  // Your Razorpay API Key
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3';  // Your Razorpay API Secret

// Include the Razorpay PHP library
require '../vendor/autoload.php'; // Ensure this points to the correct path for Razorpay SDK

use Razorpay\Api\Api;

// Initialize the Razorpay API client with your API key and secret
$api = new Api($apiKey, $apiSecret);

try {
    // Fetch the list of customers
    $customers = $api->customer->all();
    $customerList = [];

    // Loop through all customers and prepare data for display
    foreach ($customers->items as $customer) {
        $customerList[] = [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'contact' => $customer->contact
        ];
    }

    // Return customer list as JSON
    echo json_encode($customerList);

} catch (\Razorpay\Api\Errors\Error $e) {
    // Handle errors gracefully
    echo json_encode(['error' => $e->getMessage()]);
}

?>
