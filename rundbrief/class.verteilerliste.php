<?php 
require_once 'conn/class.db.php'; 

class Verteilerliste {
    // Steht für einen Eintrag aus  Tabelle "verteilerlisten" 
    public $ID; // verteilerlist.ID 
    public $Tabelle; // verteilerliste.Tabelle 
    public $Beschreibung; // verteilerliste.Beschreibung 
    public $OrderID; // verteilerliste.OrderID     

    // -----------------
    public $Mitglieder; // die Daten aus [verteilerliste.Tabelle]
    public $row_count=0; // Anzahl Zeilen in [verteilerliste.Tabelle]

    private $db; 
    
    public function __construct($ID){
        $conn=new DBConnection(); 
        $this->db=$conn->db;    

        $this->ID=$ID; 

        $query="SELECT ID, Tabelle, Beschreibung 
                FROM verteilerlisten 
                WHERE ID=:ID "; 

        // echo $query; 
        $select = $this->db->prepare($query); 
        $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);        
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);
        $this->Tabelle = $row["Tabelle"]; 
        $this->Beschreibung = $row["Beschreibung"]; 

    }

    public function getMitglieder(): array {
        $tmpArrMitglieder=[]; 
        $query="SELECT Vorname, Nachname, Mailadresse 
                FROM ".$this->Tabelle." 
                WHERE Freigeschaltet=1  
                ORDER BY Nachname"; 

        // echo $query; 
        $select = $this->db->prepare($query); 
        $select->execute();
        $this->row_count=$select->rowCount(); 
        $tmpArrMitglieder= $select->fetchAll(PDO::FETCH_ASSOC); 
        return $tmpArrMitglieder; 
    }


    public function printTest() {
        echo '<p>'; 
        echo 'ID: '.$this->ID.'<br>';     
        echo 'Tabelle: '.$this->Tabelle.'<br>'; 
        echo 'Beschreibung: '.$this->Beschreibung.'<br>';     
        echo '</p>';  

}



}  

?>