<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


   $userid = $_POST['user_id'];
 //  $userid = 640;

   $_designation = $_POST['designation'];
 //  $_designation = 6;

   if($_designation=='6'){
       
       $cash_sql = mysqli_query($con, "select * from mis_loginusers where id='" . $userid . "' and branch!='null' and zone!='null' ");
        $cash_sql_result = mysqli_fetch_assoc($cash_sql);

        $branch_result = $cash_sql_result['branch'];
        $branch = explode(',', $branch_result);
        
        foreach($branch as $branchkey => $branchvalue){
            $miscitysql = mysqli_query($con,"select * from mis_city where id='".$branchvalue."'");
            $miscitysql_result = mysqli_fetch_assoc($miscitysql);
            
            $miscity[] = $miscitysql_result['city'];
            
        }


        
        
        
        $branch = json_encode($miscity);
        $branch = str_replace(array('[', ']', '"'), '', $branch);
        $branch = explode(',', $branch);
        $branch = "'" . implode("', '", $branch) . "'";
        
        if ($branch_result) {
            $branch_query = " and b.branch in($branch)";
        } else {
            $branch_query = " ";
        }
        
        $zone_result = $cash_sql_result['zone'];
        $zone = explode(',',$zone_result);
        
        $zone=json_encode($zone);
        $zone=str_replace( array('[',']','"') , ''  , $zone);
        $zone=explode(',',$zone);
        $zone = "'" . implode ( "', '", $zone )."'";
        
        if($zone_result){
            $zone_query = " and b.zone in($zone)";
        }else{
            $zone_query =" ";
        }
       
       $statement = "select a.*,b.customer,b.bank,b.address,b.city,b.state,b.zone,b.branch,
                
                    (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_name,
                    (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_contact
                    
                    
                    from eng_fund_request a
                        INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                        
                       where 1 and a.req_status >= 3 $zone_query
                    ";
    //    echo $statement;die;            
      /*  $statement = "select a.*,b.customer,b.bank,b.address,b.city,b.state,b.zone,b.branch,
                
                    (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_name,
                    (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_contact
                    
                    
                    from eng_fund_request a
                        INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                        
                       where 1 and b.cashier_id='".$userid."' and
                    a.req_status >= 2 $branch_query $zone_query
                    ";           
        */            
                    
     //  echo $statement;die;
    //   $ch_sql = "select * from eng_fund_request where req_status>=2 AND atmid IN (SELECT atmid FROM `mis_newsite` WHERE cashier_id='".$userid."')";
     //  echo $ch_sql;
	   $sql = mysqli_query($con,$statement);
   }else{
       $ch_sql = "select * from eng_fund_request where fund_requested_by='".$userid."'";
       $sql = mysqli_query($con,"select * from eng_fund_request where fund_requested_by='".$userid."'");
   }

	  $dataArray = array();
	  if(mysqli_num_rows($sql)>0){
		  while($sql_result = mysqli_fetch_assoc($sql)){
		      $fundreq_id = $sql_result['id'];
		      $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fundreq_id."' order by id desc limit 1");
              $current_status = $sql_result['req_status'];
              $approved_amount = 0;
              if(mysqli_num_rows($fund_sql)>0){
                  $fund_data = mysqli_fetch_assoc($fund_sql);
                  $current_status = $fund_data['status'];
                  $approved_amount = $fund_data['approved_amount'];
              }
              if($_designation=='6'){
                  if($current_status>3){
                      $is_completed = 1;
                  }else{
                      $is_completed = 0;
                  }
              }else{
                  if($current_status==0){
                      $is_completed = 1;
                  }else{
                      $is_completed = 0;
                  }
              }
		      
		      $_newdata = array();
		      $_newdata['id'] = $sql_result['id'];
			  $_newdata['atmid'] = $sql_result['atmid'];
			  $_newdata['fund_type'] = $sql_result['fund_type'];
			  $_newdata['fund_component'] = $sql_result['fund_component'];
			  $_newdata['requested_amount'] = $sql_result['requested_amount'];
			  $_newdata['approved_amount'] = $approved_amount;
			  $_newdata['is_completed'] = $is_completed;
			  $_newdata['is_status'] = $current_status;
			  array_push($dataArray,$_newdata); 
		      
		  }
	  }
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray,'qry'=>$ch_sql]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);					  