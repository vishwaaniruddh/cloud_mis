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
                                        <?
                                        
                                        if($_REQUEST['submit']){
                                            
                                            $customer = $_REQUEST['customer'];
                                            $bank = $_REQUEST['bank'];
                                            $dismantleFormId = $_REQUEST['dismantleFormId'];
                                            $statement = "insert into dismatleForm(customer,bank,created_at,status) 
                                            values('".$customer."','".$bank."','".$datetime."',1)";
                                            if(mysqli_query($con,$statement)){
                                                $insertId = $con->insert_id; 
                                                
                                                $sql = mysqli_query($con,"select * from dismatleFormDetails where dismatleFormId='".$dismantleFormId."'");
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                    $question = $sql_result['question'];
                                                    $type = $sql_result['type'];
                                                    $optionVal = $sql_result['optionVal'];
                                                    
                                                    $a = "insert into dismatleFormDetails(dismatleFormId,question,type,optionVal,status) 
                                                    values('".$insertId."','".$question."','".$type."','".$optionVal."',1)";
                                                    mysqli_query($con,$a);
                                                }
                                                ?>
                                                <script>
                                                    window.location = 'forms_master.php';
                                                </script>
                                                <? 
                                            }
                                        }



                                        
                                        ?>
                                        
                                        <form action="" method="POST">
                                            <input type="hidden" name="dismantleFormId" value="<? echo $_REQUEST['id']; ?>">
<div class="row">
        <div class="col-sm-6">
            <select class="form-control" name="customer">
                <option value="">-- Select Customer --</option>
                <?  
                $i = 0;
                $con_sql = mysqli_query($con, "select * from contacts where type='c' ");
                while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { 

                ?>
                    <option value="<? echo $con_sql_result['contact_first']; ?>">
                        <? echo $con_sql_result['contact_first']; ?>
                    </option>
                <?
                    $i++;
                } ?>
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
        
        
        <div class="row">
            <br />
            <input type="submit" name="submit" class="btn btn-primary">
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