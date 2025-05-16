<? session_start();
include('config.php');
// include('comfort_con.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                                                        <div class="two_end">
                                    <h5>Update Bulk Site test <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <!--<a class="btn btn-success" href="excelformat/Add_Sites.xlsx" download>BULK SITES UPLOAD FORMAT</a>-->
                                </div>
                                        
                                        
                                        
                                      <? 
                                      
                                      if(isset($_POST['submit'])){
$userid = $_SESSION['userid']; 

    $date = date('Y-m-d h:i:s a', time());
    $only_date = date('Y-m-d');
    $target_dir = '../PHPExcel/';
    $file_name=$_FILES["images"]["name"];
    $file_tmp=$_FILES["images"]["tmp_name"];
    $file =  $target_dir.'/'.$file_name;


$status ='open';                      
$created_by = $_SESSION['userid'];
$created_at = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$_date = str_replace("-","_",$date);


//  $sitebackup = mysqli_query($con,"create table site_circle_com1_".$_date." as select * from site_circle_com ");

    move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
    $inputFileName = $file;

  try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  for ($row = 1; $row <= $highestRow; $row++) { 
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);
                                
  }
// echo '<pre>';print_r($rowData);echo '</pre>';die;
$row = $row-2;
$error = '0';
$contents='';
   $updatekey = 0;
   $error_array = array();
   
    for($i = 1; $i<=$row; $i++){
       
      
      $old_circle = $rowData[$i][0][1];
        if($old_circle){
         
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid']; 
                $new_circle = $rowData[$i][0][2];
                $ATMID[] = $rowData[$i][0][3];
                
                // var_dump($ATMID);
                
                $_atmid=json_encode($ATMID);
                $_atmid=str_replace( array('[',']','"') , ''  , $_atmid);
                $_atmid=explode(',',$_atmid);
                $_atmid = "'" . implode ( "', '", $_atmid )."'";
                
                $receivedtime = date('Y-m-d H:i:s');
                
		        $qry = mysqli_query($con,"SELECT SN FROM `sites_comfort` WHERE ATMID IN($_atmid)");
		        
                // $updatesql = "update site_circle_com set new_circle = '".$new_circle."' where ATMID = '".$ATMID."' ";
             
                if(mysqli_num_rows($qry)){ 
                while($sitesql_result = mysqli_fetch_assoc($qry)){
			    $SN = $sitesql_result['SN'];
			    
			    $updatesql= " UPDATE `network_report_com` SET `router`='".$receivedtime."',`dvr`='".$receivedtime."',`panel`='".$receivedtime."' where `SN`='".$SN."'";
				$month_result = mysqli_query($con,$updatesql);
				if($month_result==1){
				   $updatekey = $total_updated + 1;
				   // up network site
				   $update_network_list = mysqli_query($con,"update `network_report_list_com` set router_status = 1,panel_status = 1,dvr_status = 1,router_lastcommunication = '".$receivedtime."',dvr_lastcommunication='".$receivedtime."',panel_lastcommunication='".$receivedtime."' where ATMID in ($_atmid) "); 
				}	
			    	
                    }
                }
            
    
        }else{
            $sentence = "Row ".$i." not have atmid";
            array_push($error_array,$sentence); 
        }

   }
//   echo mysqli_num_rows($qry).'<br>';
// //   print_r($qry); 
// //   echo "SELECT SN FROM `sites` WHERE ATMID IN($_atmid)".'<br>';
              if($updatekey>0){ ?>
                    <script>
                        var key = <?php echo $updatekey;?>;
                        alert("Total no of rows updated : "+key);</script>
           <?php   }

                                    
                                }
                                ?>
                                
                                
                                  <?php if(isset($error_array)){ 
                                     if(count($error_array)>0){
                                  ?>
                                    List of errors :
                                    <ul>
                                        <?php for($i=0;$i<count($error_array);$i++){ ?>
                                          <li><?php echo $error_array[$i];?></li>
                                        <?php } ?>
                                    </ul>
                                <?php }} ?>
                                
                                    <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            
                                            <div class="col-sm-4">
                                                <input type="file" name="images" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                  <input type="submit" name="submit" value="upload" class="btn btn-danger">
                                            </div>
                                                
                                        </div>
                                    </form>                                                            
                                                            
                                      
                                      
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
    
        <script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>




<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>



</body>

</html>