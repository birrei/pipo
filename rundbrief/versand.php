<?php 
require_once 'class.verteilerliste.php'; 
require_once 'class.absender.php'; 
require_once 'class.rundbrief.php'; 
require_once 'class.htmlselect.php'; 
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
   <title>Rundbrief versenden</title>
    <link rel='stylesheet' type='text/css' href='style.css'/>    

   </head>
<body>
<?php 


$rundbrief = new Rundbrief(); 

$Betreff = $rundbrief->get_default_subject(); 
$Mailtext = $rundbrief->get_default_message(); 

$AbsenderID=''; 
$VerteilerID=''; 

$CheckOhneAnhang=''; // "checked" oder "" 
$CheckEinzelversand='';

if(isset($_POST['versenden'])) {

    $AbsenderID=$_POST["AbsenderID"]; 
    $VerteilerID=$_POST["VerteilerID"]; 
    $Betreff=$_POST["Betreff"]; 
    $Mailtext=$_POST["Mailtext"]; 
    $CheckOhneAnhang=isset($_POST["OptionOhneAnhang"])?'checked':'';     
    $CheckEinzelversand=isset($_POST["OptionEinzelversand"])?'checked':'';      

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
    $rundbrief->loadProperties(); 

    if (!isset($_POST["OptionEinzelversand"])) {
        $rundbrief->Versenden(); 
    } else {
        $rundbrief->Versenden2();         
    }
 

    if($rundbrief->versendet) {
        goto skipform; 
    }
    // $rundbrief->printTest(); 
    // $rundbrief->printTest2(); 

}
?>

<form enctype="multipart/form-data" action="" method="post" id="adminformular" accept-charset="UTF-8">
<table class="Mailformular">
    <tr><td colspan="2"><h3> Rundbrief versenden </h3> </td></tr>
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
                $Absenderauswahl->printHTMLSelect($AbsenderID); 
            ?>
        </td>
    </tr>
    
    <tr>
        <td class="td1">Verteiler:</td>      
        <td>
            <?php 
                $Verteilerauswahl = new HTMLSelect('VerteilerID');
                $Verteilerauswahl->printHTMLSelect($VerteilerID); 
            ?>
        </td>
    </tr>
    <tr>
        <td class="td1"></td>
        <td><input type="submit" class="button" name="versenden" value="Rundbrief senden"/> 
        
        &nbsp; &nbsp; &nbsp; &nbsp; 
    
        <input name="OptionEinzelversand" type="checkbox" <?php echo $CheckEinzelversand; ?>>Einzelversand (Test)
            
     
        

    </td>
    </tr>
    </table>
    </form>

<?php 

skipform: 

?>

<!-- <p><a href="">Formular neu laden</a> unnötig --> 

<p> <a href="suche.php" target="_blank">Suche</a> </p>

</body>
</html>     