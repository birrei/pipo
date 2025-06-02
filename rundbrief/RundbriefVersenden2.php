<?php 
//PHPMailer
include '../phpmailer/class.phpmailer.php';
include 'db.php';
?> 

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<head>
   <title>Piano-Podium Rundbrief</title>
   <link rel='stylesheet' type='text/css' href='style.css'/>
   <style type="text/css">
     .Mailformular {
	margin-left: 100px;
	margin-top: 20px; 
     }
     #admincontainer{
        margin:10px auto;
        left:50%;
        top:10px;
        width:770px;
        height:800px;
        background-color:#D3CFC0;
        border:1px solid gray;
        
        background-image:url("Adminumgebung.gif");
        background-position:bottom right;
        background-repeat:no-repeat;
     }
     #admincontent{
        overflow:auto;
        width:740px;
        height:700px;
        padding:15px;
     }
     #adminmenu{
        /*border-bottom:1px solid #777777;*/
        border-collapse:collapse;
        width:770px;
        height:22px;
     }
     #adminmenu td.inactive{
        border-left:1px solid #BBBBBB;
        /*border-right:1px solid #BBBBBB;*/
        /*border-top:1px solid gray;*/
        border-bottom:1px solid gray;
        background-color:#DCDCDC;
     }
     #adminmenu td.active{
        /*border-top:1px solid gray;*/
        z-index:1;
        border-left:1px solid gray;
        border-right:1px solid gray;
     }
     #adminmenu a{
        display:block;
        width:100%;
        height:100%;
        text-decoration:none;
        /*font-size:10pt;*/
        font-weight:bold;
        text-align:center;
        padding-top:3px;
        color:#70293E;
     }
     #adminmenu a:hover{
        background-color:silver;
        border-bottom-style:none;
     }
     #adminformular input.text{
        border:1px solid black;
        background-color:silver;
        font-family:Arila,Helvetica,Sans-serif;
        width:280px;
     }
     #formular textarea{
        border:1px solid black;
        background-color:silver;
        font-family:Arila,Helvetica,Sans-serif;
        text-align:left;
        width:280px;
        height:130px;
        font-size:0.9em;
     }
     #adminformular input.file{
        width:410px;
        background-color:silver;
     }
     #adminformular input.button{
        border:1px outset black;
        background-color:silver;
     }
     #bordernew{
        border:1px solid #777777;
        padding:5px;
        background-color:#DCDCDC;
     }
     #bordernew input.text{
        width:100%;
        border:1px solid black;
        background-color:silver;
        font-family:Arila,Helvetica,Sans-serif;
     }
     #bordernew input.button{
        width:150px;
        border:1px outset black;
     }
     #bordernew tr{
        vertical-align:top;
     }
     textarea{
        border:1px solid black;
        background-color:silver;
        font-family:Arila,Helvetica,Sans-serif;
        text-align:left;
        width:280px;
        height:130px;
        font-size:0.9em;
     }
     textarea.low{
       height:64px;
     }
     table.content{
        border-collapse:collapse;
     }
     td.content input{
        background-color:#DCDCDC;
        border:1px solid #555555;
        width:100%;
     }
     td.content{
        background-color:#DCDCDC;
        padding-right:2px;
        vertical-align:top;
     }
     td.loeschencontent{
        background-image:url("loeschenlinie.gif");
        background-repeat:no-repeat;
        background-position:center;
        background-color:#DCDCDC;
        padding-right:0px;
        vertical-align:top;
     }
     td.loeschencontent2{
        background-image:url("loescheneck.gif");
        background-repeat:no-repeat;
        background-position:center;
        padding-right:0px;
        vertical-align:top;
     }
   </style>
</head>

<body>


<?php

// print_r($_FILES);
$mailversand = false; // false: nur Formular anzeigne, true: Abschluss-Info anzeigen. 

$versendet_an = "";

//Fehlermeldung
$fehler = "";

$betreff=""; 
$message=""; 

$AbsenderID=0;
$AbsenderEmail="";
$AbsenderAlias="";
$AbsenderAusgabe="";  // Ausgabe nach Versand 

$VerteilerID=0;
$VerteilerTabelle="";
$VerteilerBeschreibung="";
$VerteilerInfo=""; // Ausgabe nach Versand 

//  Optionen 
$option_ohne_anhang=""; //  neu 28.12.2013 , breiner 
$anzahl_anhaenge=0;

//  sonst. 
$testmsg="";

$anzahl_fehler=0; 

echo '<div id="admincontainer" class="Mailformular">'; 
	
if(isset($_POST['versenden'])) {
	
	

	
	$betreff = $_POST['betreff'];
	if($betreff == "") {
		print_error('Die Mail konnte nicht versendet werden, der Betreff fehlt'); 
		$anzahl_fehler=$anzahl_fehler+1; 
	}
	
	$message = $_POST['message'];		
	if($message == "") {
		print_error('Die Mail konnte nicht versendet werden, die Nachricht fehlt.'); 
		$anzahl_fehler=$anzahl_fehler+1; 
	}
	
	$option_ohne_anhang = $_POST['option_ohne_anhang'];	
	$anzahl_anhaenge= count_attachmentes($_FILES["datei"]); 
	
	if($option_ohne_anhang != "yes" and  $anzahl_anhaenge==0 ) {
		print_error('Die Mail konnte nicht versendet werden, da keine (PDF-) Datei ausgewählt wurde. Fall kein Anhang versendet werden soll, muss die Option "Email ohne Anhang senden" aktiviert sein!'); 
		$anzahl_fehler=$anzahl_fehler+1; 
	}; 
	

	$AbsenderID = $_POST['AbsenderID'];
	$AbsenderDaten= mysql_query( "SELECT Mailadresse, Beschreibung FROM Mailadressen WHERE ID=".$AbsenderID); 
	$row = mysql_fetch_row($AbsenderDaten);
	$AbsenderEmail= $row[0];
	$AbsenderAlias= $row[1];
	$AbsenderAusgabe="Absender: ".$AbsenderEmail." ".$AbsenderAlias;
 	// print_test('Absenderinfo', $AbsenderAusgabe); 


	$VerteilerID = $_POST['VerteilerID'];
	$VerteilerDaten= mysql_query( "SELECT Tabelle, Beschreibung FROM verteilerlisten WHERE ID=".$VerteilerID); 
	$row = mysql_fetch_row($VerteilerDaten);
	$VerteilerTabelle= $row[0];
	$VerteilerBeschreibung= $row[1];
	$VerteilerInfo="Verteiler: ".$VerteilerTabelle." - ".$VerteilerBeschreibung;
 	// print_test('Verteilerinfo', $VerteilerInfo); 
	// print_test('Anzahl Fehler', $anzahl_fehler); 
		
	if ($anzahl_fehler > 0) {
		goto formular; 
		break; 
	}

// ----------------------------- Versand ------------------------------------

	$mail = new PHPMailer();

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = "localhost"; // sets the SMTP server
	$mail->SMTPSecure = "ssl";		
	$mail->Port       = 465;                    // set the SMTP port 
	$mail->Username   = "web553p1";   // SMTP account username
	// $mail->Password   = "77uhW7S89P";        // SMTP account password
	$mail->Password   = "PIAcan697453";        // SMTP account password
	$mail->CharSet ="UTF-8";
	$mail->SetLanguage('de');

	$mail->SetFrom($AbsenderEmail,$AbsenderAlias);
	$mail->AddAddress($AbsenderEmail,$AbsenderAlias);		
	$mail->Subject  = $betreff;
	$mail->Body     = $message;
	      
	if($option_ohne_anhang !="yes" and $anzahl_anhaenge > 0) {
		if (isset($_FILES["datei"]))  { 
			foreach ($_FILES["datei"] as $ids=>$datinfos) { 	
				if ($ids == "name") { 
					foreach ($datinfos as $id=>$info) {
						$mail->AddAttachment($_FILES['datei']['tmp_name'][$id], $_FILES['datei']['name'][$id]);
					}
				 }
			}
		}
	}
	
	$sqlResult = mysql_query('SELECT * FROM '.$VerteilerTabelle.' WHERE freigeschaltet = 1 ORDER BY Nachname');
	while($row = mysql_fetch_assoc($sqlResult)) {
		 $mail->AddBcc($row['Mailadresse'],$row['Vorname']." ".$row['Nachname']);
		 $versendet_an .= $row['Mailadresse'] . "<br/>";
	}
	$mailversuch = $mail->Send();
	$mailversand = true;

	if($mailversuch) {
		echo '<h3>Mail erfolgreich versandt von:</h3>'; 
		echo $AbsenderAusgabe; 
		echo '<h3>Verteiler:</h3>'; 	
		echo $VerteilerInfo;		
		echo '<h3>Empfänger:</h3>'; 
		echo $versendet_an;
	}
	else {
		echo '<p class="fehler">Mailversand fehlgeschlagen!</p>';
		echo '<p class="fehler">Fehler: '.$fehler.'</p>';			
		echo '<pre>'; 
		print_r($mail->ErrorInfo);	
		echo '</pre>'; 		

	}
	echo '<p><a href="RundbriefVersenden2.php">Formular neu laden</a></p>';

}
else {
	// Noch kein Versand ausgelöst, Formular laden 
	
	$betreff=get_default_subject() ; 
	//~ print_test('Betreff', $betreff); 

	$message=get_default_message();
	//~ print_test('Mailtext', $message); 
	

	formular: 
	
	$absenderadressen= mysql_query( "SELECT ID, Mailadresse, Beschreibung FROM Mailadressen WHERE OrderID > 0 ORDER BY OrderID" ); 
	$verteilerlisten= mysql_query( "SELECT ID, Tabelle, Beschreibung FROM verteilerlisten WHERE OrderID > 0 ORDER BY OrderID" ); 	
		

	?>

	<form enctype="multipart/form-data" action="#" method="post" id="adminformular" accept-charset="UTF-8">
	<table class="Mailformular">
		<tr><td><h1> Rundbrief versenden </h1></td></tr> 
		<tr>
			<td>
				<h3>Schritt 1: PDF-Datei(en) ausw&auml;hlen:</h3>
				<br /><input name="datei[]" type="file" class="file"/> 
				<br /><input name="datei[]" type="file" class="file"/>   	    
				<br /><input name="datei[]" type="file" class="file"/>
				<br /><input name="datei[]" type="file" class="file"/>   	  
				<br /><input name="option_ohne_anhang" type="checkbox" value="yes">Email ohne Anhang senden<br><!-- neu 28.12.2013, breiner  --> 
			</td>
		</tr>
		<tr>
			<td>
				<h3>Schritt 2: Betreff des Rundbriefs eingeben</h3>
				<input type="text" class="text" name="betreff" value="<?php echo $betreff; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<h3>Schritt 3: Text des Rundriefs eingeben</h3>
				<textarea name="message"><?php echo $message; ?></textarea>
			</td>
		</tr>
	
		
		<tr>
			<td>
				<h3>Schritt 4: Absender festlegen</h3>

			<select name="AbsenderID"> 
			<?php 
				while( $absender = mysql_fetch_object($absenderadressen)) { 
					if ($AbsenderID==$absender->ID) {
						echo "<option value=\"".$absender->ID."\" selected>".$absender->Mailadresse." - ".$absender->Beschreibung."</option>"; 
					} else {
						echo "<option value=\"".$absender->ID."\">".$absender->Mailadresse." - ".$absender->Beschreibung."</option>"; 
					}
	
				} 
			?>
			</select> 

			</td>
		</tr>
		
	
		<tr>
			<td>
				<h3>Schritt 5: Verteiler festlegen</h3>

			<select name="VerteilerID"> 
			<?php 
				while( $verteiler = mysql_fetch_object($verteilerlisten)) { 
				
					if ($VerteilerID==$verteiler->ID) {
						echo "<option value=\"".$verteiler->ID."\" selected>".$verteiler->Beschreibung."</option>"; 
					} else {
						echo "<option value=\"".$verteiler->ID."\">".$verteiler->Beschreibung."</option>"; 
					}

				} 
			?>
		</select> 

			</td>
		</tr>
		
		<tr>
			<td>
				<h3>Schritt 6: Rundbrief abschicken</h3>
				<input type="submit" class="button" name="versenden" value="Rundbrief senden"/>
			</td>
		</tr>
		<tr><td></td></tr> 		<tr><td></td></tr> 
		
		<tr><td> <a href="RundbriefVersenden2.php">Formular neu laden</a></td></tr> 
				
	</table>
	</form>


<?php 
}

echo '	</div> '; 

?>

</body>

</html>

<?php 

function get_default_subject() {
	return "Piano-Podium Rundbrief " . date("m/Y");
}
function get_default_message() {
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
function count_attachmentes($files) {
	$anzahl_anhaenge=0; 
	// gibt Anzahl gueltiger Anhaenge zurueck (nur PDF-Dateien sind zugelassen) 
	foreach ($files as $ids=>$datinfos) { 	// z�hlen, anzeigen 
		if ($ids == "name") { 
			//~ $testmsg.=$_FILES["datei"]["name"][0]; // Erste Datei
			//~ $testmsg.=$_FILES["datei"]["name"][1]; // Zweite Datei
			foreach ($datinfos as $id=>$info) {
				// $testmsg .="Datei: ".$_FILES["datei"]["name"][$id]."<br />";
				// $testmsg .="Uploadstatus ".$_FILES["datei"]["error"][$id]."<br />";
				// $testmsg .="Dateityp: ".$_FILES["datei"]["type"][$id]."<br />";	
				if($files["name"][$id]!="") { // nur verwendete FElder prfen 
					$anzahl_anhaenge=$anzahl_anhaenge + 1; 
					if($files["type"][$id]=='application/pdf') {
						$anzahl_anhaenge=$anzahl_anhaenge + 1; 
						// $fehler ="Die Mail konnte nicht versendet werden, da Datei ".$files["name"][$id]." keine PDF-Datei ist.";
					}								
				}
			}
		}
	}
	return $anzahl_anhaenge; 
}

function print_test($name, $wert) {
	echo '<pre>'.$name.': '.$wert.'</pre>'; 
}
function print_error($text) {
	echo '<p class="fehler">Fehler: '.$text.'</p>'; 
}


?> 
