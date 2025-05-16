<? session_start();
include('config.php');
include('function.php');
$req_id = $_GET['req_id'];
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <td>Requested Amount</td>
                                                    <td>Approved Amount</td>
                                                    <td>Approved By</td>
                                                    <td>Created Date</td>
                                                    <td>Status</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
            <?  $statement = "select * from mis_fund_requests where req_id=".$req_id." order by id desc" ;
                $i = 0 ; 
                $sql = mysqli_query($con,$statement);
                while($sql_result = mysqli_fetch_assoc($sql)){  
                     $status = $sql_result['status'];
                     $_action = $sql_result['action'];
                       if($status==1){
                           $action = "Operation Level Approval Pending ";
                       }  
                       if($status==3){
                           
                           if($prevstatus==4){
                              $action = "Operation Level Approval Done ";
                           }else{
                               if($_action==0){
                                  $action = "Operation Level Rejected"; 
                               }else{
                                  $action = "Operation Level Approval Done & Manager Level Approval Pending ";
                               }
                           }
                       }  
                       if($status==4){
                           if($prevstatus==5){
                                $action = "Manager Level Approval Done ";
                           }else{
                               if($_action==0){
                                  $action = "Manager Level Rejected"; 
                               }else{
                                  $action = "Manager Level Approval Done & Director Level Approval Pending ";
                               }
                              
                           }
                       } 
                       if($status==5){
                           $action = "Director Level Approval Done ";
                       } 
                    $prevstatus = $status;
            ?>
                                <tr>
                                    <td><? echo ++$i; ?></td>
                                    <td><? echo $sql_result['req_amt']; ?> </td>
                                    <td><? echo $sql_result['approved_amt']; ?> </td>
                                    <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                    <td><? echo $sql_result['created_date']; ?> </td>
                                    <td><? echo $action; ?> </td> 
                                </tr>    
    <? }?>   
    </tbody>
                                            </table>
   