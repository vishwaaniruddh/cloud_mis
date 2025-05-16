<? session_start();
include('config.php');

if($_SESSION['username']){ 


                $user_id = $_SESSION['userid'];  
                $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
                $user_sql = mysqli_query($con,$user_statement);
                $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
                $_userlevel = $user_rowresult[0];
               
            include('header.php');
            $_resultdata = 0;
            if(isset($_POST['apps'])){ 
              if(!empty($_POST['apps'])){
                    $app=$_POST['apps'];
                 echo '<pre>';print_r($app);echo '</pre>';die;
                if(!empty($app)){ 
                    for($x=0;$x<count($app);$x++){ 
                        $req_id = $app[$x];
                        $_getsql="select approved_amt,req_amt from mis_fund_requests_test where req_id='".$req_id."' order by id desc limit 1";
                        $_get_table=mysqli_query($con,$_getsql); 
                        $_get_table_result = mysqli_fetch_row($_get_table);
                        $req_amt = $_get_table_result[1];
                        $approved_amt = $_get_table_result[0];
                        $created_by = $_SESSION['userid'];
                        $action = 1;
                        $remarks = "Approved By Ashish";
                        $created_date = date('Y-m-d');
                        $status = 5;
                        
                        $sql = "insert into mis_fund_requests_test(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
                                values('".$req_id."','".$req_amt."','".$approved_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
                        mysqli_query($con,$sql);
                        
                        $updatesql = "update rnm_fund_test SET required_amount = '".$req_amt."', status= '".$status."' WHERE id = ".$req_id; 
                       
                        mysqli_query($con,$updatesql); 
                    }
                }
              }
            }
?>


<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />
<style>
              a:not([href]) {
                  padding: 5px;
              }
              .btn-group{
                      border: 1px solid #cccccc;
              }
              
              
              
              ul.dropdown-menu{
                  transform: translate3d(0px, 2%, 0px) !important;
                      overflow: scroll !important;
                      max-height:250px;
              }
          label{
                  font-weight: 900;
    font-size: 16px;
          }
          </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="row">
                                                 <div class="col-md-2">
                                                     <label>ATMID</label>  
                                                     <input type="text" name="atmid" class="form-control" value="<? if(isset($_POST['atmid'])) { echo $_POST['atmid']; } ?>">     
                                                 </div>
                                                 <div class="col-md-2">
                                                     <label>Customer</label>
                                                      <select id="multiselect" class="form-control" name="customer[]" multiple="multiple">
                                                        <?
                                                        $i = 0;
                                                        $con_sql = mysqli_query($con,"select * from contacts where type='c'");
                                                           while($con_sql_result = mysqli_fetch_assoc($con_sql)){ ?>
                                                              <option value="<? echo $con_sql_result['contact_first']; ?>" 
                                                              <? if(isset($_POST['customer'])) { if($_POST['customer'][$i]==  $con_sql_result['contact_first']){ echo 'selected'; } } ?>>
                                                           <? echo $con_sql_result['contact_first']; ?>
                                                                </option> 
                                                           <?
                                                           $i++;
                                                           } ?>
                                                     </select>   
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label>From Call Login Date</label>
                                                     <input type="date" name="fromdt" class="form-control" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">    
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label>To Call Login Date</label>
                                                     <input type="date" name="todt" class="form-control" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">    
                                                 </div>
                                                 <div class="col-md-2">
                                                     <label>Status</label>
                                                     <select id="multiselect_status" class="form-control" name="status[]" multiple="multiple">
                                                         <option value="pending" <? if(isset($_POST['status'])) { if(in_array('pending',$_POST['status'])){ echo 'selected' ;  }} ?>>Pending</option>
                                                         <option value="1" <? if(isset($_POST['status'])) { if(in_array('1',$_POST['status'])){ echo 'selected' ;  } } ?>>Approve</option>
                                                         <option value="0" <? if(isset($_POST['status'])) { if(in_array('0',$_POST['status'])){ echo 'selected' ;  } } ?>>Reject</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label>Level Type</label>
                                                     
                                                     <select id="multiselect_zone" class="form-control" name="zone[]" multiple="multiple">
                                                         <option value="3" <? if(isset($_POST['zone'])) {  if(in_array("3",$_POST['zone'])){ echo 'selected';}}?>>Operation</option>
                                                         <option value="4" <? if(isset($_POST['zone'])) {  if(in_array("4",$_POST['zone'])){ echo 'selected';}}?>>Manager</option>
                                                         <option value="5" <? if(isset($_POST['zone'])) {  if(in_array("5",$_POST['zone'])){ echo 'selected';}}?>>Director</option>
                                                          <? 
                                                              /*    $i = 0;
                                                          $state_sql = mysqli_query($con,"select level_name as zone,level_number from mis_esurveillance_levels");
                                                           while($state_sql_result = mysqli_fetch_assoc($state_sql)){ ?>
                                                              <option value="<? echo $state_sql_result['level_number']; ?>" 
                                                              <? if(isset($_POST['zone'])) {  if($_POST['zone'][$i] == $state_sql_result['level_number']){ echo 'selected';}}?>>
                                                                  <? echo ucfirst($state_sql_result['zone']); ?>
                                                              </option> 
                                                           <? $i++; } */?>
                                                     </select>
                                                 </div>
                                            </div>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>
                                <!--Filter Start -->
                                
                                
                                
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         
         <?
            if(!isset($_POST['submit'])){
                
               
                if($_userlevel==2){
                     $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id and b.action=1 and a.status=1";
                }elseif($_userlevel==3){
                     $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id and b.action=1 and a.status=3";
                }elseif($_userlevel==4){
                     $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id and b.action=1 and a.status=4";
                }else{
                     $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id";
                }
            }else{
                $statement = "select a.*,b.action from rnm_fund_test a, mis_fund_requests_test b where 1 and b.req_id = a.id" ;
                if(isset($_POST['status']) && $_POST['status'] != ''){
    $_status=json_encode($_POST['status']);
    $status=json_encode($_POST['status']);
    $status=str_replace( array('[',']','"') , ''  , $status);
    $arr_status=explode(',',$status);
     if(in_array("pending",$arr_status)){
         $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id";
     }
                }
                 
               /*  */
                    
                    
            }       
   
//         $statement = "select a.*,b.action from rnm_fund a, mis_fund_requests b where 1 and b.req_id = a.id" ;

      //   $statement = "select * from rnm_fund where 1";
             
             if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                 $statement .= " and a.atmid like '%".$_POST['atmid']."%'";
             }
            if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
{

$date1 = $_POST['fromdt'] ; 
$date2 = $_POST['todt'] ;

$statement .=" and CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."'";
}




if(isset($_POST['customer']) && $_POST['customer'] != ''){
    
    $cust=json_encode($_POST['customer']);
    $cust=str_replace( array('[',']','"') , ''  , $cust);
    $arr=explode(',',$cust);
    $cust = "'" . implode ( "', '", $arr )."'";
    $statement .=" and a.customer in($cust)" ;
}


$arr_status = array();

if(isset($_POST['status']) && $_POST['status'] != ''){
    $_status=json_encode($_POST['status']);
    $status=json_encode($_POST['status']);
    $status=str_replace( array('[',']','"') , ''  , $status);
    $arr_status=explode(',',$status);
    $status = "'" . implode ( "', '", $arr_status )."'";
    
    if(in_array("pending",$arr_status)){
        $statement .=" and b.action = 1" ;
    }else{
      $statement .=" and b.action in($status)" ;
    }
    

}else{
    //    $statement .=" and b.action in('0','1')" ;

}  


if(isset($_POST['zone']) && $_POST['zone'] != ''){
    
    $zone=json_encode($_POST['zone']);
    $zone=str_replace( array('[',']','"') , ''  , $zone);
    $arr_zone=explode(',',$zone);
    $zone = "'" . implode ( "', '", $arr_zone )."'";
    if(isset($_POST['status'])){
        if(in_array("pending",$arr_status)){
            if(in_array('3',$arr_zone)){
                $statement .=" and a.status =1" ;
            }else{
                if(in_array('4',$arr_zone)){
                    $statement .=" and a.status =3" ;
                }else{
                    $statement .=" and a.status =4" ;   
                }
            }
           
        }else{
             $statement .=" and b.status in($zone)" ;
        }
    }else{
        $statement .=" and b.status in($zone)" ;
    }

}else{
    if(in_array("pending",$arr_status)){
        if($_userlevel==2){
    $statement .=" and a.status=1" ;
        }
        if($_userlevel==3){
    $statement .=" and a.status=3" ;
        }
        if($_userlevel==4){
    $statement .=" and a.status=4" ;
        }
    }else{
    if(isset($_POST['submit'])){
        if($_userlevel==2){
    $statement .=" and b.created_by =".$user_id ;
        }
        if($_userlevel==3){
    $statement .=" and b.created_by =".$user_id ;
        }
        if($_userlevel==4){
    $statement .=" and b.created_by =".$user_id ;
        }
    }
    }
}

           $statement.= " ORDER BY a.id DESC";
       //  $statement.= " group BY b.req_id ORDER BY b.req_id DESC";
       //  $statement.= " order by id desc" ; 
         
         
        //  echo $statement ;
         ?>
        <!-- <input type="text" value="<?php //echo $statement;?>"> -->
         <style>
             .indication{
                 display:flex;
                 background:#404e67;
             }
             .indication span{
                 width:15px;
                 height:15px;
                 border:1px solid white;
                 border-radius:25px;
                 margin: 10px;
             }
             .open{
                 background:white;
             }
             .close{
                 background:#e29a9a;
             }
             .schedule{
                 background:#d09f45;
             }
   
   th.address, td.address {
    white-space: inherit;
}

         </style>
    <div style="display:flex;justify-content:space-around;">
        <h5 style="text-align:center;"></h5>
       
        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
    </div>     
        <hr>
                                <form id="form" action="show_fund1.php" method="POST">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="check"><input type="checkbox" id="flowcheckall" value="" />&nbsp;All</th>
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
                                                    <td>approved_amount</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                    <td>Action</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                               
                                                
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                $_view = 0;
                                                $_approveview = 0;
                                                
                                                $userfundaction = "select action,status,req_amt,approved_amt from mis_fund_requests_test where req_id=".$id." order by id desc" ;
                                                $userfundactionsql = mysqli_query($con,$userfundaction);
                                                $userfundaction_rowresult = mysqli_fetch_row($userfundactionsql);
                                                
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
                                                          if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==1){
                                                                 $_approveview = 1;
                                                                 $_view = 1;
                                                              }else{
                                                                  $_view = 1;
                                                              }
                                                          }
                                                        }
                                                        $_requestedamt = $userfundaction_rowresult[2];
                                                        $_status = 3;
                                                    }
                                                    if($level==3){
                                                        if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==3){
                                                                  if($userfundaction_rowresult[0]==1){
                                                                    $_approveview = 1;
                                                                    $_view = 1;
                                                                  }
                                                                 
                                                              }else{
                                                                  if($userfundaction_rowresult[1]>3){
                                                                     $_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 4;
                                                           $_requestedamt = $userfundaction_rowresult[3];
                                                    }
                                                    if($level==4){
                                                        if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==4){
                                                                 if($userfundaction_rowresult[0]==1){
                                                                    $_approveview = 1;
                                                                    $_view = 1;
                                                                  }
                                                                 
                                                              }else{
                                                                  if($userfundaction_rowresult[1]>4){
                                                                    $_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 5;
                                                           $_requestedamt = $userfundaction_rowresult[3];
                                                    }
                                                }
                                                ?>
                                                 <?php if($_view==1){?>
                                                    <tr>
                                                        <td>
                                                            <? if($_requestedamt<=2000){ ?>
                                                            <input type='checkbox' id="checkbox_<? echo $i; ?>" name='apps[]' value="<? echo $id; ?>" onclick="deductamt(<? echo $i; ?>)">
                                                            <? } ?>
                                                        </td>
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
                                                        <td><? echo $userfundaction_rowresult[3]; ?></td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>

                                                        <th>
                                                            <?php if($_SESSION['userid']!=$sql_result['created_by']){ 
                                                                    if($_approveview==1){
                                                                    ?>
                                                           <? //if($_requestedamt>2000){ ?>
                                                           <a id="approve_<? echo $id; ?>" data-toggle="modal" data-status="<? echo $_status; ?>" data-req_amt="<? echo $_requestedamt; ?>" data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Approve</a>
                                                            <?// } ?>
                                                            <?php //}else{ ?>
                                                               <a data-toggle="modal" data-status="<? echo $userfundaction_rowresult[1]; ?>" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">
                                                                  <? if($userfundaction_rowresult[0]==1){ ?>
                                                                   Details
                                                                  <? } else { ?>
                                                                   Rejected Details
                                                                  <? } ?>
                                                                   </a>
                                                           <?php } 
                                                           }else{ ?>    
                                                            <a this data-toggle="modal" data-status="<? echo $userfundaction_rowresult[1]; ?>" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">Details</a>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                <? } } ?>
                                            </tbody>
                                            <tr>
                                               <td>
                                                  <!-- <input style="cursor:pointer;" class="btn btn-primary" type="submit" name="submit" value="Payments">-->
                                                   <button onclick="checkButton()" style="cursor:pointer;" class="btn btn-primary" type="button" value="Confirm">Done</button>
                                                </td>
                                            </tr>
                                            </table>
                                        </form>    
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



<!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approve / Reject</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Approve / Reject RNM Fund </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="reqId" name="req_id">
                        <input type="hidden" id="reqStatus" name="status">
                        <div class="col-sm-4">
                            <label>Select Action</label>
                            <select name="action" class="form-control" id="action" onchange="selectAction(this.value)">
                                <option value="1">Approve</option>
                                <option value="0">Reject</option>
                            </select>    
                        </div>
                        <div class="col-sm-4">
                            <label>Requested Amount</label>
                            <input type="text" readonly name="req_amt" id="req_amt" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label>Approve Requested Amount</label>
                            <input type="number" name="approved_amt" class="form-control" id="approved_amt" value="0" min="1">
                        </div>
                        
                        <div class="col-sm-12">
                            <br>
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control" id="remarks">
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <input type="submit" name="submit" class="btn btn-success">
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>


<!-- large modal -->
<div class="modal fade" id="myModalDetail" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">History Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>RNM Fund Request and Approve Details</h6>
          <div class="card">
            <div class="card-block" id="result_status" style=" overflow: auto;">
              
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>


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
var oTableStaticFlow;
$(document).ready(function() {
    
    oTableStaticFlow = $('#example').DataTable( {
        columnDefs: [ {
            orderable: false,
            
        } ],
        
        order: [[ 1, 'asc' ]],
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
    
    $("#flowcheckall").click(function () { debugger;
     //  var total_req_amt = $("#total_requested_amt").val();
       
        //$('#flow-table tbody input[type="checkbox"]').prop('checked', this.checked);
        var cols = oTableStaticFlow.column(0).nodes(),
            state = this.checked;
            
      /*  if(state==true){
            
              $("#total_req_amt").val(total_req_amt);
        }else{
              $("#total_req_amt").val(0);
        }    
        */
        for (var i = 0; i < cols.length; i += 1) {
        	cols[i].querySelector("input[type='checkbox']").checked = state;
        	
        }
        
    });
    
    $("#flowcheckall").click();
    
} );

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_rnmfund_action1.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            var textmsg = "Approval Done";
            if(res[1]==0){
                textmsg = "Rejected Done";
            }
            $('#approve_'+res[0]).prop('href','#');
            $('#approve_'+res[0]).html(textmsg);
            
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });

$(document).on("click", ".open-AddBookDialog", function () {
     var reqId = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var reqStatus = $(this).data('status');
     $(".modal-body #reqId").val( reqId );
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #approved_amt").prop('max',req_amt );
     $(".modal-body #reqStatus").val( reqStatus );
});
$(document).on("click", ".open-DetailDialog", function () {
     var reqId = $(this).data('id');
     var reqStatus = $(this).data('status');
     $.ajax({    //create an ajax request to display.php
        type: "GET",
        url: "show_fund_details.php?req_id="+reqId,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $(".modal-body #result_status").html(response); 
            //alert(response);
        }
     });
    // $(".modal-body #result_status").val( reqStatus );
});
function selectAction(val){
    if(val==0){
        $("#approved_amt").prop('required',false);
        $("#approved_amt").prop('readonly',true);
        $("#remarks").prop('required',true);
        $("#approved_amt").prop('min',0);
    }else{
        $("#approved_amt").prop('required',true);
        $("#approved_amt").prop('readonly',false);
        $("#remarks").prop('required',false);
        $("#approved_amt").prop('min',1);
    }
}



    	$(document).ready(function() {
              $('#multiselect').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_bm').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                  $('#multiselect_status').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_zone').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
              
              
        });
                
    
        $("#show_filter").css('display','none');
    
        $("#hide_filter").on('click',function(){
           $("#filter").css('display','none');
           $("#show_filter").css('display','block');
        });
        $("#show_filter").on('click',function(){
          $("#filter").css('display','block');
           $("#show_filter").css('display','none');
        });
        
        function checkButton(){

                swal({
                    title: "Are you sure?",
                    text: "Once done, you cannot revert back so be sure before proceed !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: "No, cancel it!"
                 }).then(function(value) {
        				if (value) {
        			         $("#form").submit();
        				}else {
                            swal("Cancelled", "You cancel it :)", "error"); 
                            return false;
                        }
        			});
        
        }
        
        function deductamt(key){ debugger;
            /*var total_req_amt = $("#total_req_amt").val();
            var less_req_amt = $("#req_amt_"+key).html();
            var checked_or_not = $('#checkbox_'+key).prop("checked");
            var new_req_amt = parseFloat(total_req_amt) - parseFloat(less_req_amt);
            if(checked_or_not){
              new_req_amt = parseFloat(total_req_amt) + parseFloat(less_req_amt);
            }
            $("#total_req_amt").val(new_req_amt);*/
        }
       
       
        var isalertmsg = <? echo $_resultdata ?>;
        if(isalertmsg==1){
            swal("Good job!", "Selected Person Payments Added For Further Process!", "success");  
        }
              
        
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
</body>
</html>