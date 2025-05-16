<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay API Keys
$apiKey = 'rzp_test_KSuwHLjb1B4BeO'; // Replace with your API key
$apiSecret = 'XhdFeHK2NnYw60IxNbCT1eq3'; // Replace with your API secret

$api = new Api($apiKey, $apiSecret);

// Initialize variables for messages
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form inputs
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactNumber = $_POST['contact_number'];
        $upiId = $_POST['upi_id'];

        // Step 1: Create a Contact
        $contact = $api->contact->create([
            "name" => $name,
            "email" => $email,
            "contact" => $contactNumber,
            "type" => "employee", // You can change this based on the use case
            "reference_id" => "ref_" . time(), // Optional unique reference ID
            "notes" => [
                "notes_key" => "Created from PHP application"
            ]
        ]);

        $contactId = $contact['id'];

        // Step 2: Create a Fund Account using the Contact ID
        $fundAccount = $api->fundAccount->create([
            "contact_id" => $contactId,
            "account_type" => "vpa",
            "vpa" => [
                "address" => $upiId
            ]
        ]);

        $fundAccountId = $fundAccount['id'];
        $message = "Contact and Fund Account created successfully. Fund Account ID: " . $fundAccountId;

    } catch (\Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay UPI Integration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type="text"], input[type="email"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Razorpay UPI Integration</h1>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter recipient's name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter recipient's email" required>

    <label for="contact_number">Contact Number:</label>
    <input type="text" id="contact_number" name="contact_number" placeholder="Enter recipient's contact number" required>

    <label for="upi_id">UPI ID:</label>
    <input type="text" id="upi_id" name="upi_id" placeholder="Enter recipient's UPI ID" required>

    <input type="submit" value="Create UPI Fund Account">
</form>

</body>
</html>
