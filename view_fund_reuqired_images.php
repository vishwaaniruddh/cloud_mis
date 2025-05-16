<? session_start();
include('config.php');

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
                                        
                                        
                                        <?php 
                                
                                    $spareFundId = $_REQUEST['spare_id'];

    // Fetch attachments for this spare fund
    $attachmentsql = mysqli_query($con, "SELECT * FROM spare_funds_attachments WHERE spare_fund_id='" . $spareFundId . "'");
    $attachments_html = ''; // Store HTML for attachments


        
                                            while ($attachmentsql_result = mysqli_fetch_assoc($attachmentsql)) {
        $media_type = $attachmentsql_result['type'];
        $path = $attachmentsql_result['path'];

        if ($media_type == 'image') {
            // Display image with 100x100 size
            $attachments_html .= "<img src='$path' alt='Spare Image' style='width: 100px; height: 100px; object-fit: cover; margin: 5px;' />";
        } else if ($media_type == 'video') {
            // Display video with 100x100 size, fallback link if not supported
            $attachments_html .= "
                <video width='100' height='100' controls style='margin: 5px;'>
                    <source src='$path' type='video/mp4'>
                    <source src='$path' type='video/quicktime'>
                    <source src='$path' type='video/avi'>
                    Your browser does not support this video format. <a href='$path' target='_blank'>View Video</a>
                </video>";
        }
    }



echo $attachments_html ; 


                                        
                                        ?>
                                        
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
    
       