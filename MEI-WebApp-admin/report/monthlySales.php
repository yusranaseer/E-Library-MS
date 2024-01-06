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
  $result = mysqli_query($link, "select * from tbl_order where order_date like '_____$month%' and order_date like '$year%'");  
}
else
{
  $result = mysqli_query($link, "select * from tbl_order where order_date like '______$month%' and order_date like '$year%'");  
}
 
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>ADMIN | Monthly Sales Report <?php echo $Month; echo " "; echo $year; ?></title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:50%;">  
                <h3 align="center">Monthly Sales Report <?php echo $Month; echo " "; echo $year; ?></h3>                 
                <br />  
                <form method="post" action="exportmonthlysalesCSV.php" align="center">  
                     <input type="submit" name="export" value="Export as CSV" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">Order ID</th>  
                               <th width="5%">Customer ID</th>  
                               <th width="10%">Username</th>  
                               <th width="10%">Order Date</th>  
                               <th width="10%">Total</th>  
                               <th width="10%">Products(ID)</th>  
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                          <tr>  
                               <td><?php echo $row["order_id"]; ?></td>  
                               <td><?php echo $row["Customer_ID"]; ?></td>  
                               <?php
                               $r = mysqli_query($link, "select username from cus_details where Customer_ID = $row[Customer_ID]");
                               $rw = mysqli_fetch_row($r);
                               $name = $rw[0];

                               ?>
                               <td><?php echo $name; ?></td>  
                               <td><?php echo $row["order_date"]; ?></td>  
                               <td><?php echo $row["total"]; ?></td>
                               <td>
                                <?php
                                  $r1 = mysqli_query($link, "select * from order_product where order_id = $row[order_id]");
                                  while($rw1 = mysqli_fetch_array($r1))
                                  {
                                      echo $rw1["product_id"]; echo ", ";
                                  }
                               ?>
                             </td>


                          </tr>  
                     <?php       
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  