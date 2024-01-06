<?php
session_start();
if($_SESSION["admin"]=="")
{
?>
<script type="text/javascript">
window.location="admin_login.php";
</script>
<?php
}

$link=mysqli_connect("localhost","root","");
mysqli_select_db($link,"online_shopping");
$year = date("Y");
$month = idate("m");
$Month = date("F");
if($month >= 10)
{
  $result = mysqli_query($link, "select * from payment_details where order_id in (select order_id from tbl_order where order_date like '_____$month%' and order_date like '$year%')");  
}
else
{
  $result = mysqli_query($link, "select * from payment_details where order_id in (select order_id from tbl_order where order_date like '______$month%' and order_date like '$year%')"); 
}
 
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>ADMIN | Monthly Payments Report <?php echo $Month; echo " "; echo $year; ?></title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:60%;">  
                <h3 align="center">Monthly Payments Report <?php echo $Month; echo " "; echo $year; ?></h3>                 
                <br />  
                <form method="post" action="exportmonthlypaymentsCSV.php" align="center">  
                     <input type="submit" name="export" value="Export as CSV" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">Bill No</th>
                               <th width="5%">Order ID</th>  
                               <th width="5%">Customer ID</th>  
                               <th width="10%">Total</th>  
                               <th width="10%">Discount</th>  
                               <th width="10%">Net Total</th>  
                               <th width="15%">Payment Method</th>  
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                          <tr> 
                               <td><?php echo $row["Bill_no"]; ?></td>   
                               <td><?php echo $row["order_id"]; ?></td>  
                               <td><?php echo $row["Customer_ID"]; ?></td>  
                               <td><?php echo $row["total"]; ?></td>  
                               <td><?php echo $row["discount"]; ?></td>
                               <td><?php echo $row["net_total"]; ?></td>
                               <td><?php echo $row["payment_method"]; ?></td>
                          </tr>  
                     <?php       
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  