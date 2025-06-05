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

    public $Betreff='';
    public $Mailtext='';
    public $AbsenderMailadresse=''; 
    public $AbsenderAlias=''; 

    public $NameVerteiler=''; 
    public $Empfaengerliste=[]; // Enthält die Empfänger (Mailadesse, Vorname, Name)
    public $AnzahlEmpfaenger=0; 
    
    public $UploadItems=[]; //  Upload-Elemente (Input-Elemente im Formular ) 
    public $Anhaenge=[]; // Tatsächlich hinterlegte Datei-Anhänge 
    public $AnzahlAnhaenge=0; 
    public $AnzahlAnhaengeNichtPDF=0; //  fehler, wenn > 0          
    public $OhneAnhang=false;  

    public $AnzahlFehler=0; 
    public $Fehlertext=''; 

    public $versendet=false; 

    public function __construct(){
        
    }

    public function loadProperties() {
        // Parameter setzen, die nicht bei bei Programmaufruf gefüllt werden   
        $this->Anhaenge = $this->getAnhaenge(); // setzt auch "$this->AnzahlAnhaenge", "this->AnzahlAnhaengeNichtPDF"
        $this->AnzahlEmpfaenger = count($this->Empfaengerliste);
        $this->AnzahlFehler = $this->getAnzahlFehler();  // Setzt auch "$this->Fehlertext"
    }

    public function Versenden() {

        if($this->AnzahlFehler>0) {
            $this->printError($this->Fehlertext); 
            return; 
        }

        $mail = new PHPMailer(true); 
        $creds = new Mailcreds(); 

        /************************************* */
        $mail->SMTPDebug = 0; // SMTP::DEBUG_SERVER; // XXX Enable verbose debug output
        $mail->isSMTP();                                       
        $mail->Host       = $creds->Host; 
        $mail->SMTPAuth   = true;          
        $mail->Username   = $creds->Username; 
        $mail->Password   = $creds->Password;  
        $mail->SMTPSecure = $creds->SMTPSecure; 
        $mail->Port       = $creds->Port;  
        $mail->CharSet    ="UTF-8";
        $mail->SetLanguage('de');

        $mail->setFrom($this->AbsenderMailadresse, $this->AbsenderAlias);
        $mail->AddAddress($this->AbsenderMailadresse, $this->AbsenderAlias);

        foreach($this->Empfaengerliste as $Empfaenger) {
            $mail->AddBcc($Empfaenger["Mailadresse"], $Empfaenger["Vorname"].' '.$Empfaenger["Nachname"]);
        }

        $mail->Subject = $this->Betreff;
        $mail->Body    = $this->Mailtext;

        foreach ($this->Anhaenge as $index=>$datei) {
            $mail->AddAttachment($datei["tmp_name"], $datei["name"]);
            // echo $datei["name"].' '.$datei["tmp_name"].'<br>';  // test 
        }

        try {
            $mail->send();
            $this->versendet=true;             
            $this->printInfo('Die Mail wurde an '.$this->AnzahlEmpfaenger.' Empfänger versendet.' ); 
            $this->printInfo('Verwendete Verteilerliste: '.$this->NameVerteiler);
            $this->printInfo('Verwendete Absenderadresse: '.$this->AbsenderMailadresse);               
        } catch (Exception $e) {
            $this->versendet=false;             
            $this->printError('Die Mail konnte nicht versendet werden.'); 
            $this->printError($mail->ErrorInfo); 
        } 
    }

    public function getAnzahlAnhaenge() {
        // Nicht verwendet, alternative Ermittlungsart, zum Verständnis ... 
        $Anhaenge= array_filter($this->UploadItems["name"]);
        return count($Anhaenge);  
    }

    public function getAnhaenge(): array {
        $Anhaenge = [];  
        $Uploads = $this->UploadItems;
        $anzahlUplads = count($Uploads['name']);

        for ($i = 0; $i < $anzahlUplads; $i++) {
            $dateiname = $Uploads['name'][$i];
            if ($dateiname!='') {
                $tmp_name = $Uploads['tmp_name'][$i];
                $Anhaenge[]=array('tmp_name'=>$tmp_name, 'name'=>$dateiname); 

                if($Uploads['type'][$i]!='application/pdf') {
                    $this->AnzahlAnhaengeNichtPDF+=1; 
                }

                // echo '<p>file tmp_name: '.$Uploads['tmp_name'][$i].'<br>';    
                // echo 'file name: '.$Uploads['name'][$i].'<br>';                                
                // echo 'file type: '.$Uploads['type'][$i].'<br>';
                // echo 'file size: '.$Uploads['size'][$i].'<br>';
                // echo 'file error: '.$Uploads['error'][$i].'<br>';                
            }
        }
        $this->AnzahlAnhaenge = count($Anhaenge); 
        return $Anhaenge; 
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
        
        /** Absender  */
        echo '<p>Absender Mailadresse: '.$this->AbsenderMailadresse.'<br>';    
        echo 'Absender Alias: '.$this->AbsenderAlias.'</p>';  

        /** Empfänger  */      
        echo 'Anzahl Empfänger: '.count($this->Empfaengerliste).'<br>';        
        echo '<p>Liste Empfänger: <br>'; 
        foreach($this->Empfaengerliste as $Empfaenger) {
            echo '* Vorname: '.$Empfaenger["Vorname"].', Nachname: '.$Empfaenger["Nachname"].', Mailadresse: '.$Empfaenger["Mailadresse"].'<br>';
        }        
        echo '</p>'; 

        /** Anhänge *********** */
        echo '<p>Anhänge: <br>'; 
        if($this->OhneAnhang) {
            echo 'Option "ohne Anhang senden" wurde gewählt.<br>'; 
        }
        echo 'Anzahl Anhänge: '.$this->AnzahlAnhaenge.'<br>';   
        echo '<p>Anhänge Auflistung: <br>'; 
        // foreach ($this->Anhaenge as $index=>$datei) {            
        foreach ($this->Anhaenge as $datei) {                            
            echo '* name: '.$datei["name"].', tmp_name: '.$datei["tmp_name"].'<br>';  // test 
        }
        echo '</p>'; 

        /** Text  *********** */
        echo '<p>Betreff: '.$this->Betreff.'</p>';    
        echo '<p>Mailtext: <pre>'.$this->Mailtext.'</pre></p>'; 
        
        /** Fehler  *********** */
        echo '<p><b>Fehler: </b><br>'; 
        echo 'Anzahl Fehler: '.$this->AnzahlFehler.'<br>';   
        echo 'Fehlertext: <br>';             
        $this->printError($this->Fehlertext);

    }

    public function printTest2() {
        echo '<pre>';
        echo 'Empfänger:'; 
        print_r($this->Empfaengerliste);

        echo 'Anhänge:';         
        print_r($this->Anhaenge);  
        echo '</pre>'; 

    } 

    public function getAnzahlFehler (): int {
        $AnzahlFehler=0; 

        If($this->Betreff=='') {
            $this->Fehlertext.='Betreff fehlt! <br>'; 
            $AnzahlFehler+=1; 
        }
        
        If($this->Mailtext=='') {
            $this->Fehlertext.='Mailtext fehlt! <br>';             
            $AnzahlFehler+=1; 
        }

        If(count($this->Empfaengerliste)==0) {
            $this->Fehlertext.='Die Empfängerliste ist leer. Prüfte bitte, ob du einen leeren Verteiler für den Versand gewählt hast<br>';             
            $AnzahlFehler+=1; 
        }  

        If($this->AbsenderMailadresse=='') {
            $this->Fehlertext.='Absenderadresse fehlt! <br>';             
            $AnzahlFehler+=1; 
        }        

        if(!$this->OhneAnhang & $this->AnzahlAnhaenge==0) {
            $this->Fehlertext.='Anhang fehlt! Falls kein Anhang versendet werden soll, bitte Option "Email ohne Anhang senden" aktivieren<br>';             
            $AnzahlFehler+=1; 
        }
        if($this->OhneAnhang & $this->AnzahlAnhaenge>0) {
            $this->Fehlertext.='Option "Ohne Anhang senden" wurde gewählt, jedoch Dateien wurden angehängt. Diese Kombination ist nicht möglich! <br>';             
            $AnzahlFehler+=1; 
        }
        if($this->AnzahlAnhaengeNichtPDF>0) {
            $this->Fehlertext.='Es dürfen nur PDF-Dateien angehängt werden! <br>';             
            $AnzahlFehler+=1; 
        }
        // XXX nur PDF zulassen ! 
            
        return $AnzahlFehler; 
        
    }

    public function printError($text) {
        echo '<p class="printerror">'.$text.'</p>'; 
    } 

    public function printInfo($text) {
        echo '<p class="printinfo">'.$text.'</p>'; 
    } 

}
  

?>