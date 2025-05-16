<?php session_start();
//echo $_SESSION['user'];
if(!isset($_SESSION['user']))
{
echo "<script type='text/javascript'>alert('Sorry, your session has Expired'); window.location='index.php';</script>";
}
else
{
$desig='6'; //$_POST['desig'];
$service='1'; //$_POST['service'];
$dept='5'; //$_POST['dept'];
$accname=$_POST['accname'];
$reqs=$_POST['reqs'];
$chqname=$_POST['chqname'];
$chqno=$_POST['chqno'];
//echo count($reqs);
include('config.php');
$nwords = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen", "Twenty", 30 => "Thirty", 40 => "Forty", 50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eighty", 90 => "Ninety" ); 
function int_to_words($x)
       {
           global $nwords;
           if(!is_numeric($x))
           {
               $w = '#';
           }else if(fmod($x, 1) != 0)
           {
               $w = '#'; 
           }else{
               if($x < 0)
               {
                   $w = 'minus ';
                   $x = -$x;
               }else{
                   $w = '';
               } 
               if($x < 21)
               {
                   $w .= $nwords[$x];
               }else if($x < 100)
               {
                   $w .= $nwords[10 * floor($x/10)];
                   $r = fmod($x, 10); 
                   if($r > 0)
                   {
                       $w .= ' '. $nwords[$r];
                   }
               } else if($x < 1000)
               {
                   $w .= $nwords[floor($x/100)] .' Hundred'; 
                   $r = fmod($x, 100);
                   if($r > 0)
                   {
                       $w .= ' and '. int_to_words($r);
                   }
               } else if($x < 100000) 
               {
                   $w .= int_to_words(floor($x/1000)) .' Thousand';
                   $r = fmod($x, 1000);
                   if($r > 0)
                   {
                       $w .= ' '; 
                       if($r < 100)
                       {
                           $w .= 'and ';
                       }
                       $w .= int_to_words($r);
                   } 
               } else if($x < 10000000){
                   $w .= int_to_words(floor($x/100000)) .' Lakh';
                   $r = fmod($x, 100000);
                   if($r > 0)
                   {
                       $w .= ' '; 
                       if($r < 100)
                       {
                           $word .= 'and ';
                       }
                       $w .= int_to_words($r);
                   } 
               }else {
                   $w .= int_to_words(floor($x/10000000)) .' Crore';
                   $r = fmod($x, 10000000);
                   if($r > 0)
                   {
                       $w .= ' '; 
                       if($r < 100)
                       {
                           $word .= 'and ';
                       }
                       $w .= int_to_words($r);
                   } 
               }
           }
           return $w;
       }
?>
<html>
<head>
<script type="text/javascript">     
        function PrintDiv(id) {   
       <!-- document.getElementById('hide').style.display='none';--> 
           var divToPrint = document.getElementById(id);
           
           var popupWin = window.open('', '_blank', 'width=800,height=400');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>
</head>
<body>
<center>
<div id="ppdf" ><br><br><br><br><br><br><br><br><br>
<table width="995" border="0" cellpadding="2" cellspacing="0"  id="custtable" style="margin-top:5px;"> 
<tr><td width="600" >TO	</td><td>			<B>DATE :- <?php echo date('d-m-Y'); ?></B>	</td></tr>
<tr><td width="600" ><?php echo $chqname; ?></td><td>			</td></tr>
<tr><td width="600" >SION BRANCH </td><td>			</td></tr>					
<tr><td width="600" >MUMBAI</td><td>			</td></tr>								
<tr><td width="600" ></td><td>			</td></tr>								
<tr><td width="600" ></td><td>			</td></tr>												
					
<tr><td width="600" >Respected Sir / Madam,</td><td>			</td></tr>	
<tr><td width="600" ></td><td>			</td></tr>																				
<tr><td width="600" >Please debit  on my a/c No. <?php echo $_POST['dbtacc']; ?> & my account recognised as</td><td>			</td></tr>													
<tr><td width="600" >Clear Secured Services Pvt. Ltd. Kindly credit to following accounts.	</td><td>			</td></tr>																					
</table>
<table width="995" border="1" cellpadding="2" cellspacing="0"  id="custtable" style="margin-top:5px;"> 
<th width="10">Sr NO</th>
<th width="200px">Account Name</th>	
<th width="180px" align="center">Account No.</th>	
<th width="60">Amount</th>
<th width="200">Location</th>
<th width="200">Remarks</th>
<?php	
        $total=0;
$qry1=mysql_query("select max(tid) from ebfundtransfers");        
$qrrow=mysql_fetch_row($qry1);
     if($qrrow!=null){ $tid=$qrrow[0]+1; //echo $tid;
      }
     else $tid=1;
	for($x=0;$x<count($reqs);$x++){
		//echo $reqs[$x];
		if($accname[$x]!='-1'){
			$pdt=date("Y-m-d",strtotime(str_replace("/","-",$_POST['pdate'])));
			$dt=date('Y-m-d H:i:s');
			$userid=$_SESSION['user'];
			$sql="insert into ebfundtransfers(tid,reqid,accid,pdate,chqname,chqno,dbtaccno,narration,entrydt) values('$tid','$reqs[$x]','$accname[$x]','$pdt','$chqname','$chqno','".$_POST['dbtacc']."','".$_POST['narr'][$x]."','$dt')";		
			$table=mysql_query($sql); 
			/*if(!$table)
				echo mysql_error();*/
			$sql="insert into ebillfundapp(reqid,appby,apptime,level) values('$reqs[$x]','$userid','$dt','8')";		
			$table=mysql_query($sql); 
			$qry=mysql_query("select iFund_status from ebillfundrequests where req_no='$reqs[$x]'");
			$row=mysql_fetch_array($qry);
			if($row[0]==7)
			{
				$sql="update ebillfundrequests set chqno='$chqno',iFund_status='8' where req_no='$reqs[$x]'";
				mysql_query("Update oldebreq set status='8' where reqid='$reqs[$x]'");
			}
			else
				$sql="update ebillfundrequests set reqstatus='8',chqno='$chqno' where req_no='$reqs[$x]'";		
			$table=mysql_query($sql);
		}  
    }  
                
$qry1=mysql_query("select distinct(accid) from ebfundtransfers where tid='$tid' and accid<>90");
$ct=1;
while($qrrow=mysql_fetch_array($qry1))
{
$branch=mysql_query("select * from fundaccounts where aid='$qrrow[0]'");
$brro=mysql_fetch_row($branch);
//$deptde=mysql_query("select `desc` from department where deptid='2'");
//$dtro=mysql_fetch_row($deptde);
//$crow=mysql_fetch_row($qry1);	
//echo "select sum(approvedamt) from ebillfundrequests where req_no in(select reqid from ebfundtransfers where tid='$tid' and accid='$qrrow[0]')";
$qry2=mysql_query("select sum(approvedamt) from ebillfundrequests where req_no in(select reqid from ebfundtransfers where tid='$tid' and accid='$qrrow[0]')");
$qrrow2=mysql_fetch_array($qry2);
?><div class=article>
<div class=title><tr>
<td width="10" align='center'><?php echo $ct++; ?></td>
<td width="200" align='left'><?php echo $brro[5];  ?></td>
<td width="180px"  align="center"><?php echo $brro[2]; ?></td>
<td width="60" align='right' style='padding-right:15px'><?php echo number_format($qrrow2[0],2); $total=$total+$qrrow2[0]; ?></td>
<td width="200" align='left'><?php echo $brro[4]; ?></td>
<td align='left' width="200">EBill Payment</td>
</tr></div></div>
<?php
 }
 //echo "select accid,reqid,narration from ebfundtransfers where tid='$tid' and accid=90";
 //for cheque DD
 $qry2=mysql_query("select accid,reqid,narration from ebfundtransfers where tid='$tid' and accid=90");
//$ct=1;
while($qrrow2=mysql_fetch_array($qry2))
{
$branch2=mysql_query("select * from fundaccounts where aid='$qrrow2[0]'");
$brro2=mysql_fetch_row($branch2);
//$deptde=mysql_query("select `desc` from department where deptid='2'");
//$dtro=mysql_fetch_row($deptde);
//$crow=mysql_fetch_row($qry1);	
//echo "select approvedamt from ebillfundrequests where req_no ='".$qrrow2[1]."'";
$qry3=mysql_query("select approvedamt from ebillfundrequests where req_no ='".$qrrow2[1]."'");
$qrrow3=mysql_fetch_array($qry3);
?><div class=article>
<div class=title><tr>
<td width="10" align='center'><?php echo $ct++; ?></td>
<td width="200" align='left'><?php echo $brro2[5]."-".$qrrow2[2]; ?></td>
<td width="180px"  align="center"><?php echo $brro2[2]; ?></td>
<td width="60" align='right' style='padding-right:15px'><?php echo number_format($qrrow3[0],2); $total=$total+$qrrow3[0]; ?></td>
<td width="200" align='left'><?php echo $brro2[4]; ?></td>
<td align='left' width="200">EBill Payment</td>
</tr></div></div>
<?php
 }
?>
<tr><td colspan=3 align='right' ><B>TOTAL AMOUNT</B></td><td align='right'  style='padding-right:15px'><B><?php echo number_format($total,2); ?></B></td><td></td><td></td></tr>
</table>
<table width="995" border="0" cellpadding="2" cellspacing="0"  id="custtable" style="margin-top:5px;"> 
<tr><td width="600" ><B><?php echo '(Rupees : '.int_to_words($total).' Only.)'; ?></B>	</td><td>				</td></tr>
<tr><td width="600" ></td><td>			</td></tr>
<tr><td width="600" ><B>Thanking You,</B></td><td>			</td></tr>					
<tr><td width="600" ><B>Yours Faithfully</B></td><td>			</td></tr>								
<tr><td width="600" >For Clear Secured Services Pvt. Ltd.</td><td>			</td></tr>								
<tr><td width="600" >&nbsp;</td><td>			</td></tr>																	
<tr><td width="600" >&nbsp;</td><td>			</td></tr>	
<tr><td width="600" ><B>Authorised Signatory</B></td><td>			</td></tr>													
<tr><td width="600" ></td><td>			</td></tr>																					
</table>										
</div><input type="button" name="GENERATE" id="GENERATE" value="PRINT PDF" onClick="PrintDiv('ppdf');" /><br><br>
      <a href="ebillreqapprovals.php" >HOME</a>      
</center></body>
</head>
</html>
<?php
}
?>