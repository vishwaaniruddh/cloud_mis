<?php
// Include the configuration file to connect to the database
include 'config.php';

// Get the component name from the request (it can be passed via GET or POST)
$componentname = isset($_GET['componentname']) ? $_GET['componentname'] : '';

// Set the header for the response type to be JSON
header('Content-Type: application/json');

// Initialize the result array
$result2 = [];
$dataArray = array();
// Check if componentname is provided
if (!empty($componentname)) {
    // Query to fetch data from mis_subcomponent where component_id matches the provided componentname and status is 1
    $sql2 = mysqli_query($con, "SELECT * FROM sparesComponent WHERE spareid = '$componentname' AND status = 1 ORDER BY id DESC");

    // Check if there are any rows returned
    if (mysqli_num_rows($sql2) > 0) {
        // Loop through the query results and store them in the result array
        while ($row2 = mysqli_fetch_assoc($sql2)) {
        //    $model2 = $row2["name"];
        //    $component_id = $row2["component_id"];
        //    $id = $row2['id'];
        //    $result2[] = ['id' => $id, 'fk' => $component_id, 'name' => $model2];
            
            $_newdata = array();
            $_newdata['label'] = $row2['spareComponentName']; 
            $_newdata['value'] = $row2['spareComponentName'];
            array_push($dataArray,$_newdata); 
        }

        // Return the result as a JSON response
        echo json_encode(['status' => 'success', 'data' => $dataArray]);
    } else {
        // Return an error response if no subcomponents are found
        echo json_encode(['status' => 'error', 'message' => 'No subcomponents found']);
    }
} else {
    // Return an error response if componentname is not provided
    echo json_encode(['status' => 'error', 'message' => 'Component name is required']);
}

// Close the database connection
mysqli_close($con);
?>
