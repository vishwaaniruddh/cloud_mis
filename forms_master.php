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
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>Actions</th>
                                                </tr>    
                                            </thead>
                                            <tbody>
                                                
                                            
                                        <?
                                        $count = 1 ; 
                                        $sql = mysqli_query($con,"Select max(id) as id,customer,bank from `dismatleForm` GROUP by customer,bank");
                                        while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                           <tr>
                                               <td><? echo $count; ?></td>
                                               <td><? echo $sql_result['customer'];?></td>
                                               <td><? echo $sql_result['bank'];?></td>
                                               <td><a href="copy_dismantleForm.php?id=<? echo $sql_result['id'];?>">Copy</a></td>
                                           </tr> 
                                        <? $count++ ;  }
                                        
                                        ?>
                                        </tbody>
                                        </table>
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