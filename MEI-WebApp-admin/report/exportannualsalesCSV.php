 <?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      $link=mysqli_connect("localhost","root","");
      mysqli_select_db($link,"online_shopping");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=annual sales.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('Order Id', 'Customer ID', 'Order Date', 'Total'));  
      $year = date("Y");
      $result = mysqli_query($link, "SELECT * from tbl_order where order_date like '$year%' ORDER BY order_id");  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 