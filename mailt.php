<?
function select($Primary_Gmail_1,$Primary_nameOnTheCard,$member_id,$validity,$payment_mode,$level_id,$Static_LeadID,$AdditionalRenewalAssignBooklet,$AdditionalPromotionalAssignBooklet,$pdf,$MembershipDts_NetPayment,$MembershipDts_GrossTotal,$AssignBooklet){
     global $conn,$bcc;
     
    // $hostusername = 'contactus@theresortexperiences.com';
    // $host = 'mail.theresortexperiences.com';
    // $hostpassword = '94Z6g.;d1CSq';
    
    // $host = 'smtp.hostinger.com';
    // $hostpassword = 'mckyaUC,?z5H';
    // $port = '587';
    
    // $nodes = 'https://arpeeindustries.in/mail.php';
    //  $nodes = 'https://sarmicrosystems.in/SarMailor_APIS/mail.php';
    $nodes = 'sendmailapi.sarmicrosystems.in/elinairemailapi.php';
    
    
    $attachment = "https://loyaltician.in/elinaire/Leadpdf/memberpdf/$Primary_nameOnTheCard.pdf";

    $EmailSubject2="Welcome to Club Elinaire !";
    $message2 ='<table width="50%" align="center"><td><img style="width:60%;padding-left:20%" id="Picture 4" src="https://loyaltician.in/elinaire/newassets/elinaire_mail_head.jpeg"></td></table>
                <table width="50%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    
                    <td width="325" style="width:243.75pt;padding:11.25pt 0cm 0cm 0cm">
                        <p align="right" style="text-align:center">
                          <span style="text-decoration:none"><img border="0" width="130" style="width:3.3541in" src="https://loyaltician.in/elinaire/newassets/elinaire_logo.jpeg" alt="Club Elinaire Select">
                          </span>
                       <u></u><u></u></p>
                    </td>
                  </tr>
                </tbody>
                </table>
                <table width="50%" align="center">
                    <tbody>
                       <td>
                          <p class=MsoNormal><span lang=EN-IN style="font-size:12.0pt;line-height:107%">&nbsp;</span></p>
                          <p class=MsoNormal><span lang=EN-IN>Dear  '.$Primary_nameOnTheCard.'</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>A Warm Welcome to Club Elinaire.</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in">
                          <span lang=EN-IN style="color:black">We thank you for your decision to become a member at Courtyard by Marriott Vadodara, Sarabhai Campus.We have issued your membership with the following details:</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN><b><u>Membership Details</u></b></span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>Membership Level - Select</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>Your Membership Card number is '.$member_id.'. </span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>The membership is valid till '.date('M Y', strtotime($validity)).' </span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN> </span></p>
                          
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN><b><u>Membership Fee</u></b></span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          
                          
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in">
                          <span lang=EN-IN>The annual membership charge of Rs. '.$MembershipDts_NetPayment.'.  + 18% Goods &amp; Services Tax amounting to Rs. '.$MembershipDts_GrossTotal.'.  /- ( '.getIndianCurrency($MembershipDts_GrossTotal).')
                            has been received by '.$payment_mode.'.  A receipt is enclosed in
                            this email. This receipt does not require a signature. </span></p>

                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN><b><u>Membership Usage</u></b></span></p>

                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>You can present your membership number and a copy of this email to
                            start using your membership card benefits.</span></p>

                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN><b><u>Membership Package</u></b></span></p>

                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                          <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>Your personalised welcome package is now under process and will reach you within 15 working days of this email. Do note that the membership gift certificates can be used only upon receipt of the membership package and have to be presented in original. The certificates issued along with the membership are given at the bottom of this email. Should there be a need to use any of these certificates urgently before they arrive, do reach out to our Member Help Desk for help.</span></p>
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN> </span></p>

                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN><b><u>Membership Terms and Conditions</u></b></span></p>
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN>Payment of the membership fee confirms that you have read and understood the membership terms and conditions
                            and then made the payment to enrol.Do take a moment to view all benefits and terms at </span><span
                            lang=EN-IN><a href="https://www.clubelinaire.com">www.clubelinaire.com </a> or
                            reach out to our Member Help Desk from Monday to Saturday, 9.30 AM to 6.30 PM for any clarifications.</span><span
                            lang=EN-IN> </span></p>

                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>&nbsp;</span></p>
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span lang=EN-IN>We will look forward to welcoming you to our hotel and to a great Membership Year with us.</span></p>
                            
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN>&nbsp;</span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN style="font-size:12.0pt;line-height:107%"> </span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN style="font-size:12.0pt;line-height:107%">Yours sincerely,</span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN style="font-size:12.0pt;line-height:107%"> </span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN style="font-size:12.0pt;line-height:107%">Club Elinaire Team</span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN style="font-size:12.0pt;line-height:107%">+91 90098 23923</span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN><a href="https://www.clubelinaire.com"><span style="font-size:12.0pt;
                            line-height:107%">www.clubelinaire.com</span></a></span><span lang=EN-IN
                            style="font-size:12.0pt;line-height:107%"> </span></p>
                            
                            <p class=MsoNormal style="margin-bottom:0in;margin-bottom:0in;margin-top:0in"><span
                            lang=EN-IN><span style="font-size:12.0pt;
                            line-height:107%">https://www.clubelinaire.com</span></span><span lang=EN-IN
                            style="font-size:12.0pt;line-height:107%"> </span></p>
                            
                            <p class=MsoNormal><span lang=EN-IN style="font-size:12.0pt;line-height:107%">&nbsp;</span></p>
                            
                            <p class=MsoNormal align=center style="text-align:center"><span lang=EN-IN
                            style="font-size:12.0pt;line-height:107%">Gift Certificates issued</span></p>


                        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
                         style="border-collapse:collapse;border:none">

                         <tr style="height:14.5pt">

                          <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
                          padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">SN</span></b></p>
                          </td>

                          <td width=329 nowrap valign=top style="width:247.0pt;border:solid windowtext 1.0pt;
                          border-left:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">Certificate Description</span></b></p>
                          </td>

                          <td width=168 nowrap valign=top style="width:125.85pt;border:solid windowtext 1.0pt;
                          border-left:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">Certificate Number</span></b></p>
                          </td>
                          </tr>';

$srno=1;
$qry="select Leval_id,level_name from Level where Leval_id='".$level_id."' ";
$did=$level_id;
$sql2="SELECT serviceName,serialNumber FROM `voucher_Type` where level_id='".$did."' and serviceName not like '%RENEWAL%'";
$runsql2=mysqli_query($conn,$sql2);
while($sql2fetch=mysqli_fetch_array($runsql2)){
  	     $remaining1=substr($sql2fetch['serialNumber'],8);
  	     $remaining1=sprintf("%03s", $remaining1);
        if($isfirst==1){
            $value= $AssignBooklet+1;
        }else{
            $value= $AssignBooklet;
        }
        $AssignBooklet1=$value.$remaining1;

$message2 .= '<tr style="height:14.5pt">
  <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'.$srno.'</span></p>
  </td>

  <td width=329 valign=top style="width:247.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'. $sql2fetch['serviceName'].'</span></p>
  </td>


  <td width=168 nowrap valign=top style="width:125.85pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'. $AssignBooklet1.'</span></p>
  </td>

 </tr>';
     $srno++;
}
if($AdditionalRenewalAssignBooklet!=""){
    $message2 .= '<tr style="height:14.5pt">
  <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'.$srno.'</span></p>
  </td>

  <td width=329 valign=top style="width:247.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">Renewal Voucher Code</span></p>
  </td>


  <td width=168 nowrap valign=top style="width:125.85pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'. $AdditionalRenewalAssignBooklet.'</span></p>
  </td>

 </tr>';
     $srno++;
}
if($AdditionalPromotionalAssignBooklet!=""){
    $message2 .= '<tr style="height:14.5pt">
  <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'.$srno.'</span></p>
  </td>

  <td width=329 valign=top style="width:247.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">Promotional Voucher Code</span></p>
  </td>


  <td width=168 nowrap valign=top style="width:125.85pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
  <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
  lang=EN-IN style="font-size:10.5pt;
  border:none windowtext 1.0pt;padding:0in;background:white">'. $AdditionalPromotionalAssignBooklet.'</span></p>
  </td>

 </tr>';
     $srno++;
}

$message2 .='</table>

<p class=MsoNormal><em><span lang=EN-IN style="font-size:10.5pt;line-height:
107%;border:none windowtext 1.0pt;
padding:0in;background:white;font-style:normal">&nbsp;</span></em></p>

<p class=MsoNormal><em><span lang=EN-IN style="font-size:10.5pt;line-height:
107%;border:none windowtext 1.0pt;
padding:0in;background:white">The membership program is operated by Loyaltician CRM India Private Limited for Courtyard by Marriott
Vadodara (Operated by Maitraya Hospitality LLP under license from Marriott International, Inc. or one of its
affiliates) Membership Tax Invoice cum Receipt is issued by Loyaltician CRM India Private Ltd and enclosed. </span></em></p>

<p class=MsoNormal><em><span lang=EN-IN style="font-size:10.5pt;line-height:
107%;border:none windowtext 1.0pt;
padding:0in;background:white">This message is sent to you because your email
address is on our subscribers list as a Member with an express consent to
communicate with you. We will ensure only high quality / relevant information
is sent to you to manage your membership. If you wish to change any
communication preferences, please write to us at </span></em><span lang=EN-IN><a
href="mailto:contactus@clubelinaire.com"><span style="font-size:10.5pt;
line-height:107%;border:none windowtext 1.0pt;
padding:0in;background:white">https://www.clubelinaire.com</span></a></span><em><span
lang=EN-IN style="font-size:10.5pt;line-height:107%;
color:#444444;border:none windowtext 1.0pt;padding:0in;background:white"> </span></em></p>

<p class=MsoNormal style="line-height:normal;background:white;vertical-align:
baseline"><i><span lang=EN-IN style="font-size:10.5pt;
color:#444444;border:none windowtext 1.0pt;padding:0in">Disclaimer: This
message has been sent as a part of discussion between ‘Club Elinaire’ and
the addressee whose name is specified above. Should you receive this message by
mistake, we would be most grateful if you informed us that the message has been
sent to you. In this case, we also ask that you delete this message from your
mailbox, and do not forward it or any part of it to anyone else. Thank you for
your cooperation and understanding.</span></i></p>

<p class=MsoNormal><span lang=EN-IN style="font-size:12.0pt;line-height:107%">&nbsp;</span></p>
</td>
</tbody>
</table>';

$pdfsql = mysqli_query($conn,"select * from Members where Static_LeadID='".$Static_LeadID."'");
$pdfsql_result = mysqli_fetch_assoc($pdfsql);

$receiptNO = $pdfsql_result['receipt_no'];
$MembershipDetails_Level = $pdfsql_result['MembershipDetails_Level'];
$memGST = $pdfsql_result['GST_Number'];
if($memGST){

}else{
    // $memGST ='27AADCL8692D1Z8';
}


$pdfleads_sql = mysqli_query($conn,"select * from Leads_table where Lead_id='".$Static_LeadID."'");
$pdfleads_sql_result = mysqli_fetch_assoc($pdfleads_sql);


$Primary_nameOnTheCard = $pdfsql_result['Primary_nameOnTheCard'];
$receipt_no = $pdfsql_result['receipt_no'];
$entryDate = $pdfsql_result['entryDate'];
$entryDate =  date("d-m-Y", strtotime($entryDate));
$MembershipDetails_Level = $pdfsql_result['MembershipDetails_Level'];
if($MembershipDetails_Level==1){
    $level ='Select';
}elseif($MembershipDetails_Level==2){
    $level ='Plus';
}
elseif($MembershipDetails_Level==3){
    $level ='Premium';
}

$ExpiryDate = $pdfsql_result['ExpiryDate'];
$ExpiryDate =  date("d-m-Y", strtotime($ExpiryDate));
$MembershipDetails_Fee = $pdfsql_result['MembershipDetails_Fee'];
$MembershipDts_NetPayment = $pdfsql_result['MembershipDts_NetPayment'];
// $MembershipDts_GrossTotal = $sql_result['MembershipDts_GrossTotal'];
$MembershipDts_PaymentMode = $pdfsql_result['MembershipDts_PaymentMode'];

$CGST=$pdfsql_result['MembershipDts_GST']/2;
$MembershipDts_GrossTotal = $pdfsql_result['MembershipDts_GrossTotal'] ;

$MobileNumber = $pdfleads_sql_result['MobileNumber'];
$Company = $pdfleads_sql_result['Company'];
$EmailId = $pdfleads_sql_result['EmailId'];
$State = $pdfleads_sql_result['State'];
$City = $pdfleads_sql_result['City'];
$CGST=$pdfsql_result['MembershipDts_GST']/2;

$htmtab1='<table border="1" cellpadding="5">
                                        <tbody>
                                            <tr>
                                            <th colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <img src="https://sarmicrosystems.in/Lead_Management/Loyaltician/resortmumbai/Leadpdf/logoai.jpg" style="margin-left:200px;height:60px;">
                                            </th>
                                            </tr>

                                            <tr>
                                            <th colspan="6" style="font-size:25px;font-weight:700;text-align:center;"> LCRM - CY Marriott Vadodara </th>
                                            </tr>

                                            <tr>
                                            <th colspan="6" style="text-align:center;"> Aksa Beach, Madh-Marve Road, Malad(West),Mumbai:400 095. Tel:(91) 22 2844 7777/5055 5777 </th>
                                            </tr>

                                            <tr>
                                            <th colspan="6" style="text-align:center;"> E Mail: resv@theresortmumbai.com Website: www.theresortmumbai.com </th>
                                            </tr>

                                            <tr>
                                            <th colspan="6" style="text-align:center;"> GSTN ID- 27AAACP0522B2Z5      State- Maharashtra     Code -27 </th>
                                            </tr>

                                            <tr>
                                            <th colspan="6" style="font-size:25px;text-align:center;"> Receipt</th>
                                            </tr>



                                        <tr>
                                            <th colspan="4" style="padding:10pt; background-color: #b48a1c; color: black; "><b>Invoice to: (Customer Details)</b></th>
                                            <th colspan="2" style="background-color: #b48a1c; color: black; "><b>Invoice Details</b></th>
                                        </tr>


                                        <tr>
                                            <td colspan="4"><b>Company Name :</b> '.$Company.' </td>
                                            <td border="0" colspan="1"><b>Date :</b></td>
                                            <td border="0" colspan="1">'.$entryDate.'</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4"><b>Name :</b> '.$Primary_nameOnTheCard.' </td>
                                            <td colspan="1"><b>Invoice / Receipt: </b></td>
                                            <td colspan="1">'.$receipt_no.'</td>
                                        </tr>
                                        <tr>

                                            <td colspan="4"><b>Phone: </b>'.$MobileNumber.'</td>
                                            <td colspan="2"><b>Membership Details</b></td>
                                        </tr>


                                        <tr>
                                            <td class="" colspan="4"><b>Email :</b> '.$EmailId.' </td>
                                            <td colspan="1"><b>Level :</b></td>
                                            <td colspan="1">'.$level.'</td>
                                        </tr>


                                        <tr>
                                            <td class="" colspan="4"><b>GSTN: </b>'.$memGST.' </td>
                                           <td colspan="1"><b>Validity :</b></td>
                                            <td colspan="1">'.date('M Y',strtotime($ExpiryDate)).'</td>
                                        </tr>


                                        <tr>
                                            <td class="" colspan="3"><b>City: </b>'.$City.' </td>
                                           <td colspan="3"><b>State :</b>'.$State.'</td>
                                        </tr>




                                        <tr style="background-color: #b48a1c; color: black; ">
                                            <td class="" colspan="3"><b>Description</b></td>
                                           <td colspan="1"><b>Quantity :</b></td>
                                            <td colspan="1"><b>Unit Price</b></td>
                                            <td colspan="1"><b>Amount</b></td>
                                        </tr>



                                    <tr>
                                            <td class="" colspan="3" style="padding-top: 10px; padding-bottom: 60px; ">'.$level.' Membership: </td>
                                           <td colspan="1">1</td>
                                            <td colspan="1">'.$MembershipDetails_Fee.'</td>
                                            <td colspan="1">'.$MembershipDts_NetPayment.'</td>

                                        </tr>

                                        <tr>
                                            <td class="" colspan="3" style="background-color: #b48a1c; color: black; "><b>Payment Details:</b></td>
                                           <td colspan="2" style="background-color: #e9c877; color: black; "><b>Subtotal:</b></td>
                                            <td colspan="1" style="background-color: #e9c877; color: black; ">'.$MembershipDts_NetPayment.'</td>

                                        </tr>

                                        <tr>
                                            <td class="" colspan="3" style="background-color: #b48a1c; color: black; ">Received by : '.$MembershipDts_PaymentMode.'</td>';

                                             if($State=="MAHARASHTRA" || $State=="Maharashtra"){

                                                    $htmtab1 .='<td colspan="2" style="background-color: #e9c877; color: black; "><b>CGST @ 9% </b></td>
                                                    <td colspan="1" style="background-color: #e9c877; color: black; ">'.$CGST.'</td>';

                                            }else{
                                                $htmtab1 .='<td colspan="2"rowspan="2" style="background-color: #e9c877; color: black; "><b>IGST @ 18% </b></td>
                                                    <td colspan="1" rowspan="2" style="background-color: #e9c877; color: black; ">'.($CGST*2).'</td>';
                                            }


                                        $htmtab1 .='</tr>

                                        <tr>
                                            <td class="" colspan="3" style="background-color: #b48a1c; color: black; ">Instrument Number/ Approval Code</td>';

                                            if($State=="MAHARASHTRA" || $State=="Maharashtra"){
                                            $htmtab1 .='<td colspan="2" style="background-color: #e9c877; color: black; "><b>GGST @ 9% </b></td>
                                            <td colspan="1" style="background-color: #e9c877; color: black; ">'.$CGST.'</td>';
                                                                                         }else{


                                                                                         }


                                        $htmtab1 .='</tr>

                                        <tr>
                                            <td class="" colspan="3" style="background-color: #b48a1c; color: black; "><b>Cheque Favouring -  LCRM - CY Marriott Vadodara</b></td>
                                           <td colspan="2" style="background-color: #b48a1c; color: black; "><b>Total including Taxes </b></td>
                                            <td colspan="1" style="background-color: #b48a1c; color: black; "><b>'.$MembershipDts_GrossTotal.'</b></td>
                                        </tr>

                                       <tr>
                                        <td class="" colspan="3" style="padding-top: 10px; padding-bottom: 60px; ">Terms and Conditions<br>
1. To avail input credit (if available), GSTN number and State is mandatory.<br>
2. This is not the final tax invoice regarding the purchase and is a receipt.<br>
3. No refunds are entertained beyond 15 days of purchase<br>
</td>
                                        <td class="" colspan="3" style="padding-top: 10px; padding-bottom: 60px; ">
                                        <br><br><br><br><br><br>
                                        <b>Signed</b><br>
                                        LCRM - CY Marriott Vadodara <br>
                                        (Computer Generated Receipt)
                                        </td>


                                    </tr>
                                </tbody>
                            </table>';


$pdf->writeHTML($htmtab1 . $htmtab1_body . $tbl_footer, true, false, false, false, '');
$pdf->Output('Leadpdf/memberpdf/'.$Primary_nameOnTheCard.'.pdf','F');

$leadsmail2= "contactus@theresortexperiences.com";
$mailheader2 = "From: ".$leadsmail2."\r\n";
$mailheader2.= "Reply-To: ".$leadsmail2."\r\n";

// require 'phpmail/src/PHPMailer.php';
// require 'phpmail/src/SMTP.php';
// require 'phpmail/src/Exception.php';


// $pagesource = "welcome_template";
// $memid = $Static_LeadID;
// $msg = "";

$subject = $EmailSubject2;
$message = $message2;
$leadsmail = $leadsmail2;

 $from = 'contactus@theresortexperiences.com';
    $fromname = 'Club Elinaire' ; 
    
    
    
    // $to =['contactus@theresortexperiences.com'];
    $to = $Primary_Gmail_1;
    $cc = [];
    
$data = array(
        'subject' => $subject,
        'message' => $message,
        'leadsmail' => $leadsmail,
        'host' => $host,
        'hostusername' => $hostusername,
        'hostpassword' => $hostpassword,
        'port'=> $port ,
        'from'=>$from,
        'fromname'=>$fromname,
        'to'=>$to,
        'cc'=>$cc,
        'bcc'=>$bcc,
        'pdfstructure'=>$htmtab1,
        'attachment'=>$attachment,
        'primary_name'=>$Primary_nameOnTheCard,
        );
    
    // $options = array(
    //     'http' => array(
    //         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //         'method'  => 'POST',
    //         'content' => http_build_query($data)
    //     )
    // );
    
    // $context  = stream_context_create($options);
    // $result =  file_get_contents($nodes, false, $context);
    
$ch = curl_init($nodes);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
var_dump($response);


}
