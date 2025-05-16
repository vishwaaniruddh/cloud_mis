<?php session_start();
date_default_timezone_set('Asia/Kolkata');

// error_reporting(0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



$host="localhost";
$user="u444388293_cncindia";
$pass="CNCIndia2024#";
$dbname="u444388293_cncindia";
$con = new mysqli($host, $user, $pass, $dbname);
// Check connection
if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
// echo "Connected succesfull";
   
}




//$host="198.38.84.10";
/*
$host = "cloud.sarmicrosystems.in";
$user="sarmicro_root";
$pass="s@r1234";
$dbname="sarmicro_esurv";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {}

*/


if (!function_exists('getesurvUsername')) {
function getesurvUsername($id){
    global $conn; 
    $sql = mysqli_query($conn,"select * from login where id = '".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['name'];
}

    
}


$userid = $_SESSION['userid'];
$datetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$server_path = $_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/';

$_user_designation = $_SESSION['designation'];

if($userid>0){
                
        $assign_cust_sql = mysqli_query($con,"select cust_id,permission from mis_loginusers where id ='".$userid."'");
        if($assign_cust_sql_result = mysqli_fetch_assoc($assign_cust_sql)){
          $assigned_customer =   $assign_cust_sql_result['cust_id'];
        }
        
            $assigned_customer = explode(',', $assigned_customer);
            $assigned_customer = json_encode($assigned_customer);
            $assigned_customer = str_replace(array('[', ']', '"'), '', $assigned_customer);
            $assigned_customer = explode(',', $assigned_customer);
            $assigned_customer = "'" . implode("', '", $assigned_customer) . "'";
            
            
            
                
            $menuPermission = $assign_cust_sql_result['permission'];
            $menuPermissionAr = explode(',',$menuPermission);
            $userRole = $_SESSION['userRole'] ; 
            
            
            
        
        // if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        //     $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //     $pagename = basename($url);
            
            
        
        
        
        
        
            
            
        //     if($pagename!='index.php'){
                
        //         $getPageInfoSql = mysqli_query($con,"select * from sub_menu where page='".$pagename."'");
        //         $getPageInfoSql_result = mysqli_fetch_assoc($getPageInfoSql);
                
        //         $pageId = $getPageInfoSql_result['id'];
                
        //         if(in_array($pageId,$menuPermissionAr)){
                    
        //         }else{
                    
        //                 if(isset($_SERVER['HTTP_REFERER'])) {} else {
        //                     echo '
        //                 <script>alert("You Don\'t have permission to view this page ! Redirecting...");
        //                 window.location = "https://cssmumbai.sarmicrosystems.com/css/dash/esir/index.php" ; 
        //                 </script>';
        //                     }
        
        
        
            
        //         }        
        //     }
            
        
            
        // }
        
        
    
}





if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || 
        (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('clean')) {
function clean($string) {
  $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2){
    	$site_remark2_arr = explode(" ",$site_remark2);
    	
    	foreach($site_remark2_arr as $k=>$v){
    		$a[] = preg_split ('/\n/', $v);	
    	}
    	
    	$site_remark ='' ; 
    	foreach($a as $key=>$value){
    		foreach($value as $ke=>$va){
    			$site_remark .= $va . " " ; 
    		} 
    
    	}
    
    return clean($site_remark) ; 
    
    }
    
}
?>