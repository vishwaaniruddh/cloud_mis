<? session_start();
include('config.php');
include('function.php');
$fund_remark = $_POST['fund_remark'];
$type = $_POST['type'];
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <td>Beneficiary Name</td>
                                                    <td>Approved Amount</td>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                
                   <? 
                    if($type=='1'){    
                       $transfund_statement = "select beneficiary_name,approved_amt from mis_fund_transfer where fund_remark='".$fund_remark."' and status='3' and current_status='4' order by id desc" ;
                    }
                    if($type=='2'){    
                       $transfund_statement = "select beneficiary_name,amount from mis_salary_fund_transfer where fund_remark='".$fund_remark."' and status='3' and current_status='4' order by id desc" ;
                    }
                    
                       $transfund_sql = mysqli_query($con,$transfund_statement);
                       if(!empty($transfund_sql)){
                           while($transfund_sql_result = mysqli_fetch_array($transfund_sql))
                           
                             {  
                            
                               ?>
                               
                              <tr>
                                    <td><? echo ++$i; ?></td>
                                    <td><? echo $transfund_sql_result[0]; ?> </td>
                                    <td><? echo $transfund_sql_result[1]; ?> </td>
                                    
                                </tr>  
                               
                      <?  }  
                       }
    
    ?>   
                                                
                                                
                                                
            
    
                    
              
    </tbody>
                                            </table>
   