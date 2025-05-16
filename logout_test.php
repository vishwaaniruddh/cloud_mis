<? session_start();


session_destroy();


?>

<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>

<script>
       swal("", "Logout Successfully !", "success");
                  setTimeout(function(){ 
               window.location.href="login_test.php";
           }, 3000);
</script>        
    </body>
</html>
        

