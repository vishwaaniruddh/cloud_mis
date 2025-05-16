<?php include('config.php');


$contents='';
$contents.="Sr no \t name \t username \t password \t contact \t ";


$i=1;

$sql = mysqli_query($con,"select * from mis_loginusers where designation=4");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $contents.="\n".$i."\t";
    $contents.=$sql_result['name']."\t";
    $contents.=$sql_result['uname']."\t";
    $contents.=$sql_result['pwd']."\t";
    $contents.=$sql_result['contact']."\t";
    
    $i++; 
}



$contents = strip_tags($contents); 



  header("Content-Disposition: attachment; filename=All_engineer.xls");
  header("Content-Type: application/vnd.ms-excel");
  print $contents;
  
 
?>