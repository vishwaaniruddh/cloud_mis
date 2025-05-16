<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay API Keys
$apiKey = 'rzp_test_KSuwHLjb1B4BeO';
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3';

// Initialize Razorpay API
$api = new Api($apiKey, $apiSecret);

try {
    // Add the fund account with UPI ID (this step is typically done beforehand)
    $fundAccount = $api->fundAccount->create([
        "contact_id" => "cont_1234567890", // Replace with an actual contact_id
        "account_type" => "vpa",
        "vpa" => [
            "address" => "recipient_upi_id@bank" // Replace with the actual UPI ID
        ]
    ]);

    // Create a payout
    $payout = $api->payout->create([
        "account_number" => "your_virtual_account_number", // Provided by Razorpay
        "fund_account_id" => $fundAccount['id'], // ID of the created fund account
        "amount" => 50000, // Amount in paise (₹500.00 = 50000)
        "currency" => "INR",
        "mode" => "upi",
        "purpose" => "payout",
        "queue_if_low_balance" => true,
        "reference_id" => "txn_123456",
        "narration" => "Payment for services",
    ]);

    echo "Payout Successful: " . $payout->id;

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
