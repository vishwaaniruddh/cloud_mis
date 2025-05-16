<?php session_start();
include('config_test.php');

if($_SESSION['username']){ 

include('header.php');


?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
 <style>
    .select2-container .select2-selection--single{height: auto !important; }
    .select2-selection__choice {background-color:cyan; }
}
 </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">
                                                 
                                                <div class="col-md-3">
                                                    <label>Subject</label>
                                                    <select id="subject" class="form-control" name="subject">
                                                        <option value=""> Select </option>
                                                        <option value="6" <?php if(isset($_POST['subject'])) { if($_POST['subject']=='6'){ echo 'selected' ;  }} ?>>English</option>
                                                        <option value="all" <?php if(isset($_POST['subject'])) { if($_POST['subject']=='all'){ echo 'selected' ;  } } ?>>GK</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>


                            <?php if($_POST['submit']) {
                                   
                            
                            if(isset($_POST['subject']) && $_POST['subject']!=''){
                                $subject = $_POST['subject'];
                                if($subject== '6'){
                                     $atm_sql .= "select * from quiztest where subject = '".$subject."' ";
                                }
                                else {
                                     $atm_sql .= "select * from quiztest where subject!=6 ";
                            }
                                }
                               
                                $atm_sql .= "order by id asc";
                               
                            //   echo $atm_sql; die;
                            } 
                               ?>
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        
                                        <form action="viewrajexcl.php" method="POST">
                                            <input type="hidden" name="qry" value="<? echo $atm_sql; ?>">
                                            <input type="submit" class="btn btn-secondary" value="Excel" target="_blank">
                                        </form>
                                        
                                        <br>
                                        
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>srno</th>
                                                    <th>std</th>
                                                    <th>subject</th>
                                                    <th>topic</th>
                                                    <th>sub topic</th>
                                                    <th>mcq</th>
                                                    <th>a</th>
                                                    <th>b</th>
                                                    <th>c</th>
                                                    <th>d</th>
                                                    <th>final answer</th>
                                                    <th>status</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                if(isset($_POST['submit'])){
                                                    
                                                // echo $atmid; die;
                                                $atm_sql_res = mysqli_query($contest,$atm_sql);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
                                                     
                                                ?>
                                                
                                                 <tr>
                                                     <td><?php echo $i; ?></td>
                                                     <td><?php echo $atm_sql_result['srno']; ?></td>
                                                     <td><?php echo $atm_sql_result['std']; ?></td>
                                                     <td><?php echo $atm_sql_result['subject']; ?></td>
                                                     <td><?php echo $atm_sql_result['topic']; ?></td>
                                                     <td><?php echo $atm_sql_result['sub_topic']; ?></td>
                                                     <td><?php echo $atm_sql_result['mcq']; ?></td>
                                                     <td><?php echo $atm_sql_result['a']; ?></td>
                                                     <td><?php echo $atm_sql_result['b']; ?></td>
                                                     <td><?php echo $atm_sql_result['c']; ?></td>
                                                     <td><?php echo $atm_sql_result['d']; ?></td>
                                                     <td><?php echo $atm_sql_result['final_ans'];?></td>
                                                     <td><?php echo $atm_sql_result['status'];?></td>
                                                 </tr>
                                                <?php $i++; 
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <?php include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<?php }
    ?>
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>-->
<!--        <script src="../datatable/jquery.dataTables.js"></script>-->
<!--<script src="../datatable/dataTables.bootstrap.js"></script>-->
<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
<!--<script src="../datatable/buttons.flash.min.js"></script>-->
<!--<script src="../datatable/jszip.min.js"></script>-->




<!--<script src="../datatable/pdfmake.min.js"></script>-->
<!--<script src="../datatable/vfs_fonts.js"></script>-->
<!--<script src="../datatable/buttons.html5.min.js"></script>-->
<!--<script src="../datatable/buttons.print.min.js"></script>-->
<!--<script src="../datatable/jquery-datatable.js"></script>-->
<script>
     $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $('.js-example-basic-single').find(':selected');
        // maximumSelectionLength: 100
    });
    
    
    
</script>


</body>

</html>