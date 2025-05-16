<?php


session_start();
include('config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);




if ($_SESSION['username']) {
    include('header.php');
    ?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block">
                                
                                <a href="./excelformat/MATERIAL_DISPATCH_INPROCESS_FORMAT.xlsx" download>Download Format</a>
                                
                                <h4>Upload Excel File</h4>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="file" name="excel_file" accept=".xls,.xlsx" required>
                                    <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                                </form>

                                <?php

if (isset($_POST['upload'])) {
    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

    $target_dir = "uploads"; // Set your upload directory
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["excel_file"]["name"]);
    $file_tmp = $_FILES["excel_file"]["tmp_name"];
    $target_file = $target_dir . '/' . $file_name;

    if (move_uploaded_file($file_tmp, $target_file)) {
        try {
            $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            $worksheet = $objPHPExcel->getActiveSheet();
            $data = $worksheet->toArray();

            $headers = $data[0]; // First row is headers

            // Loop through all rows starting from index 1 (to skip the header)
            for ($i = 1; $i < count($data); $i++) {
                $values = $data[$i];

                $ticketId = $values[0];
                $status = $values[1];
                $courierAgency = $values[2];
                $pod = $values[3];
                $serialNumber = $values[4];
                $dispatchDate = $values[5];
                $dispatchRemark = $values[6];

                // Check if Ticket exists
                $ticketsql = mysqli_query($con, "SELECT * FROM mis_details WHERE ticket_id='" . $ticketId . "'");
                if ($ticketsql_result = mysqli_fetch_assoc($ticketsql)) {
                    $mis_details_id = $ticketsql_result['id'];
                    $mis_parent_id = $ticketsql_result['mis_id'];

                    if ($status == 'material_delivered' || $status == 'material_in_transit') {
                        if ($status == 'material_delivered') {
                            $column = 'delivery_date';
                        } else if ($status == 'material_in_transit') {
                            $column = 'dispatch_date';
                        }

$dispatchDate = DateTime::createFromFormat('m/d/Y', $values[5]);
if ($dispatchDate) {
    $dispatchDate = $dispatchDate->format('Y-m-d');
} else {
    $dispatchDate = '0000-00-00'; // Default value if conversion fails
}



                        // Insert into history
                      $statement = "INSERT INTO mis_history (mis_id, type, status, created_at, created_by, $column, courier_agency, pod, serial_number) 
                                      VALUES ('$mis_details_id', '$status', '1', '$datetime', '$userid', '$dispatchDate', '$courierAgency', '$pod', '$serialNumber')";

                        if (mysqli_query($con, $statement)) {
                            $_mis_history_id = $con->insert_id;
                            // echo "UPDATE mis_details SET status = '$status' WHERE id = '$mis_details_id'" ; 
                            mysqli_query($con, "UPDATE mis_details SET status = '$status' WHERE id = '$mis_details_id'");

                            echo "<p class='text-success'>Ticket ID: <strong>$ticketId</strong> - Updated Successfully!</p>";
                        } else {
                            echo "<p class='text-danger'>Error updating ticket ID: <strong>$ticketId</strong></p>";
                        }
                    }
                } else {
                    echo "<p class='text-warning'>Ticket ID: <strong>$ticketId</strong> - Not Found in system. Check before trying again.</p>";
                }
            }
        } catch (Exception $e) {
            echo "<p class='text-danger'>Error reading the file: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p class='text-danger'>Failed to upload file.</p>";
    }
}

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
} else { ?>
    <script>
        window.location.href = "login.php";
    </script>
<?php } ?>