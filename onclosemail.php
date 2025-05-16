<?php

require 'mail/PHPMailer/src/PHPMailer.php';
require 'mail/PHPMailer/src/SMTP.php';
require 'mail/PHPMailer/src/Exception.php';


class EmailSender {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.hostinger.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'mail@orchiddining.com';
        $this->mailer->Password = 'ul4yHO1*653Q';
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = 587;
        $this->mailer->isHTML(true);
    }
    
    public function sendEmail($recipient, $subject,$body,$cc) {
        try {
            $this->mailer->setFrom('mail@orchiddining.com', 'Comfort Techno Services');
            $this->mailer->addAddress($recipient);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            // $this->mailer->addAttachment('viewmis.xlsx');
            
            foreach ($cc as $ccRecipient) {
                $this->mailer->addCC($ccRecipient);
            }
            $this->mailer->send();
            


            echo 'Message has been sent';
            echo 1;
        } catch (Exception $e) {
            echo 'Message could not be sent. Error: ', $this->mailer->ErrorInfo;
            echo 0;
        }
    }
}


include('config.php');

$id = $_POST['id'];
if(isset($id)){
    echo "<script>alert('yes');</script>";
?>


        <h5>CALL INFORMATION</h5>
        <hr>                                        
        <?
        // $id = $_POST['id'];
        $sql = mysqli_query($con,"select * from mis_details_1_test  where id= '".$id."'");
        $sql_result = mysqli_fetch_assoc($sql);
        
        $mis_id = $sql_result['mis_id']; 
        
        $mis_status = $sql_result['status'];
        $status_view = 0;
         if($mis_status=='material_in_process'){
             $status_view = 1;
         }
        
        $sql1 = mysqli_query($con,"select * from mis_1_test where id = '".$mis_id."'");
        $sql1_result = mysqli_fetch_assoc($sql1);
        
        $date = date('Y-m-d H:i:s');
        $date1 = date('Y-m-d');
        $date1=date_create($date1);
        $date2=date_create($sql_result['created_at']);
        $diff=date_diff($date1,$date2);
        
        
        $message.='<table width="70%" align="center">';
        $message.='<tr>';
        $message.='</tr><tr></br>';
        $message.='<th style="text-align: left;"><b>View MIS DETAILS close</b></th></tr><tr></br>';
        $message.='<td>Call Information<br><br>
        <b> Ticket ID : </b>'.$sql_result['ticket_id'].'<br>
        <b> Assigned Engineer : </b>'.$sql_result['ticket_id'].' <br>
        <b> Current Status : </b>'.$personemail.' <br>
        <b> Component : </b>'.$sql_result['component'].' <br><br>
        <b> Created On : </b>'.$sql1_result['created_at'].' <br><br>
        <b> Created By : </b>'.get_member_name($sql1_result['created_by']).' <br><br>
        <b> Down Time : </b>'.$diff->format("%a days").' <br><br>
        <b> Remark : </b>'.$sql1_result['remarks'].' <br><br>
         </td>';
       
        $message.='</tr></table>';
    

        ?>
       
                                

<?
}
$cc = array('work.rajeshb@gmail.com','hellbinderkumar@gmail.com');

$emailSender = new EmailSender();
$emailSender->sendEmail('rajeshrungta719@gmail.com', 'ViewMIS Report',$message,$cc);





mysqli_query($con,"truncate table mis_logintrack");
?>