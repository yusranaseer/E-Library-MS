 <?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      $link=mysqli_connect("localhost","root","");
      mysqli_select_db($link,"online_shopping");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=annual payments.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('Bill No', 'Order Id', 'Customer ID', 'Total', 'Discount', 'Net Total', 'Payment Method'));  
      $year = date("Y");
      $result = mysqli_query($link, "SELECT * from payment_details where order_id in (select order_id from tbl_order where order_date like '$year%') ORDER BY Bill_no");  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 