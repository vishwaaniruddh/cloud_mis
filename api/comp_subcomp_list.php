<?php 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$sql = mysqli_query($con,"select name from mis_component where status=1");
$dataArray = array();
  if(mysqli_num_rows($sql)>0){
	  while($sql_result = mysqli_fetch_assoc($sql)){
	      $comp = $sql_result['name'];
	      $subsql = mysqli_query($con,"select name from mis_subcomponent where component_id='".$comp."' AND status=1");
	      $subdataArray = array();
	      if(mysqli_num_rows($subsql)>0){
	         while($subsql_result = mysqli_fetch_assoc($subsql)){
	             $subcomp = str_replace(" ","_",$subsql_result['name']);
	             array_push($subdataArray,$subcomp);
	         }
	          
	      }
	      $comp = str_replace(" ","_",$comp);
	      $comp = str_replace("-","_",$comp);
	      $comp = str_replace("&","AND",$comp);
	      $dataArray[$comp] = $subdataArray;
	  }
  }
  
  	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);	