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
                            
                            <div class="card-block">
                              
                                <form action="process_add_city.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>zone</label>
                                            <select name="zone"  id ="zone" class="form-control" required>
                    						    <option value="">Select Zone</option>
                    						    <?
                    						        $zone_sql = mysqli_query($con,"select * from newzone order by id");
                    						        while($zone_sql_result = mysqli_fetch_assoc($zone_sql)){ ?>
                    						            <option value="<? echo $zone_sql_result['id']; ?>" <? if($zone == $zone_sql_result['zone_name']){ echo 'selected'; } ?>>
                    						                <? echo $zone_sql_result['zone_name'];?>
                    						            </option>
                    						        <? } ?>
                    						</select>
                                        </div>

                                        <div class="col-sm-3">
                                            <label>state</label>
                                            <select name="state"  id ="state" class="form-control" required>
                    						    <option value="">Select State</option>
                    						    <?
                    						        $state_sql = mysqli_query($con,"select * from state order by state");
                    						        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ ?>
                    						            <option value="<? echo $state_sql_result['state_id']; ?>" <? if($state == $state_sql_result['state']){ echo 'selected'; } ?>>
                    						                <? echo $state_sql_result['state'];?>
                    						            </option>
                    						        <? } ?>
                    						</select>
                                        </div>

                                        <div class="col-sm-3">
                                            <label>city</label>
                                            <input type="text" class="form-control" name="city" id="city" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <br>
                                            <input type="submit" name="submit" class="btn btn-danger">
                                        </div>
                                    </div>

                                </form>


                            </div>
                        </div>





                        <div class="card">
                            <div class="card-body" style="overflow:auto;">
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Zone</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <!--<th>Status</th>-->
                                            <!--<th>Active / Inactive </th>-->
                                            <!--<th>Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $i = 1;
                                        $sql = mysqli_query($con, "select * from mis_city");
                                        while ($sql_result = mysqli_fetch_assoc($sql)) {
                                            $zone_id = $sql_result['zone_id'];
                                            $state_id = $sql_result['state_id'];
                                            
                                            $state = mysqli_query($con,"select * from state where state_id = '".$state_id."'");
                                            $state_res = mysqli_fetch_assoc($state);
                                            
                                            $zone = mysqli_query($con,"select * from newzone where id = '".$zone_id."' ");
                                            $zone_res = mysqli_fetch_assoc($zone);
                                            
                                            if ($sql_result['user_status'] == 0) {
                                                $user_status = 'Inactive';
                                                $makeuser_status = 'Make Active';
                                                $status_class = 'text-danger';
                                            } else {
                                                $user_status = 'Active';
                                                $makeuser_status = 'Make Inactive';
                                                $status_class = 'text-success';
                                            }
                                        ?>
                                            <tr>
                                                <td><? echo $i; ?></td>
                                                <td><? echo $zone_res['zone_name']; ?></td>
                                                <td><? echo $state_res['state']; ?></td>
                                                
                                                <td><? echo $sql_result['city']; ?></td>
                                                <!--<td class="<? echo $status_class; ?>"><? echo $user_status; ?></td>-->
                                                
                                                <!--<td><a href="#" class="btn btn-danger" onclick="disable(<? echo $sql_result['id']; ?>)"><? echo $makeuser_status; ?></a></td>-->
                                                <!--<td><a href="edit_designation.php?id=<? echo $sql_result['id']; ?>"><input type="submit" name="edit" id="edit" class="btn btn-warning" value="Edit"></a></td>-->
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