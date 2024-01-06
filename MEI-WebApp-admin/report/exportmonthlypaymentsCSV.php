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
      fputcsv($output, array('Bill No', 'Order Id', 'Customer ID', 'Total', 'Discount', 'Net Total', 'Payment Method')); 
      
      if($month >= 10)
{
  $result = mysqli_query($link, "select * from payment_details where order_id in (select order_id from tbl_order where order_date like '_____$month%' and order_date like '$year%')");  
}
else
{
  $result = mysqli_query($link, "select * from payment_details where order_id in (select order_id from tbl_order where order_date like '______$month%' and order_date like '$year%')"); 
}
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?> 