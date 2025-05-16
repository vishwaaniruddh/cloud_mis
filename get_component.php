<?php include('config.php');		
	$keyword = strval($_POST['query']);

// 	$search_param = "{$keyword}%";
	

	$sql = mysqli_query($con,"SELECT * FROM mis_component WHERE name LIKE '%".$keyword."%' and status=1");
		while($row = mysqli_fetch_assoc($sql)) {
		$name= $row["name"];
        $id= $row["id"];
        $Result[] =  ['id'=>$id,'name'=>$name];
        
		}
		echo json_encode($Result);
?>

