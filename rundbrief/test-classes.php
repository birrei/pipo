<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<head>
   <title>Test Klassen </title>
   </head>

<body>
<?php 


require_once 'class.verteilerliste.php'; 
require_once 'class.absender.php'; 
require_once 'class.rundbrief.php'; 
require_once 'class.htmlselect.php'; 



$AbsenderID = 7; // birgitreiner@piano-podium.de
$absender= new Absender($AbsenderID); 
// $absender->printTest(); 

$VerteilerID = 3; // 3: Testadressen Birgit 
$verteilerliste = New Verteilerliste($VerteilerID );
// $verteilerliste->printTest(); 

$rundbrief = new Rundbrief(); 
$rundbrief->AbsenderMailadresse = $absender->Mailadresse; 
$rundbrief->AbsenderAlias = $absender->Alias; 
$rundbrief->Betreff = $rundbrief->get_default_subject(); 
$rundbrief->Mailtext = $rundbrief->get_default_message(); 
$rundbrief->Empfaengerliste = $verteilerliste->getEmpfaenger(); 
$rundbrief->printTest(); 


// echo '--------------------------'; 
// $listName='AbsenderID';
// $listName='VerteilerID';
// $htmlselect= new HTMLSelect($listName); 
// $htmlselect->printTest(); 





?>


</body>
</html>     