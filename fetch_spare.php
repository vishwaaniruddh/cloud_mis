<?php
include('config.php');

if (isset($_POST['spareId'])) {
    $spareId = $_POST['spareId'];
    $query = mysqli_query($con, "SELECT * FROM sparesComponent WHERE id = '$spareId'");
    
    if ($component = mysqli_fetch_assoc($query)) {
        echo json_encode(['success' => true, 'data' => $component]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
