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
                                            <?=$_GET['type']?> Request     <a href="Fund_Chart.php" style="float:right;" class="btn btn-sm btn-danger text-right">Back</a>
                                          </h4>
                                          
                                          <div>
                                              <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                                  <thead>
                                                      <th>S.No.</th>
                                                      <th>ATM ID</th>
                                                      <th>Request</th>
                                                  </thead>
                                                  <tbody>
                                                      <?php
                                                      if(isset($_GET['type']))
                                                            {
                                                                if(isset($_GET['strdate']) && isset($_GET['enddate']))
                                                                {
                                                                    
                                                                    $strdate= $_GET['strdate'];
                                                                    $lastdate= $_GET['enddate'];
                                                                    $addquery="AND created_at BETWEEN '".$strdate."' AND '".$lastdate."'";
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    $addquery='';
                                                                }
                                                                $query="SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='".$_GET['type']."' $addquery group by atmid having noofreq>2";
                                                                  $gettotalquery = mysqli_query($con,$query)or die(mysql_error($con));
                                                            
                                                           
                                                      
                
                                                      foreach ($gettotalquery as $key => $value) {
                                                      ?>
                                                      <tr>
                                                          <td><?=$key+1?></td>
                                                          <td><?=$value['atmid']?></td>
                                                          <td><?=$value['noofreq']?></td>
                                                      </tr>
                                                      <?php
                                                      }}
                                                      ?>
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
</html