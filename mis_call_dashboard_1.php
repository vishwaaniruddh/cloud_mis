<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
        function total_amount($con,$status,$zone){
            $close_east_query = mysqli_query($con,"SELECT COUNT(id) FROM `mis_details` WHERE status='".$status."' AND zone='".$zone."'");
            $close_east_query_res = mysqli_fetch_row($close_east_query); 
            $close_east_amt = $close_east_query_res[0];
            return $close_east_amt;
        }


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
  
                               <div class="card">
                                 <div class="card-block" style=" overflow: auto;">
                                   <h4 class="card-title">
                                    <i class="fas fa-chart-pie"></i>
                                           
                                          </h4>
                                          
                                          <div>
                                              <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:100%">
                                                  <thead>
                                                      <th>S.No.</th>
                                                      <th>Current Status</th>
                                                      <th>EAST</th>
                                                      <th>NORTH</th>
                                                      <th>SOUTH</th>
                                                      <th>WEST</th>
                                                      <th>GRAND TOTAL</th>
                                                  </thead>
                                                  <tbody>
                                                      <?php
                                                      
                                                        $close_east_amt = total_amount($con,'close','east');
                                                        $close_west_amt = total_amount($con,'close','west');
                                                        $close_north_amt = total_amount($con,'close','north');
                                                        $close_south_amt = total_amount($con,'close','south');
                                                        
                                                        $md_east_amt = total_amount($con,'material_delivered','east');
                                                        $md_west_amt = total_amount($con,'material_delivered','west');
                                                        $md_north_amt = total_amount($con,'material_delivered','north');
                                                        $md_south_amt = total_amount($con,'material_delivered','south');
                                                        
                                                        $mdis_east_amt = total_amount($con,'material_dispatch','east');
                                                        $mdis_west_amt = total_amount($con,'material_dispatch','west');
                                                        $mdis_north_amt = total_amount($con,'material_dispatch','north');
                                                        $mdis_south_amt = total_amount($con,'material_dispatch','south');
                                                        
                                                        $mip_east_amt = total_amount($con,'material_in_process','east');
                                                        $mip_west_amt = total_amount($con,'material_in_process','west');
                                                        $mip_north_amt = total_amount($con,'material_in_process','north');
                                                        $mip_south_amt = total_amount($con,'material_in_process','south');
                                                        
                                                        $mr_east_amt = total_amount($con,'material_requirement','east');
                                                        $mr_west_amt = total_amount($con,'material_requirement','west');
                                                        $mr_north_amt = total_amount($con,'material_requirement','north');
                                                        $mr_south_amt = total_amount($con,'material_requirement','south');
                                                        
                                                        $open_east_amt = total_amount($con,'open','east');
                                                        $open_west_amt = total_amount($con,'open','west');
                                                        $open_north_amt = total_amount($con,'open','north');
                                                        $open_south_amt = total_amount($con,'open','south');
                                                        
                                                        $pr_east_amt = total_amount($con,'permission_require','east');
                                                        $pr_west_amt = total_amount($con,'permission_require','west');
                                                        $pr_north_amt = total_amount($con,'permission_require','north');
                                                        $pr_south_amt = total_amount($con,'permission_require','south');
                                                        
                                                        $sch_east_amt = total_amount($con,'schedule','east');
                                                        $sch_west_amt = total_amount($con,'schedule','west');
                                                        $sch_north_amt = total_amount($con,'schedule','north');
                                                        $sch_south_amt = total_amount($con,'schedule','south');
                                                        
                                                        $open_grand_total = $open_east_amt + $open_north_amt + $open_south_amt + $open_west_amt; 
                                                        $mip_grand_total = $mip_east_amt + $mip_north_amt + $mip_south_amt + $mip_west_amt; 
                                                        $mr_grand_total = $mr_east_amt + $mr_north_amt + $mr_south_amt + $mr_west_amt; 
                                                        $mdis_grand_total = $mdis_east_amt + $mdis_north_amt + $mdis_south_amt + $mdis_west_amt;
                                                        
                                                        $pr_grand_total = $pr_east_amt + $pr_north_amt + $pr_south_amt + $pr_west_amt; 
                                                        $sch_grand_total = $sch_east_amt + $sch_north_amt + $sch_south_amt + $sch_west_amt; 
                                                        $md_grand_total = $md_east_amt + $md_north_amt + $md_south_amt + $md_west_amt; 
                                                        $close_grand_total = $close_east_amt + $close_north_amt + $close_south_amt + $close_west_amt; 
                                                        
                                                        $total_east = $open_east_amt + $mip_east_amt + $mr_east_amt + $mdis_east_amt + $pr_east_amt + $sch_east_amt + $md_east_amt + $close_east_amt;
                                                        $total_west = $open_west_amt + $mip_west_amt + $mr_west_amt + $mdis_west_amt + $pr_west_amt + $sch_west_amt + $md_west_amt + $close_west_amt;
                                                        $total_south = $open_south_amt + $mip_south_amt + $mr_south_amt + $mdis_south_amt + $pr_south_amt + $sch_south_amt + $md_south_amt + $close_south_amt;
                                                        $total_north = $open_north_amt + $mip_north_amt + $mr_north_amt + $mdis_north_amt + $pr_north_amt + $sch_north_amt + $md_north_amt + $close_north_amt;
                                                        $total_grand_total = $open_grand_total + $mip_grand_total + $mr_grand_total + $mdis_grand_total + $pr_grand_total + $sch_grand_total + $md_grand_total + $close_grand_total;
                                                        
                                                      ?>
                                                      <tr>
                                                          <td>1</td>
                                                          <td>OPEN</td>
                                                          <td><?= $open_east_amt?></td>
                                                          <td><?= $open_north_amt?></td>
                                                          <td><?= $open_south_amt?></td>
                                                          <td><?= $open_west_amt?></td>
                                                          <td><?= $open_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>2</td>
                                                          <td>Material In Process</td>
                                                          <td><?= $mip_east_amt?></td>
                                                          <td><?= $mip_north_amt?></td>
                                                          <td><?= $mip_south_amt?></td>
                                                          <td><?= $mip_west_amt?></td>
                                                          <td><?= $mip_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>3</td>
                                                          <td>Material Requirement</td>
                                                          <td><?= $mr_east_amt?></td>
                                                          <td><?= $mr_north_amt?></td>
                                                          <td><?= $mr_south_amt?></td>
                                                          <td><?= $mr_west_amt?></td>
                                                          <td><?= $mr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>4</td>
                                                          <td>Material Dispatch</td>
                                                          <td><?= $mdis_east_amt?></td>
                                                          <td><?= $mdis_north_amt?></td>
                                                          <td><?= $mdis_south_amt?></td>
                                                          <td><?= $mdis_west_amt?></td>
                                                          <td><?= $mdis_grand_total?></td>
                                                      </tr>
                                                      
                                                       <tr>
                                                           <td>5</td>
                                                          <td>Permission Require</td>
                                                          <td><?= $pr_east_amt?></td>
                                                          <td><?= $pr_north_amt?></td>
                                                          <td><?= $pr_south_amt?></td>
                                                          <td><?= $pr_west_amt?></td>
                                                          <td><?= $pr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>6</td>
                                                          <td>Schedule</td>
                                                          <td><?= $sch_east_amt?></td>
                                                          <td><?= $sch_north_amt?></td>
                                                          <td><?= $sch_south_amt?></td>
                                                          <td><?= $sch_west_amt?></td>
                                                          <td><?= $sch_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>7</td>
                                                          <td>Material Delivered</td>
                                                          <td><?= $md_east_amt?></td>
                                                          <td><?= $md_north_amt?></td>
                                                          <td><?= $md_south_amt?></td>
                                                          <td><?= $md_west_amt?></td>
                                                          <td><?= $md_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>8</td>
                                                          <td>Close</td>
                                                          <td><?= $close_east_amt?></td>
                                                          <td><?= $close_north_amt?></td>
                                                          <td><?= $close_south_amt?></td>
                                                          <td><?= $close_west_amt?></td>
                                                          <td><?= $close_grand_total?></td>
                                                      </tr>
                                                       <tr>
                                                          <td>9</td> 
                                                          <td>Grand Total</td>
                                                          <td><?= $total_east?></td>
                                                          <td><?= $total_north?></td>
                                                          <td><?= $total_south?></td>
                                                          <td><?= $total_west?></td>
                                                          <td><?= $total_grand_total?></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
               
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