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
                                            <div class="row form-group">
                                                 
                                                 <div class="col-md-6 form-group">
                                                     <label>Status</label>
                                                     <select class="form-control" name="type" >
                                                         <option value="1" <? if($_POST['type']==1) { echo 'selected' ;  }?>>Uptill Now</option>
                                                         <option value="2" <? if($_POST['type']==2){ echo 'selected' ;  }?>>Last Month</option>
                                                         
                                                     </select>
                                                     <?php
                                                 if(isset($_POST['type'])){
                                                     if($_POST['type']==2){
                                            $strdate1= date("d-m-Y", strtotime("first day of previous month"));
                                            $lastdate1= date("d-m-Y", strtotime("last day of previous month"));
                                            ?>
                                            Date From  <?=$strdate1?> To <?=$lastdate1?>
                                            <?php
                                                     }}
                                                 ?>
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
    
    <?php
    if(isset($_POST['type'])){
        $strdate= date("Y-m-d", strtotime("first day of previous month"));
        $lastdate= date("Y-m-d", strtotime("last day of previous month"));
        if($_POST['type']=='2')
        {
              $gettotalquery = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Vendor' AND created_at BETWEEN '".$strdate."' AND '".$lastdate."' group by atmid having noofreq>2")or die(mysql_error($con));
        }
        else
        {
              $gettotalquery = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Vendor' group by atmid having noofreq>2")or die(mysql_error($con));
        }
    
                  
    }else
    {
                    $gettotalquery = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Vendor' group by atmid having noofreq>2")or die(mysql_error($con));
    }
                    $gettotalrecords=  mysqli_fetch_assoc($gettotalquery);
                
                  
                  $reqamt=array();
                  $aprvamt=array();
                  $atmid=array();
                  $noofreq=array();
                  
                
                  
                 foreach ($gettotalquery as $key => $value) {
                     
                     $reqamt[]=$value['required_amount'];
                     $aprvamt[]=$value['aprvamt'];
                     $atmid[]='"'.$value['atmid'].'"';
                     $noofreq[]='"'.$value['noofreq'].'"';
                     
                    
                }
                $totalatms = implode(',',$atmid);
                $totalaprvamt = implode(',',$aprvamt);
                $totalreqamt = implode(',',$reqamt);
                $totalrequest = implode(',',$noofreq);


    ?>
                    <h4 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    <?php
                    if(isset($_POST['type'])){
                     $strdate= date("Y-m-d", strtotime("first day of previous month"));
                     $lastdate= date("Y-m-d", strtotime("last day of previous month"));
                    $link="&strdate=".$strdate."&enddate=".$lastdate;
                    }
                    else
                    {
                    $link="";
                    }
                    ?>
                    Vendor Request <a href="fund_showmore.php?type=Vendor<?=$link?>" style="float:right;" class="btn btn-sm btn-info text-right">Show More</a>
                  </h4>
                  <canvas id="orders-chart"></canvas>
                  <div id="orders-chart-legend" class="orders-chart-legend"></div>   
                     <br/>
    <br/>
    <br/>
                 
                 
                  <?php
                    if(isset($_POST['type'])){
        $strdate= date("Y-m-d", strtotime("first day of previous month"));
        $lastdate= date("Y-m-d", strtotime("last day of previous month"));
        if($_POST['type']=='2')
        {
              $gettotalquery1 = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Employee' AND created_at BETWEEN '".$strdate."' AND '".$lastdate."' group by atmid having noofreq>2")or die(mysql_error($con));
        }
        else
        {
              $gettotalquery1 = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Employee' group by atmid having noofreq>2")or die(mysql_error($con));
        }
    
                  
    }else
    {
                    $gettotalquery1 = mysqli_query($con,"SELECT atmid,required_amount,approval_amount, count(id) as noofreq,SUM(required_amount) as reqamt,SUM(approval_amount) as aprvamt FROM rnm_fund WHERE payee_type='Employee' group by atmid having noofreq>2")or die(mysql_error($con));
    }
     
                    $gettotalrecords1=  mysqli_fetch_assoc($gettotalquery1 );
                
                  
                  $reqamt1=array();
                  $aprvamt1=array();
                  $atmid1=array();
                  $noofreq1=array();
                  
                //   var_dump($gettotalrecords1);
                  
                
                  
                 foreach ($gettotalquery1 as $value1) {
                     
                     $reqamt1[]=$value1['required_amount1'];
                     $aprvamt1[]=$value1['aprvamt'];
                     $atmid1[]='"'.$value1['atmid'].'"';
                     $noofreq1[]='"'.$value1['noofreq'].'"';
                    //  echo $value1['noofreq1']." - ".$value1['atmid'];
                    //  echo "<br/>";
                     
                    
                }
                $totalatms1 = implode(',',$atmid1);
                $totalaprvamt1 = implode(',',$aprvamt1);
                $totalreqamt1 = implode(',',$reqamt1);
                $totalrequest1 = implode(',',$noofreq1);


    ?>
    
    </div>
    </div>
    <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
    
 
                    <h4 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    <?php
                    if(isset($_POST['type'])){
                     $strdate= date("Y-m-d", strtotime("first day of previous month"));
                     $lastdate= date("Y-m-d", strtotime("last day of previous month"));
                    $link="&strdate=".$strdate."&enddate=".$lastdate;
                    }
                    else
                    {
                    $link="";
                    }
                    ?>
                    Employee Request  <a href="fund_showmore.php?type=Employee<?=$link?>" style="float:right;" class="btn btn-sm btn-info text-right">Show More</a>
                  </h4>
                  <canvas id="request-chart"></canvas>
                  <div id="request-chart-legend" class="orders-chart-legend"></div>   
                  
                 
               
               
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
    if ($("#orders-chart").length) {
      var currentChartCanvas = $("#orders-chart").get(0).getContext("2d");
      var currentChart = new Chart(currentChartCanvas, {
        type: 'bar',
        data: {
          labels: [<?=$totalatms?>],
          datasets: [{
              label: 'No of Request',
              data: [<?=$totalrequest?>],
              backgroundColor: '#392c70'
            },
            // {
            //   label: 'Required Amount',
            //   data: [<?=$totalreqamt?>],
            //   backgroundColor: '#d1cede'
            // }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              gridLines: {
                drawBorder: false,
              },
              ticks: {
                stepSize: 2,
                fontColor: "#686868"
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true,
                fontColor: "#686868"
              },
              gridLines: {
                display: false,
              },
              barPercentage: 0.4
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          },
          legendCallback: function(chart) { 
            var text = [];
            text.push('<ul class="legend'+ chart.id +'">');
            for (var i = 0; i < chart.data.datasets.length; i++) {
              text.push('<li><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor + '"></span>');
              if (chart.data.datasets[i].label) {
                text.push(chart.data.datasets[i].label);
              }
              text.push('</li>');
            }
            text.push('</ul>');
            return text.join("");
          },
        }
      });
      document.getElementById('orders-chart-legend').innerHTML = currentChart.generateLegend();
    }
</script>

<script>
    if ($("#request-chart").length) {
      var currentChartCanvas = $("#request-chart").get(0).getContext("2d");
      var currentChart = new Chart(currentChartCanvas, {
        type: 'bar',
        data: {
          labels: [<?=$totalatms1?>],
          datasets: [{
              label: 'No of Request',
              data: [<?=$totalrequest1?>],
              backgroundColor: '#392c70'
            },
            // {
            //   label: 'Required Amount',
            //   data: [<?=$totalreqamt1?>],
            //   backgroundColor: '#d1cede'
            // }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              gridLines: {
                drawBorder: false,
              },
              ticks: {
                stepSize: 2,
                fontColor: "#686868"
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true,
                fontColor: "#686868"
              },
              gridLines: {
                display: false,
              },
              barPercentage: 0.4
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          },
          legendCallback: function(chart) { 
            var text = [];
            text.push('<ul class="legend'+ chart.id +'">');
            for (var i = 0; i < chart.data.datasets.length; i++) {
              text.push('<li><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor + '"></span>');
              if (chart.data.datasets[i].label) {
                text.push(chart.data.datasets[i].label);
              }
              text.push('</li>');
            }
            text.push('</ul>');
            return text.join("");
          },
        }
      });
      document.getElementById('request-chart-legend').innerHTML = currentChart.generateLegend();
    }
</script>





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