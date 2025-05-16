<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');
    
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    
    $data = $_POST;
   
    $report_type = $data['report_type'];
    $userid = $data['created_by'];
    $array = array();
    $checklist_json = array();
    foreach($data as $key=>$value){
        if($key!='report_type' && $key!='created_by'){
            $_newdata = array();
            $_newdata['k'] = $key;
            $_newdata['v'] = $value;
            array_push($checklist_json,$_newdata);
        }
        
    }
    $checklist_json = json_encode($checklist_json);
    $sql = "insert into daily_report_app(report_type,checklist_json,report_date,created_at,created_by) values('".$report_type."','".$checklist_json."','".$date."','".$datetime."','".$userid."')";
    mysqli_query($con,$sql); 	


    $array = array(['Code'=>200]);
            
    echo json_encode($array);		
  