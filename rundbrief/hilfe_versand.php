<?php 
$PageTitle='Hilfe Rundbrief-Versand'; 
include 'head.php'; 
?>

<h1>Rundbrief versenden</h1> 

<p>Das Formular steht unter <a href="versand.php">Versand</a> zur Verfügung. </p>

<!-- 

  <p>
    Die nachfolgende Anleitung beschreibt den allgemeinen Ablauf des Versands. Sie enthält jedoch aus Datenschutzgründen keine 
    Angaben zu den konkreten Verteilerlisten, Absenderadressen oder eingerichteten Weiterleitungen. 
    Bei Bedarf können diesee Zusatzinformationen in <a href="PPR_Rundbrief_Anleitung_Extra.pdf">dieser separaten Datei</a>
    eingesehen werden. 
  </p> 

-->

<!-- <p style="color:red; font-weight:bold">Entwurf! </p> -->

<h2>Anhänge auswählen </h2> 

<p> Es können nur PDF-Dateien angehängt werden, andere Dateitypen werden vom Programm abgelehnt. 
Es können bis zu 4 Anhänge mitgesendet werden. Der einzelne Anhang sollte nicht größer sein als 20 MB. 
Siehe auch: <a href="https://help.dogado.de/hc/de/articles/22597257803409-Was-ist-die-maximale-Gr%C3%B6%C3%9Fe-einer-E-Mail" target="_blank">Was ist die maximale Größe einer E-Mail?</a> (dogado). 

</p>

<p>Falls eine Mail ohne Anhang versendet werden soll, dann muss Checkbox "Email ohne Anhang senden" aktiviert werden.</p>

<h2>Betreff eingeben </h2>
<p>Der automatisch generierte Text kann bei Bedarf manuell  überschrieben werden</p>

<h2>Mailtext eingeben </h2>
<p>Der automatisch generierte Text kann bei Bedarf manuell  überschrieben werden</p>

<h2>Absender auswählen</h2>
<p>Auswahl der gewünschten Absender-Adresse </p>

<h2>Verteilerliste auswählen</h2>
<p>Auswahl der gewünschten Verteilerliste </p>
<p>Die zur Verfügung stehenden Verteilerlisten können unter <a href="suche.php">Suche</a> eingesehen und durchsucht werden. </p>

<h2>Rundbrief senden (erster Versand)</h2>
<p> Nach Start des Versandvorgangs werden (sofern ausgewählt) die Anhänge hochgeladen, das kann je nach Größe der Dateien einige Sekunden dauern 
(der Fortgang ist ggf. am "Kreiseln" im Browser-Tab erkennbar ) </p>

<p>
  Nach erfolgreichem Versand wird im Kopfbereich des Formulars ein Infotext angezeigt. 
  Der Text enthält Datum und Uhrzeit des zuvor durchgeführten Versands, die Anzahl der bedienten Empfänger sowie die verwendete Verteilerliste 
</p>

<h2>Rundbrief senden (erneuter Versand)</h2>

<p style="color:red; font-weight:bold"> Es muss mindestens 1 Stunde abgewartet werden!  </p> 

<!-- Vermutlich sind nicht Abstände, sondern fixe Zeitfenster massgeblich - das muss ich nochmal testen  -->

<p>Für den Folgeversand kann man vom vorherigen Versand 
  den Betreff, den Mailtext sowie den ausgewählten Absender stehen lassen.  
  Neu gewählt werden muss (logischerweise) die Verteilerliste, 
  zudem müssen ggf. gewünschte Anhänge neu hochgeladen werden.   

<p>Ansonsten läuft alles ab wie beim ersten Versand. </p>


<?php
include 'foot.php'; 

?>
