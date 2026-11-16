<?php 
$PageTitle='Hilfe'; 
include 'head.php'; 

?>

<h1>Hilfe zum Rundbrief-Versand (ENTWURF) </h1> 


<pre>
    
... Nach dem Absenden des Formulars wird ein Infotext angezeigt. 
    Das Formular wird wieder angezeigt und kann 
    für den nächsten Versand (nach 1 Stunde) wieder verwendet werden.
     Also: Für den nächsten Versand die Seite einfach stehen lassen. 
    Betreff, Mailtext und ausgewählte Verteilerliste bleiben erhalten.
    Anhänge müssen jedoch neu hochgeladen werden. 
   
    
</pre>



<h1>Neue Einteilung der Rundbrief-Verteilerliste ( ENTWURF!) </h1> 

<pre> 

Aktuell 4 Views, von denen jede einen Teil der Kompletten Tabelle "Newsletter" anzeigt. 

Eine Liste enthält max. 200 Adressen. Die erlaubt Höchstzahl ist zwar 250 Mails, allerdings wird ein grosser Sicherheitspuffer 
empfohlen, da immer weider bei einem Versandvorgang einzelne Adressen nicht gleich zugestellt werden können, 
die Zustellversuche werden dann zusätzlich gezählt.

Liste 4 ist die letzte Liste und hat noch Platz. Falls sie auch bei 200 Adressen ankommt, sollte eine neue Liste 5 erstellt werden. 
Ggf. kann die Einteilung auch ganhz neu vorgenonmen werden, da ja bei Listen 1 - 3 immer wieder mal welche rausfallen. 

Hilfs-Abfragen, mit deren Hilfe die Einteilung vorgenommen wurde: 
<a href="https://github.com/birrei/pipo/blob/main/sql/Newsletter_Aufteilung-Test2_200er-Gruppen.sql" target="_blank">Newsletter_Aufteilung-Test2_200er-Gruppen.sql</a> 



Aktuelle Einteilung: 

* View: Newsletter_01, Name: Rundbrief Standardliste - Teil 1
  Inhalt: Einträge aus Tabelle "Newsletter" mit  ID 1 - 398 

* View: Newsletter_02, Name: Rundbrief Standardliste - Teil 2
  Inhalt: Einträge aus Tabelle "Newsletter" mit  ID  399 - 830

* View: Newsletter_03, Name: Rundbrief Standardliste - Teil 3
  Inhalt: Einträge aus Tabelle "Newsletter" mit  ID  831 -  1099 

* View: Newsletter_04, Name: Rundbrief Standardliste - Teil 4
  Inhalt: Einträge aus Tabelle "Newsletter" mit  ID  >  1099



</pre>


<h1>FAQ</h1> 

<h2> Wie kann ich sehen, wo Verteilerlisten und Empfänger gespeichert sind? </h2>

<p>Der Inhalt der der Verteilerlisten kann über die <a href="suche.php">Suche</a> abgerufen werden. 
In der Ergebnistabelle unter der Spalte "Tabelle" wird die Tabelle (bzw. die View) angezeigt, 
in der die Empfänger in der Datenbank verfügbar sind. 
</p>


<h2>Wo kann der Code der Rundbrief-Anwendung eingesehen werden?</h2>

<p> Siehe <a href="https://github.com/birrei/pipo" target="_blank">Repository auf GitHub</a></p> 



<?php
include 'foot.php'; 

?>
