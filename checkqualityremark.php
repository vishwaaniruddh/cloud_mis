<?php 

include('config.php');
$id = $_POST['cid'];


$remark1 = $_POST['remark1'];
if($remark1 == "-" || $remark1 == "null"){ $remark1 = "";}else {$remark1 = $remark1 ;}
$remark2 = $_POST['remark2'];
if($remark2 == "-" || $remark2 == "null"){ $remark2 = "";}else { $remark2 = $remark2 ;}
$remark3 = $_POST['remark3'];
if($remark3 == "-" || $remark3 == "null"){ $remark3 = "";}else { $remark3 = $remark3 ;}
$remark4 = $_POST['remark4'];
if($remark4 == "-" || $remark4 == "null"){ $remark4 = "";}else { $remark4 = $remark4 ;}
$remark5 = $_POST['remark5'];
if($remark5 == "-" || $remark5 == "null"){ $remark5 = "";}else { $remark5 = $remark5 ;}
$remark6 = $_POST['remark6'];
if($remark6 == "-" || $remark6 == "null"){ $remark6 = "";}else { $remark6 = $remark6 ;}
$remark7 = $_POST['remark7'];
if($remark7 == "-" || $remark7 == "null"){ $remark7 = "";}else { $remark7 = $remark7 ;}


$data = array();

$newdata = array();
$newdata['question_list'] = $remark1;
$newdata['question_list_2'] = $remark2;
$newdata['question_list_3'] = $remark3;
$newdata['question_list_4'] = $remark4;
$newdata['question_list_5'] = $remark5;
$newdata['question_list_6'] = $remark6;
$newdata['question_list_7'] = $remark7;


$testarray = array();

foreach($newdata as $key=>$value)
{
    $_newdata = array();
    $_newdata['key'] = $key;
    $_newdata['value'] = $value;
    array_push($testarray,$_newdata);
}

// echo "<pre>";
// print_r($testarray);
// echo "</pre>";


$data = json_encode($testarray);


$checkremarksql = mysqli_query($con,"update newcheckquality set dissapp_remark='".$data."',status=3 where id='".$id."' ");
if($checkremarksql){ ?>
    <script>
        alert("Updated Successfully");
        window.location.href="view_newcheckquality_test.php";
    </script>
<? } else { ?>
    <script>
        alert("Error");
        window.location.reload();
    </script>
<? }

?>