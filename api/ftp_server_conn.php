<?php 

function OpenComfortFTPLocalCon()
 {
$ftp_server = "192.168.100.26"; 
$ftp_username = "comfort";
$ftp_userpass = "cam@12345";
$ftp_port = "7554";
$timeout = "90";
$ftp_conn = ftp_connect($ftp_server,$ftp_port,$timeout) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
//var_dump($ftp_conn);
// check connection
if ((!$ftp_conn) || (!$login)) {
      echo "FTP connection has failed!";
      echo "Attempted to connect to $ftp_server for user $ftp_username";
      die;
  } else {
     // echo "Connected to $ftp_server, for user $ftp_username";
  }
 
 return $ftp_conn;
 }
 
 function OpenVisitFTPCon()
{

    $ftp_server = "103.141.218.26";
    $ftp_username = "css";
    $ftp_userpass = "Comfort@#1212";
    $ftp_port = "521";
    $timeout = "90";
    $ftp_conn = ftp_connect($ftp_server, $ftp_port, $timeout) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

// check connection
    if ((!$ftp_conn) || (!$login)) {
        echo "FTP connection has failed!";
        echo "Attempted to connect to $ftp_server for user $ftp_username";
        die;
    } else {
        // echo "Connected to $ftp_server, for user $ftp_username";
    }

    return $ftp_conn;
}

?>