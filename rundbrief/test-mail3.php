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
require_once 'class.verteilerliste.php'; 
require_once 'class.absender.php'; 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); 
$creds = new Mailcreds(); 

$VerteilerID = 3; // 3: Testadressen Birgit 
$AbsenderID = 7; // birgitreiner@piano-podium.de

$Betreff='Hallo das ist ein Test-Betreff'; 
$Mailtext='Hallo das ist ein Test-Mailtext'; 

$verteilerliste = New Verteilerliste($VerteilerID );
$Mitglieder = $verteilerliste->getMitglieder(); 

$absender= new Absender($AbsenderID); 
echo 'Absender: '.$absender->Mailadresse.' '.$absender->Alias.'<br>'; // Test 

/************************************* */
$mail->SMTPDebug = 0; // SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                       
$mail->Host       = $creds->Host; 
$mail->SMTPAuth   = true;          
$mail->Username   = $creds->Username; 
$mail->Password   = $creds->Password;  
$mail->SMTPSecure = $creds->SMTPSecure; 
$mail->Port       = $creds->Port;  
// $mail->CharSet    ="UTF-8";
// $mail->SetLanguage('de');

$mail->setFrom($absender->Mailadresse, $absender->Alias);
$mail->AddAddress($absender->Mailadresse, $absender->Alias);

foreach($Mitglieder as $Mitglied) {
    echo $Mitglied["Vorname"].' '.$Mitglied["Nachname"].' '.$Mitglied["Mailadresse"].'<br>'; 
    $mail->AddBcc($Mitglied["Mailadresse"], $Mitglied["Vorname"].' '.$Mitglied["Nachname"]);
}

$mail->Subject = $Betreff;
$mail->Body    = $Mailtext;

try {
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} 

?>


</body>
</html>     