<?php 
    include('ftp_server_conn.php');
    $ftp_conn_local = OpenComfortFTPLocalCon();
	$ftp_pasv_local = ftp_pasv($ftp_conn_local,true);
	$file_list = ftp_nlist($ftp_conn_local, "Footage_Upload");
	echo '<pre>';print_r($file_list);echo '</pre>';die;