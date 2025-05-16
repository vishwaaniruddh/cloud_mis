<?php
session_start();
include('config.php');

if ($_SESSION['username']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $batch_name = mysqli_real_escape_string($con, $_POST['batch_name']);
        $selected_records = $_POST['selected_records'] ?? [];
        $mis_ids = $_POST['mis_id'] ?? [];
        $total_amount = floatval($_POST['total_amount']);

        if (empty($batch_name) || empty($selected_records)) {
            echo "<script>alert('Batch name and selected records are required.'); window.history.back();</script>";
            exit;
        }

        // Save the batch in the database
        $batch_insert_query = "INSERT INTO eng_fund_batches (batch_name, total_amount, created_by, created_at) 
                               VALUES ('$batch_name', $total_amount, '{$_SESSION['username']}', NOW())";
        if (!mysqli_query($con, $batch_insert_query)) {
            echo "<script>alert('Error creating batch: " . mysqli_error($con) . "'); window.history.back();</script>";
            exit;
        }

        // Get the batch ID of the newly created batch
        $batch_id = mysqli_insert_id($con);

        // Update the selected records to associate them with this batch
        foreach ($selected_records as $record_id) {
            $record_id = intval($record_id); // Sanitize input
            $update_query = "UPDATE eng_fund_request 
                             SET batch_id = $batch_id 
                             WHERE id = $record_id";
            if (!mysqli_query($con, $update_query)) {
                echo "<script>alert('Error updating record ID $record_id: " . mysqli_error($con) . "'); window.history.back();</script>";
                exit;
            }
        }
        
        
        foreach ($mis_ids as $mis_id){
            $mis_id = intval($mis_id); // Sanitize input
            mysqli_query($con, "update mis_details  set status = 'fund_under_process' where id = '" . $mis_id . "'");

        }

        // Success message and redirection
        echo "<script>alert('Batch created successfully.'); window.location.href = 'view_batches.php';</script>";
    } else {
        echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    }
} else {
    echo "<script>window.location.href = 'login.php';</script>";
}
?>
