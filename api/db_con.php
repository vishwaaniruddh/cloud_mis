<?php
$dbhost = "103.72.141.218:3306";
 $dbuser = "comsarmi_DVR";
 $dbpass = "sar@1234";
 $db = "comsarmi_DVR_Data";
 $db_port ='3308';
// $port = "3308";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);