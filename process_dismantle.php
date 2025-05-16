<? include('config.php');

$userid = $_SESSION['userid'];                                        
$total_records = $_REQUEST['total_records'];
$dismatleFormId = $_REQUEST['dismatleFormId'];
$customer = $_REQUEST['customer'];
$bank = $_REQUEST['bank'];
$allowed = array('jpg', 'jpeg', 'png');
$siteid = $_REQUEST['siteid'];


$year = date('Y');
$month = date('M');
$day = date('d');
$requestdata = $_REQUEST;
$filedata = $_FILES ; 
$recordInsertSql = "insert into dismantleFormResponse(customer,bank,status,created_at,created_by,requestdata,filedata) 
values('".$customer."','".$bank."','1','".$datetime."','".$userid."','".$requestdata."','".$filedata."')";






if(mysqli_query($con,$recordInsertSql)){
    $insertId = $con->insert_id;


mysqli_query($con,"update mis_newsite set status=0 where id='".$siteid."'");


            for($i=1;$i<$total_records;$i++){
                $finalename = ''; 
                $questionId = $_REQUEST['questionId'.$i];
                $option = $_REQUEST['option'.$i];
                if(is_array( $option )){
                    $option = implode(',',$option);
                }
                $option = htmlspecialchars($option, ENT_QUOTES, 'UTF-8');
            
                    $file = $_FILES['file'.$i];
                    $fileName = $_FILES['file'.$i]['name'];
                    $fileTmpName = $_FILES['file'.$i]['tmp_name'];
                    $fileSize = $_FILES['file'.$i]['size'];
                    $fileType = $_FILES['file'.$i]['type'];
                    
                    $fileExt = explode('.', $fileName);
                    $fileActualExt = $fileExt[1];
                        if($fileSize < 1000000){
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = 'dismantleForm/'.$year.'/'.$month.'/'.$day;
                            
                            if (!file_exists($fileDestination)) {
                                mkdir($fileDestination, 0777, true);
                                
                            }
                            if($fileNameNew){
                                $fileDestination = $fileDestination .'/'. $fileNameNew;
                                $finalename = $fileDestination ; 
                                move_uploaded_file($fileTmpName, $fileDestination);
                                
                            }

                        }
                        
                $sql = "insert into dismantleFormResponseDetails(dismantleFormResponseID,dismatleFormId,dismatleDetailId,response,image_url,status,created_at,created_by) 
                values('".$insertId."','".$dismatleFormId."','".$questionId."','".$option."','".$fileDestination."','1','".$datetime."','".$userid."')";    
                mysqli_query($con,$sql);
                // echo '<br>';
                
            }
?>
   
   <script>
        alert('success');
        window.location.href='sitestest.php'
   </script>
   

<? }
                // header("Location: sitestest.php");
?>
