<?php include('config.php');


$contents='';
$contents.="Sr no \t activity \t customer \t bank \t atmid \t atmid2 \t atmid3 \t trackerno \t address \t city \t state \t zone \t branch \t bm_name \t bm_number \t created_by \t created_at \t remark \t";


$i=1;

$sql = mysqli_query($con,"select * from mis_newsite where status=1 order by id asc");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $contents.="\n".$i."\t";
    $contents.=$sql_result['activity']."\t";
    $contents.=$sql_result['customer']."\t";
    $contents.=$sql_result['bank']."\t";
    $contents.=$sql_result['atmid']."\t";
    $contents.=$sql_result['atmid2']."\t";
    $contents.=$sql_result['atmid3']."\t";
    $contents.=$sql_result['trackerno']."\t";
    $contents.=$sql_result['address']."\t";
    $contents.=$sql_result['city']."\t";
    $contents.=$sql_result['state']."\t";
    $contents.=$sql_result['zone']."\t";
    $contents.=$sql_result['branch']."\t";
    $contents.=$sql_result['bm_name']."\t";
    $contents.=$sql_result['bm_number']."\t";
    $contents.=$sql_result['created_by']."\t";
    $contents.=$sql_result['created_at']."\t";
    
    $i++; 
}



$contents = strip_tags($contents); 



  header("Content-Disposition: attachment; filename=All_sites.xls");
  header("Content-Type: application/vnd.ms-excel");
  print $contents;
  
 
?>