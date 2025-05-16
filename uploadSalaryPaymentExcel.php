<? session_start();
include('config.php');

if($_SESSION['username']){ 
    $_resultdata = 0;
    include('header.php');
    
    //  Include PHPExcel_IOFactory
    require_once 'Classes/PHPExcel.php';
    
    require_once "Classes/PHPExcel/IOFactory.php";
    
    //$inputFileName = './sampleData/example1.xls';
    if(isset($_POST['import'])){ 
        if(!empty($_POST['import'])){
            
            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'text/xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (in_array($_FILES["file"]["type"], $allowedFileType)) {
                    
                  // $inputFileName = $_FILES['file']['name']; 
                    $inputFileName = "uploads/".$_FILES['file']['name'];
                    $isUploaded = copy($_FILES['file']['tmp_name'], $inputFileName);
                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch(Exception $e) {
                        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                    }
                    
                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0); 
                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();
                    $chkdata = 0;
                    $checkrowcount = 0;
                    //  Loop through each row of the worksheet in turn
                    for ($row = 2; $row <= $highestRow; $row++){ 
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
                        //  Insert row data array into your database of choice here
                       // echo '<pre>';print_r($rowData[0]);echo '</pre>';
                        $_row_array = $rowData[0];
                        $count = count($rowData[0]);
                        $action = 1;
                        $status = 1; 
                        $user_id = $_SESSION['userid'];
                       // echo $_row_array[17];
                        $excel_date = $objPHPExcel->getActiveSheet()->getCell('S'.$row)->getFormattedValue();
                        $salary_date = date("Y-m-d", strtotime($excel_date) );
                        $month = date("M", strtotime($excel_date) );
                        $year = date("Y", strtotime($excel_date) );
                       // echo $salary_date;die;
                       
                     /*  if($chkdata==0){
                            $checkmonthsql = "select * from mis_staff_salary where month='".$month."' and account_number='".$_row_array[9]."'
                                              department='".$_row_array[11]."'";
                           
                            $checkmonthquery = mysqli_query($con,$checkmonthsql);
                            if(!empty($checkmonthquery)){
                               $checkrowcount= mysqli_num_rows($checkmonthquery);
                               $chkdata = 1;
                            }
                       } */
                        
                        if($_row_array[9]!=""){
                            
                            $checkmonthsql = "select * from mis_staff_salary where month='".$month."' and account_number='".$_row_array[9]."'
                                              and department='".$_row_array[11]."' and year='".$year."'";
                           
                            $checkmonthquery = mysqli_query($con,$checkmonthsql);
                            if(!empty($checkmonthquery)){
                               $checkrowcount= mysqli_num_rows($checkmonthquery);
                               
                            }
                            
                            if($checkrowcount==0){
                               // echo '<pre>';print_r($_row_array);echo '</pre>';die;
                                $insertexcelsql = "insert into mis_staff_salary(company,categories,staff_type,customer,payee_name,amount,emp_code,beneficiary_name,
                                                 beneficiary_name_fencer,account_number,ifsc,department,email_body,state,branch_location,sup_name,bank,atm_id,month,salary_date,required_by,
                                                 remark,uan,esic,action,status,created_by,action_by,year) 
                                values('".$_row_array[0]."','".$_row_array[1]."','".$_row_array[2]."','".$_row_array[3]."','".$_row_array[4]."','".$_row_array[5]."',
                                '".$_row_array[6]."','".$_row_array[7]."','".$_row_array[8]."','".$_row_array[9]."','".$_row_array[10]."','".$_row_array[11]."',
                                '".$_row_array[12]."','".$_row_array[13]."','".$_row_array[14]."','".$_row_array[15]."','".$_row_array[16]."','".$_row_array[17]."','".$month."',
                                '".$salary_date."','".$_row_array[19]."','".$_row_array[20]."','".$_row_array[21]."','".$_row_array[22]."',
                                '".$action."','".$status."','".$user_id."','".$user_id."','".$year."')";
                              mysqli_query($con,$insertexcelsql); 
                              $_resultdata = 1;
                            }else{
                                $_resultdata = 2;
                            }
                        }
                    }
                   
            }
        }
    }
    
      if(isset($_POST['importparticulars'])){ 
        if(!empty($_POST['importparticulars'])){
            
            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'text/xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (in_array($_FILES["file"]["type"], $allowedFileType)) {
                    
                  // $inputFileName = $_FILES['file']['name']; 
                    $inputFileName = "uploads/".$_FILES['file']['name'];
                    $isUploaded = copy($_FILES['file']['tmp_name'], $inputFileName);
                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch(Exception $e) {
                        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                    }
                    
                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0); 
                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();
                    $chkdata = 0;
                    $checkrowcount = 0;
                    //  Loop through each row of the worksheet in turn
                    for ($row = 2; $row <= $highestRow; $row++){ 
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
                        //  Insert row data array into your database of choice here
                        // echo '<pre>';print_r($rowData[0]);echo '</pre>'; die;
                        $_row_array = $rowData[0];
                        $count = count($rowData[0]);
                        $action = 1;
                        $status = 1; 
                        $user_id = $_SESSION['userid'];
                       // echo $_row_array[17];
                        $excel_date = $objPHPExcel->getActiveSheet()->getCell('S'.$row)->getFormattedValue();
                        $salary_date = date("Y-m-d", strtotime($excel_date) );
                        $month = date("M", strtotime($excel_date) );
                        $year = date("Y", strtotime($excel_date) );
                       // echo $salary_date;die;
                       
                     /*  if($chkdata==0){
                            $checkmonthsql = "select * from mis_staff_salary where month='".$month."' and account_number='".$_row_array[9]."'
                                              department='".$_row_array[11]."'";
                           
                            $checkmonthquery = mysqli_query($con,$checkmonthsql);
                            if(!empty($checkmonthquery)){
                               $checkrowcount= mysqli_num_rows($checkmonthquery);
                               $chkdata = 1;
                            }
                       } */
                        
                        if($_row_array[9]!=""){
                            
                            $checkmonthsql = "select * from mis_staff_salary where month='".$month."' and account_number='".$_row_array[9]."'
                                              and department='".$_row_array[11]."' and year='".$year."'";
                           
                            $checkmonthquery = mysqli_query($con,$checkmonthsql);
                            if(!empty($checkmonthquery)){
                               $checkrowcount= mysqli_num_rows($checkmonthquery);
                               
                            }
                            
                            if($checkrowcount==0){
                               // echo '<pre>';print_r($_row_array);echo '</pre>';die;
                                $insertexcelsql = "insert into mis_staff_salary(company,categories,staff_type,customer,payee_name,amount,emp_code,beneficiary_name,
                                                 beneficiary_name_fencer,account_number,ifsc,department,email_body,state,branch_location,sup_name,bank,atm_id,month,salary_date,required_by,
                                                 remark,uan,esic,action,status,created_by,action_by,year,particulars) 
                                values('".$_row_array[0]."','".$_row_array[1]."','".$_row_array[2]."','".$_row_array[3]."','".$_row_array[4]."','".$_row_array[5]."',
                                '".$_row_array[6]."','".$_row_array[7]."','".$_row_array[8]."','".$_row_array[9]."','".$_row_array[10]."','".$_row_array[11]."',
                                '".$_row_array[12]."','".$_row_array[13]."','".$_row_array[14]."','".$_row_array[15]."','".$_row_array[16]."','".$_row_array[17]."','".$month."',
                                '".$salary_date."','".$_row_array[19]."','".$_row_array[20]."','".$_row_array[21]."','".$_row_array[22]."',
                                '".$action."','".$status."','".$user_id."','".$user_id."','".$year."','".$_row_array[23]."')";
                              mysqli_query($con,$insertexcelsql); 
                              $_resultdata = 1;
                            }else{
                                $_resultdata = 2;
                            }
                        }
                    }
                   
            }
        }
    }

?>
<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        
                                        <div class="two_end">
                                            <h5>Upload Salary <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                            <select class="form-control" style=" width: 30%;" name="type" id="type" onchange="SelectOption(this.value)" required>
                    						<option value="">Select Type</option>
                    						<option value="Salary">Salary</option>
                    						<option value="Particulars">Particulars</option>
                    					</select>
                                            <a class="btn btn-success"  style="display:none" id="salaryuploadformat" href="excelformat/Comfort_Techno_Staff_Salary.xlsx" download>SALARY UPLOAD FORMAT</a>
                                            <a class="btn btn-success" style="display:none" id="salaryuploadformatParticulars" href="excelformat/Comfort_Techno_Staff_Salary-Particulars.xlsx" download>SALARY UPLOAD FORMAT PARTICULARS</a>
                                        </div>
                        
                                        <hr>

    <h2>Import Excel File </h2>
    
    <div class="outer-container">
        <form action="uploadSalaryPaymentExcel.php"  method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                            <div>
                                <label>Choose Excel
                                    File</label> <input type="file" name="file"
                                    id="file" accept=".xls,.xlsx">
                                <button type="submit" id="submit" name="import" value="import" style="display:none"
                                    class="btn-submit" class="btn btn-danger">Import</button>
                                     <button type="submit" id="importparticulars" name="importparticulars" value="importparticulars" style="display:none"
                                    class="btn-submit" class="btn btn-danger">Import Particulars</button>
                        
                            </div>
        
        </form>
        
        <!--<form action="uploadSalaryPaymentExcelParticulars.php" style="display:none" method="POST" name="frmExcelImportParticulars" id="frmExcelImportParticulars" enctype="multipart/form-data">-->
        <!--                    <div>-->
        <!--                        <label>Choose Excel-->
        <!--                            File</label> <input type="file" name="file"-->
        <!--                            id="file" accept=".xls,.xlsx">-->
        <!--                        <button type="submit" id="importparticulars" name="importparticulars" value="importparticulars"-->
        <!--                            class="btn-submit" class="btn btn-danger">Import Particulars</button>-->
                        
        <!--                    </div>-->
        
        <!--</form>-->
        
        
    </div>
   <!-- <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div> -->
</div></div></div></div></div></div></div>    
    
<? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>  
    <script>
       var isalertmsg = <? echo $_resultdata ?>;
        if(isalertmsg==1){
            swal("Good job!", "Excel Data Uploaded!", "success");  
        }
        if(isalertmsg==2){
            swal("Something Wrong!", "Already Uploaded!", "info"); 
        }
    </script>
    <script>
        function SelectOption(val){
            // alert(val);
          
            if(val=="Salary"){
                $("#salaryuploadformat").show();
                // $("#frmExcelImport").show();
                // $("#frmExcelImportParticulars").hide();
                $("#importparticulars").hide();
                $("#submit").show();
                $("#salaryuploadformatParticulars").hide();
            }
            else if(val=="Particulars")
            {
                $("#salaryuploadformat").hide();
                // $("#frmExcelImport").hide();
                // $("#frmExcelImportParticulars").show();
                $("#salaryuploadformatParticulars").show();
                $("#importparticulars").show();
                $("#submit").hide();
            }
            
        }
    </script>