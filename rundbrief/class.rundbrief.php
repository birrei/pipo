<?php 

require_once '../phpmailer2/src/PHPMailer.php'; 
require_once '../phpmailer2/src/SMTP.php'; 
require_once '../phpmailer2/src/Exception.php'; 

require_once 'conn/class.mailcreds.php'; 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;


/** https://github.com/PHPMailer/PHPMailer?tab=readme-ov-file#minimal-installation * */


class Rundbrief {

    // public $Betreff_Standard='';
    // public $Mailtext_Standard='';

    public $Betreff='';
    public $Mailtext='';
    public $AbsenderMailadresse=''; 
    public $AbsenderAlias=''; 
    public $Empfaengerliste=[]; 
    public $UploadItems=[]; 
    public $Anhaenge=[];
    public $AnzahlAnhaenge;      

    public $mitAnhang=true;  

    public function __construct(){
        // $this->Betreff_Standard = $this->get_default_subject(); 
        // $this->Mailtext_Standard = $this->get_default_message(); 
    }

    public function Versenden() {
        $mail = new PHPMailer(true); 
        $creds = new Mailcreds(); 

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

        $mail->setFrom($this->AbsenderMailadresse, $this->AbsenderAlias);
        $mail->AddAddress($this->AbsenderMailadresse, $this->AbsenderAlias);

        foreach($this->Empfaengerliste as $Empfaenger) {
            $mail->AddBcc($Empfaenger["Mailadresse"], $Empfaenger["Vorname"].' '.$Empfaenger["Nachname"]);
        }

        $mail->Subject = $this->Betreff;
        $mail->Body    = $this->Mailtext;


        if($this->mitAnhang) {
            $this->Anhaenge = $this->getAnhaenge(); 
            if (count($this->Anhaenge)==0 ) {
                $this->printError('Anhang fehlt!'); 
                return; 
            } else {
                foreach ($this->Anhaenge as $index=>$datei) {
                    $mail->AddAttachment($datei["tmp_name"], $datei["name"]);
                    echo $datei["name"].' '.$datei["tmp_name"].'<br>';  // test 
                }
            }
        }

        try {
            // $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } 
    }

    public function getAnhaenge(): array {
        $Uploads = $this->UploadItems;
        $anzahlUplads = count($Uploads['name']);
        $tmpAnhaenge = []; 

        for ($i = 0; $i < $anzahlUplads; $i++) {
            $dateiname = $Uploads['name'][$i];
            if ($dateiname!='') {
                $tmp_name = $Uploads['tmp_name'][$i];
                $tmpAnhaenge[]=array('tmp_name'=>$tmp_name, 'name'=>$dateiname); 
                // $fehlercode = $_FILES['datei']['error'][$i];
                // $dateigrosse = $_FILES['datei']['size'][$i];
                // $dateityp = $Uploads['type'][$i];
            }
        }
     
        // echo 'Anzahl Anhaenge: '.count( $tmpAnhaenge).'<br>'; 
        // print_r($tmpAnhaenge); 

        // foreach ($tmpAnhaenge as $index=>$dateien) {
        //     // echo  $Anhaenge[$index];
        //     echo $dateien["name"];
        //     echo $dateien["tmp_name"];  
        // }

        return $tmpAnhaenge; 
    }

    public function get_default_subject() {
        return "Piano-Podium Rundbrief " . date("m/Y");
    }

    public function get_default_message() {
        $msg="Liebe Mitglieder des Piano-Podiums,\n\n" .
            "im Anhang finden Sie den neuen Rundbrief für den Monat " . date("m/Y") . ".\n\n" .
            "Viel Spaß bei der Lektüre des Rundbriefs wünscht\n" .
            "Das Piano-Podium Webteam\n" .
            "www.piano-podium.de\n\n" .
            "------------------------------------------------------------------------------------------------------------------------\n" .
            "Hinweise: \n\n" . 
            "* Sie erhalten diesen Rundbrief, weil Sie sich mit der Mitgliedschaft bei Piano-Podium Karlsruhe e.V. für den Erhalt des Rundbriefs in elektronischer Form entschieden haben. Falls Sie diesen Rundbrief nicht länger erhalten möchten, genügt ein Hinweis an rundbrief@piano-podium.de, dann nehmen wir Sie aus dem Verteiler.\n\n" . 
            "* PDF-Dateien können in den meisten modernen Browsern direkt geöffnet und angezeigt werden. Sollte dies nicht möglich sein, muss ein Leseprogramm wie z.B. der Adobe Reader installiert sein. Sie können diesen, bei Bedarf, unter der folgenden Adresse herunterladen: http://www.adobe.com/de/products/acrobat/readstep2.html  \n\n" . 
            "* Frühere Ausgaben des Piano-Podium Rundbriefs können online abgerufen werden unter: https://drive.google.com/drive/folders/0Bwrxc0rQO46yeEVjVWZGQXBFTlE?resourcekey=0-gZG-mjyWWijOiG7SAUd0Ow&usp=sharing \n" .
            "";
        return $msg; 
    }

    public function printTest() {
  
        echo '<p>Absender Mailadresse: '.$this->AbsenderMailadresse.'<br>';    
        echo 'Absender Alias: '.$this->AbsenderAlias.'</p>';  

        echo '<p>Liste Empfänger: <br>'; 
        $Empfaengerliste = $this->Empfaengerliste; 
        foreach($Empfaengerliste as $Empfaenger) {
            echo '* '.$Empfaenger["Vorname"].' '.$Empfaenger["Nachname"].' '.$Empfaenger["Mailadresse"].'<br>';
        }        
        echo '</p>'; 
        
        echo '<p>Anhänge: <br>'; 
   
        $this->Anhaenge = $this->getAnhaenge(); 
        
        if ($this->mitAnhang & count($this->Anhaenge)==0) {
            $this->printError('Fehler, kein Anhang!'); 
        }  
        foreach ($this->Anhaenge as $index=>$datei) {                            
            echo 'name: '.$datei["name"].', tmp_name: '.$datei["tmp_name"].'<br>';  // test 
        }
        
        echo '</p>'; 

        echo '<p>Betreff: '.$this->Betreff.'</p>';    
        echo '<p>Mailtext: <pre>'.$this->Mailtext.'</pre></p>';          

    }

    public function printError($text) {
        echo '<p style="color:red">'.$text.'</p>'; 
    } 

}
  

?>