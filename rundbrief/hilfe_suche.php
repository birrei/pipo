<?php 
$PageTitle='Hilfe Rundbrief-Versand'; 
include 'head.php'; 
?>

<h1>Suche Verwenden</h1> 

<p>Das Formular steht unter <a href="suche.php">Suche</a> zur Verfügung. </p>

<h2>Filter "Verteilerliste"</h2>
  <p>Auswahl der Verteilerliste</p>

<h2>Filter "Versand freigeschaltet"</h2>
    <p>Mögliche Auswahl: 
        Leer (keine Einschränkung), 
        "ja" (findet nur freigeschaltete Adressen) oder 
        "nein" (findet nur deaktivierte Adressen) </p>

<h2>Suchbegriff</h2>

  <p>
    Es wird parallel in den Feldern "Vorname", "Nachname", "Mailadresse" sowie "Bemerkung" gesucht.
    Groß/Kleinschreibung wird ignoriert. 
  </p>

  <p>
    Eine Mustersuche wird durch das Zeichen "%" ermöglicht. 
  </p>


<h2>Suchabfragen Beispiele</h2>

  <h3>Finde alle deaktivierten Adressen, für die 2026 Zustellfehler dokumentiert wurden</h3>

      <p>
      Filter: 
      <br>- Versand freigeschaltet = "nein". 
      <br>- Suchtext: Zustellfehler%2026 
      </p>
      <!-- 
      <P>Die Eingabe "Zustellfehler%2026" findet gleichzeitig Einträge wie z.B. "Zustellfehler 01.01.2026" und "Zustellfehler 12.12.2026".</P>
       -->

  <h3>Finde alle Einträge, die zum Februar 2026 als Neuzugang dokumentiert wurden </h3>

    <p>
    Filter: 
    <br>- Suchbegriff: "Neu 2026-02" 


    </p>    


<?php
include 'foot.php'; 

?>
