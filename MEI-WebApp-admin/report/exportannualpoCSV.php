 <?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      $link=mysqli_connect("localhost","root","");
      mysqli_select_db($link,"online_shopping");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=annual purchase order.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('PO No', 'Supplier ID', 'PO Date', 'Total'));  
      $year = date("Y");
      $result = mysqli_query($link, "SELECT * from po where po_date like '$year%' ORDER BY po_no");  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 