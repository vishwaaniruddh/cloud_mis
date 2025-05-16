<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
function get_mis_history($parameter,$type,$id){
    global $con;
    
    $sql = mysqli_query($con,"select $parameter from mis_history where type='".$type."' and mis_id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter]; 
}

?>

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
          
          
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style="overflow:auto;">
                                    <table class="table table-bordered table-striped" id="data_table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>SR</th>
                                                <!--<th>Delete</th>-->
                                                <th>TicketId</th>
                                                <th>Customer</th>
                                                <th>Bank</th>
                                                <th>Atmid</th>
                                                <th >Atm Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Component</th>
                                                <th>Sub Component</th>  
                                                <th>Current Status</th>
                                                <th>Status Remarks</th>
                                                <th>Schedule Date</th>
                                                <th>Material</th>
                                                <th>Material Remark</th>
                                                <th>Courier Agency (Material Dispatch)</th>
                                                <th>POD (Material Dispatch)</th>
                                                <th>Serial Number</th>
                                                <th>Material dispatch date </th>
                                                <th> Material Dispatch Remark</th>
                                                <th>Attachment (Close)</th>
                                                <th>Close Type</th>
                                                <th>Close Remark</th>
                                                <th>Last Action By</th>
                                                <th>Call Close Date</th>
                                                <th>Call Log Date</th>
                                                <th>Call Log By</th>
                                                <th>BM</th>
                                                <th>Aging</th>
                                                <th>Remark</th>
                                                <th>Engineer Name</th>
                                                <th>Engineer Contact Number</th>
                                            </tr>
                                          </thead>

                                        <?
                                        
$_status = $_REQUEST['status'];
if( $_REQUEST['status'] == ''){
    $statement ="select a.remarks,a.id,a.bank,a.customer,a.zone,a.state,b.id,b.mis_id,b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date from mis a, mis_details b 
    where 1 and b.mis_id = a.id and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','MRS','fund_required','service_center') 
    order by b.id desc";
}else{
    $type = $_REQUEST['type'];
    $statement ="select a.remarks,a.id,a.bank,a.customer,a.zone,a.state,b.id,b.mis_id,b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date from mis a, mis_details b 
    where 1 and b.mis_id = a.id and b.call_type='".$type."' 
    ";
    
        if($_status == 'schedule_today'){
        $statement .=" and DATE(b.created_at)=CURDATE() ";
    }
    $statement .=" order by b.id desc";
}

echo $statement ; 
?>
                                        
                                        
                                        
                                        
  <tbody>
  <? 
        $date = date('Y-m-d');
        $date1=date_create($date);
        
        $i=0;
        
        $sql = mysqli_query($con,$statement);
        while($sql_result = mysqli_fetch_assoc($sql)){
            
        $id = $sql_result['id'];
        $mis_id = $sql_result['mis_id'];
        $sql1 = mysqli_query($con,"select * from mis where id='".$mis_id."'");
        $sql1_result = mysqli_fetch_assoc($sql1);
        $customer = $sql1_result['customer'];
        $closed_date = $sql_result['close_date'];
        
        if($closed_date!='0000-00-00'){
                $date1=date_create($closed_date);
        }
        
        $date2=$sql_result['created_at'];
        $cust_date2 = date('Y-m-d' , strtotime($date2));
        
        $cust_date2 = date_create($cust_date2);
        $diff=date_diff($date1,$cust_date2);
        $atmid = $sql_result['atmid'] ;
        
        $bm_sql = mysqli_query($con,"select bm from atm_info where atmid like '".$atmid."'");
        $bm_sql_result = mysqli_fetch_assoc($bm_sql);
        $bm_name = $bm_sql_result['bm'];
        
        $site_sql = mysqli_query($con,"select DVRIP from sites where ATMID = '".$atmid."'");
        $site_sql_result = mysqli_fetch_assoc($site_sql);
        $dvrip = $site_sql_result['DVRIP'];
        $status = $sql_result['status'] ;
        $created_by = $sql1_result['created_by'];
        $aging_day = $diff->format("%a") ;  
        
        $lastactionsql = mysqli_query($con,"select * from mis_history where mis_id='".$id."' order by id desc");
        $lastactionsql_result = mysqli_fetch_assoc($lastactionsql);
        $lastactionuserid = $lastactionsql_result['created_by'];
        $status_remark = $lastactionsql_result['remark'];
       /* 
        $_subcomp = $sql_result['subcomponent'];
        $_compsql = mysqli_query($con,"select * from mis_subcomponent where name='".$_subcomp."' order by id desc");
        $_compsql_result = mysqli_fetch_assoc($_compsql);
        $_comp = $_compsql_result['component_id']; */
        
     //   mysqli_query($con,"update mis_details SET component='".$_comp."' where subcomponent='".$_subcomp."'");
        
        ?>
   <tr <? if($aging_day>3 && $status!='close' ){ ?> style="background:red;color:white;" <? } if($status=='close'){ ?> style="background:#28a745;color:white;" <?  } elseif($status=='schedule'){  ?> style="background:#6c757d;color:white;" <? } elseif($status=='open'){  ?> style="background:yellow;color:black;" <? }  ?>>
                        <td><? echo ++$i; ?></td>
                       <!-- <th><a href="delete_mis.php?id=<? echo $id;?>" <? if($aging_day>3 && $status!='close' ){ ?> style="color:white"  <? } ?>>Delete</a></th>-->
                        <td><a target="_blank" href="mis_details.php?id=<? echo $id ; ?>" <? if($aging_day>3 && $status!='close' ){ ?> style="color:white"  <? } ?> ><? echo $sql_result['ticket_id'];?></a></td>
                        <td><? echo $customer; ?></td>

                        <td><? echo $sql1_result['bank']; ?></td>
                        <td><? echo $atmid; ?></td>

                        <td>
                            <? echo $sql1_result['location']; ?>
                            
                        </td>
                        <td><? echo $sql1_result['city']; ?></td>
                        <td><? echo $sql1_result['state']; ?></td>
                        
                        <td><? echo $sql_result['component'];?></td>
                        <td><? echo $sql_result['subcomponent'];?></td>
                        <td><? echo $status;?></td>
                        <td><? echo $status_remark;?></td>
                       <!-- <td>
                            <form class="update_remark" method="POST">
                                <input type="hidden" value="<? echo $id;?>" name="misid">
                                <input type="text" name="update_remark" class="update_remark form-control">
                                <input type="submit" name="coupon_submit" class="btn btn-dark" value="Update Remark">        

                            </form>
                            
                        </td>-->
                        <!--<td><?// echo get_mis_history('remark','remark',$id);  ?></td>-->
                       <!-- <td><?// echo get_mis_history('remark','schedule',$id);  ?></td>-->
                        <td><? echo get_mis_history('schedule_date','schedule',$id);  ?></td>
                        <td><? echo get_mis_history('material','material_requirement',$id);  ?></td>
                        <td><? echo get_mis_history('remark','material_requirement',$id);  ?></td>
                        <td><? echo get_mis_history('courier_agency','material_dispatch',$id);  ?></td>
                        <td><? echo get_mis_history('pod','material_dispatch',$id);  ?></td>
                        <td><? echo get_mis_history('serial_number','material_dispatch',$id);  ?></td>
                        <td><? echo get_mis_history('dispatch_date','material_dispatch',$id);  ?></td>
                        <td><? echo get_mis_history('remark','material_dispatch',$id);  ?></td>
                        <td>
                        <? if(get_mis_history('attachment','close',$id)!=''){ ?> 
                        
                            <a target="_blank" href="http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo get_mis_history('attachment','close',$id);  ?>">http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo get_mis_history('attachment','close',$id);  ?></a>
                        <? }?>
                        
                        </td>
                        <td><? echo get_mis_history('close_type','close',$id);  ?></td>
                        <td><? echo get_mis_history('remark','close',$id);  ?></td>
                        <td><? echo get_member_name($lastactionuserid); ?></td>
                        <td><? echo get_mis_history('created_at','close',$id);  ?></td>
                        <td><? echo $sql_result['created_at']; ?></td>
                        <td><? echo get_member_name($created_by); ?></td>
                                                            
                        <td><? echo $bm_name ;?></td>
                        <td><? echo $diff->format("%a days");?></td>
                        <td><? echo $sql_result['remarks']; ?></td>
                        <td><? echo get_eng('eng',get_mis_history('engineer','schedule',$id));  ?></td>
                        <td><? echo get_eng('contact',get_mis_history('engineer','schedule',$id));  ?></td>
                        
                                                        </tr>
                                                     

<?    } ?>

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
    
    <script>
    

    
    
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
        
        

//         $(document).ready(function() {
//     $('#data_table').DataTable( {
//   "pageLength": 20      
//     });
// });    
        
        
        
// $(document).ready(function() {
//  //Initialize your table
//  var table = $('#data_table').dataTable();
//  //Get the total rows
//  $("#row_count").html('Total Records' + table.fnGetData().length);
// });




    </script>
    
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">


<script>

$(document).ready(function() {
    $('#data_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy',
            'excel',
            'csv',
            'pdf',
           ]
    } );
} );

</script>

</body>
</html>