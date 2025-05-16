<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
 <link rel="stylesheet" type="text/css" href="../datatable/lightbox.min.css">    
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <div class="row">
                                            
                                        
                                        <?
                                        $id = $_GET['id'];
                                        // echo $id;
                                        $sql = mysqli_query($con,"select * from misvisit_images_app where misvisitid='".$id."'");
                                        while($sql_result = mysqli_fetch_assoc($sql)){ 
                                        $images = $sql_result['link'];
                                        ?>
                                            
                                            
                                            <div class="col-md-3 col-sm-4">
												<div class="thumbnail">
													<div class="thumb">
														<a href="<? echo $images; ?>" data-lightbox="gallery" > <img src="<? echo $images; ?>" style="width:150px;" class="img-fluid img-thumbnail"> </a>
													</div>
												</div>
											</div>
                                        <? } ?>
                                        </div>
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
<script src="../datatable/lightbox.min.js"></script>



<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>
<script>
		lightbox.option({
  albumLabel: 'Image %1 of %2',
  alwaysShowNavOnTouchDevices: false,
  fadeDuration: 600,
  fitImagesInViewport: true,
  imageFadeDuration: 600,
  maxWidth: 800,
  maxHeight: 600,
  positionFromTop: 50,
  resizeDuration: 700,
  showImageNumberLabel: true,
  wrapAround: false, // If true, when a user reaches the last image in a set, the right navigation arrow will appear and they will be to continue moving forward which will take them back to the first image in the set.
  disable<a href="https://www.jqueryscript.net/tags.php?/Scroll/">Scroll</a>ing: false,
 
  sanitizeTitle: false
})

	</script>


</body>

</html>