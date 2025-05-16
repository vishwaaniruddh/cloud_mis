<?php

require_once("config.php");
 
 $params = $columns = $totalRecords = $data = array();
 
 $params = $_REQUEST;
 echo $params;
 
 $columns = array(
 0 => 'id',
 1 => 'images', 
 2 => 'activity',
 3 => 'atmid',
 4 => 'router_status',
 5 => 'router_id',
 6 => 'dvr_status',
 7 => 'cam1',
 8 => 'cam2',
 9 => 'ip_cam',
 10 => 'hdd_status',
 11 => 'recording_from',
 12 => 'recording_to',
 13 => 'site_tested_by',
 14 => 'created_by',
 15 => 'remark',
 
 );
 
 var_dump($params['search']['value']);
 $where_condition = $sqlTot = $sqlRec = "";
 
 if( !empty($params['search']['value']) ) {
 $where_condition .= " WHERE ";
 $where_condition .= " ( ";  
 $where_condition .= " activity LIKE '%".$params['search']['value']."%' ";  
 
 $where_condition .= " AND atmid LIKE '%".$params['search']['value']."%' ";
  
 
 $where_condition .= " AND recording_from LIKE '%".$params['search']['value']."%' ";
 $where_condition .= " AND recording_to LIKE '%".$params['search']['value']."%' ";
 $where_condition .= "  )";
 }
 
 $sql_query = " SELECT * FROM li_ajax_post_load "; 
 $sqlTot .= $sql_query;
 $sqlRec .= $sql_query;
 
 if(isset($where_condition) && $where_condition != '') {
 
 $sqlTot .= $where_condition;
 $sqlRec .= $where_condition;
 }
 
 $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";
 
 $queryTot = mysqli_query($con, $sqlTot) or die("Database Error:". mysqli_error($con));
 
 $totalRecords = mysqli_num_rows($queryTot);
 
 $queryRecords = mysqli_query($con, $sqlRec) or die("Error to Get the Post details.");
 
 while( $row = mysqli_fetch_row($queryRecords) ) { 
 $data[] = $row;
 } 
 
 $json_data = array(
 "draw"            => intval( $params['draw'] ),   
 "recordsTotal"    => intval( $totalRecords ),  
 "recordsFiltered" => intval($totalRecords),
 "data"            => $data
 );
 
 echo json_encode($json_data);



?>