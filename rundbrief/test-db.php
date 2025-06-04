<?php 
// require_once 'dbconn/class.db.php'; 
require_once 'class.verteilerliste.php'; 

?>

<!DOCTYPE html>
<html lang="de">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Datenbank</title>
</head>
<body>

<h1> DB Test - Inhalte Tabelle Newsletter_test</h1>
<?php 

    $verteilerliste = new Verteilerliste(3); // Birgit Testadressen 
    $Mitglieder = $verteilerliste->getMitglieder(); 
    // $verteilerliste->printTest(); 

    if($verteilerliste->row_count>0 ) {
        foreach ($Mitglieder as $Mitglied) {
            echo '<p>'; 
            echo $Mitglied["Vorname"].'<br>'; 
            echo $Mitglied["Nachname"].'<br>';             
            echo $Mitglied["Mailadresse"].'<br>'; 
            echo '</p>';             
        }

    } else {
        echo 'keine Daten vorhanden '; 
    }
        


?>



</body>
</html>