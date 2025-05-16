<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Razorpay\Api\Api;

$apiKey = 'rzp_test_KSuwHLjb1B4BeO';
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3';

header('Content-Type: application/json');

$api = new Api($apiKey, $apiSecret);

// Get contact_id from query parameters
$contactId = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;

if (!$contactId) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing contact_id parameter'
    ]);
    exit;
}

try {
    // Fetch specific fund account by contact_id
    $response = $api->request->request('GET', 'fund_accounts', [
        'contact_id' => $contactId
    ]);

    // Check if a fund account is found for the given contact_id
    if (!empty($response['items'])) {
        echo json_encode([
            'status' => 'success',
            'data' => $response['items']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No fund accounts found for the given contact_id'
        ]);
    }
} catch (\Exception $e) {
    // Handle errors and return response
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

?>
