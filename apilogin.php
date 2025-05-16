<? include('config.php');


if(isset($_REQUEST['username'])){
    $email = $_REQUEST['username'];
}else{
    $email =  $_REQUEST['email'];
}

$password = $_REQUEST['password'];


require "vendor/autoload.php";
use \Firebase\JWT\JWT;


if ($email && $password) {
    $usersql = mysqli_query($con, "select * from mis_loginusers where uname='" . $email . "' and password='".$password."' and status=1 ");
    $usersql_result = mysqli_fetch_assoc($usersql);
    
        if ($usersql_result = mysqli_fetch_assoc($sql)) {
            
            $id = $usersql_result['id'];
            $fname = $usersql_result['name'];
            $email = $usersql_result['uname'];
    
    




        $secret_key = "CSS_INVENTORY";
		$issuedat_claim = time(); // issued at
		$notbefore_claim = $issuedat_claim + 10; //not before in seconds
		$expire_claim = $issuedat_claim + 60; // expire time in seconds
		
        $token = array(
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $userid,
                "fullname" => $fname,
                "email" => $email,
        ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key,"HS256");
        


            $token_sql = "update mis_loginusers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$id."'";

            if(mysqli_query($con,$token_sql)){
                

                $data = ['id' => $id, 'full_name' => $fname, 'email' => $email, 'is_authenticate' => '1',
                'token' => $jwt];
                echo json_encode($data);                
            }else{
                echo json_encode('501');
            }
            



        } else {
            echo json_encode(0);
        }
    
} else {
    echo json_encode(0);
}

?>