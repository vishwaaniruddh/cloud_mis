<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');



$host="localhost";
$user="u444388293_cncindia";
$pass="CNCIndia2024#";
$dbname="u444388293_cncindia";
$css = new mysqli($host, $user, $pass, $dbname);


$host="localhost";
$user = "u444388293_cssInventory";
$pass = "cssInventory@2024#";
$dbname= "u444388293_cssInventory";
$conn = new mysqli($host, $user, $pass, $dbname);


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);




function get_material($id){
    global $css;
    
    $sql = mysqli_query($css,"Select * from material where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['material'];
}

function mis_details_data($parameter,$id){
    global $css;
    
    $sql = mysqli_query($css,"select $parameter from mis_details where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter];
}

function mis_history_data($parameter,$id){
    global $css;
    $sql = mysqli_query($css,"select $parameter from mis_history where mis_id='".$id."' and $parameter is not null and $parameter <> '' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter];
}


?>

								<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script>
            function search(strPage,perpg){
                
                var oit=document.getElementById("oit").value;
        
var Page="";
if(strPage!="")
{
Page=strPage;
}

var perp='';
if(perpg=='')
perp='50';
else
perp=document.getElementById(perpg).value;



            $.ajax({
   type: 'POST',    
   url:'dashboard1_process.php',
  
    //data:'oit='+oit+'&Page='+Page+'&perpg='+perp,
    data:'oit='+oit+'&Page='+Page+'&perpg='+perp,

   success: function(msg){
    
    
   //alert(msg);
   document.getElementById("show").innerHTML=msg;
   
   
   
} })
            }
        </script>
        
        
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
            <div class="row">
                    <div class="col-md-9">
                        
                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="col-md-6">
                            <select id="status" class="form-control" name="status">
                                 <option value="1" <? if(isset($_POST['status'])) { if($_POST['status']=='1'){ echo 'selected' ;  }} ?>>Material Requirement</option>
                                 <option value="5" <? if(isset($_POST['status'])) { if($_POST['status']=='5'){ echo 'selected' ;  }} ?>>Confirm Processed</option>
                                 <option value="2" <? if(isset($_POST['status'])) { if($_POST['status']=='2'){ echo 'selected' ;  }} ?>>Available</option>
                                 
                                 <option value="0" <? if(isset($_POST['status'])) { if($_POST['status']=='0'){ echo 'selected' ;  }} ?>>Cancelled</option>
                                 <option value="3" <? if(isset($_POST['status'])) { if($_POST['status']=='3'){ echo 'selected' ;  }} ?>>Not Available</option>
                                 <option value="4" <? if(isset($_POST['status'])) { if($_POST['status']=='4'){ echo 'selected' ;  }} ?>>Dispatched</option>
                            </select>
                            </div>
                            <div class="col-md-3">
                                <input type="submit" value="Search">
                            </div>
                        </form>    
                    </div>
            </div>
        </div>
    </div>    
    <div class="card">
        <div class="card-block">
            <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
            <table  id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Actions</th>
                            <th>Ticket ID</th>
                            <th>Customer</th>
                            <th>Bank</th>
                            <th>ATM ID</th>
                            <th>CTS BM</th>
                            <th>Material Condition</th>
                            <th>Require Material Name</th>
                            <th>Dispatch Address</th>
                            <th>Contact Person Name</th>
                            <th>Contact Person Mobile</th>
                            <th>Remark</th>
                            <th>Created Date</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zone</th>
                            <th>MIS ID</th>
                            <th>Created By</th>
                        </tr> 
                    </thead>
                            <tbody>
                                <? $view = 0;
                                if(isset($_POST['status'])){
                                    $_status = $_POST['status'];
                                  //  SELECT * FROM `material_inventory` WHERE status=1 and mis_id IN (select mis_id from mis_details)
                                  if($_status==1){
                                      $query = "SELECT * FROM `material_inventory` WHERE status='".$_status."' AND material_inventory.mis_id IN (select mis_details.id from mis_details, mis WHERE mis.id = mis_details.mis_id and mis_details.status='material_requirement') order by id desc";
                                  }else{
                                      $query = "select * from material_inventory where status='".$_status."' group by mis_id order by id desc";
                                  }
                                    
                                    $view = 1; 
                                }else{
                                   // $query = "select * from material_inventory where status=2 order by id desc";
                                   $query = "";
                                }
                                

                                if($view==1){
                                $i=1;
                                $sql = mysqli_query($css,$query);
                                
                               // echo mysqli_num_rows($sql);
                                if(mysqli_num_rows($sql)>0){
                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                $id = $sql_result['id'];
                                $mis_id = $sql_result['mis_id'];
                                
                                $misdetail_sql = mysqli_query($css,"select * from mis_details where id='".$mis_id."'");
                                $count = mysqli_num_rows($misdetail_sql);
                                $misdetail_sql_result = mysqli_fetch_assoc($misdetail_sql);
                                $main_mis = $misdetail_sql_result['mis_id'];
                                
                                $current_status = $misdetail_sql_result['status'];
                                
                                $mis_sql = mysqli_query($css,"select * from mis where id='".$main_mis."'");
                                $mis_sql_result = mysqli_fetch_assoc($mis_sql);
                                $location = $mis_sql_result['location'];
                                $state = $mis_sql_result['state'];
                                $zone = $mis_sql_result['zone'];
                                $city = $mis_sql_result['city'];
                                $customer = $mis_sql_result['customer'];
                                $bank = $mis_sql_result['bank'];
                                $_atmid = $mis_sql_result['atmid'];
                               // $_atmid = mis_details_data('atmid',$sql_result['mis_id']);
                                $bm_sql = mysqli_query($css,"select bm from atm_info where atmid like '".$_atmid."'");
                                $bm_sql_result = mysqli_fetch_assoc($bm_sql);
                                $bm = $bm_sql_result['bm'];
                                
                                $mis_history = mysqli_query($css,"select material_condition,created_by from mis_history where mis_id='".$mis_id."' AND type='".$current_status."'");
                                $mis_his_count = mysqli_num_rows($mis_history);
                                $user_created_by = "";
                                if($mis_his_count>0){
                                  $mis_his_sql_result = mysqli_fetch_assoc($mis_history);
                                  $created_by_id = $mis_his_sql_result['created_by'];
                                  if($created_by_id>0){
                                      $mis_created_by_sql = mysqli_query($css,"select name from mis_loginusers where id='".$created_by_id."'");
                                      $mis_created_by_count = mysqli_num_rows($mis_created_by_sql);
                                      if($mis_created_by_count>0){
                                          $mis_user_sql_result = mysqli_fetch_assoc($mis_created_by_sql);
                                          $user_created_by = $mis_user_sql_result['name'];
                                      }
                                  }
                                  
                                $material_condition = $mis_his_sql_result['material_condition'];
                                $contact_person_name = $mis_his_sql_result['contact_person_name']; 
                                }
                                
                                if($count>0){
                                ?>
                                    <tr>
                                        <td><? echo $i; ?></td>  
                                        <td>
                                            <a target="_blank" class="btn btn-info" href="material_update.php?id=<? echo $sql_result['mis_id']; ?>">View</a>
                                            <?php if($sql_result['status']==1) { ?>
                                            <a data-id="<? echo $sql_result['mis_id']; ?>" class="open-Accept btn btn-success">Accept</a>
                                            <?php } ?>
                                            <?php if($sql_result['status']==1 || $sql_result['status']==2){ ?>
                                            <!--<a data-toggle="modal" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModal">Cancel</a>    -->
                                            <?php } if($sql_result['status']==2){ ?>
                                            <a data-toggle="modal" data-misid="<? echo $mis_id; ?>" data-id="<? echo $id; ?>" class="open-DetailPOD-Dialog btn btn-success" href="#myPODModal">POD</a>   
                                            <?php } ?>
                                        </td>
                                       
                                        <td><? echo mis_details_data('ticket_id',$sql_result['mis_id']);?></td>
                                        <td><? echo $customer;?></td>
                                        <td><? echo $bank;?></td>
                                        <td><? echo mis_details_data('atmid',$sql_result['mis_id']);?></td>
                                        <td><? echo $bm; ?></td>
                                        <td><? echo $material_condition ; ?></td>
                                        <td><? echo $sql_result['material']; ?><?// echo get_material($sql_result['material']);?></td> <? //echo mis_history_data('material',$mis_id);?>
                                        <td><? echo mis_history_data('delivery_address',$sql_result['mis_id']);?></td>
                                        <td><? echo mis_history_data('contact_person_name',$sql_result['mis_id']) ;?></td>
                                        <td><? echo mis_history_data('contact_person_mob',$sql_result['mis_id']);?></td>
                                        
                                        <td><? echo mis_history_data('remark',$sql_result['mis_id']);?></td>
                                        <td><? echo $sql_result['created_at']; ?></td>
                                        <td><? echo $location; ?></td>
                                        <td><? echo $city; ?></td>
                                        <td><? echo $state; ?></td>
                                        <td><? echo $zone; ?></td>
                                       <!-- <td>
                                            <tr>
                                            <td><a target="_blank" class="btn btn-info" href="material_update.php?id=<? echo $sql_result['mis_id']; ?>">View</a></td>
                                            <?php if($sql_result['status']==1 || $sql_result['status']==2){ ?>
                                            <td><a data-toggle="modal" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModal">Cancel</a></td>    
                                            <?php } if($sql_result['status']==2){ ?>
                                            <td><a data-toggle="modal" data-misid="<? echo $mis_id; ?>" data-id="<? echo $id; ?>" class="open-DetailPOD-Dialog btn btn-success" href="#myPODModal">POD</a></td>    
                                            <?php } ?>
                                            </tr> 
                                        </td> -->
                                         <td><? echo $sql_result['mis_id']; ?></td>
                                         <td><? echo $user_created_by;?></td>
                                    </tr>
                                <? $i++; } } } }?>

                            </tbody>
                </table>
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
        <h4 class="modal-title" id="myModalLabel">Cancel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Cancel </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="reqId" name="id">
                        <input type="hidden" name="status" value="0">
                        <div class="col-sm-12">
                            <br>
                            <label>Remarks</label>
                            <input type="text" required name="cancel_remarks" class="form-control" id="remarks">
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
<div class="modal fade" id="myPODModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">POD</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>POD </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="tableId" name="id">
                        <input type="hidden" id="misId" name="mis_id">
                        <input type="hidden" name="status" value="4">
                        <div class="col-sm-6">
                            <label>POD</label>
                            <input type="text" required name="pod" class="form-control" id="pod">
                        </div>
                        <div class="col-sm-6">
                            <label>Courier Name</label>
                            <input type="text" name="courier_name" class="form-control" id="courier_name">
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





<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<!--<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />-->


<script src="https://code.jquery.com/jquery-3.7.0.jss"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
   $(document).ready(function() {
var oTable = $('#example').DataTable( {
        dom: 'Blfrtip',
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    } );

} );
</script>
<script>
$('#myModal form').on('submit', function (e) {
          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'material_process_action.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { 
                console.log(msg) ;
                
              if(msg==1){
                  swal("Success","Cancelled Successfully","success");
                  setTimeout(() => {
                      location.reload();
                  },1000);
                   
              }else{
                  swal("Error","Unable to proceed your request","error");
                    $("#myModal .btn-success").show();
                    $('#myModal').modal('toggle'); 
              }
            
            }
          });

        });

$(document).on("click", ".open-DetailDialog", function () {
     var reqId = $(this).data('id');
     $(".modal-body #reqId").val( reqId );
});

function allLetter(inputtxt)
    { 
      var letters = /^[A-Za-z]+$/;
      if(inputtxt.match(letters))
      {
         return 1;
      }
      else
      {
         return 0;
      }
    }
$('#myPODModal form').on('submit', function (e) { 
        var courier_name = $("#courier_name").val();
        if(allLetter(courier_name)){
          e.preventDefault();
              $("#myPODModal .btn-success").hide();
              $.ajax({
                type: 'post',
                url: 'material_process_action.php',
                data: $('#myPODModal form').serialize(),
                success: function (msg) { debugger;
                   if(msg==1){
                       swal("Success","Processed Successfully","success");
                       setTimeout(() => {
                           location.reload();
                       },1000);
                       
                   }else{
                       swal("Error","Unable to proceed your request","error");
                        $("#myModal .btn-success").show();
                        $('#myModal').modal('toggle'); 
                   }
                
                }
              });
        }else{
            swal("Error","Courier Name Must have Alphabets Only","error");
            return false;
        }

});
$(document).on("click", ".open-DetailPOD-Dialog", function () {
     var reqId = $(this).data('id');
     $(".modal-body #tableId").val( reqId );
     var misId = $(this).data('misid');
     $(".modal-body #misId").val( misId );
});
$(document).on("click", ".open-Accept", function () {
     var Id = $(this).data('id');
     swal({
    title: "Are you sure?",
    text: "Check before proceed!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, accept it!",
    cancelButtonText: "No, cancel plz!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
    function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: 'POST',
          url: 'material_request_accept.php',
          data: {id:Id},
          success: function (msg) {
              if(msg==1)
                 swal("Accept!", "Material Request has been accepted.", "success");
              else
                 swal("NOT Accepted!", "Something blew up.", "error");
          },
          error: function (msg) {
            swal("NOT Accepted!", "Something blew up.", "error");
          }
        });
      } else {
        swal("Cancelled", "Material Request has not been accepted :)", "error");
      }
    });

  return false;
     
});
</script>

</body>

                                        
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


