<?php session_start();
include('config.php');
error_reporting(0);
$engid=$_REQUEST['engid'];
$_SESSION['engid'] = $engid ;
if(isset($_REQUEST['engid'])){
}else{
$engid=$_SESSION['engid'] ; 
    
}
    $sql = mysqli_query($con,"select * from mis_loginusers where id=$engid");
    $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
            $atmsql = mysqli_query($con,"select atmid from mis_newsite where engineer_user_id=$engid");
            while($atmsql_result = mysqli_fetch_assoc($atmsql)){
                $atmids[] = $atmsql_result['atmid'];
            }
            $_SESSION['assigned_atm'] = $atmids ;
                $_SESSION['auth']=1;
                $_SESSION['username']=$sql_result['name'];
                $_SESSION['designation']=$sql_result['designation'];
                $_SESSION['userid'] = $sql_result['id'];
                 $_SESSION['level'] = $sql_result['level'];
                $userid = $sql_result['id'];
                
                if($uname == 'admin@gmail.com'){
                    $_SESSION['access']=1 ;
                }            
           }
if($_SESSION['username']){
include('header.php');
?>
    <style>
    html{
        text-transform: inherit !important;
    }
        nav{
            display:none !important;
        }
        .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="expanded"][vertical-effect="shrink"] .pcoded-content {
        margin-left: 0;
    }
    .line-on-side {
        border-bottom: 1px solid #dadada;
        line-height: 0.1em;
        margin: 10px 0 20px;
    }
    .line-on-side span {
        background: #F6F7FB;
        padding: 0 10px;
    }
    </style>
        <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <h2 class="card-subtitle line-on-side center font-small-3 pt-2">
                                    <span>CSS App Portal</span>
                                </h2>
                                <div class="card">
                                    <div class="card-block">
                                        <ul class="nav">
                                              <li class="nav-item">
                                                <a class="nav-link" aria-current="page" id="project" href="appportalInstallation.php?engid=<? echo $engid; ?>">Project</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="sites" href="appportalSitestest.php?engid=<? echo $engid; ?>">Sites</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="ATMVisit" href="appportal.php?engid=<? echo $engid; ?>">ATM Visit</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link active" href="appvisitrecords.php?engid=<? echo $engid; ?>">Visit Records</a>
                                              </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">    
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Name</th>
                                                    <th>ATMID</th>
                                                    <th>Call Given By</th>
                                                    <th>Bank</th>
                                                    <th>Purpose</th>
                                                    <th>Created By</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $count = 1 ; 
                                                $sql = mysqli_query($con,"select * from appportal_atmvisit where status=1 order by id desc");
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                $name = $sql_result['name'];
                                                $atmid = $sql_result['atmid'];
                                                $bank = $sql_result['bank'];
                                                $purpose = $sql_result['purpose'];
                                                $callby = $sql_result['callby'];
                                                $created_by = $sql_result['created_by'];
                                                $created_at = $sql_result['created_at'];
                                                ?>
                                                <tr>
                                                    <td><? echo $count ; ?></td>
                                                    <td><? echo $name; ?></td>
                                                    <td><? echo $atmid; ?></td>
                                                    <td><? echo $callby?></td>
                                                    <td><? echo $bank; ?></td>
                                                    <td><? echo $purpose; ?></td>
                                                    <td><? echo get_member_name($created_by) ; ?></td>
                                                    <td><? echo $created_at ; ?></td>
                                                </tr>
                                                <? $count++; } ?>
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