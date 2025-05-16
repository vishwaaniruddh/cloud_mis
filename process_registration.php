<? include('config.php');

$fname = $_REQUEST['fname'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$confirm_password = $_REQUEST['confirm_password'];
$officecontactno = $_REQUEST['officecontactno'];
$personalcontactno = $_REQUEST['personalcontactno'];
$designation = $_REQUEST['designation'];

$check_sql = mysqli_query($con,"select * from mis_loginusers where uname='".$username."' and user_status=1");
if($check_sql_result = mysqli_fetch_assoc($check_sql)){
    
    ?>
    
    <script>
        alert('Username Already Exists !');
        window.history.back();
    </script>
    <?
    
}else{
    


$sql = "insert into mis_loginusers(name,uname,pwd,designation,email,contact,user_status,personalcontactno) 
        values('".$fname."','".$username."','".$password."','".$designation."','".$username."','".$officecontactno."',1,'".$personalcontactno."')";

if(mysqli_query($con,$sql)){
    
    ?>
    <script>
        alert('Registration Successfull !');
        window.location = 'login.php';
    </script>
    <?
    
}else{
    
    ?>
    <script>
        alert('Registration Error !');
        // window.location = 'login.php';
    </script>
    <?
    
    
}


}

?>