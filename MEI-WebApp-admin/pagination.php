<?php
$per_page_record = 25;       
if (isset($_GET["page"])) {    
      $page  = $_GET["page"];    
 }    
 else {    
       $page=1;    
 }    
     
 $start_from = (($page-1) * $per_page_record)+1; 
?>