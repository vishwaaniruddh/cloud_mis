<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    .card-data{
        overflow-x: auto;
    }
        
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                                                        <div class="two_end">
                                    <h5>Update Bulk Sites <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="all_site_excel.php" download>BULK SITES UPLOAD FORMAT</a>
                                    
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
        
        
        
        
        move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
        include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
        $inputFileName = $file;

    //  Read your Excel workbook

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
  
//  Loop through each row of the worksheet in turn

  for ($row = 1; $row <= $highestRow; $row++) { 
      
       //  Read a row of data into an array
       
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);
          
           //  Insert row data array into your database of choice here                      
  }

$row = $row-2;
$error = '0';
$contents='';
   $updatekey = 0;
   $error_array = array();
   
   for($i = 1; $i<=$row; $i++){
      $atmid = $rowData[$i][0][3];

        if($atmid){

                $userid = $_SESSION['userid'];                                        
                $_activity = $rowData[$i][0][0];
                $activity = $_activity;
                if (strpos($_activity, 'E-Surveillance') !== false) {
                    $activity = 'RMS';
                }
                if (strpos($_activity, 'DVR') !== false || strpos($_activity, 'Router') !== false) {
                  $activity = 'DVR Activity';
                }
                if (strpos($_activity, 'Cloud') !== false) {
                    $activity = 'Cloud';
                }
                
                $customer = $rowData[$i][0][1];
                $bank = $rowData[$i][0][2];
                
                $atmid2 = $rowData[$i][0][4];
                $atmid3 = $rowData[$i][0][5];
                $trackerno = $rowData[$i][0][6];
                $address = str_replace("'", "", $rowData[$i][0][7]);
                $city = $rowData[$i][0][8];
                $state = $rowData[$i][0][9];
                $zone = $rowData[$i][0][10];
                $branch = $rowData[$i][0][11];
                $bm_name = $rowData[$i][0][17];
                $bm_number = $rowData[$i][0][18];
                
                $errorcount=0;
               
                
                $atmidcount=0;
                $atmidsql="select atmid from mis_newsitetest where atmid='".$atmid."' ";
                $atmidquery= mysqli_query($con,$atmidsql);
                if($atmidsqlresult = mysqli_fetch_assoc($atmidquery)){
                    $sentence = "ATMID ".$atmid." Exist!!";
                    array_push($error_array,$sentence);
                    $errorcount = 1;
                }else{

                }
                
                // $locationcount=0;
                // $locationsql= "select address from mis_newsitetest where address= '".$address."' ";
                // $locationquery = mysqli_query($con,$locationsql);
                // if($locationresult = mysqli_fetch_assoc($locationquery)){
                //     $errorcount = 1;
                // }else{
                //     $sentence = "".$location."Error!!";
                //     array_push($error_array,$sentence);
                // }
                
                
                
                $branchcount = 0;
                $branchsql = "select id from newbranch where branch = '".$branch."' ";
                $branchquery = mysqli_query($con,$branchsql);
                $branchsqlresult = mysqli_num_rows($branchquery);
                if($branchsqlresult>0)
                {
                    $branchcount = 1;
                }
                else{
                    $sentence = "Branch ".$branch." not in Branch Master";
                    array_push($error_array,$sentence); 
                }
                
                
                $zonecount = 0;
                $zonesql = "select id from newzone where zone_name = '".$zone."' ";
                $zonequery = mysqli_query($con,$zonesql);
                $zonesqlresult = mysqli_num_rows($zonequery);
                 if($zonesqlresult>0)
                 {
                    $zonecount = 1;
                 }
                 else{
                     $sentence = "Zone ".$zone." not in Zone Master";
                    array_push($error_array,$sentence); 
                }
                

              if($branchcount==1 && $zonecount ==1 && $errorcount==0){
                  
                  $check_sql = mysqli_query($con,"select atmid from mis_newsitetest_success where atmid='".$atmid."'");
                  if($check_sql_resulr = mysqli_fetch_assoc($check_sql)){
                        mysqli_query($con,"delete from mis_newsitetest_success where  atmid='".$atmid."'"); 
                  
                  
                     $sql = "insert into mis_newsitetest_success(activity,customer,bank,atmid,atmid2,atmid3,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,created_by,created_at) 
                    values('".$activity."','".$customer."','".$bank."','".$atmid."','".$atmid2."','".$atmid3."','".$trackerno."','".$address."','".$city."','".$state."','".$zone."','".$branch."','".$bm_name."','".$bm_number."','0','".$userid."','".$created_at."')";
                    
                    if(mysqli_query($con,$sql)){ 
                        $updatekey = $updatekey + 1;
                    }else{
                        $sentence = "Atm ID ".$atmid." not able to update its value";
                        array_push($error_array,$sentence); 
                    }
                  }
                    
              }else{
                  

                        mysqli_query($con,"delete from mis_newsitetest_err where  atmid='".$atmid."'"); 
                        
                        $sql = "insert into mis_newsitetest_err(activity,customer,bank,atmid,atmid2,atmid3,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,created_by,created_at,remark) 
                        values('".$activity."','".$customer."','".$bank."','".$atmid."','".$atmid2."','".$atmid3."','".$trackerno."','".$address."','".$city."','".$state."','".$zone."','".$branch."','".$bm_name."','".$bm_number."','0','".$userid."','".$created_at."','".$sentence."')";
                        
                        mysqli_query($con,$sql);   

            }
        }
   }
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
                                
                                
                                <div class="card">
                                    <div class="card-body">
                                            <div class="two_end">
                                                <h6>Success Table</h6>
                                                <a class="btn btn-success" href="newsite_sucess_approve.php">Approve All To Main Site</a>
                                                <a class="btn btn-success" href="newsite_sucess_excel.php">Bulk Report Download</a>
                                            </div>
        <br>
        <div class="card-data">
            <table class="table table-bordered table-striped" id="data_table" style="width:100%;">
  <thead>
    <tr>
    <th>Sr no</th> 
    <th>activity</th>
     <th>customer</th>
      <th>bank</th>
      <th>atmid</th>
      <th>atmid2</th>
      <th>atmid3</th>
      <th>trackerno</th>
      <th>address</th>
      <th>city</th>
      <th>state</th>
      <th>zone</th>
      <th>branch</th>
      <th>bm_name</th>
      <th>bm_number</th>
    </tr>
    </thead>
    <tbody>
        <?
        $i=0;
$sql = mysqli_query($con,"select * from mis_newsitetest_success where status=0");
while($sql_result = mysqli_fetch_assoc($sql)){
        ?>
    <tr>
        <td><? echo ++$i;?></td> 
        <td><? echo $sql_result['activity'] ; ?></td>
        <td><? echo $sql_result['customer'] ; ?></td>
        <td><? echo $sql_result['bank'] ; ?></td>
        <td><? echo $sql_result['atmid'] ; ?></td>
        <td><? echo $sql_result['atmid2'] ; ?></td>
        <td><? echo $sql_result['atmid3'] ; ?></td>
        <td><? echo $sql_result['trackerno'] ; ?></td>
        <td><? echo $sql_result['address'] ; ?></td>
        <td><? echo $sql_result['city'] ; ?></td>
        <td><? echo $sql_result['state'] ; ?></td>
        <td><? echo $sql_result['zone'] ; ?></td>
        <td><? echo $sql_result['branch'] ; ?></td>
        <td><? echo $sql_result['bm_name'] ; ?></td>
        <td><? echo $sql_result['bm_number'] ; ?></td>
    </tr>
    <? } ?>
    </tbody>
    </table>
        </div>
        
                                    
                                        <!--<a href="newsite_sucess_excel.php">Download</a>-->
                                    </div>
                                </div>
                                
                                
                                <div class="card" id="err_card">
                                    <div class="card-body">
                                        
                                            <div class="two_end">
                                                <h6>Error Table</h6>
                                                <a href="#" id="delete_err" class="btn btn-danger">Delete All Records</a>
                                                <a class="btn btn-success" href="newsite_err_excel.php">Bulk Report Download</a>
                                            </div>
        <br>
        
                <div class="card-data">
                    <table class="table table-bordered table-striped" id="data_table2" style="width:100%;">
  <thead>
    <tr>
    <th>Sr no</th> 
    <th>activity</th>
     <th>customer</th>
      <th>bank</th>
      <th>atmid</th>
      <th>atmid2</th>
      <th>atmid3</th>
      <th>trackerno</th>
      <th>address</th>
      <th>city</th>
      <th>state</th>
      <th>zone</th>
      <th>branch</th>
      <th>bm_name</th>
      <th>bm_number</th>
    <th>Remark</th>
    </tr>
    </thead>
    <tbody>
        <?
        $i=0;
$sql = mysqli_query($con,"select * from mis_newsitetest_err where status=0");
while($sql_result = mysqli_fetch_assoc($sql)){
        ?>
    <tr>
        <td><? echo ++$i;?></td> 
        <td><? echo $sql_result['activity'] ; ?></td>
        <td><? echo $sql_result['customer'] ; ?></td>
        <td><? echo $sql_result['bank'] ; ?></td>
        <td><? echo $sql_result['atmid'] ; ?></td>
        <td><? echo $sql_result['atmid2'] ; ?></td>
        <td><? echo $sql_result['atmid3'] ; ?></td>
        <td><? echo $sql_result['trackerno'] ; ?></td>
        <td><? echo $sql_result['address'] ; ?></td>
        <td><? echo $sql_result['city'] ; ?></td>
        <td><? echo $sql_result['state'] ; ?></td>
        <td><? echo $sql_result['zone'] ; ?></td>
        <td><? echo $sql_result['branch'] ; ?></td>
        <td><? echo $sql_result['bm_name'] ; ?></td>
        <td><? echo $sql_result['bm_number'] ; ?></td>
        <td><? echo $sql_result['remark'] ; ?></td>

    </tr>
    <? } ?>
    </tbody>
    </table>
                </div>
                                    
                                        <!--<a href="newsite_sucess_excel.php">Download</a>-->
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
    
    
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">


<script>
$("#delete_err").on('click',function(){
if (confirm('Are you sure to delete all Records ?')) {
     $.ajax({

                type: "POST",
                url: 'delete_err_ajax.php',
                success:function(msg) {
                    if(msg==1){
                           $("#err_card").load(location.href+" #err_card>*","");                        
                    }
                }
            });
} else {
    alert('Canceled');
}





});


$(document).ready(function() {


    $('#data_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy',
            'excel',
            'csv',
            'pdf',
           ]
    } );
    
    $('#data_table2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy',
            'excel',
            'csv',
            'pdf',
           ]
    } );
    
} );

</script>



</body>

</html>