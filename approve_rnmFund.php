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
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                              <table class="table m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Ticket ID </th>
                                                            <td>M202103310153</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">ATM ID</th>
                                                            <td>
                                                                <span>MN002020</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Bank</th>
                                                            <td>indusind</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Location</th>
                                                            <td>12063 ,Waheguru Complex,&nbsp; Main Rahon Road , Ludhiana ,Punjab 141007.</td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                            <div class="col-sm-6">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <h3>Approve RNM FUnd </h3>
                                        
                                        
                                        <form action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Amount</label>
                                                    <input type="text" name="amount" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Remark</label>
                                                    <input type="text" name="remark" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-success">
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h3>History</h3>
                                        
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                </tr>
                                            </tbody>
                                        
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