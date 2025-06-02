<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<head>
   <title>Test Mail </title>
   </head>

<body>
<?php 

/** https://github.com/PHPMailer/PHPMailer?tab=readme-ov-file#minimal-installation * */

require_once '../phpmailer2/src/PHPMailer.php'; 
require_once '../phpmailer2/src/SMTP.php'; 
require_once '../phpmailer2/src/Exception.php'; 

require_once 'conn/class.mailcreds.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); 
$creds = new Mailcreds(); 

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                       
    $mail->Host       = $creds->Host; 
    $mail->SMTPAuth   = true;          
    $mail->Username   = $creds->Username; 
    $mail->Password   = $creds->Password;  
    $mail->SMTPSecure = $creds->SMTPSecure; 
    $mail->Port       = $creds->Port;  
    $mail->SMTPAutoTLS = false; 

    $mail->setFrom('birgitreiner@piano-podium.de', 'Birgit Reiner');
    $mail->addAddress('birgitreiner@web.de', 'Birgit Reiner');    
    $mail->Subject = 'Testmail Subject';
    $mail->Body    = 'Testmail Body ';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} 
  


?>


</body>
</html>     