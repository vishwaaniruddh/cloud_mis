<? include('config.php');

$atmid = $_REQUEST['atmid'];

function mis_eng($id){
    global $con;
    $sql = mysqli_query($con,"select * from mis_eng where id ='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['eng'];
}

if($atmid){ 
        $sql = mysqli_query($con,"select * from mis_newsite where atmid = '".$atmid."'");      
        if($sql_result = mysqli_fetch_assoc($sql)){ 
            $customer = trim(strtoupper($sql_result['customer']));
            $bank = $sql_result['bank']; 
            $location = $sql_result['address'];
            $city = $sql_result['branch'];
            $state = trim($sql_result['state']);
            $region = $sql_result['zone'];
            
            $visit_sql = mysqli_query($con,"select * from mis_newvisit  where atmid ='".$atmid."' order by id desc limit 1");
            if(mysqli_num_rows($visit_sql)>0){ 
                $visit_sql_result = mysqli_fetch_assoc($visit_sql);
                $engineer = trim($visit_sql_result['engineer']); 
                $engsql = mysqli_query($con,"select * from mis_eng where id ='".$engineer."'");
                if(mysqli_num_rows($engsql)>0){ 
                   $engsql_result = mysqli_fetch_assoc($engsql);
                   $engineer = $engsql_result['eng']; 
                }
                
                $created_at = $visit_sql_result['created_at'];    
            }else{
                $engineer = 'No Info';
                $created_at = 'No Info';
            }
            
            
    								  $_newdata['bank'] = $bank;
    								  $_newdata['customer'] = $customer;
    								  $_newdata['region'] = $region;
    								  $_newdata['city'] = $city;
    								  $_newdata['state'] = $state;
    								  $_newdata['location'] = htmlspecialchars($location);
                                      $_newdata['engineer'] = $engineer;
    								  $_newdata['created_at'] = $created_at;
    								  $_newdata['from'] ='1';
            $data = $_newdata;
          //  $data = ['customer'=>$customer,'bank'=>$bank,'location'=>$location,'city'=>$city,'state'=>$state,'region'=>$region,'engineer'=>$engineer,'created_at'=>$created_at,'from'=>'1'] ;
            echo json_encode($data);    
        }else{
            
            $sql = mysqli_query($con,"select * from mis_newvisit where atmid like '".$atmid."'");      
            if($sql_result = mysqli_fetch_assoc($sql)){
                $customer = strtoupper($sql_result['customer']);
                $bank = $sql_result['bank'];
                $location = $sql_result['location'];
                $city = $sql_result['city'];
                $state = $sql_result['State'];
                $region = $sql_result['zone'];
                $engineer = $sql_result['engineer'];
                $engineer = mis_eng($engineer);
                $created_at = $sql_result['created_at'];
                
                $data = ['customer'=>$customer,'bank'=>$bank,'location'=>$location,'city'=>$city,'state'=>$state,'region'=>$region,'engineer'=>$engineer,'created_at'=>$created_at,'from'=>'2'] ;
                echo json_encode($data);
                
                
            }else{
                echo '0';
            }
            
        }
    }


?>