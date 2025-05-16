<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

    $username = $_SESSION['username'];
    
    
    $usersql = mysqli_query($con,"select cust_id,zone from mis_loginusers where name='".$username."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",",$_cust_ids);

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="customer" id="customer">
                                                <option value="">--select Customer--</option>
                                                <?  
                                                $i = 0;
                                                $con_sql = mysqli_query($con, "select * from contacts where type='c' ");
                                                while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { 
                                                  if(in_array($con_sql_result['contact_first'],$assigned_customers)){
                                                ?>
                                                    <option value="<? echo $con_sql_result['contact_first']; ?>">
                                                        <? echo $con_sql_result['contact_first']; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                                } } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
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
                                </div>
                                
<button id="getForm" class="btn btn-primary">Get Form</button>



    
    
    <br>
    <br>
    
    <div id="result"></div>
    
    <br>
    
    <br>
    <br>
    
    
    
    
    
    <script>
    $(document).on('click','#getForm',function(){
        customer = $("#customer").val();
        bank = $("#bank").val();
        
        $.ajax({
                       type:"POST",
                       url:"get_dismantleForm.php",
                       data: "customer="+customer+'&&bank='+bank, 
                       success:function(msg){
                           $("#result").html(msg);
                       }
                    });     
    })
        
    </script>
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