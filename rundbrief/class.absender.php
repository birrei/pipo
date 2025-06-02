<?php 
require_once 'conn/class.db.php'; 

class Absender {
    // Steht für einen Eintrag aus  Tabelle "Mailadressen" 
    public $ID; // Mailadressen.ID 
    public $Mailadresse; // Mailadressen.Mailadresse 
    public $Alias; // Mailadressen.Beschreibung 
    public $OrderID; // Mailadressen.OrderID     

    // -----------------

    private $db; 
    
    public function __construct($ID){
        $conn=new DBConnection(); 
        $this->db=$conn->db;    

        $this->ID=$ID; 

        $query="SELECT ID, Mailadresse, Beschreibung as Alias
                FROM Mailadressen 
                WHERE ID=:ID "; 

        // echo $query; 
        $select = $this->db->prepare($query); 
        $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);        
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);
        $this->Mailadresse = $row["Mailadresse"]; 
        $this->Alias = $row["Alias"];        
    }

    

    public function printTest() {
        echo '<p>'; 
        echo 'ID: '.$this->ID.'<br>';     
        echo 'Mailadresse: '.$this->Mailadresse.'<br>'; 
        echo 'Alias: '.$this->Alias.'<br>';     
        echo '</p>';  

}



}  

?>