<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Full Name</label>
                                                    <input name="name" class="form-control" type="text" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>ATMID</label>
                                                    <input name="atmid" class="form-control" type="text" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>Call Given By</label>
                                                    <input name="callBy" class="form-control" type="text" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>Bank</label>

                                                        <select name="bank" id="bank" class="form-control" required>
                                                            <option value="">--Select Bank --</option>
                                                                <?
                                                                
                                                                $bank_sql = mysqli_query($con,"SELECT distinct(bank) as bank FROM `mis_newsite`");
                                                                while($bank_sql_result = mysqli_fetch_assoc($bank_sql)){
                                                                    ?>
                                                                    
                                                                   <option value="<? echo $bank_sql_result['bank'];?>"><? echo $bank_sql_result['bank'];?></option> 
                                                                <? }
                                                                
                                                                ?>
                                                        </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>Purpose</label>
                                                    <select class="form-control" name="purpose" id="purpose">
                                                        <option value="">--Select--</option>
                                                        <option value="New Installation">New Installation</option>
                                                        <option value="Quality Check">Quality Check</option>
                                                        <option value="Sensor Installation">Sensor Installation</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br />
                                                    <input type="submit" name="submit" class="btn btn-primary" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
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



</body>

</html>