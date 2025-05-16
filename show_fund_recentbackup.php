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
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
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
                                                         <option value="6" <? if(isset($_POST['zone'])) {  if(in_array("6",$_POST['zone'])){ echo 'selected';}}?>>Transfer Done</option>
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
                                         
         <?php  $_ispostsubmit = 0; $_isfundtransfer = 0;
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
                $_ispostsubmit = 1;
                $statement = "select a.*,b.action from rnm_fund a, mis_fund_requests b where 1 and b.req_id = a.id" ;
                if(isset($_POST['status']) && $_POST['status'] != ''){
                    $_status=json_encode($_POST['status']);
                    $status=json_encode($_POST['status']);
                    $status=str_replace( array('[',']','"') , ''  , $status);
                    $arr_status=explode(',',$status);
                    if(in_array("pending",$arr_status)){
                        $statement = "select a.*,b.action,b.req_id from rnm_fund a, 
                                    (select mfr.action,mfr.req_id,mfr.id from mis_fund_requests mfr ,(select req_id,max(id) as RequestID from mis_fund_requests GROUP BY req_id) t1 
                                    WHERE mfr.req_id=t1.req_id and mfr.id = t1.RequestID) b where 1 and b.req_id = a.id";
                      //  $_isfundtransfer = 1;
                    }
                }
             
                    
                    
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
        $statement .=" and b.action in(1,2)" ;
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
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
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
                                                    <td>approved_amount</td>
                                                    <td>transfer/reject amount</td>
                                                    <td>transfer date</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                    <td>Rejected Remarks</td>
                                                    <td>Action</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?php $checkatmarray = array();
                                               if($_ispostsubmit == 1){
                                                    
                                                   if(is_array($arr_zone)){
                                                         if(in_array('6',$arr_zone)){
                                                            $_isfundtransfer = 1;   
                                                         }
                                                   }
                                                }
                                               
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                $_view = 0;
                                                $_approveview = 0;
                                                
                                                
                                              //  if($_ispostsubmit == 1){ 
                                                    $rnm_fund_status = $sql_result['status'];
                                                    if($rnm_fund_status==6){
                                                        $_isfundtransfer = 1; 
                                                    }
                                               //  }
                                                
                                                $transfer_amount = 0; 
                                                $_istransferdone = 1; 
                                                $_rejected_remarks = "";
                                                $transferred_date = '-';
                                                
                                                if($_isfundtransfer == 1){ 
                                                    $userfundtransferstmt = "select status,current_status,approved_amt,remarks,transferred_date from mis_fund_transfer where req_id='".$id."' order by id desc limit 1" ;
                                                    $userfundtransfersql = mysqli_query($con,$userfundtransferstmt);
                                                    $userfundtransfer_rowresult = mysqli_fetch_row($userfundtransfersql);
                                                  //  if($userfundtransfer_rowresult[0]==3 && $userfundtransfer_rowresult[1]==4){
                                                   
                                                    if($userfundtransfer_rowresult[0]==3){
                                                        $_istransferdone = 1;
                                                        if($userfundtransfer_rowresult[1]==4){
                                                            $transferred_date = $userfundtransfer_rowresult[4];
                                                        }
                                                    }else{
                                                        $_istransferdone = 0;
                                                    }
                                                    
                                                    $transfer_amount = $userfundtransfer_rowresult[2]; 
                                                    if($userfundtransfer_rowresult[1]==0){
                                                        $_rejected_remarks = $userfundtransfer_rowresult[3];
                                                    }
                                                }
                                                
                                                $userfundaction = "select action,status,req_amt,approved_amt from mis_fund_requests where req_id='".$id."' order by id desc limit 1" ;
                                                $userfundactionsql = mysqli_query($con,$userfundaction);
                                                $userfundaction_rowresult = mysqli_fetch_row($userfundactionsql);
                                                 
                                                //echo $_istransferdone."==";
                                                       
                                                        if($_SESSION['userid']==$sql_result['created_by']){ 
                                                            $_view = 1;
                                                        }else{
                                                          if($_istransferdone==1){ 
                                                            $userid = $_SESSION['userid'];
                                                            $userstatement = "select level,cust_id from mis_loginusers where id=".$userid ;
                                                            $usersql = mysqli_query($con,$userstatement);
                                                            $sql_rowresult = mysqli_fetch_row($usersql);
                                                            $level = $sql_rowresult[0];
                                                            $cust_id = $sql_rowresult[1];
                                                           // echo $level;
                                                            if($level==1){
                                                                if($_SESSION['userid']==$sql_result['created_by']){ 
                                                                  //  echo $sql_result['id'];
                                                                    $_view = 1;
                                                                }
                                                               //   $_view = 1;
                                                            }
                                                            
                                                            
                                                            if($level==2){
                                                                if($cust_id=='All'){
                                                                    $_view = 1;
                                                                }else{
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
                                                    }
                                                ?>
                                                 <?php if($_view==1){
                                                 
                                                    $style = 0; 
                                                    if(!in_array($sql_result['atmid'],$checkatmarray)){
                                                            array_push($checkatmarray,$checkatmarray);  
                                                    }else{
                                                        $style  = 1;
                                                    }
                                                 ?>
                                                    <tr>
                                                        <td><? echo ++$i; ?></td>
                                                        <td><? echo $sql_result['type']; ?> </td>
                                                        <td><? echo $sql_result['subtype']; ?> </td>
                                                        <td><span <? if($status=='1'){ ?> style="background:red;color: yellow;" <? } ?>><? echo $sql_result['atmid']; ?></span> </td>
                                                        <td><? echo $sql_result['bank']; ?> </td>
                                                        <td><? echo $sql_result['customer']; ?> </td>
                                                        <td><? echo $sql_result['zone']; ?> </td>
                                                        <td><? echo $sql_result['city']; ?> </td>
                                                        <td><? echo $sql_result['state']; ?> </td>
                                                        <td><? echo $sql_result['location']; ?> </td>
                                                        
                                                        <td>
                                                            <? if($sql_result['attach']!=""){ ?>
                                                            <a href="<? echo $sql_result['attach']; ?>" target="_blank">View</a> 
                                                            <a href="<? echo $sql_result['attach']; ?>" download>Download</a>
                                                            <? }else{ ?>
                                                            No File Attach
                                                            <? } ?>
                                                        </td>
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                                       <!-- <td><? //echo $sql_result['status']; ?> </td> -->
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <!--<td><? //echo $sql_result['added_pos']; ?> </td>-->
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        <td><? echo $sql_result['approval_amount']; ?> </td>
                                                        <td><? echo $sql_result['required_amount']; ?> </td>
                                                        <td><? echo $transfer_amount; ?></td>
                                                        
                                                        <td><? echo $userfundaction_rowresult[3]; ?></td>
                                                        <td><? echo $transferred_date; ?></td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>
                                                        <td><? echo $_rejected_remarks; ?></td>
                                                        <th>
                                                            <?php if($_SESSION['userid']!=$sql_result['created_by']){ 
                                                                    if($_approveview==1){
                                                                    ?>
                                                           <!-- <a data-toggle="modal" class="btn btn-danger" href="approve_rnmFund.php?id=<? echo $id; ?>">Approve</a>-->
                                                           <a id="approve_<? echo $id; ?>" data-toggle="modal" data-status="<? echo $_status; ?>" data-req_amt="<? echo $_requestedamt; ?>" data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Approve</a>
                                                            <?php }else{ ?>
                                                               <a data-toggle="modal" data-status="<? echo $userfundaction_rowresult[1]; ?>" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">
                                                                  <? if($userfundaction_rowresult[0]>0){ ?>
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
                                            </table>
                                            
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

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_rnmfund_action.php',
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
        
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
</body>
</html>