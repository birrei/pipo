
<?php 

require_once 'conn/class.db.php'; 

class Sendlog {

  public string $Verteilerliste;
  public string $Absender;
  public string $Infotext;
  public string $Status;
  public int $AnzahlEmpfaenger;
  private $db; 
  // public int $ID; // unnötig, da Tabelle nicht bearbeitet wird 
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db;  
  }

  public function insert_row (){

    $this->Infotext = mb_strimwidth($this->Infotext, 0, 2000, '...', 'UTF-8'); 

    $insert = $this->db->prepare("INSERT INTO sendlog   
                                  SET Verteilerliste = :Verteilerliste,  
                                    Absender = :Absender, 
                                    AnzahlEmpfaenger = :AnzahlEmpfaenger, 
                                    Infotext = :Infotext, 
                                    Status = :Status, 
                                    dbname = DATABASE(), 
                                    username = CURRENT_USER(), 
                                    tstmp= CURRENT_TIMESTAMP() 
                                  
                                  ");
          
    $insert->bindParam(':Verteilerliste', $this->Verteilerliste);
    $insert->bindParam(':Absender', $this->Absender);
    $insert->bindParam(':AnzahlEmpfaenger', $this->AnzahlEmpfaenger);
    $insert->bindParam(':Infotext', $this->Infotext);
    $insert->bindParam(':Status', $this->Status);

    try {
      $insert->execute(); 
      // $this->ID=$this->db->lastInsertId(); 
    }
      catch (PDOException $e) {
      echo '<pre>'; 
      echo $e->getMessage(); 
      echo '</pre>'; 
    }
  }  


}
  




?>