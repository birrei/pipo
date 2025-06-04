<?php 
require_once 'conn/class.db.php'; 

class HTMLSelect {
    public $Name=''; 
    public $row_count=0; 

    private $db; 
    
    public function __construct($Name){
        $conn=new DBConnection(); 
        $this->db=$conn->db;    
        $this->Name=$Name; 
    }

    public function getItems(): array {
        $tmpItems=[]; 
        switch ($this->Name) {
            case 'AbsenderID': 
                $query="SELECT ID, Beschreibung as `Name` 
                        FROM Mailadressen 
                        ORDER BY OrderID "; 
                break; 

            case 'VerteilerID': 
                $query="SELECT ID, Beschreibung as `Name`  
                        FROM verteilerlisten 
                        ORDER BY OrderID ";                 
                break; 
        }

        $select = $this->db->prepare($query);      
        $select->execute();
        $this->row_count = $select->rowCount(); 
        $tmpItems=$select->fetchAll(PDO::FETCH_ASSOC);
        return $tmpItems; 
    }

    public function printHTMLSelect($selectedValue='') {
        $Items = $this->getItems(); 
        $strSelect='<select name="'.$this->Name.'">'.PHP_EOL; 
        if(count($Items)==0){
            $strSelect.='<option optionvalue="">(keine Daten vorhanden)</option>'.PHP_EOL;             
        } else {
            foreach($Items as $Item) {
                if($selectedValue!='' & $selectedValue==$Item["ID"]) {
                    $strSelect.='<option value="'.$Item["ID"].'" selected>'.$Item["Name"].'</option>'.PHP_EOL; 
                }
                else{
                    $strSelect.='<option value="'.$Item["ID"].'">'.$Item["Name"].'</option>'.PHP_EOL; 
                }
            }
        }
        $strSelect.='</select>'.PHP_EOL; 
        echo $strSelect; 
    }

    public function printTest() {
        echo '<p><b>Liste Name: '.$this->Name.'</b><br>'; 
        $Items = $this->getItems(); 
        echo 'Anzahl Zeilen (db): '.$this->row_count.'<br>';         
        echo 'Anzahl Items: '.count($Items).'<br>';   
        echo 'Items: <br>';           
        foreach($Items as $Item) {
            echo ' * '.$Item["ID"].' '.$Item["Name"].'<br>';   
        }
       
        echo '</p>';  
    }

}  

?>