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
    $amountInPaise = $amount * 100; // Example: Convert INR to paise (1 INR = 100 paise)

    try {
        // Create a customer object using UPI ID (vpa)
        $customer = $api->customer->create([
            'contact' => '7021889882', // Customer contact number
            'email' => 'vishwaaniruddh2@gmail.com', // Customer email
            'vpa' => $upi_id, // UPI ID (vpa)
            'name'=>'Aniruddh'
        ]);

        // Get the customer ID from the response
        $customerId = $customer->id;

        // Now create a transfer using the customer ID
        $transfer = $api->transfer->create([
            'amount' => $amountInPaise, // Amount in paise
            'currency' => 'INR', // Currency code (INR for Indian Rupees)
            'customer' => $customerId, // Use the customer ID here
            'notes' => [
                'UPI_ID' => $upi_id, // Store UPI ID in the notes (optional)
            ],
        ]);

        echo 'Payment sent successfully!';
        // Optionally, print transfer details for debugging or confirmation
        print_r($transfer);

    } catch (\Razorpay\Api\Errors\Error $e) {
        // Handle errors gracefully
        echo 'Error: ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Payment</title>
</head>
<body>
    <h2>Send Payment via UPI</h2>
    <form action="send_payment_form.php" method="POST">
        <label for="upi_id">UPI ID:</label><br>
        <input type="text" id="upi_id" name="upi_id" required><br><br>
        
        <label for="amount">Amount (in INR):</label><br>
        <input type="number" id="amount" name="amount" required><br><br>

        <input type="submit" value="Send Payment">
    </form>
</body>
</html>
