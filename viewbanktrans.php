<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    $tid=$_GET['transid'];
    include('config.php');

       $tra=mysqli_query($con,"select * from mis_fund_transfer where trans_id='".$tid."' and status!=0");
       $traro=mysqli_fetch_array($tra);




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
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">

<center>
<div id="ppdf" ><br><br><br><br><br><br><br><br><br>
<table width="995" border="0" cellpadding="2" cellspacing="0"  id="custtable" style="margin-top:5px;"> 
<tr><td width="600" >TO	</td><td>			<B>DATE :- <?php if($traro[5]!="0000-00-00"){ echo date('d-m-Y',strtotime($traro[5])); }?></B>	</td></tr>
<tr><td width="600" >ICICI BANK LTD.</td><td>			</td></tr>
<tr><td width="600" >SION BRANCH </td><td>			</td></tr>					
<tr><td width="600" >MUMBAI</td><td>			</td></tr>								
<tr><td width="600" ></td><td>			</td></tr>								
<tr><td width="600" ></td><td>			</td></tr>												
					
<tr><td width="600" >Respected Sir / Madam,</td><td>			</td></tr>	
<tr><td width="600" ></td><td>			</td></tr>																				
<tr><td width="600" >Please debit  on my a/c No. <?php echo $traro[9]; ?> & my account recognised as</td><td>			</td></tr>													
<tr><td width="600" >Clear Secured Services Pvt. Ltd. Kindly credit to following accounts.	</td><td>			</td></tr>																					
</table>
<table width="995" border="1" cellpadding="2" cellspacing="0"  id="custtable" style="margin-top:5px;"> 
<th width="10">Sr NO</th>
<th width="200px">Account Name</th>	
<th width="180px" align="center">Account No.</th>	
<th width="60">Amount</th>

<?php	
        $total=0;
 
 $qry3=mysqli_query($con,"select * from mis_fund_transfer where trans_id='".$tid."' and status=0");
$ct = 0;
while($qrrow3=mysqli_fetch_array($qry3))
{

?><div class=article>
<div class=title><tr>
<td width="10" align='center'><?php echo $ct++; ?></td>
<td width="200" align='left'><?php echo $qrrow3[8]; ?></td>
<td width="180px"  align="center"><?php echo $qrrow3[9]; ?></td>
<td width="60" align='right' style='padding-right:15px'><?php echo number_format($qrrow3[10],2); $total=$total+$qrrow3[10]; ?></td>

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
<br>
<br>
<br>
<br><br>									
</div><input type="button" name="GENERATE" id="GENERATE" value="PRINT PDF" onclick="PrintDiv('ppdf');" /><br><br>
      <a href="ebillreqapprovals.php" >HOME</a>      
</center></div></div></div></div></div></div></div>

<?php
 } ?>
 <? include('footer.php'); ?>
 