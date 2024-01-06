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
 $result = mysqli_query($link, "select * from po where po_date like '$year%' ");  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>ADMIN | Annual Purchase Order Report <?php echo $year; ?></title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:50%;">  
                <h3 align="center">Annual Purchase Order Report <?php echo $year; ?></h3>                 
                <br />  
                <form method="post" action="exportannualpoCSV.php" align="center">  
                     <input type="submit" name="export" value="Export as CSV" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">PO No</th>  
                               <th width="5%">Supplier ID</th>  
                               <th width="10%">Supplier Name</th>  
                               <th width="10%">PO Date</th>  
                               <th width="10%">Total</th>  
                               <th width="10%">Products(ID)</th>  
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                          <tr>  
                               <td><?php echo $row["po_no"]; ?></td>  
                               <td><?php echo $row["supplier_id"]; ?></td>  
                               <?php
                               $r = mysqli_query($link, "select s_name from supplier where s_id = $row[supplier_id]");
                               $rw = mysqli_fetch_row($r);
                               $name = $rw[0];

                               ?>
                               <td><?php echo $name; ?></td>  
                               <td><?php echo $row["po_date"]; ?></td>  
                               <td><?php echo $row["total"]; ?></td>
                               <td>
                                <?php
                                  $r1 = mysqli_query($link, "select * from grn where po_no = $row[po_no]");
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