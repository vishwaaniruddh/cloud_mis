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
		      $isPaymentProcessed = $sql_result['isPaymentProcessed'];
		      $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fundreq_id."' order by id asc");
              $current_status = $sql_result['req_status'];
              $fund_requested_date = '';
              $bm_manager_approved_date = '';
              $manager_approved_date = '';
              $payment_paid_date = '';
              $invoice_upload_date = '';
              $account_cleared_date = '';
              $bm_manager_approved_amount = 0;
              $manager_approved_amount = 0;
              $img_url = '';
              if(mysqli_num_rows($fund_sql)>0){
                  while($fund_data = mysqli_fetch_assoc($fund_sql)){
                     $current_status = $fund_data['status'];
                     if($current_status=='1'){
                         $fund_requested_date = $fund_data['created_at'];
                     }
                     if($current_status=='2'){
                         $bm_manager_approved_date = $fund_data['created_at'];
                         $bm_manager_approved_amount = $fund_data['approved_amount'];
                     }
                     if($current_status=='4'){
                         $manager_approved_date = $fund_data['created_at'];
                         $manager_approved_amount = $fund_data['approved_amount'];
                     }
                     if($current_status=='5'){
                         if($isPaymentProcessed==1){
                            $payment_paid_date = $fund_data['created_at'];
                         }
                     }
                     if($current_status=='6'){
                         $img_url = $sql_result['img'];
                         $invoice_upload_date = $fund_data['created_at'];
                     }
                     if($current_status=='0'){
                         $account_cleared_date = $fund_data['created_at'];
                     }
                  }
              }
              
             
		      $_newdata = array();
		      $_newdata['id'] = $sql_result['id'];
			  $_newdata['atmid'] = $sql_result['atmid'];
			  $_newdata['fund_type'] = $sql_result['fund_type'];
			  $_newdata['fund_component'] = $sql_result['fund_component'];
			  $_newdata['requested_amount'] = $sql_result['requested_amount'];
			  $_newdata['approved_amount'] = $sql_result['approved_amount'];
			  $_newdata['status'] = $current_status;
			  $_newdata['fund_requested_date'] = $fund_requested_date;
			  $_newdata['bm_manager_approved_date'] = $bm_manager_approved_date;
			  $_newdata['manager_approved_date'] = $manager_approved_date;
			  $_newdata['payment_paid_date'] = $payment_paid_date;
			  $_newdata['invoice_upload_date'] = $invoice_upload_date;
			  $_newdata['account_cleared_date'] = $account_cleared_date;
			  $_newdata['img_url'] = $img_url;
			  $_newdata['manager_approved_amount'] = $manager_approved_amount;
			  $_newdata['bm_manager_approved_amount'] = $bm_manager_approved_amount;
			  array_push($dataArray,$_newdata); 
		      
		  }
	  }
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);					  