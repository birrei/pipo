<?php 
// Kopie aus ndb-projekt, noch bereinigen XXX 
require_once 'conn/class.db.php'; 

class HTML_Table {
    private $db; 
    private $select; 
    private $result; 
    public $query=''; 

    private $count_cols; 
    private $count_rows; 
    

    
    function __construct($query) {

        // echo '<pre>'.$query.'</pre>'; 
        $conn=new DBConnection(); 
        $this->db=$conn->db;    

        $this->select = $this->db->prepare($query); 
        // $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);        
        $this->select->execute(); 
        $this->result = $this->select->fetchAll(PDO::FETCH_ASSOC);
        $this->count_cols=$this->select->columnCount(); 
        $this->count_rows=$this->select->rowCount(); 

        // echo '<pre> Anzahl Zeilen: '.$this->count_rows.'</pre>'; // Test 
        // echo '<pre> Anzahl Spalten: '.$this->count_cols.'</pre>'; // Test 
    }
    
    
    function print_table() {

        $html = ''. PHP_EOL;

        // $html.= $this->caption!=''?'<h4>'.$this->caption.'</h4>':'';         

        if ($this->count_cols > 0 & $this->count_rows > 0){
            
            $html.= '<style>

            table {
                border: 1px solid black;
                border-collapse: collapse; 
                font-size: 10pt;  
                margin: 0px; 
                padding: 0px;
            }
            td, th {
                text-align: left;
                vertical-align: top; 
            }                
            th {
                border: 1px solid black;
                background-color: lightgrey;    
                padding: 1px;       
            }
            td {
                border: 1px solid black;   
            background-color: white;                    
                padding: 2px;   
            }
        
            </style>'. PHP_EOL;   

            $html.= '<table class="resultset">'. PHP_EOL;

            $html.= '<thead>'. PHP_EOL;
            $html.= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->select->getColumnMeta($i); // assoz. array 
                $html .= '<th class="resultset">'.$colmeta['name'].'</th>'. PHP_EOL;    
            }
 
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';

            if  ($this->count_rows > 0) {
                $html .= '<tbody>';                
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $key=>$cell){
                        $html .= '<td class="resultset">'.$cell.'</td>'. PHP_EOL;
                    }

                    $html .= '</tr>'. PHP_EOL;
                } 
                $html .= '</tbody>'. PHP_EOL;   
            }
            $html .= '</table>'. PHP_EOL; 
            $html .= '<p>'.$this->count_rows.' Treffer</p>'; 
        }

        echo $html;
    }



    
    // function print_table_checklist($checkbox_name) {
    //     /* $select: Tabelle Spalten ID, Name */
    //     $html = ''. PHP_EOL;

    //     if ($this->count_cols > 0 & $this->count_rows > 0){
    //         $html.= '<table class="checkboxtable">'. PHP_EOL;

    //         if  ($this->count_rows > 0) {
    //             $html .= '<tbody>';                
    //             foreach ($this->result as $row) {
    //                 $html .= '<tr>'. PHP_EOL;
    //                 if($this->add_link_edit & $this->edit_link_table!='') {
    //                     $html .= '      <td class="checkboxtable"><label><input type="checkbox" name="'.$checkbox_name.'[]" value="'.$row["ID"].'"> '.$row["Name"].' </label> <a href="edit_'.$this->edit_link_table.'.php?ID='.$row["ID"].'" target="_blank">Bearbeiten</a></td>'. PHP_EOL; 
    //                 }
    //                 else {
    //                     $html .= '      <td class="checkboxtable"><label><input type="checkbox" name="'.$checkbox_name.'[]" value="'.$row["ID"].'"> '.$row["Name"].' </label> </td>'. PHP_EOL; 
    //                 }
    //                 $html .= '</tr>'. PHP_EOL;
    //             } 
    //             $html .= '</tbody>'. PHP_EOL;   
    //         }
    //         $html .= '</table>'. PHP_EOL; 
    
    //     }
    //     echo $html;
    // }
       

    // function datum_umwandeln($datum_string) {
    //     // Gemini ... 
    //     // Erstelle ein DateTime-Objekt aus dem Eingabe-String
    //     $datum_objekt = DateTime::createFromFormat('Y-m-d', $datum_string);
    
    //     // Überprüfe, ob das Datum erfolgreich erstellt wurde
    //     if ($datum_objekt) {
    //         // Formatiere das Datum in das gewünschte Format 'TT.MM.JJJJ'
    //         return $datum_objekt->format('d.m.Y');
    //     } else {
    //         // Gib einen Fehler zurück, wenn das Datum ungültig ist
    //         return "Ungültiges Datumsformat";
    //     }
    // }

    // function getFormattedDate($date_in) {
    //     //  return $date_in; 
    //     if (gettype($date_in) == 'NULL') {
    //         return $date_in; 
    //     } else {
    //         $date = new DateTimeImmutable($date_in);
    //         return $date->format('d.m.Y');
    //     }
    // }

    
//     function print_table_tablelist() {
//         /* 
//         Verwendung in list_tables.php
//         einspaltige Tabelle mit Objekt-Namen, die als Link ausgegeben werden  
//         */
 
//         $html = '';

//         if ($this->count_cols > 0 & $this->count_rows > 0)
//         {
//             $html = '<table>';
//             // header 
//             $html .= '<thead>';
//             $html .= '<tr>'. PHP_EOL;
//             for($i = 0; $i < $this->count_cols; ++$i) {
//                 $colmeta=$this->select->getColumnMeta($i); // assoz. array 
//                 $html .= '<th>'.$colmeta['name'].'</th>';    
//             }
       
//             $html .=  '</tr>'. PHP_EOL;
//             $html .= '</thead>';
//             // zeilen  
//             if  ($this->count_rows > 0) {
//                 foreach ($this->result as $row) {
//                     $html .= '<tr>'. PHP_EOL;
//                     foreach ($row as $key=>$cell){
//                         // echo $key; 
//                         $html .= '<td><a href="show_table2.php?table='.$cell.'">'.$cell.'</a></td>';                        

//                     }
                    
//                     $html .= '</tr>'. PHP_EOL;
//                 } 
//             }
//             $html .= '</table>'; 
//         }
//         else {
//            $html .= '<p>Keine Daten vorhanden.</p> '; 
//         }
//         echo $html;
//     }


 }


?>