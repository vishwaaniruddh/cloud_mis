<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php  
// session_start();
include('config.php');


// var_dump($_POST); die;
$status_name = $_POST['status_name'];
$status_code = $_POST['status_code'];
$created_at = date('Y-m-d H:i:s');
$userid = $_POST['userid'];

$sql = mysqli_query($con,"insert into mis_status (status_name,status_code,created_at,created_by) 
            values('".$status_name."','".$status_code."','".$created_at."','".$userid."')  ");
if($sql){ ?>
    <script>
        Swal.fire(
          'Added!',
          'Status has been inserted.',
          'success'
        );
        setTimeout(function(){ 
    window.location.href="add_call_status.php";
}, 2000);
    </script> 
<? } else { ?>
    <script>
        Swal.fire(
          'Error!',
          'Status should be unique.',
          'success'
        );
        setTimeout(function(){ 
    window.location.href="add_call_status.php";
}, 2000);
    </script>  
<?} ?>