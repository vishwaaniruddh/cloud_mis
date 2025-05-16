<?php
// Include the configuration file to connect to the database
include 'config.php';

// Set the header for the response type to be JSON
header('Content-Type: application/json');

// Initialize the result array
$result1 = [];

// Query to fetch the data from mis_component table where status is 1
$sql1 = mysqli_query($con, "SELECT * FROM spares WHERE status=1");

$dataArray = array();
// Check if there are any rows returned
if (mysqli_num_rows($sql1) > 0) {
    // Loop through the query results and store them in the result array
    while ($row1 = mysqli_fetch_assoc($sql1)) {
      //  $name1 = $row1["name"];
     //   $id1 = $row1["id"];
      //  $result1[] = ['id' => $id1, 'name' => $name1];
        
        $_newdata = array();
        $_newdata['label'] = $row1['spareName']; 
        $_newdata['value'] = $row1['spareName'];
        array_push($dataArray,$_newdata); 
    }
    
    // Return the result as a JSON response
    echo json_encode(['status' => 'success', 'data' => $dataArray]);
} else {
    // Return an error response if no records are found
    echo json_encode(['status' => 'error', 'message' => 'No components found']);
}

// Close the database connection
mysqli_close($con);
?>
