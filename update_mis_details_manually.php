<? session_start();
date_default_timezone_set('Asia/Kolkata');

include('config.php');

$mis_details_sql = mysqli_query($con,"select * from mis_details where mis_city ='0'");
while($mis_details_sql_result  = mysqli_fetch_assoc($mis_details_sql)){
    $id = $mis_details_sql_result['id'];
    $atmid = $mis_details_sql_result['atmid'];
    $sql = mysqli_query($con, "select * from mis_newsite where atmid = '" . $atmid . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    $num_rows = mysqli_num_rows($sql);
    if($num_rows>0) {
        if(isset($atmid) && $atmid!='' ){
            $zone = $sql_result['zone'];
            $city = $sql_result['city'];
            $mis_city = 0;
            $mis_city_sql = mysqli_query($con,"select * from mis_city where city ='".$city."'");
            if($mis_city_sql_result  = mysqli_fetch_assoc($mis_city_sql)){
                $mis_city = $mis_city_sql_result['id'];    
            }
            $detail_statement = "update mis_details set mis_city='".$mis_city."',zone='".$zone."' where id = '" . $id . "'";
            if (mysqli_query($con, $detail_statement)) {
                echo 'record updated for ATMID: ' . $atmid;
                echo '<br>';
            }
        }
    }
}
