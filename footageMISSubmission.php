<?php include('./config.php');



    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $misid = $_POST['misid'];
        $status = $_POST['status'];
        $link = isset($_POST['link']) ? $_POST['link'] : null;
        $reason = isset($_POST['reason']) ? $_POST['reason'] : null;
        $issue = isset($_POST['issue']) ? $_POST['issue'] : null;
        $other_issue = isset($_POST['other_issue']) ? $_POST['other_issue'] : null;
        $schedule_date = isset($_POST['schedule_date']) ? $_POST['schedule_date'] : null;
        $remark = isset($_POST['remark']) ? $_POST['remark'] : null;

        $transaction_type = isset($_POST['transaction_type']) ? $_POST['transaction_type'] : null;
        $transaction_no = isset($_POST['transaction_no']) ? $_POST['transaction_no'] : null;


        mysqli_query($con,"update mis_footage set transaction_type='".$transaction_type."', transaction_no='".$transaction_no."' where id='".$misid."'");


        // Insert data into the footage_mis_history table
        $sql = "INSERT INTO footage_mis_history 
                (misid, status, link, reason, issue, other_issue, schedule_date, remark, created_at,created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,?)";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, 'issssssssi', $misid, $status, $link, $reason, $issue, $other_issue, $schedule_date, $remark,$datetime,$userid);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data saved successfully!'); window.location.href = 'viewfootagemisdetail.php?id=$misid';</script>";
            } else {
                echo "<script>alert('Error saving data. Please try again.'); window.location.href = 'viewfootagemisdetail.php?id=$misid';</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Could not prepare statement.";
        }
    }

?>
