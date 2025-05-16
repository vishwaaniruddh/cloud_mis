<?php session_start();
// return;
  ini_set('post_max_size', '64M');
  ini_set('upload_max_filesize', '64M');
  

include('function.php');






$token = $_SESSION['token'] ; 

if (!function_exists('verifyToken')) {
    function verifyToken($token){
        global $con; 
    
        $sql = mysqli_query($con,"select * from mis_loginusers where token='".$token."' and user_status=1");
            if($sql_result = mysqli_fetch_assoc($sql)){
                return 1 ; 
        
            }else{
                return 0;
            }    
    }    
}    


if(verifyToken($token)!=1){

    header('Location: login.php');
    exit;
}



?>
<!DOCTYPE html>
<!--<html lang="en" style="text-transform: uppercase;">-->
    <html lang="en">

<head>
    <title>CAMP - Comfort Asset Management Program</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="./assets/cts.png" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    
            <link href="select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="../files/bower_components/bootstrap/dist/css/bootstrap.min.css">


   <link rel="stylesheet" type="text/css" href="../files/assets/icon/feather/css/feather.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../files/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../files/assets/css/jquery.mCustomScrollbar.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
   <!-- <script src='jquery-3.0.0.js' type='text/javascript'></script>-->

        <!-- select2 css -->
        <script src="select2/dist/js/select2.min.js" defer></script>
</head>

<style>
label{
        font-weight: 900;
}
.btn{
        font-size: 16px !important;
            padding: 5px 16px !important;
}
.badge {
    border-radius: 10px;
    padding: 10px 12px;
}

@media (min-width: 992px) {
    .modal-lg, .modal-xl {
        max-width: 1500px;
    }
}


body{
    font-size:16px;
}
.pcoded[theme-layout="vertical"] .pcoded-navbar .pcoded-item>li>a .pcoded-mtext{
    font-size:16px;
}
span, .pcoded .pcoded-navbar .pcoded-item .pcoded-hasmenu .pcoded-submenu li>a{
    font-size:15px;
}
    .modal-backdrop{
            width: 200vw !important;
    height: 200vh !important;
    }
    
    .pcoded .pcoded-navbar[navbar-theme="theme1"] .pcoded-item>li.pcoded-trigger>a, .pcoded .pcoded-navbar[navbar-theme="theme1"] .main-menu,
    .pcoded .pcoded-navbar[navbar-theme="theme1"] .pcoded-item .pcoded-hasmenu .pcoded-submenu li.active>a,
    .pcoded .pcoded-header .navbar-logo[logo-theme="theme1"],
    .pcoded .pcoded-navbar[navbar-theme="theme1"] .pcoded-item li.pcoded-hasmenu .pcoded-submenu li>a,
    .pcoded .pcoded-navbar[navbar-theme="theme1"]
    {
            background: #191c24;
    }
    thead {
    background: #51e2f5;
    color: black;
}
</style>
<script>



// var ajax_call = function() {
//     id = '1';
// $.ajax({
//             type: "POST",
//             url: 'login_track.php',
//             data: 'id='+id,
//             success:function(msg) {}
//           });    
// }
// setInterval(ajax_call, 10000);


</script>


<body>
    <div id="pcoded" class="pcoded" nav-type="st5">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="index.php" style="font-size: 200%;">
                            <img src="./assets/cts.png" style="width: 150px;text-align: left;float: left;" />
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>
                    
                    <?
                    $notification_count_sql = mysqli_query($con,"select count(1) as notification_count from notification where is_seen=0 and notification_to='".$userid."'");
                    $notification_count_sql_result = mysqli_fetch_assoc($notification_count_sql);
                    $notification_count = $notification_count_sql_result['notification_count'];
                    ?>
                    <div class="navbar-container">
                        <ul class="nav-right">
                            <li><a href="profileUpdate.php">Profile</a></li>
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="feather icon-bell"></i>
                                    <span class="badge bg-c-pink"><? echo $notification_count; ?></span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        
                                     <? 
                                     $noti_sql = mysqli_query($con,"select department,remark,TIMEDIFF('".$datetime."',created_at) as ago from notification where notification_to='".$userid."' and is_seen=0");
                                        while($noti_sql_result = mysqli_fetch_assoc($noti_sql)){ 
                                        
                                                $ago = $noti_sql_result['ago'];
                                                $ago_ar = explode(':',$ago);

                                                
                                                $ago_hr = $ago_ar[0];
                                                $ago_min = $ago_ar[1];
                                                $ago_sec = $ago_ar[2];
                                                
                                                if($ago_hr==0){
                                                    $ago_hr = '';
                                                }else if($ago_hr==1){
                                                    $ago_hr = $ago_hr . ' Hour and ';
                                                }else{
                                                    $ago_hr = $ago_hr . ' Hours and ';
                                                }
                                                
                                                if($ago_min==0){
                                                    $ago_min = '';
                                                }else if($ago_min==1){
                                                    $ago_min = $ago_min . ' Minute and ';
                                                }else{
                                                    $ago_min = $ago_min . ' Minutes and ';
                                                }
                                                
                                                if($ago_sec==0){
                                                    $ago_sec = '';
                                                }else if($ago_sec==1){
                                                    $ago_sec = $ago_sec . ' Second';
                                                }else{
                                                    $ago_sec = $ago_sec . ' Seconds';
                                                }
                                                
                                                $time = $ago_hr  .$ago_min . $ago_sec ;
                                                
                                        ?>
                                           <li>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h6 class="notification-user">From : <span style="font-size:12px;color:red;"><? echo $noti_sql_result['department'];?></span> </h6>
                                                        <p class="notification-msg" style="font-size:12px;" ><? echo $noti_sql_result['remark']; ?> </p>
                                                        <span class="notification-time"><? echo $time; ?> ago</span>
                                                    </div>
                                                </div>
                                            </li> 
                                        <? } ?>
                                        
                                        
                                     
                                    </ul>
                                </div>
                            </li>

                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <span>Hello, <? echo ucwords($_SESSION['username']);?></span>
                                </div>
                            </li>
                            
                            
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="./uploads/wallet.svg">
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <?php 
                                            
                                            $query = "
    SELECT 
        IFNULL(SUM(approved_amount) - SUM(finalUtilisedAmount), 0) AS balance 
    FROM 
        eng_fund_request 
    WHERE 
        
        fund_requested_by = '".$userid."' AND req_status = 5";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$balance = $row['balance'];


                                            ?>
                                            <h6>Wallet BalanceL  : <?php echo $balance ; ?></h6>
                                            <hr>
                                            <a href="./wallet.php">View</a>

                                        </li>
                                        
                                  
                                        
                                        
                                     
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>
                    </div>

                </div>
            </nav>

            <!-- Sidebar chat start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="card card_main p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-inner-header">
                                <div class="back_chatBox">
                                    <div class="right-icon-control">
                                        <input type="text" class="form-control  search-text" placeholder="Search Friend"
                                            id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online"
                                    data-username="Josephin Doe" data-toggle="tooltip" data-placement="left"
                                    title="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius"
                                            src="" alt="Generic placeholder image ">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online"
                                    data-username="Lary Doe" data-toggle="tooltip" data-placement="left"
                                    title="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice"
                                    data-toggle="tooltip" data-placement="left" title="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia"
                                    data-toggle="tooltip" data-placement="left" title="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen"
                                    data-toggle="tooltip" data-placement="left" title="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat start-->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                        <i class="feather icon-chevron-left"></i> Josephin Doe
                    </a>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src=""
                            alt="Generic placeholder image">
                    </a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media-right photo-table">
                        <a href="#!">
                            <img class="media-object img-radius img-radius m-t-5"
                                src="" alt="Generic placeholder image">
                        </a>
                    </div>
                </div>
                <div class="chat-reply-box p-b-20">
                    <div class="right-icon-control">
                        <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                        <div class="form-icon">
                            <i class="feather icon-navigation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    
                    
                    <? include('nav.php');?>
                    
                    
                    
                    
                    <script>
                    
                    
                    
                    
//                     window.addEventListener('beforeunload', function (e) {
//   var confirmationMessage = 'Are you sure you want to leave this page?';

//   // Display the confirmation dialog
//   (e || window.event).returnValue = confirmationMessage;
//   return confirmationMessage;
// });




                        var logoutTimeout;
                        
                        function startLogoutTimer() {
                          logoutTimeout = setTimeout(logout, 3600000); // 1 Hour in milliseconds
                        }
                        
                        function resetLogoutTimer() {
                          clearTimeout(logoutTimeout);
                          startLogoutTimer();
                        }
                        
                        function logout() {
                          window.location.href = 'logout.php';
                        }
                        
                        document.addEventListener('mousemove', resetLogoutTimer);
                        document.addEventListener('keydown', resetLogoutTimer);
                        document.addEventListener('click', resetLogoutTimer);
                        
                        startLogoutTimer();
                    </script>