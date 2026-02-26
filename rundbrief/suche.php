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

?>

<form enctype="multipart/form-data" action="" method="post" id="adminformular" accept-charset="UTF-8">

<input type="text" class="text" name="Suchtext" value="<?php echo $Suchtext; ?>"/>

</form>

<?php 

    $query="SELECT * FROM Newsletter WHERE 1=1 "; 

    if($Suchtext!='') {
        $query.="AND (
                Vorname LIKE '%".$Suchtext."%' OR 
                Nachname LIKE '%".$Suchtext."%' OR 
                Mailadresse LIKE '%".$Suchtext."%' OR 
                Bemerkung LIKE '%".$Suchtext."%' 
                ) "; 
    }

    $query.="ORDER BY Nachname, Vorname "; 

    $html_table=new HTML_Table($query); 

    $html_table->print_table(); 

?>



</body>
</html>     