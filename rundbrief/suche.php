<?php 
require_once 'class.htmltable.php'; 

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
   <title>Suche</title>
    <link rel='stylesheet' type='text/css' href='style.css'/>    

   </head>
<body>

<h3>Suche</h3>

<?php 

$Suchtext=isset($_REQUEST['Suchtext'])?$_REQUEST['Suchtext']:''; 
$Mitglied=isset($_REQUEST['Mitglied'])?$_REQUEST['Mitglied']:''; 
$Freigeschaltet=isset($_REQUEST['Freigeschaltet'])?$_REQUEST['Freigeschaltet']:''; 

?>

<form enctype="multipart/form-data" action="" method="GET" id="adminformular" accept-charset="UTF-8">

    Ist Mitglied: 
    <select id="Mitglied" name="Mitglied" onchange="this.form.submit()" >
                <option value="" <?php echo ($Mitglied==''?'selected':'') ; ?>></option> 
                <option value="1" <?php echo ($Mitglied=='1'?'selected':'') ; ?>>Ja</option> 
                <option value="0" <?php echo ($Mitglied=='0'?'selected':'') ; ?>>Nein</option> 
    </select> 
    
     Versand freigeschaltet: 
    <select id="Freigeschaltet" name="Freigeschaltet" onchange="this.form.submit()" >
                <option value="" <?php echo ($Freigeschaltet==''?'selected':'') ; ?>></option> 
                <option value="1" <?php echo ($Freigeschaltet=='1'?'selected':'') ; ?>>Ja</option> 
                <option value="0" <?php echo ($Freigeschaltet=='0'?'selected':'') ; ?>>Nein</option> 
    </select> 

     Suchbegriff: <input type="text" class="text" name="Suchtext" value="<?php echo $Suchtext; ?>"/> 


</form>

<?php 

    $query="SELECT ID, Vorname, Nachname, Mailadresse, Freigeschaltet, Mitglied, Bemerkung, Datum, 'Newsletter' as Tabelle   
            FROM Newsletter 
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

    if ($Mitglied!='') {
      $query.="AND Mitglied=".$Mitglied." ".PHP_EOL;  
    }  
    if ($Freigeschaltet!='') {
      $query.="AND Freigeschaltet=".$Freigeschaltet." ".PHP_EOL;  
    }  

    $query.="UNION ALL 
            SELECT ID, Vorname, Nachname, Mailadresse, Freigeschaltet, Mitglied, Bemerkung, Datum, 'Newsletter_disabled' as Tabelle    
            FROM Newsletter_disabled 
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
    
    if ($Mitglied!='') {
      $query.="AND Mitglied=".$Mitglied." ".PHP_EOL;  
    }  
    if ($Freigeschaltet!='') {
      $query.="AND Freigeschaltet=".$Freigeschaltet." ".PHP_EOL;  
    }  

    // echo $query; // test 

    $query.="ORDER BY Nachname, Vorname "; 

    $html_table=new HTML_Table($query); 

    $html_table->print_table(); 

?>



</body>
</html>     