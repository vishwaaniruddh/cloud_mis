<? session_start();

if($_SESSION['username']){ 

include('header.php');


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
               
?>

        <script src="https://code.highcharts.com/highcharts.js"></script>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                
                                
                                
                                
                               


                                
                                <form>
                                    <?php $oncount = 0;
                                          $offcount = 0; $nvrcount = 0;
                                        $sql = mysqli_query($con,"SELECT id from mis_loginusers where  designation = 4 and user_status=1 ");
                                         $counteng = mysqli_num_rows($sql);
                                        if(mysqli_num_rows($sql)>0 ){
                                        while($res = mysqli_fetch_assoc($sql)){
                                            $eng_id = $res['id'];
                                            
                                             
                                            $statement = "select user_id,location,created_time from eng_locations where user_id='".$eng_id."' order by id desc limit 1";
                                             
                                            $sqle = mysqli_query($con,$statement);
                                            // $fetchrow = mysqli_fetch_row($sqle);
                                            // if($eng_id==277){
                                            //     echo mysqli_num_rows($sqle);
                                            // }
                                            if(mysqli_num_rows($sqle)>0 ){
                                                $engnamesql_res = mysqli_fetch_assoc($sqle);
                                                
                                                $eng_user_id = $engnamesql_res['user_id'];
                                                $location = $engnamesql_res['location'];
                                                
                                                $created_time = $engnamesql_res['created_time'];
                                                $created_date = date("Y-m-d", strtotime($created_time)); 
                                                
                                                $datetime = date("Y-m-d H:i:s");
                                                $date = date("Y-m-d");
                                                $start_date = new DateTime($datetime);  
                                                
                                                $since_start = $start_date->diff(new DateTime($created_time));
                                               
                                                $hr = $since_start->h;
                                                // echo 'Created Time : '. $created_time."<br>";
                                                // echo 'created_date' .$created_date."<br>";
                                                // echo $datetime."<br>"; die;
                                                
                                                if($date == $created_date) {
                                                    if($hr<=1)
                                                    {
                                                       $oncount =$oncount+1;
                                                       
                                                    }
                                                    else if($hr > 1){
                                                       $offcount = $offcount+1;
                                                    }
                                                }else{
                                                    $offcount = $offcount+1;
                                                }
                                            }else {
                                               $nvrcount = $nvrcount+1;
                                                
                                                
                                            }
                                        } 
                                    
                                    ?>

                                    <div class="row">
                                        
                                        
                                         <div class="col-xl-3 col-md-6">
                                            <div class="card" style="background:linear-gradient(to right,#fe9365,#feb798); color: white;">
                                            <div class="card-block">
                                            <div class="row align-items-center">
                                            <div class="col-8">
                                            <h4 class="f-w-600" style="color:white;"><?= $counteng; ?></h4>
                                            <h6 class="m-b-0" style="color:white;">Total Engineer</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <i class="feather icon-bar-chart f-28"></i>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>


                                        
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card" style="background:linear-gradient(to right,#0ac282,#0df3a3);color: white;">
                                            <div class="card-block">
                                            <div class="row align-items-center">
                                            <div class="col-8">
                                            <a href="total_status.php?status=<?php echo "online";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $oncount; ?> </h4></a>
                                            <h6 class="m-b-0" style="color:white;">Total Online</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <i class="feather icon-file-text f-28"></i>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                        
                                        
                                                                                
                                                                                
                                        <div class="col-xl-3 col-md-6">
                                        <div class="card" style="background:linear-gradient(to right,#fe5d70,#fe909d);color: white;">
                                        <div class="card-block">
                                        <div class="row align-items-center">
                                        <div class="col-8">
                                         <a href="total_status.php?status=<?php echo "offline";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $offcount; ?></h4></a> 
                                        <h6 class=" m-b-0" style="color:white;">Total Offline</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                        <i class="feather icon-calendar f-28"></i>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-xl-3 col-md-6">
                                        <div class="card" style="
    background: linear-gradient(to right,#01a9ac,#01dbdf);
    color: white;
">
                                        <div class="card-block">
                                        <div class="row align-items-center">
                                        <div class="col-8">
                                        <a href="total_status.php?status=<?php echo "neverused";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $nvrcount; ?></h4></a> 
                                        <h6 class="m-b-0" style="color:white;">Never Used</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                        <i class="feather icon-download f-28"></i>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                              
                                    </div>
                                    <? } ?>
                                </form>
                                <!--Filter End -->

                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        <div id="container" style="width:100%; height:400px;"></div>
    
    <ul style="display:flex;justify-content: center; ">
        
                                 
<?php
    $start = 0;
    $end = 240;
    $interval = 24;
    
    for ($i = $start; $i < $end; $i += $interval) {
        $rangeStart = $i;
        $rangeEnd = $i + $interval ;
        $series = "$rangeStart-$rangeEnd";
        
        ?>
        
        <li style="margin:5px;">
                <a style="color: red; font-weight: 600;" href="?to=<? echo $rangeStart ; ?>&&from=<? echo $rangeEnd; ?>">
                    <? echo $series ; ?>
                </a>
            
        </li>
        <?
        
        
    }
?>
    </ul>   
<? 
                                        
                                        
if(isset($_REQUEST['to']) && isset($_REQUEST['from'])){
    $to = $_REQUEST['to'];
    $from = $_REQUEST['from'];
}else{
    $to = 0 ;
    $from = 24 ; 
}

            
$mis_sql =  mysqli_query($con,"SELECT created_by, (SELECT CONCAT(name) from mis_loginusers WHERE id= a.created_by) AS eng_name, count(1) as mymisrecord FROM `mis_history` a WHERE

created_at >= DATE_SUB(NOW(), INTERVAL $from HOUR)
AND created_at < DATE_SUB(NOW(), INTERVAL $to HOUR)

and created_by is not null  
            group by created_by");
            $eng = '' ; 
            $mymisrecordcount = '';
while($mis_sql_result = mysqli_fetch_assoc($mis_sql)){
    $eng_name =  $mis_sql_result['eng_name'];
    $mymisrecord = $mis_sql_result['mymisrecord'];
    $eng .= "'$eng_name',";
    $mymisrecordcount .= $mymisrecord . ',';
    
}

$mymisrecordcount = rtrim($mymisrecordcount, ",");
$eng = rtrim($eng, ",");


?>                  
            
            
            
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                               <div class="card">
                                 <div class="card-block" style=" overflow: auto;">
                                   <h4 class="card-title">
                                    <!--<i class="fas fa-chart-pie"></i>-->
                                           
                                          </h4>
             <?php
// Fetch data from database
$sql = "SELECT status, 
       SUM(CASE WHEN zone = 'East' THEN 1 ELSE 0 END) AS EAST,
       SUM(CASE WHEN zone = 'North' THEN 1 ELSE 0 END) AS NORTH,
       SUM(CASE WHEN zone = 'South' THEN 1 ELSE 0 END) AS SOUTH,
       SUM(CASE WHEN zone = 'West' THEN 1 ELSE 0 END) AS WEST,
       COUNT(*) AS GRAND_TOTAL
FROM mis_details
WHERE zone IN ('East', 'North', 'South', 'West')
AND LOWER(status) IN (SELECT LOWER(status_code) FROM mis_status WHERE status = 1)
AND status NOT IN ('close','submitted')
GROUP BY status";

$query = mysqli_query($con, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($con)); // Debugging
}

// Initialize totals **before the loop**
$totalEast = 0;
$totalWest = 0;
$totalNorth = 0;
$totalSouth = 0;
$totalGrand = 0;

// Display data in table format
echo "<table border='1' cellpadding='5' cellspacing='0' class='table'>";
echo "<tr>
        <th>S.No.</th>
        <th>Current Status</th>
        <th>EAST</th>
        <th>NORTH</th>
        <th>SOUTH</th>
        <th>WEST</th>
        <th>GRAND TOTAL</th>
      </tr>";

$sno = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $status = urlencode($row['status']); // Encode status for URL
    $statusToPrint = ucwords(str_replace("_", " ", $row['status'])); 

    // Update totals inside the loop
    $totalEast += $row['EAST'];  
    $totalWest += $row['WEST'];  
    $totalNorth += $row['NORTH'];  
    $totalSouth += $row['SOUTH'];  
    $totalGrand += $row['GRAND_TOTAL'];  

    echo "<tr>
            <td>{$sno}</td>
            <td>{$statusToPrint}</td>
            <td><a href='mis_call_detail.php?status={$status}&zone=East'>{$row['EAST']}</a></td>
            <td><a href='mis_call_detail.php?status={$status}&zone=North'>{$row['NORTH']}</a></td>
            <td><a href='mis_call_detail.php?status={$status}&zone=South'>{$row['SOUTH']}</a></td>
            <td><a href='mis_call_detail.php?status={$status}&zone=West'>{$row['WEST']}</a></td>
            <td><a href='mis_call_detail.php?status={$status}'>{$row['GRAND_TOTAL']}</a></td>
          </tr>";
    $sno++;
}

// Print total row at the end **after the loop**
echo "<tr>
        <th></th>
        <th>Total</th>
        <th>{$totalEast}</th>
        <th>{$totalNorth}</th>
        <th>{$totalSouth}</th>
        <th>{$totalWest}</th>
        <th>{$totalGrand}</th>
      </tr>";

echo "</table>";
?>

  

<br/>
</div>
</div>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
                  
                  
        <script>
        
        document.addEventListener('DOMContentLoaded', function () {
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Last <? echo $to; ?> - <? echo $from ;?> Hours On MIS'
            },
            xAxis: {
                categories: [<? echo $eng; ?>]
            },
            yAxis: {
                title: {
                    text: 'Count'
                }
            },
            series: [{
                name: '',
                data: [<? echo $mymisrecordcount; ?>]
            }]
        });
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
</body>

</html>