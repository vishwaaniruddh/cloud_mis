<?php
include('config.php');

if (isset($_POST['saveSpare'])) {
    $spareId = mysqli_real_escape_string($con, $_POST['spareName']);
    $componentNames = $_POST['spareComponentName'];
    $costs = $_POST['cost'];

    if (!empty($spareId) && !empty($componentNames) && !empty($costs)) {
        $errors = [];
        
        for ($i = 0; $i < count($componentNames); $i++) {
            $componentName = mysqli_real_escape_string($con, $componentNames[$i]);
            $cost = mysqli_real_escape_string($con, $costs[$i]);

            if (!empty($componentName) && is_numeric($cost) && $cost >= 0) {
                $query = "INSERT INTO sparesComponent (spareid, spareComponentName, cost, status) 
                          VALUES ('$spareId', '$componentName', '$cost', 1)";
                if (!mysqli_query($con, $query)) {
                    $errors[] = "Error adding component: " . mysqli_error($con);
                }
            } else {
                $errors[] = "Invalid input for component $componentName";
            }
        }

        if (empty($errors)) {
            echo json_encode(['status' => 'success', 'message' => 'Spare components added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => implode(", ", $errors)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
