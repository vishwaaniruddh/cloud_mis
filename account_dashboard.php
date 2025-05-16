<? session_start();
    
include('config.php');
if($_SESSION['username']){
    include('header.php'); 
    
    $user_id = $_SESSION['userid'];  
    $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
    $user_sql = mysqli_query($con,$user_statement);
    $user_rowresult = mysqli_fetch_row($user_sql);
    $_userlevel = $user_rowresult[0];
    
    $date1 = '2021-03-23';
    $date2 = date('Y-m-d');
    
    if(isset($_POST['submit'])){
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $_userlevel = $_POST['levelwise'] ;
        
    }
    
        if($_userlevel==4){
            $_userlevel = 4;
        }
        if($_userlevel==6){
            $_userlevel = 5;
        }
        if($_userlevel==7){
            $_userlevel = 6;
        }
        if($_userlevel==8){
            $_userlevel = 7;
        }
    
    $totalapprovalpendingamt = 0;
    $totalnoapprovalpending = 0;
    $userlev = 0;
    
    if($_userlevel<6){
        $userlev = $_userlevel;
        $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_requests where status='".$_userlevel."' and action!=0 and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
    }else{
        if($_userlevel==6){
            $userlev = 2;
            $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_transfer where status='2' and current_status!=0 and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
        }
        if($_userlevel==7){
            $userlev = 3;
            $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_transfer where status='3' and current_status!=0 and current_status!=4 and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
        }
    }   
        $_pendingapprovetable=mysqli_query($con,$_pendingapprovesql);   
        $pendingapproverowcount=mysqli_num_rows($_pendingapprovetable);
        if($pendingapproverowcount>0){
          while($pendingapprovesql_result = mysqli_fetch_array($_pendingapprovetable)){
              if($_userlevel<6){
                $check_statement = "select approved_amt,status,action from mis_fund_requests where req_id='".$pendingapprovesql_result[2]."' order by id desc limit 1" ;
              }else{
                $check_statement = "select approved_amt,status,current_status from mis_fund_transfer where req_id='".$pendingapprovesql_result[2]."' order by id desc limit 1" ;  
              }
                $check_sql = mysqli_query($con,$check_statement);
                $check_rowresult = mysqli_fetch_row($check_sql);
               // $_userlevel = $check_rowresult[0];
              
              if($check_rowresult[1]==$userlev){
                   if($check_rowresult[2]!=0){
                        $checkrnmsql="select * from rnm_fund where id='".$pendingapprovesql_result[2]."'";
                    	$rnmtable=mysqli_query($con,$checkrnmsql);    
                        $countrnm=mysqli_num_rows($rnmtable);
                        if($countrnm>0){
                        $totalapprovalpendingamt = $totalapprovalpendingamt + $check_rowresult[0];
                        $totalnoapprovalpending = $totalnoapprovalpending + 1;
                        }
               // echo $pendingapprovesql_result[2]."=";
                   }
              }
          }
        } 
    
   // die;
    $totaltransferapproveamt = 0;
    $totalnotransfer = 0;
    
    $_transferapprovesql = "select approved_amt from mis_fund_transfer where current_status=4 and transferred_date!='0000-00-00' 
                             and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
   
    $_transferapprovetable=mysqli_query($con,$_transferapprovesql);   
    $transapproverowcount=mysqli_num_rows($_transferapprovetable);
    if($transapproverowcount>0){
      while($transferapprovesql_result = mysqli_fetch_array($_transferapprovetable)){
      $totaltransferapproveamt = $totaltransferapproveamt + $transferapprovesql_result[0];
      $totalnotransfer = $totalnotransfer + 1;
      }
    }
    
    $totalpendingamt = 0;
    $totalnopending = 0;
    
    $_transferpendingsql ="select approved_amt from mis_fund_transfer where current_status!=0 and current_status!=4 
                          and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
    $_transferpendingtable=mysqli_query($con,$_transferpendingsql);   
    $transpendingrowcount=mysqli_num_rows($_transferpendingtable);
    if($transpendingrowcount>0){
      while($transferpendingsql_result = mysqli_fetch_array($_transferpendingtable)){
      $totalpendingamt = $totalpendingamt + $transferpendingsql_result[0];
      $totalnopending = $totalnopending + 1;
      }
    }
    
    $totaltransferrejectamt = 0;
    $totalnorejected = 0;
    
    $_transferrejectsql ="select approved_amt from mis_fund_transfer where current_status=0 
                          and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
    $_transferrejecttable=mysqli_query($con,$_transferrejectsql);   
    $transrejectrowcount=mysqli_num_rows($_transferrejecttable);
    if($transrejectrowcount>0){
      while($transferrejectsql_result = mysqli_fetch_array($_transferrejecttable)){
      $totaltransferrejectamt = $totaltransferrejectamt + $transferrejectsql_result[0];
      $totalnorejected = $totalnorejected + 1;
      }
    }

?>

<style>
    label {
    font-weight: 900;
    font-size: 16px;
}

</style>            
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label" for="inputPassword6">
                                                        From Date
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="date" name="fromdt" class="form-control" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label" for="inputPassword6">
                                                        To Date
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                   <input type="date" name="todt" class="form-control" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-md-4">
                        						    <label class="col-form-label">Level Wise</label>
                        						</div>
                                                <div class="col-md-8">
                            						<select name="levelwise" class="form-control" required>
                        						        <option value="4" <? if($_userlevel=='4'){ echo 'selected'; } ?> >Ashish</option>
                                                        <option value="5" <? if($_userlevel=='5'){ echo 'selected'; } ?> >Madhuri</option>
                                                        <option value="6" <? if($_userlevel=='6'){ echo 'selected'; } ?> >Neeta</option>
                                                       
                                                    </select>    
                                                </div>
                                            </div>
                        				</div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <input type="submit" name="submit" value="Fetch" class="btn btn-primary">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <!--<div class="row form-group">
                                        <div class="col-md-4 form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label" for="inputPassword6">
                                                        No Of Files
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    
                                                    <p>
                                                        1
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label" for="inputPassword6">
                                                        Select
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="" name="">
                                                        <option value="1">
                                                            1
                                                        </option>
                                                        <option value="2">
                                                            2
                                                        </option>
                                                        <option value="3">
                                                            3
                                                        </option>
                                                        <option value="4">
                                                            4
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div> 
                               
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                        		<table class="table">
                                <thead>
                                    <tr style="background: lightgray;">
                                       
                                        <th scope="col">
                                            Transaction Status
                                        </th>
                                        <th scope="col">
                                            No. of transactions
                                        </th>
                                        <th scope="col">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                        <td>
                                            <form action="fund_process_details.php" method="POST">
                                                <input type="hidden" name="fromdt" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">
                                                <input type="hidden" name="todt" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">
                                                <input type="hidden" name="current_status" value="4">
                                                <input type="submit" name="submit" value="Transferred" class="btn btn-primary">
                                            </form>    
                                        </td>
                                        <td id="transferred">
                                            <? echo $totalnotransfer; ?>
                                        </td>
                                        <td>
                                           <? echo $totaltransferapproveamt; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                       
                                        <td>
                                            <form action="fund_process_details.php" method="POST">
                                                <input type="hidden" name="fromdt" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">
                                                <input type="hidden" name="todt" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">
                                                <input type="hidden" name="current_status" value="3">
                                                <input type="submit" name="submit" value="Pending" class="btn btn-info">
                                            </form>  
                                        </td>
                                        <td id="pending">
                                            <? echo $totalnopending; ?>
                                        </td>
                                        <td>
                                            <? echo $totalpendingamt; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                       
                                        <td>
                                            
                                            <form action="fund_process_details.php" method="POST">
                                                <input type="hidden" name="fromdt" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">
                                                <input type="hidden" name="todt" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">
                                                <input type="hidden" name="current_status" value="0">
                                                <input type="submit" name="submit" value="Rejected" class="btn btn-danger">
                                            </form>  
                                        </td>
                                        <td id="rejected">
                                            <? echo $totalnorejected; ?>
                                        </td>
                                        <td>
                                            <? echo $totaltransferrejectamt; ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td>
                                            <? if($totalnoapprovalpending>0){ ?>
                                            <form action="fund_process_details.php" method="POST">
                                                <input type="hidden" name="fromdt" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">
                                                <input type="hidden" name="todt" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">
                                                <input type="hidden" name="current_status" value="2">
                                                <input type="hidden" name="level_wise" value="<? echo $_userlevel; ?>">
                                                <input type="submit" name="submit" value="Approval Pending" class="btn btn-warning">
                                            </form> 
                                            <? }else{ ?>
                                                <button type="button" class="btn btn-warning">Approval Pending</button>
                                            <? } ?>
                                        </td>
                                        <td id="pendingapproval">
                                            <? echo $totalnoapprovalpending; ?>
                                        </td>
                                        <td>
                                           <? echo $totalapprovalpendingamt; ?>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
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
        window.location.href="auth/login.php";
    </script>
<? }
    ?>