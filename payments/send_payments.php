<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Razorpay API Keys
$apiKey = 'rzp_test_KSuwHLjb1B4BeO';
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3';

// Include the Razorpay PHP library
// require 'razorpay-php/Razorpay.php'; // Make sure the path to Razorpay PHP SDK is correct
require '../vendor/autoload.php';

use Razorpay\Api\Api;

// Initialize the Razorpay API client with your API key and secret
$api = new Api($apiKey, $apiSecret);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $upi_id = $_POST['upi_id'];
    $amount = $_POST['amount'];

    // Validate inputs
    if (empty($upi_id) || empty($amount)) {
        echo 'UPI ID and Amount are required.';
        exit;
    }

    // Convert amount to smallest currency unit (paise for INR)
    $amountInPaise = $amount * 100;

    try {
        // Create a transfer (this example assumes you have the linked account ID)
        // You must replace 'linked_account_id' with the actual linked account ID
        $transfer = $api->transfer->create([
            'amount' => $amountInPaise, // Amount in paise
            'currency' => 'INR', // Currency code (INR for Indian Rupees)
            'linked_account' => 'linked_account_id', // Replace with the actual linked account ID
            'notes' => [
                'UPI_ID' => $upi_id, // You can save UPI ID as a note
            ],
        ]);

        echo 'Payment sent successfully!';
        print_r($transfer); // Optional: Display the transfer details

    } catch (\Razorpay\Api\Errors\Error $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
