<?php 
$PageTitle='Sendlog'; 
include 'head.php'; 
require_once 'class.htmltable.php'; 
require_once 'class.htmlselect.php'; 
?>

<h3 style="display:inline;">Versandlog</h3> 

<p></p>

<?php 

    $query="SELECT * FROM sendlog ORDER BY tstmp DESC "; 

    // echo $query; // test 

    $html_table=new HTML_Table($query); 

    $html_table->print_table(); 

    include 'foot.php'; 

?>

