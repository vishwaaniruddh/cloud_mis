<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');

$userid = $_POST['user_id'];

$usersql = mysqli_query($con,"select id,atmid from mis_newsite where engineer_user_id ='".$userid."' AND activity='RMS'");
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
      // $_newdata = array();
      // $_newdata['id'] = $userdata['id'];
       $atmid = $userdata['atmid'];
       array_push($dataarray,$atmid);
   }
}

    $_atm_ids=json_encode($dataarray);
	$_atm_ids=str_replace( array('[',']','"') , ''  , $_atm_ids);
	$_atm_id_arr=explode(',',$_atm_ids);
	$_atm_ids = "'" . implode ( "', '", $_atm_id_arr )."'";
	
echo $_atm_ids;	

$arr_atm = "'P3ENCI38', 'P1ENCI30', 'P1ENCI48', 'P1ENCN35', 'P1ENCN68', 'P1ENCI08', 'P1ENCH37', 'P1ENCH57', 'P1ENCI37', 'P1ENCH38', 'P1ENCH63', 'P1ENCI02', 'P1EWCH17', 'P1ENCI42', 'P1ENCH18', 'P3ENCI01', 'P3ENCI34', 'P1ENCH42', 'P1ENCI26', 'P1ENCI20', 'P1ENCH16', 'P3ENCI04', 'P1ENCH72', 'P1ENTP07', 'P1ENCN56', 'P1EWCH07', 'P1ENCI18', 'P1EWCH20', 'P3ENCI22', 'P1ENCN20', 'P1ENCI36', 'P1ENCI34', 'P3ENTN17', 'P1ENCH30', 'P1ENCH74', 'P3ECCI10', 'P3ECCI09', 'P3ECCI02', 'P3ENCE32', 'P1EWCH39', 'P3ENCI92', 'MN000785', 'P1EWCH55', 'P3ENCI85', 'P1EWCH51', 'P3ENCE39', 'P3ENCE47', 'P3ENCE44', 'P3ENCE46', 'SECPR389', 'P3ENCE43', 'SECPR400', 'SECPS727', 'SPCPM999', 'P3ENCE64', 'SECPR557', 'SECPR553', 'MC000708', 'MN000743', 'SECPS744', 'P3ENCE67', 'SECPS722', 'P3ENCE71', 'SECPS743', 'SECPT137', 'MN000707', 'SPCPM976', 'SECPS741', 'S1B2001020084', 'S1B2001243127', 'SECPS742', 'S1N2001020085', 'S1B2001176001', 'SFCPT333', 'MN000731', 'MN000744', 'P3ENCE84', 'P3ENMD17', 'P3ENCE87', 'P3ENCE86', 'P3ENCE83', 'EN801193', 'P3ENMD22', 'S1B2000956009', 'S1B2003303015', 'ER801231', 'EN801262', 'P3ENMD39', 'P3ENMD48', 'ER801264', 'S1B2000956003', 'P3ENMD76', 'P3ENMD81', 'P3ENMD58', 'P3ENMD97', 'S1B2001243030', 'P3ENCX15', 'P3ENCX17', 'P3ENCX06', 'S1B2001020001', 'P3ENCX09', 'P3ENCX21', 'P3ENCX20', 'ER801331', 'P3ENCX19', 'ZCE8115', 'P3ENCX26', 'ZCE8119', 'S1B2001243026', 'S1B2003303013', 'P3ENCX85', 'P3ENCX74', 'P3ENCX85', 'A1092810', 'D1214620', 'N2980500', 'A1058110', 'N4395800', 'P3ENCX73', 'A1177610', 'EN801331', 'B1175120', 'A1102410', 'B1106310', 'B1111310', 'ZCE8130', 'N5607600', 'N4607600', 'E1526810', 'H07260', 'P3ENCR18', 'P3ENCR12', 'P3ENCR20', 'N2792700', 'N5438900', 'D3406200', 'N2657000', 'N4030600', 'A1194210', 'N2016500', 'A1217920', 'N4406200', 'N2394000', 'D2607800', 'D3620600'";
$_arr_explode = explode(',',$arr_atm);
echo count($_arr_explode);
