<?php include('config.php');


$contents='';
$contents.="Sr no \t activity \t customer \t bank \t atmid \t atmid2 \t atmid3 \t trackerno \t address \t city \t state \t zone \t branch \t bm_name \t bm_number \t created_by \t created_at \t remark \t  ";
// $contents.="Sr no \t activity \t customer \t bank \t atmid \t atmid2 \t atmid3 \t trackerno \t address \t city \t state \t zone \t branch \t bm_name \t bm_number \t created_by \t created_at \t remark \t pincode \t live_date \t ";


$i=1;

$sql = mysqli_query($con,"select * from mis_newsitetest_err where status=0");
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
    $contents.=$sql_result['remark']."\t";
    // $contents.=$sql_result['pincode']."\t";
    // $contents.=$sql_result['live_date']."\t";
    
    $i++; 
}



$contents = strip_tags($contents); 



  header("Content-Disposition: attachment; filename=error.xls");
  header("Content-Type: application/vnd.ms-excel");
  print $contents;
  
 
?>