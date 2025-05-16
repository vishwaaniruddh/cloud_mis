<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


   $id = $_POST['id'];

   $sql = mysqli_query($con,"select * from eng_fund_request where id='".$id."'");

	  $dataArray = array();
	  if(mysqli_num_rows($sql)>0){
		  while($sql_result = mysqli_fetch_assoc($sql)){
		      $fundreq_id = $sql_result['id'];
		      $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fundreq_id."' order by id asc");
              $current_status = $sql_result['req_status'];
              $fund_requested_date = '';
              $manager_approved_date = '';
              $bm_manager_approved_date = '';
              $payment_paid_date = '';
              $invoice_upload_date = '';
              $account_cleared_date = '';
              $approved_amt = 0;$bm_approved_amt = 0;
              if(mysqli_num_rows($fund_sql)>0){
                  while($fund_data = mysqli_fetch_assoc($fund_sql)){
                     $current_status = $fund_data['status'];
                    
                     if($current_status=='2'){
                         $bm_manager_approved_date = $fund_data['created_at'];
                         $bm_approved_amt = $fund_data['approved_amount'];
                     }
                     
                     if($current_status=='3'){
                         $manager_approved_date = $fund_data['created_at'];
                         $approved_amt = $fund_data['approved_amount'];
                     }
                     
                     if($current_status=='4'){
                         $cashier_paid_date = $fund_data['created_at'];
                        // $approved_amt = $fund_data['approved_amount'];
                     }
                  }
              }
              
              $fund_requested_by = $sql_result['fund_requested_by'];   
              $eng_name_sql = mysqli_query($con,"select * from mis_loginusers where id='".$fund_requested_by."'");
              $eng_sql_result = mysqli_fetch_assoc($eng_name_sql);
              $eng_id = $eng_sql_result['id'];
              $eng_name = $eng_sql_result['name'];
              $eng_email = $eng_sql_result['email'];
              $eng_contact = $eng_sql_result['contact'];
              $first_character = substr($eng_name, 0, 1);
             
		      $_newdata = array();
		      $_newdata['id'] = $sql_result['id'];
			  $_newdata['atmid'] = $sql_result['atmid'];
			  $_newdata['fund_type'] = $sql_result['fund_type'];
			  $_newdata['fund_component'] = $sql_result['fund_component'];
			  $_newdata['requested_amount'] = $sql_result['requested_amount'];
			  $_newdata['bm_approved_amount'] = $bm_approved_amt;
			  $_newdata['approved_amount'] = $approved_amt;
			  $_newdata['status'] = $current_status;
			  $_newdata['fund_requested_date'] = $fund_requested_date;
			  $_newdata['manager_approved_date'] = $manager_approved_date;
			  $_newdata['bm_manager_approved_date'] = $bm_manager_approved_date;
			  $_newdata['cashier_paid_date'] = $cashier_paid_date;
			  $_newdata['eng_name'] = $eng_name;
			  $_newdata['eng_first_letter'] = $first_character;
			  $_newdata['eng_email'] = $eng_email;
			  $_newdata['eng_contact'] = $eng_contact;
			  $_newdata['eng_id'] = $eng_id;
			  $_newdata['razorkey_id'] = 'rzp_test_KSuwHLjb1B4BeO';
			//  $_newdata['payment_paid_date'] = $payment_paid_date;
			//  $_newdata['invoice_upload_date'] = $invoice_upload_date;
			//  $_newdata['account_cleared_date'] = $account_cleared_date;
			  array_push($dataArray,$_newdata); 
		      
		  }
	  }
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);					  