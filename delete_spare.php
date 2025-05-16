<?php
include('config.php');

if (isset($_POST['spare_id'])) {
    $spareId = mysqli_real_escape_string($con, $_POST['spare_id']);

    // Delete query
    $query = "DELETE FROM sparesComponent WHERE id = '$spareId'";

    if (mysqli_query($con, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Spare component deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting spare component: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
