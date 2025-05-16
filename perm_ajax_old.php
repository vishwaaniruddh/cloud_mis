<? include('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$zone = $_POST['zone'];
$zone = explode(',',$zone);
$zone=json_encode($zone);

$zone=str_replace( array('[',']','"') , ''  , $zone);
$zone=explode(',',$zone);
$zone = "'" . implode ( "', '", $zone )."'";

function getcityid($city){
    global $con;
    $sql = mysqli_query($con,"select * from mis_city where city='".$city."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['id'];
}







$id = $_REQUEST['user'];
$usersql = mysqli_query($con,"select * from mis_loginusers where id = '".$id."'");
$usersql_result = mysqli_fetch_assoc($usersql); 

$userbranch = $usersql_result['branch'];
$userbranch = explode (",", $userbranch);


$userzone = $usersql_result['zone'];
$userzone = explode (",", $userzone);








?>

<style>
.onezone{
 
        margin: 2% auto;
    border: 1px solid #e5e5e5;
    padding: 2%;   
}
</style>
    


<? 
$sql1 = mysqli_query($con,"select distinct(zone) as zone from mis_newsite where zone in($zone) order by zone"); 
while($sql1_result = mysqli_fetch_assoc($sql1)){
    $zone= $sql1_result['zone'];
    
?>

<div class="onezone">
    

  <h4><? echo $zone; ?> Zone</h4>
 <div class="row">

<?



$sql = mysqli_query($con,"select distinct(branch) as branch,zone from mis_newsite where zone ='".$zone."' order by branch");

while($sql_result = mysqli_fetch_assoc($sql)){
            
            $branch = $sql_result['branch'];
            $one_zone = $sql_result['zone'];
        

            $city_sql = mysqli_query($con,"select * from mis_city where city ='".$branch."'");
            $city_sql_result = mysqli_fetch_assoc($city_sql);
        
        ?>
                <div class="col-sm-3">
                    
                    <input type='checkbox' name='cities[]' value=<? echo getcityid($branch) ?> <? if(in_array($city_sql_result['id'],$userbranch)){ echo 'checked' ; } ?> >
                    <? echo $branch; ?>
                </div>

    
    
<? } ?>
</div>
</div>
<? } ?>

