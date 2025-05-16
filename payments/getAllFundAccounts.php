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

try {
    // Fetch all fund accounts
    $response = $api->request->request('GET', 'fund_accounts', []);

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'data' => $response['items']
    ]);
} catch (\Exception $e) {
    // Handle errors and return response
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

?>
