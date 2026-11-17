<?php 
$PageTitle='Suche'; 
include 'head.php'; 
require_once 'class.htmltable.php'; 
require_once 'class.htmlselect.php'; 
require_once 'class.verteilerliste.php'; 
?>

<h3>Suche</h3><p> <a href="hilfe_suche.php" target="_blank">Hilfe</a></p> 

<?php 

$Tabelle=''; 

$VerteilerID=isset($_REQUEST['VerteilerID'])?$_REQUEST['VerteilerID']:'';

$verteilerliste = new Verteilerliste($VerteilerID); 
$Tabelle = $verteilerliste->Tabelle; 


$Suchtext=isset($_REQUEST['Suchtext'])?$_REQUEST['Suchtext']:''; 
$Freigeschaltet=isset($_REQUEST['Freigeschaltet'])?$_REQUEST['Freigeschaltet']:''; 

?>



<form enctype="multipart/form-data" action="" method="GET" id="adminformular" accept-charset="UTF-8">

Verteiler: 
  <?php 
  $select_verteilerlisten = new HTMLSelect('VerteilerID'); 
  $select_verteilerlisten->autosubmit=true; 
  $select_verteilerlisten->printHTMLSelect($VerteilerID); 
  ?> 

    Versand freigeschaltet: 
    <select id="Freigeschaltet" name="Freigeschaltet" onchange="this.form.submit()" >
                <option value="" <?php echo ($Freigeschaltet==''?'selected':'') ; ?>></option> 
                <option value="1" <?php echo ($Freigeschaltet=='1'?'selected':'') ; ?>>Ja</option> 
                <option value="0" <?php echo ($Freigeschaltet=='0'?'selected':'') ; ?>>Nein</option> 
    </select> 

    Suchbegriff: <input type="text" name="Suchtext" size="10" value="<?php echo $Suchtext; ?>"/> 

<input type="submit" name="senden" value="Suche">

</form>



<?php 

    $query="SELECT ID, Vorname, Nachname, Mailadresse, Freigeschaltet, Bemerkung, Datum, '".$Tabelle."' as Tabelle   
            FROM ".$Tabelle."  
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
        $query.="AND (
                Vorname LIKE '%".$Suchtext."%' OR 
                Nachname LIKE '%".$Suchtext."%' OR 
                Mailadresse LIKE '%".$Suchtext."%' OR 
                Bemerkung LIKE '%".$Suchtext."%' 
                ) "; 
    }

    if ($Freigeschaltet!='') {
        $query.="AND Freigeschaltet=".$Freigeschaltet." ".PHP_EOL;  
    }  


    // echo $query; // test 

    $query.="ORDER BY Nachname, Vorname "; 

    $html_table=new HTML_Table($query); 

    $html_table->print_table(); 


    include 'foot.php'; 

?>

