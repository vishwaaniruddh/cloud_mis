<?php
include('config.php');

/*if(!isset($_POST['searchTerm'])){
	$fetchData = mysqli_query($con,"select beneficiary_name, account_number from mis_fund_accounts order by beneficiary_name limit 5");
}else{
	$search = $_POST['searchTerm'];
	$fetchData = mysqli_query($con,"select beneficiary_name, account_number from mis_fund_accounts where beneficiary_name like '%".$search."%' limit 5");
} */

if(isset($_POST['searchTerm'])){
    $search = $_POST['searchTerm'];
	$fetchData = mysqli_query($con,"select id,beneficiary_name, account_number,ifsc_code from mis_fund_accounts where beneficiary_name like '%".$search."%'");
}
	
$data = array();

while ($row = mysqli_fetch_array($fetchData)) {
    $textdata = $row['beneficiary_name']." - ".$row['account_number'];
    $data[] = array("id"=>$row['id'] ,"text"=>$textdata);
}

echo json_encode($data);

?>