 <?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      $year = date("Y");
      $month = idate("m");
      $Month = date("F");

      $link=mysqli_connect("localhost","root","");
      mysqli_select_db($link,"online_shopping");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=Monthly purchase order.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('PO No', 'Supplier ID', 'PO Date', 'Total'));  
      
      if($month >= 10)
{
  $result = mysqli_query($link, "select * from po where po_date like '_____$month%' and po_date like '$year%'");  
}
else
{
  $result = mysqli_query($link, "select * from po where po_date like '______$month%' and po_date like '$year%'");  
}
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 