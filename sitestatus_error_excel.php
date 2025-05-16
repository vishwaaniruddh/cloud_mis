<?php include('config.php');


$contents='';
$contents.="Sr no \t atmid \t dvr_status \t down_date \t current_status \t panel_status \t panel_down_date \t aging \t site_address \t created_by \t created_at \t";


$i=1;

$sql = mysqli_query($con,"select * from site_status_error where status=0");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $contents.="\n".$i."\t";
    $contents.=$sql_result['atmid']."\t";
    $contents.=$sql_result['dvr_status']."\t";
    $contents.=$sql_result['down_date']."\t";
    $contents.=$sql_result['current_status']."\t";
    $contents.=$sql_result['panel_status']."\t";
    $contents.=$sql_result['panel_down_date']."\t";
    $contents.=$sql_result['aging']."\t";
    $contents.=$sql_result['site_address']."\t";
    $contents.=$sql_result['created_by']."\t";
    $contents.=$sql_result['created_at']."\t";
    
    $i++; 
}



$contents = strip_tags($contents); 



  header("Content-Disposition: attachment; filename=error.xls");
  header("Content-Type: application/vnd.ms-excel");
  print $contents;
  
 
?>