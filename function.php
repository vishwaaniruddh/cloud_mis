<? 
include('config.php');

function get_bm($name,$parameter){
    global $con;
    $sql = mysqli_query($con,"select $parameter from bm where name like '%".$name."%'");
    if($sql_result = mysqli_fetch_assoc($sql)){
    return $sql_result[$parameter];        
    }else{
        return 0;
    }
    

}


function get_quotation_data($ticket , $parameter){
    global $con;
    
    echo "select $parameter from new_quotation where ticket_id='".$ticket."'" ; 
    
    $sql = mysqli_query($con,"select $parameter from new_quotation where ticket_id='".$ticket."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    
    return $sql_result[$parameter];
    
}


function get_accounts_emp($parameter,$id){
    global $con;
    $sql = mysqli_query($con,"select $parameter from accounts_emp where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter];
}
function get_member_name($id){
    global $con;
    
    
    $sql = mysqli_query($con,"select * from mis_loginusers where id ='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['name'];
}


function get_cust_by_bigname($bigname){
    global $con;
    
    $sql = mysqli_query($con,"select * from contacts where contact_first like '%".$bigname."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['short_name'];    
}


function get_custid_by_name($shortname){
    global $con;
    
    $sql = mysqli_query($con,"select * from contacts where short_name ='".$shortname."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['id'];    
}

function get_custid_by_bigname($bigname){
    global $con;
    
    $sql = mysqli_query($con,"select * from contacts where contact_first ='".$bigname."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['id'];    
}




function get_customerbyid($id){
    global $con;
    
    $sql = mysqli_query($con,"select * from contacts where id ='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['contact_first'];
}
function get_customer($shortname){
    global $con;
    
    $sql = mysqli_query($con,"select * from contacts where short_name ='".$shortname."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['contact_first'];
}

 function getExtension1($str)
 {
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
 }
 
 
 function get_calltracker($id,$parameter){
    global $con;
    $sql = mysqli_query($con,"select $parameter from calltracker where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);   
    return $sql_result[$parameter];
}


function get_beneficiary($id){
    global $con;
    
    $ben_sql = mysqli_query($con,"select hname,aid,accno from fundaccounts where aid='".$id."'");
    $ben_sql_result = mysqli_fetch_assoc($ben_sql);
    
    return $ben_sql_result['hname'] .' - '. $ben_sql_result['accno'];
}


function no_to_words($num)
{

$no = round($num);
  // $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  echo "<b>"."(Rupees : ".strtoupper($result). "ONLY ) "."<b>";
}   

function get_quotestatus($id){
    global $con;
    

    $sql = mysqli_query($con,"select * from approve_quote where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['approve_status'];
    
}


function get_atmdata($atm,$parameter){
    global $con;
    
    $sql = mysqli_query($con,"select $parameter from atm_master where atmid like '".$atm."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter];
}

function get_superior($id){
    global $con;
    $sql = mysqli_query($con,"select * from accounts_head where id ='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['name'];
}


function getnew_quotation($id,$parameter){
    global $con;
    

    $sql = mysqli_query($con,"select $parameter from new_quotation where ticket_id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter]; 
}



function beneficiary_data($id,$parameter){
    global $con;
    $sql = mysqli_query($con,"select * from fundaccounts where aid='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

function cust_date($date){
    if($date){
        return date('d M, Y', strtotime($date));        
    }else{
        return ;
    }
    
}

function check_selfclose($id){
    global $con;
    
    $sql = mysqli_query($con,"select * from calltracker_details where ticketid='".$id."'");
    if($sql_result = mysqli_fetch_assoc($sql)){
        return 1;
    }else{
        return 0;
    }
    

}



function material_name($id){
    global $con;
    
    $sql = mysqli_query($con,"select * from material where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['material'];
    
}

function mis_history($mis_id){
    global $con;    
    $i = 1 ;
    $mis_sql = mysqli_query($con,"select * from mis_history where mis_id='".$mis_id."' order by id asc");

while($mis_sql_result = mysqli_fetch_assoc($mis_sql)){
    echo $i .' )' . ' '  ;
    if($mis_sql_result['type']!=''){
        echo  $mis_sql_result['type'] .', ' ;

    }
    if($mis_sql_result['engineer']!=''){
        echo 'Engineer = ' . $mis_sql_result['engineer'] .', ';
    }
    if($mis_sql_result['remark']!=''){
        echo 'Remark = ' . $mis_sql_result['remark'] .', ';

    }
    if($mis_sql_result['material']!=''){
        echo 'Material = ' . material_name($mis_sql_result['material']) .', ';

    }
    if($mis_sql_result['courier_agency']!=''){
        echo 'Courier Agency = ' . $mis_sql_result['courier_agency'].', ' ;

    }
    if($mis_sql_result['pod']!=''){
        echo 'POD = ' . $mis_sql_result['pod'] .', ';
    }
    if($mis_sql_result['dispatch_date']!=''){
        echo 'Dispatch Date = ' . $mis_sql_result['dispatch_date'] .', ';

    }
    if($mis_sql_result['attachment']!=''){
        echo 'Image = ' . '<a href='. $mis_sql_result['attachment']. '> View Attachment </a>' .', ';

    }
    if($mis_sql_result['schedule_date']!='0000-00-00'){
        echo 'Schedule Date = ' . $mis_sql_result['schedule_date'] .', ';
    }
    if($mis_sql_result['close_type']!=''){
        echo 'Close Type = ' . $mis_sql_result['close_type'] .', ';

    }
   if($mis_sql_result['created_at']!=''){
        echo 'Created At = ' . $mis_sql_result['created_at'] .', ';

    }
   if($mis_sql_result['created_by']!=''){
        echo 'Created By = ' . get_member_name($mis_sql_result['created_by']) ;
        echo '<br><hr>';

    }
 
 $i++;   
}

}


function get_eng($data ,$id){
    global $con;   

    $sql = mysqli_query($con,"select $data from mis_eng where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$data];
}

function get_eng_name($data,$data1 ,$id){
    global $con;   

    $sql = mysqli_query($con,"select $data,$data1 from mis_loginusers where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$data];
}
