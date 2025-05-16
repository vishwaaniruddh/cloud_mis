<?php session_start();
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);

$host="localhost";
$user="sarmicrosystems_prabir";
$pass="prabir@1986";
$dbname="sarmicrosystems_q2sGeneral";
$contest = new mysqli($host, $user, $pass, $dbname);
// Check connection
if ($contest->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
// echo "Connected succesfull";
   
}
?>