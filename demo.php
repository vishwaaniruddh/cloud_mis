<?php 

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Send the email with PHPMailer
$mail = new PHPMailer(true);

try {

        $mail->isSMTP();                                          
        $mail->Host       = 'smtp-mail.outlook.com';                   
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'rohitb@comforttechno.com';               
        $mail->Password   = 'Css@ctbt121';
        $mail->SMTPSecure = 'tls';        
        $mail->Port       = 587;               
       



    $mail->setFrom('bot@comforttechno.com', 'Bot');
    $mail->addAddress('maharshi07.mt@gmail.com'); // Recipient email
    $mail->addCC('vishwaaniruddh@gmail.com'); // Recipient email
    $mail->Subject = 'Process Payment MIS Service calls';
    $mail->Body = "Hi,\n\nPlease Process Payment MIS Service calls with this Excel attachment.\n\nThanks";

    // Attach the file
    // $mail->addAttachment($filepath);

    // Send the email
    $mail->send();
    echo 1 ; 
} catch (Exception $e) {
        echo 0 ; 
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>