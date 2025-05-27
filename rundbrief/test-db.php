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

    $verteilerliste = new Verteilerliste();
    $verteilerliste->ID = 3; // ID kommt später aus Auswahl. 3 = Newsletter_test 
    $verteilerliste->setListe(); 
    $verteilerliste->readTable(); 
    // $verteilerliste->printTest(); 

    if($verteilerliste->row_count>0 ) {
        foreach ($verteilerliste->Mitglieder as $row) {
            echo '<p>'; 
            echo $row["Vorname"].'<br>'; 
            echo $row["Nachname"].'<br>';             
            echo $row["Mailadresse"].'<br>'; 
            echo '</p>';             
        }

    } else {
        echo 'keine Daten vorhanden '; 
    }
        


?>



</body>
</html>