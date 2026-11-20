<?php 
$PageTitle='Versand'; 
include 'head.php'; 
require_once 'class.verteilerliste.php'; 
require_once 'class.absender.php'; 
require_once 'class.rundbrief.php'; 
require_once 'class.htmlselect.php'; 

$rundbrief = new Rundbrief(); 

$Betreff = $rundbrief->get_default_subject(); 
$Mailtext = $rundbrief->get_default_message(); 

$AbsenderID=''; 
$VerteilerID=''; 

$CheckOhneAnhang=''; // "checked" oder "" 
$CheckEinzelversand='';
$Testausgabe=false;     
$Fehler=false;  

if(isset($_POST['versenden'])) {
    $AbsenderID=$_POST["AbsenderID"]; 
    $VerteilerID=$_POST["VerteilerID"]; 
    $Betreff=$_POST["Betreff"]; 
    $Mailtext=$_POST["Mailtext"]; 
    $CheckOhneAnhang=isset($_POST["OptionOhneAnhang"])?'checked':'';     
    $CheckEinzelversand=isset($_POST["OptionEinzelversand"])?'checked':'';      
    $Testausgabe=isset($_POST["Testausgabe"])?true:false;      

    if($AbsenderID=='') {
         echo '<p class="printerror">Bitte Absender auswählen!</p>'; 
        $Fehler=true; ; 
    }
    if($VerteilerID=='') {
         echo '<p class="printerror">Bitte Verteiler auswählen!</p>'; 
        $Fehler=true; ; 
    }    

    if(!$Fehler) {
        
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
        $rundbrief->NameVerteiler= $verteilerliste->Beschreibung; 

        $rundbrief->OhneAnhang = $CheckOhneAnhang=='checked'?true:false; 
        $rundbrief->UploadItems = $_FILES['datei']; // Anhänge 

        $rundbrief->Testausgabe=$Testausgabe; 

        $rundbrief->Versenden(); 
    }

}
?>
<form enctype="multipart/form-data" action="" method="post" id="adminformular" accept-charset="UTF-8">
<table class="Mailformular">
    <tr><td colspan="2"><h3   style="display:inline;"> Rundbrief versenden </h3> 
        <a href="hilfe_versand.php" target="_blank" title="Hilfe im neuen Tab/Fenster öffnen">Hilfe</a>
    </td></tr>
    <tr>
        <td class="td1">Anhänge (PDF): </td>
        <td>      <input name="datei[]" type="file" class="file"/> 
            <br /><input name="datei[]" type="file" class="file"/>   	    
            <br /><input name="datei[]" type="file" class="file"/>
            <br /><input name="datei[]" type="file" class="file"/>  
             	  <!--  XXX option wieder einlesen -->
            <input name="OptionOhneAnhang" type="checkbox" <?php echo $CheckOhneAnhang; ?>>Email ohne Anhang senden<br>
        </td>
    </tr>
    <tr>
        <td class="td1">Betreff:</td>
        <td><input type="text" class="text" name="Betreff" value="<?php echo $Betreff; ?>"/></td>
    </tr>
    <tr>
        <td class="td1">Text:</td>        
        <td><textarea name="Mailtext" rows="10" cols="70"><?php echo $Mailtext; ?></textarea></td>
    </tr>
    <tr>
        <td class="td1">Absender:</td>            
        <td>
            <?php 
                $Absenderauswahl = new HTMLSelect('AbsenderID');
                $Absenderauswahl->show_empty_row=true;                 
                $Absenderauswahl->printHTMLSelect($AbsenderID); 
            ?>
        </td>
    </tr>
    
    <tr>
        <td class="td1">Verteiler:</td>      
        <td>
            <?php 
                $Verteilerauswahl = new HTMLSelect('VerteilerID');
                $Verteilerauswahl->show_empty_row=true; 
                $Verteilerauswahl->printHTMLSelect($VerteilerID); 
            ?>
            &nbsp; Verteilerlisten unter <a href="suche.php" target="_blank" title="Suche im neuen Tab/Fenster öffnen">Suche</a> anschauen.    
        </td>
    </tr>
    <tr>
        <td class="td1"></td>
        <td><input type="submit" class="button" name="versenden" value="Rundbrief senden"/> 
        

    </td>
    </tr>

    <tr>
        <td class="td1"></td>
        <td align="right"> <input name="Testausgabe" type="checkbox" <?php echo $Testausgabe?'checked':''; ?>>Testausgabe<br>
        

    </td>
    </tr>

    </table>

               

    </form>

<?php 


include 'foot.php'; 

?>

