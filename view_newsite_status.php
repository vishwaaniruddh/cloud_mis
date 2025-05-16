<? session_start();
include('config.php');

if ($_SESSION['username']) {

    include('header.php');

?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function disable(id) {

            Swal.fire({
                title: 'Are you sure?',
                text: "Think twice to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Proceed it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    jQuery.ajax({
                        type: "POST",
                        url: 'disable_user.php',
                        data: 'id=' + id,
                        success: function(msg) {

                            if (msg == 1) {
                                Swal.fire(
                                    'Updated!',
                                    'Status has been changed.',
                                    'success'
                                );

                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);

                            } else if (msg == 0 || msg == 2) {

                                Swal.fire(
                                    'Cancelled',
                                    'Your imaginary file is safe :)',
                                    'error'
                                );



                            }

                        }
                    });


                }
            })

        }
    </script>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-body" style="overflow:auto;">
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>ATMID</th>
                                            <th>Bank</th>
                                            <th>Status</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $i = 1;
                                        $sql = mysqli_query($con, "select * from mis_newsitetest");
                                        while ($sql_result = mysqli_fetch_assoc($sql)) {
                                            $atmid = $sql_result['atmid'];
                                            $customer = $sql_result['customer'];
                                            $activity = $sql_result['activity'];
                                            $bank = $sql_result['bank'];
                                            
                                            
                                            if ($sql_result['status'] == 0) {
                                                $user_status = 'Inactive';
                                                // $makeuser_status = 'Make Active';
                                                $status_class = 'text-danger';
                                            } else {
                                                $user_status = 'Active';
                                                // $makeuser_status = 'Make Inactive';
                                                $status_class = 'text-success';
                                            }
                                        ?>
                                            <tr>
                                                <td><? echo $i; ?></td>
                                                <td><?=$customer ?></td>
                                                <td><?=$atmid ?></td>
                                                <td><?=$bank ?></td>
                                                <td class="<? echo $status_class; ?>"><? echo $user_status; ?></td>
                                            </tr>
                                        <? $i++;
                                        } ?>

                                    </tbody>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>


<? include('footer.php');
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>

<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>




<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>
<script>
    function validInput(e) {
        e = (e) ? e : window.event;
        a = document.getElementById('contact');
        cPress = (e.which) ? e.which : e.keyCode;

        if (cPress > 31 && (cPress < 48 || cPress > 57)) {
            return false;
        } else if (a.value.length >= 10) {
            return false;
        }

        return true;
    }
</script>


</body>

</html>