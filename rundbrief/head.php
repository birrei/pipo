<?php 
$title_base='Piano-Podium Rundbrief'; 
$title_page=isset($PageTitle)?$PageTitle:''; // Variable $PageTitle muss in aufrufender Seite dirket vor include-Anweisung ausgegeben werden  
$title_complete=($title_page!=''?$title_page.' - '.$title_base:$title_base); 
?> 
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="pragma" content="no-cache">  
  <!-- <script src="javascript.js"></script> -->
  <!-- <link rel="icon" type="image/vnd.icon" href="favicon.ico" /> -->
  <link rel="icon" type="image/vnd.icon" href="mailicon.png" />
  <title><?php echo $title_complete;  ?></title>
  <link rel='stylesheet' type='text/css' href='style.css'/>
</head>
<body>
<a href="index.php" tabindex="-1">Startseite</a> | 
<a href="versand.php" tabindex="-1">Versand</a> | 
<a href="suche.php" tabindex="-1">Suche</a>
<hr>

<?php 
?> 
