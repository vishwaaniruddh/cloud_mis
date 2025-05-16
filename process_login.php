<?php session_start();
include('config.php') ; ?>
<html>
    <head>
        <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.2/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    </head>
    <body>
        


<?php

require "vendor/autoload.php";
use \Firebase\JWT\JWT;


$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($uname && $password){

    $sql = mysqli_query($con,"select * from mis_loginusers where uname = '".$uname."' and pwd='".$password."' and user_status=1");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['auth']=1;
                $_SESSION['username']=$sql_result['name'];
                $_SESSION['designation']=$sql_result['designation'];
                $_SESSION['userid'] = $sql_result['id'];
                $_SESSION['level'] = $sql_result['level'];
                
                $_SESSION['branch'] = $sql_result['branch'];
                $_SESSION['zone'] = $sql_result['zone'];
                $_SESSION['cust_id'] = $sql_result['cust_id'];
                
                $_SESSION['bankPermission'] = $sql_result['bankPermission'];
                
                $_SESSION['callTypePermission'] = $sql_result['callTypePermission'];
                $_SESSION['userRole'] = $sql_result['role'];
                
                $userid = $sql_result['id'];
                
                if($uname == 'admin@gmail.com'){
                    $_SESSION['access']=1 ;
                }
                
                
                
                
                
                $secret_key = "CSS_ESIR";
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
                $jwt = JWT::encode($token, $secret_key,"HS256");
                $token_sql = "update mis_loginusers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                    mysqli_query($con,$token_sql) ;                
                    
                
                $_SESSION['token'] = $jwt ;
                
                
                ?>
                
                Please Wait ...
               <script>
               swal("Good job!", "Login Success !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="index.php";
                   }, 3000);
        
               </script> 
        <?php }else{ ?>       
                <script>
                   swal("Error", "You are inactive !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        <?php } ?>           
    <?php }else{ ?>
       <script>
       swal("Error", "Incorrect Username or Password !", "error");
           swal('error','','Login Error');
           setTimeout(function(){ 
              window.history.back();
           }, 3000);

       </script>
<?php }

    
    
}
else{ ?>
       <script>
       swal("Error", "Please Put Username and Password  !", "error");
            setTimeout(function(){ 
              window.history.back();
           }, 3000);

       </script>
<?php }

?>
    </body>
</html>