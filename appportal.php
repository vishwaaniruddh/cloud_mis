<?php session_start();
include('config.php');
error_reporting(0);
$engid=$_REQUEST['engid'];
$_SESSION['engid'] = $engid ; 


if(isset($_REQUEST['engid'])){
    
}else{
$engid=$_SESSION['engid'] ; 
    
}
    $sql = mysqli_query($con,"select * from mis_loginusers where id=$engid");
    $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
            // Assigned ATM's
            $atmsql = mysqli_query($con,"select atmid from mis_newsite where engineer_user_id=$engid");
            while($atmsql_result = mysqli_fetch_assoc($atmsql)){
                $atmids[] = $atmsql_result['atmid'];
            }
            
            $_SESSION['assigned_atm'] = $atmids ; 

            
            
            
                $_SESSION['auth']=1;
                $_SESSION['username']=$sql_result['name'];
                $_SESSION['designation']=$sql_result['designation'];
                $_SESSION['userid'] = $sql_result['id'];
                 $_SESSION['level'] = $sql_result['level'];
                $userid = $sql_result['id'];
                
                if($uname == 'admin@gmail.com'){
                    $_SESSION['access']=1 ;
                }            
           }



if($_SESSION['username']){ 

include('header.php');


?>

<style>
html{
    text-transform: inherit !important;
}
    nav{
        display:none !important;
    }
    .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="expanded"][vertical-effect="shrink"] .pcoded-content {
    margin-left: 0;
}
.line-on-side {
    border-bottom: 1px solid #dadada;
    line-height: 0.1em;
    margin: 10px 0 20px;
}
.line-on-side span {
    background: #F6F7FB;
    padding: 0 10px;
}
</style>



<?
if(isset($_REQUEST['submit'])){
    
    $name = $_REQUEST['name'];
    $atmid = $_REQUEST['atmid'];
    $callBy = $_REQUEST['callBy'];
    $bank = $_REQUEST['bank'];
    $purpose = $_REQUEST['purpose'];
    
    echo $sql = "insert into appportal_atmvisit(`name`,atmid,callby,bank,purpose,created_by,status,created_at) 
    values('".$name."','".$atmid."','".$callBy."','".$bank."','".$purpose."','".$engid."',1,'".$datetime."')";
    
    if(mysqli_query($con,$sql)){ ?>
       <script>
           alert('Record Added !');
           window.location.href="appportal.php?engid=<? echo $engid; ?>";
       </script> 
    <? }
    
}



?>









<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">

                                
                                <h2 class="card-subtitle line-on-side center font-small-3 pt-2">
                                    <span>CSS App Portal</span>
                                </h2>
                                <div class="card">
                                    <div class="card-block">
                                        <ul class="nav">
                                              <li class="nav-item">
                                                <a class="nav-link" aria-current="page" id="project" href="appportalInstallation.php?engid=<? echo $engid; ?>">Project</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="sites" href="appportalSitestest.php?engid=<? echo $engid; ?>">Sites</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link active" id="ATMVisit" href="appportal.php?engid=<? echo $engid; ?>">ATM Visit</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" href="appvisitrecords.php?engid=<? echo $engid; ?>">Visit Records</a>
                                              </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>?engid=<? echo $engid; ?>" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Full Name</label>
                                                    <input name="name" class="form-control" value="<? echo $_SESSION['username']; ?>" type="text" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>ATMID</label>
                                                    <input type="text" name="atmid" class="form-control" required placeholer="ATMID .. ">

                                                </div>
                                                <div class="col-sm-12">
                                                    <br /><br /><br />
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
                                                        <option value="Dismantle">Dismantle</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <input type="text" name="other_remark" class="form-control" id="other_remark" style="display:none;">
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
          
<script>
    $(document).on('change','#purpose',function(){
        let purpose = $("#purpose").val();
        if(purpose=='Other'){
            $("#other_remark").css('display','block');
        }else{
            $("#other_remark").css('display','none');
        }

        
    })
</script>

<script>
     $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $('.js-example-basic-single').find(':selected');
        // maximumSelectionLength: 100
    });
    
    
    
</script>


                    
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