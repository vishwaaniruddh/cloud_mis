<?php
include('config.php');

if (isset($_POST['spareId'])) {
    $id = $_POST['spareId'];
    $componentName = $_POST['componentName'];
    $cost = $_POST['cost'];

    $updateQuery = "UPDATE sparesComponent SET spareComponentName='$componentName', cost='$cost' WHERE id='$id'";
    
    if (mysqli_query($con, $updateQuery)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
