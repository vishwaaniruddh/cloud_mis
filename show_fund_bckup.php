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
                                    <div class="card-block" style=" overflow: auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <td>type</td>
                                                    <td>subtype</td>
                                                    <td>atmid</td>
                                                    <td>bank</td>
                                                    <td>customer</td>
                                                    <td>zone</td>
                                                    <td>city</td>
                                                    <td>state</td>
                                                    <td>location</td>
                                                    
                                                    <td>attach</td>
                                                    <td>remark</td>
                                                    <td>created_by</td>
                                                    <!--<td>status</td>-->
                                                    <td>created_at</td>
                                                    <!--<td>added_pos</td>-->
                                                    <td>payee_type</td>
                                                    <td>fundDetails</td>
                                                    <td>approval_amount</td>
                                                    <td>required_amount</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                    <td>Action</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                
                                                if($_SESSION['position']==6 || $_SESSION['position']==5){
                                                    $statement = "select * from rnm_fund order by id desc" ;    
                                                }elseif($_SESSION['position']==2){
                                                    $statement = "select * from rnm_fund where added_pos=1 order by id desc" ;
                                                }elseif($_SESSION['position']==3){
                                                    $statement = "select * from rnm_fund where added_pos=2 order by id desc" ;
                                                }elseif($_SESSION['position']==4){
                                                    $statement = "select * from rnm_fund where added_pos=3 order by id desc" ;
                                                }elseif($_SESSION['position']==5){
                                                    $statement = "select * from rnm_fund where added_pos=4 order by id desc" ;
                                                }else{
                                                    $statement = "select * from rnm_fund order by id desc" ;
                                                }
                                                
                                                
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                $_view = 0;
                                                if($_SESSION['userid']==$sql_result['created_by']){
                                                    $_view = 1;
                                                }else{
                                                    $userid = $_SESSION['userid'];
                                                    $userstatement = "select level,cust_id from mis_loginusers where id=".$userid ;
                                                    $usersql = mysqli_query($con,$userstatement);
                                                    $sql_rowresult = mysqli_fetch_row($usersql);
                                                    $level = $sql_rowresult[0];
                                                    $cust_id = $sql_rowresult[1];
                                                    if($level==1){
                                                        if($_SESSION['userid']==$sql_result['created_by']){
                                                            $_view = 1;
                                                        }
                                                    }
                                                    if($level==2){
                                                        $_custarray = explode(",",$cust_id);
                                                        $_customer = $sql_result['customer'];
                                                        if (in_array($_customer, $_custarray)){
                                                           $_view = 1; 
                                                        }
                                                    }
                                                }
                                                ?>
                                                 <?php if($_view==1){?>
                                                    <tr>
                                                        <td><? echo ++$i; ?></td>
                                                        <td><? echo $sql_result['type']; ?> </td>
                                                        <td><? echo $sql_result['subtype']; ?> </td>
                                                        <td><? echo $sql_result['atmid']; ?> </td>
                                                        <td><? echo $sql_result['bank']; ?> </td>
                                                        <td><? echo $sql_result['customer']; ?> </td>
                                                        <td><? echo $sql_result['zone']; ?> </td>
                                                        <td><? echo $sql_result['city']; ?> </td>
                                                        <td><? echo $sql_result['state']; ?> </td>
                                                        <td><? echo $sql_result['location']; ?> </td>
                                                        
                                                        <td><a href="<? echo $sql_result['attach']; ?>" target="_blank">View</a> 
                                                        <a href="<? echo $sql_result['attach']; ?>" download>Download</a></td>
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                                       <!-- <td><? //echo $sql_result['status']; ?> </td> -->
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <!--<td><? //echo $sql_result['added_pos']; ?> </td>-->
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        <td><? echo $sql_result['approval_amount']; ?> </td>
                                                        <td><? echo $sql_result['required_amount']; ?> </td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>

                                                        <th>
                                                            <?php if($_SESSION['userid']!=$sql_result['created_by']){ ?>
                                                            <a class="btn btn-danger" href="approve_rnmFund.php?id=<? echo $id; ?>">Approve</a>
                                                            <?php } ?>    
                                                        </th>
                                                    </tr>
                                                <? } } ?>
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