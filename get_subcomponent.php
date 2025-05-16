<?php include('config.php');
header('Content-Type: application/json');



$atmid = $_REQUEST['atmid'];
$comp = $_REQUEST['comp'];


  $sql2 = mysqli_query($con,"SELECT * FROM mis_subcomponent WHERE cid='".$comp."' and status=1 order by id");
		while($row2 = mysqli_fetch_assoc($sql2)) {
		    
		    
    		$model2= $row2["name"];
            $component_id= $row2["cid"];
            $id = $row2['id'];
        
        $result[] =  ['id'=>$id,'fk'=>$component_id,'name'=>$model2];
        
		}
		
$result_count = count($result) ;



$get_comp = mysqli_query($con,"select * from mis_component where id='".$comp."'");
$get_comp_result = mysqli_fetch_assoc($get_comp);

$name = $get_comp_result['name'];


    if($atmid!=''){
		    $count_sql = mysqli_query($con,"select count(id) as row_Count from mis_details where atmid='".$atmid."' and component like '".$name."' and status <> 'close'");
		    $count_sql_result = mysqli_fetch_assoc($count_sql);
		    $row_Count = $count_sql_result['row_Count'];
		    
		    
		    if($row_Count > 0 ){
		        
		    

		    $check_sql = mysqli_query($con,"select * from mis_details where atmid='".$atmid."' and component like '".$name."' and status <> 'close'");
		    
		        while($check_sql_result = mysqli_fetch_assoc($check_sql)){
    		        $subcomponent = $check_sql_result['subcomponent'];
    		        
    		        $get_subcompid_sql = mysqli_query($con,"select * from mis_subcomponent where cid='".$comp."' and name='".$subcomponent."'");
    		        $get_subcompid_sql_result = mysqli_fetch_assoc($get_subcompid_sql);
    		        
    		        $subcomp_id = $get_subcompid_sql_result['id'];
    		        
    		        
    		        $result2[] = ['id'=>$subcomp_id,'fk'=>$comp,'name'=>$subcomponent];
    		        
		        }
		    

		    
		    $result2 = array_unique($result2) ;
    
            foreach($result2 as $key=>$val){
            
                        for($i=0;$i<$result_count;$i++){
                            if($key = array_search($val['name'], $result[$i])){
                                unset($result[$i]);
                            }
                        
                        }               
                }
                
		    }
    
    }
	
	
    $result = array_values($result);
    echo json_encode($result);	    






//     $keyword = strval($_REQUEST['query']); 
//     $name = $_REQUEST['name'];
//     $atmid = $_REQUEST['atmid'];


// 	$sql = mysqli_query($con,"SELECT * FROM mis_subcomponent WHERE  component_id='".$name."' and name LIKE '%".$keyword."%' and status=1");
// 		while($row = mysqli_fetch_assoc($sql)) {
// 		$model= $row["name"];
//         $id= $row["component_id"];
//         $result[] =  ['id'=>$id,'name'=>$model];
        
// 		}
		
		
// 		$result_count = count($result) ; 
		
		
// 		if($atmid!=''){
// 		    $check_sql = mysqli_query($con,"select * from mis_details where atmid='".$atmid."' and component like '".$name."' and status <> 'close'");
		    
// 		    if(mysqli_fetch_assoc($check_sql)){
		        
// 		        while($check_sql_result = mysqli_fetch_assoc($check_sql)){
//     		        $subcomponent = $check_sql_result['subcomponent'];
//     		        $result2[] = ['id'=>$name,'name'=>$subcomponent];
// 		    }
		    
// 		    $result2 = array_unique($result2) ;
    
    
//             foreach($result2 as $key=>$val){
            
//                         for($i=0;$i<$result_count;$i++){
//                             if($key = array_search($val['name'], $result[$i])){
//                                 unset($result[$i]);
//                             }
                        
//                         }               
//                 }
                
    
    
    
// 		    }
// 	}
	
// 	if($result_count>0){
// 		echo json_encode($result);	    
// 	}else{
//         $result=  ['id'=>'1','name'=>'Not Found'];
// 		echo json_encode($result);
// 	}
	

		
		
?>

