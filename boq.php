<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/icon/ion-icon/css/ionicons.min.css">

<style>
/*    .icon-android-add-circle:before {*/
/*    content: "\e903";*/
/*}*/

input.form-control, input {
    border: none;
    margin: 10px auto;
    border-bottom: 1px solid #ac9292 ; 
}

.form-control:focus, input.form-control, input {
    background: transparent;
}

.form-control:focus {
    color: #55595c;
    background-color: #fff;
    border-color: #66afe9;
    outline: none;
    box-shadow: none;
    border: none;
}
input:focus {
    border-bottom: 1px solid red !important;
}

#here i {
    border-radius: 3px;
    font-size: 24px;
}
    
    #kacha_inside_copy {
    font-size: 2rem;
    color: #F6BB42;
    cursor: pointer;
    position: absolute;
    top: 0;
    right: 0;
}
    .dashboardTabsText{
        height: 54px;
        padding-right: 45px;
        line-height: 15px;
    }
    .dashboardTabsText a{
        font-size: 14px;
        cursor: pointer;
        color: var(--text);
        -webkit-font-smoothing: auto;
    }
    .absolute-center, .valign-wrapper {
        display: flex;
        align-items: center;
    }
    .dashboardTabsTextActive {
        color: #00d09c;
    }
    .dashboardTabDiv {
        height: 55px;
        border-bottom: 1px solid #ecedef;
    }
.boq_label{
       background: aliceblue;
        text-align: center;
        border-bottom: 1px solid gray;
        padding: 10px;
}        
.boq_node{
   display:flex;
}
.remove_boq, .add_boq{
   cursor:pointer;
}
.remove_boq{
   color:red;
}
.add_boq{
   color:green;
}

.boq_node:first-child .remove_boq{
   display:none;
}
.boq_node:not(:first-child) .add_boq{
   display:none;
}
                                   
                                        </style>
                                        
<script>
    function bank_name(myString){
        a = '<div class="row">';
        a += '<input type="hidden" name="bank" class="form-control" value="'+myString+'">';
        a += '<div class="col-sm-8 boq_label"><label>BOQ</label></div>';
        a += '<div class="col-sm-4 boq_label"><label>QTY</label></div>';
        a += '</div>';
        a += '<div class="row boq_content">';
            a += bank_name_boq() ;
        a += '</div>';
        return a ;
    }
    
    
    function bank_name_boq(){
            a = '<div class="col-sm-12 boq_node">'; 
            a += '<div class="col-sm-8"><input type="text" name="boq[]" class="form-control" placeholder="Enter Material Name" required></div>';
            a += '<div class="col-sm-3"><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity" required></div>';
            a += '<div class="col-sm-1" style="text-align: center;"><i class="ion-plus-circled add_boq"></i> <i class="ion-minus-circled remove_boq"></i></div>';
            a += '</div>';
        return a ; 
    }
    
    
    
    $(document).on('click',".add_boq",function(){
        var url_string = window.location.href;
        var url = new URL(url_string);
        var bank = url.searchParams.get("bank");
        
        boq = bank_name_boq;  
        $(".boq_content").append(boq);
        
        
    });
    
    $(document).on('click',".remove_boq",function(){
        $(this).parent().parent().remove();
    });
    
    
    
</script>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        
                                        
                <div class="col dashboardTabDiv">
                        <div class="pos-rel" style="height: 54px;">
                            <div class="valign-wrapper" style="height: 60px;">
                                <div class="dashboardTabsLine stocksSelected"></div>
                                <div class="valign-wrapper dashboardTabsText dashboardTabsTextActive"><a class="nav-link"  href-data="pnb">PNB</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="boi">BOI</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="wla">WLA</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="axis-4g-cam">Axis 4G Cam</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="mobile-atm-camera">Mobile ATM Camera</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="icici-rms">ICICI RMS</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="axis-rms">Axis RMS</a></div>
                                <div class="valign-wrapper dashboardTabsText"><a class="nav-link" href-data="sbi-tom-gs">SBI TOM GS</a></div>
                            </div>
                        </div>
                </div>        
                                    </div>
                                </div>
                                
                                
                <div class="card">
                    <div class="card-block">
                        <form action="boq_procss.php" method="POST">
                            <div id="here"></div>   
                            <input type="submit" value="Submit" class="btn btn-success">
                        </form>
                        
                    </div>
                </div>                       
                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
     <script>
     
     
     $(document).ready(async function(){    
        var url_string = window.location.href;
        var url = new URL(url_string);
        var bank = url.searchParams.get("bank");
            if(bank){
                myString = bank ;
            }else{
                myString = 'pnb' ;
            }
            
            fun = bank_name(myString);
            
            window.history.replaceState(null, null, "?bank="+myString);
            $(".pos-rel .valign-wrapper div").removeClass('dashboardTabsTextActive');
            $(".dashboardTabsText").find("[href-data='" + myString + "']").parent().addClass('dashboardTabsTextActive');
            
            var return_unit = function(){
            tmp = null
            $.ajax({
               type:"POST",
               url: 'get_boq.php',
               data:'bank='+bank,
               async:false,
               success :function(msg){
                   tmp = msg ;
               }
            });
            return tmp ; 
            }();
            
            
            $("#here").html(fun);
            $(".boq_content").html(return_unit);
            
            
        });
        
        
        function remove_boqid(parameter){
            
            
            $.ajax({
               type:"POST",
               url: 'delete_boq.php',
               data:'id='+parameter,
               async:false,
               success :function(msg){
                   if(msg==1){
                       alert('Deleted successfully !');
                   }else{
                       alert('Deletion Error !');
                   }
               }
            });
            
            
        }
        
        
        
        $(document).on('click','.nav-link',async function(){
            $("#here").html('');
            var href = $(this).attr('href-data');
            myString = href.replace("#",'');
            if(! myString) return ;
            remove_string = '#'+href;
            window.history.replaceState(null, null, "?bank="+myString);
            window.location.href.split('#')[0];
            history.replaceState(null, null, ' ');
            
            bank = myString ;
            
            $(".pos-rel .valign-wrapper div").removeClass('dashboardTabsTextActive');
            $(this).parent().toggleClass('dashboardTabsTextActive');
            
            fun = bank_name(myString);
            
            
            var return_unit = function(){
            tmp = null
            $.ajax({
               type:"POST",
               url: 'get_boq.php',
               data:'bank='+bank,
               async:false,
               success :function(msg){
                   tmp = msg ;
               }
            });
            return tmp ; 
            }();
            
            
            $("#here").html(fun);
            $(".boq_content").html(return_unit);
            
            
            // $("#here").html('');
            // $("#here").html(fun);


        });
            
            
     </script>               
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