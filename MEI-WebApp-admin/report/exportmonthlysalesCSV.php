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
      header('Content-Disposition: attachment; filename=Monthly sales.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('Order Id', 'Customer ID', 'Order Date', 'Total'));  
      
      if($month >= 10)
      {
            $result = mysqli_query($link, "select * from tbl_order where order_date like '_____$month%' and order_date like '$year%' ORDER BY order_id");  
      }
      else
      {
            $result = mysqli_query($link, "select * from tbl_order where order_date like '______$month%' and order_date like '$year%' ORDER BY order_id");  
      }
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 