<? session_start();
include('config.php');

// if($_SESSION['username']){ 

include('headertest.php');


?>

<style>
    body{
            overflow: hidden;
    }
</style>     
            <div class="pcoded-content" style="margin-left: 0px;">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                            <section class="login-block" style="background-image: url('https://cssmumbai.sarmicrosystems.com/css/dash/images/bg.jpg');">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form action="process_login_test.php" class="md-float-material form-material" method="POST">
                        <div class="text-center">
                            <img src="../files/assets/images/logo.png" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Log In</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="username" class="form-control" required=""
                                        placeholder="Enter Username">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" required=""
                                        placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                      <input class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" type="submit" value="Sign In"> 
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    
                    <!-- Site is under maintenance so keep patience  --> 

                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
//     }
// else{ ?>
    
<!--//     <script>-->
<!--//         window.location.href="login.php";-->
<!--//     </script>-->

    ?>
</body>

</html>