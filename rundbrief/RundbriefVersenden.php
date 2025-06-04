<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<head>
   <title>Test Mail </title>
    <style type="text/css">
        table {text-align: top;

                }
        td {vertical-align: top;
               padding: 10px;  
               background-color: lightgray;
        }
        input.text {width: 500px}
        

    </style>

   </head>


<body>
<?php 

require_once 'class.verteilerliste.php'; 
require_once 'class.absender.php'; 
require_once 'class.rundbrief.php'; 
require_once 'class.htmlselect.php'; 

$rundbrief = new Rundbrief(); 

$Betreff = $rundbrief->get_default_subject(); 
$Mailtext = $rundbrief->get_default_message(); 

// $VerteilerID = 3; // 3: Testadressen Birgit 
// $AbsenderID = 7; // birgitreiner@piano-podium.de

$VerteilerID = ''; 
$AbsenderID = ''; 

if(isset($_POST['versenden'])) {

    $AbsenderID=$_POST["AbsenderID"]; 
    $VerteilerID=$_POST["VerteilerID"]; 
    $Betreff=$_POST["Betreff"]; 
    $Mailtext=$_POST["Mailtext"]; 

    
    $absender= new Absender($AbsenderID);
    // $absender->printTest(); 

    $verteilerliste = New Verteilerliste($VerteilerID);
    // $verteilerliste->printTest(); 

    $rundbrief = new Rundbrief(); 
    $rundbrief->Betreff = $Betreff; 
    $rundbrief->Mailtext = $Mailtext; 
    $rundbrief->AbsenderMailadresse = $absender->Mailadresse;
    $rundbrief->AbsenderAlias = $absender->Alias; 
    $rundbrief->Empfaengerliste = $verteilerliste->getEmpfaenger();
    $rundbrief->UploadItems = $_FILES['datei']; // Anhänge 
    $rundbrief->printTest(); 


}
?>



<form enctype="multipart/form-data" action="#" method="post" id="adminformular" accept-charset="UTF-8">
<table class="Mailformular">
    <tr><td colspan="2"><h1> Rundbrief versenden </h1> </td></tr>
    <tr>
        <td>
            <h3>Schritt 1: PDF-Datei(en) auswählen:</h3>
     </td>
        <td>            
            <input name="datei[]" type="file" class="file"/> 
            <br /><input name="datei[]" type="file" class="file"/>   	    
            <br /><input name="datei[]" type="file" class="file"/>
            <br /><input name="datei[]" type="file" class="file"/>   	  
            <br /><input name="option_ohne_anhang" type="checkbox" value="yes">Email ohne Anhang senden<br>
        </td>
    </tr>
    <tr>
        <td>
            <h3>Schritt 2: Betreff des Rundbriefs eingeben</h3>
            </td>
        <td>     
            <input type="text" class="text" name="Betreff" value="<?php echo $Betreff; ?>"/>
        </td>
    </tr>
    <tr>
        <td>
            <h3>Schritt 3: Text des Rundriefs eingeben</h3>
        </td>
        <td>            
            <textarea name="Mailtext" rows="10" cols="70"><?php echo $Mailtext; ?></textarea>
        </td>
    </tr>

    
    <tr>
        <td>
            <h3>Schritt 4: Absender festlegen</h3>
        </td>
        <td>
        <?php 
            $Absenderauswahl = new HTMLSelect('AbsenderID');
            $Absenderauswahl->printHTMLSelect($AbsenderID); 
            
        ?>


        </td>
    </tr>
    

    <tr>
        <td>
            <h3>Schritt 5: Verteiler festlegen</h3>

       </td>
        <td>
        <?php 
            $Verteilerauswahl = new HTMLSelect('VerteilerID');
            $Verteilerauswahl->printHTMLSelect($VerteilerID); 
        ?>
 

        </td>
    </tr>
    
    <tr>
        <td>
            <h3>Schritt 6: Rundbrief abschicken</h3>
                 </td>
        <td>
            <input type="submit" class="button" name="versenden" value="Rundbrief senden"/>
        </td>
    </tr>


            
</table>

 
</form>

   <!-- <tr><td> <a href="RundbriefVersenden.php">Formular neu laden</a></td></tr>  -->




</body>
</html>     