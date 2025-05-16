<?php 

        include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
        header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        
        date_default_timezone_set('Asia/Kolkata');
        $created_at = date('Y-m-d H:i:s');
        $datetime = $created_at;
        
        $id = $_POST['id'];
        $eng_id = $_POST['eng_id'];
       
        $target_filedir =  "../fundreqinvoiceuploadimageapp/".$id.'/'; 
        $target_dir = "fundreqinvoiceuploadimageapp/".$id.'/';
            if (!file_exists($target_filedir)) {
                mkdir($target_filedir, 0777, true);
            }
        $path = $_FILES["image"]["name"];
        $img_ext = explode(".",$path[0]);
        $ext = $img_ext[1];
        
        $name = 0;
        
        
        
      //  $ext = pathinfo($path, PATHINFO_EXTENSION);
        $new_imagefilename = time(); 
      
        
      //  $new_imagefilename = str_replace(' ', '_', $_imagefilename);
        
        $filename = $new_imagefilename."_".$name.".".$ext;
        $noerr = 0;$err = 0;
        
        $target_file = $target_filedir . $filename;
        if (move_uploaded_file($_FILES["image"]["tmp_name"][0], $target_file)) {
            $noerr = $noerr + 1;
             $link = 'https://sarsspl.com/css/dash/esir/'.$target_dir. $filename ; 
            $update_qry = "update eng_fund_request SET img='".$link."',req_status=6 WHERE id='".$id."'";
            $query_result = mysqli_query($con,$update_qry);
            if($query_result){
                $fundreq_id = $id;
                $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fundreq_id."' order by id desc limit 1");
                $fund_data = mysqli_fetch_assoc($fund_sql);
                $requested_amt = $fund_data['requested_amount'];
                $approved_amt = $fund_data['approved_amount'];
                                  
                $insertfundsql = "insert into eng_fund_request_history(fundreq_id, requested_amount,approved_amount,action_by,status,remarks,created_at,updated_at) values('".$fundreq_id."','".$requested_amt."','".$approved_amt."','".$eng_id."',6,'Invoice Uploaded','".$created_at."','".$created_at."')" ; 
                mysqli_query($con,$insertfundsql);
            }
            
           
            
        }else {
            $err = $err + 1;
        }
        
        if($noerr>0){
            $msg = $noerr." Files uploaded successfully."; 
            $array = array(['Code'=>200,'msg'=>$msg]);
        }else{
            $msg = "Sorry, there was an error uploading ".$err." file."; 
            $array = array(['Code'=>201,'msg'=>$msg]);
        }
        
        echo json_encode($array);
        
       // echo json_encode(['path'=>$path,'ext'=>$ext]);

?>