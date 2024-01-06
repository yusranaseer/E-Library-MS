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

include("pagination.php");     
    
 $query = "SELECT * FROM grn LIMIT $start_from, $per_page_record";     
 $rs_result = mysqli_query ($link, $query); 

$user = $_SESSION["admin"];
$res1= mysqli_query($link,"select * from admin_login where admin_ID = '$user' ");
while($row1=mysqli_fetch_array($res1))
{  $image= $row1["admin_img"]; }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produc.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="js/sweetalert.min.js"></script>
    <style type="text/css">
        input, button{   
        height: 34px;   
    } 
    .textimg
{
    width: 100%;
    display: grid;
    grid-template-columns: 1.5fr 1.5fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
@media(max-width: 768px){
    thead{
        display: none;
    }
    tbody, tr, td{
        display: block;
        width: 100%;
    }
    tr{
        margin-bottom: 15px;
    }
     tbody tr td{
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
     td:before{
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: 600;
        font-size: 14px;
        text-align: left;
    }

     .textimg
{
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
}
    </style>

    <title>Admin panel</title>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <?php include("admin_logo.php"); ?>
                <li>
                    <a href="dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="product.php">
                        <i class="fab fa-product-hunt"></i>
                        <div class="title">Products</div>
                    </a>
                </li>
                <li>
                    <a href="category.php">
                        <i class="fab fa-product-hunt"></i>
                        <div class="title">Product Categories</div>
                    </a>
                </li>
                <li>
                    <a href="order.php">
                        <i class="fad fa-cart-arrow-down"></i>
                        <div class="title">Orders</div>
                    </a>
                </li>
                <li>
                    <a href="user.php">
                        <i class="fas fa-user"></i>
                        <div class="title">User Details</div>
                    </a>
                </li>
                <li>
                    <a href="payment.php">
                        <i class="fas fa-hand-holding-usd"></i>
                        <div class="title">Payments</div>
                    </a>
                </li>
                <li>
                    <a href="p_order.php">
                        <i class="fas fa-cart-arrow-down"></i>
                        <div class="title">Purchase Orders</div>
                    </a>
                </li>
                <li>
                    <a href="supplier.php">
                        <i class="fas fa-user-circle"></i>
                        <div class="title">Suppliers Details</div>
                    </a>
                </li>
                <li>
                    <a href="GRN.php" style="background-color: #444;">
                        <i class="fas fa-coins"></i>
                        <div class="title">GRN</div>
                    </a>
                </li>
                <li>
                    <a href="invoice.php">
                        <i class="fad fa-clipboard-list-check"></i>
                        <div class="title">Supplier Invoice</div>
                    </a>
                </li>
                <li>
                    <a href="reports.php">
                        <i class="fad fa-book"></i>
                        <div class="title">Reports</div>
                    </a>
                </li>
                <li>
                    <a href="setting.php">
                        <i class="fas fa-cog"></i>
                        <div class="title">Settings</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <?php include("topbar.php"); ?>
            <?php include("cards.php"); ?>
            
            <div class="tables">
                
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Good Receive Note</h2>
                    </div>
                    <table class="product">
                        <thead>
                            <td>GRN No</td>
                            <td>GRN Date</td>
                            <td>PO No</td>
                            <td>Supplier Name</td>
                            <td>Product ID</td>
                            <td>Product Name</td>
                            <td>Quantity</td>
                            <td>Buy Price</td>
                            <td>Total</td>
                        </thead>
                        <tbody>
                            <?php
                
                    
                    while($row=mysqli_fetch_array($rs_result))
                    {
                    echo "<tr>";
                    echo "<td data-label='#'>"; echo $row["GRN_no"]; echo "</td>";
                    echo "<td data-label='GRN Date'>"; echo $row["GRN_date"]; echo "</td>";
                    echo "<td data-label='PO No'>"; echo $row["po_no"]; echo "</td>";

                    $po_no = $row["po_no"];
                    $r1 = mysqli_query($link,"select * from po where po_no = $po_no ");
                    while($rw1=mysqli_fetch_array($r1))
                    {
                        $c_id = $rw1["supplier_id"];
                        $r2 = mysqli_query($link,"select * from supplier where s_id = $c_id ");
                        while($rw2=mysqli_fetch_array($r2))
                        {
                            echo "<td data-label='Supplier Name'>"; echo $rw2["s_name"]; echo "</td>";
                        }
                    }

                    echo "<td data-label='Product Id'>"; echo $row["product_id"]; echo "</td>";

                    $prod_id = $row["product_id"];
                    $r3 = mysqli_query($link,"select * from tbl_product where product_id = $prod_id ");
                    while($rw3=mysqli_fetch_array($r3))
                    {    
                        echo "<td data-label='Product Name'>"; echo $rw3["product_name"]; echo "</td>";
                    }

                    echo "<td data-label='Quantity'>"; echo $row["product_quantity"]; echo "</td>";
                    echo "<td data-label='Buy Price'>"; echo $row["product_buying_price"]; echo "</td>";
                    echo "<td data-label='Total'>"; echo $row["total"]; echo "</td>";
                    echo "</tr>";
                    }
                    echo "</table>";
                ?>
                        </tbody>
                    </table>
                         <div class="pagination">    
                            <?php  
                            $query = "SELECT COUNT(*) FROM grn";     
                            $rs_result = mysqli_query($link, $query);     
                            $row = mysqli_fetch_row($rs_result);     
                            $total_records = $row[0];     
          
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='GRN.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='GRN.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='GRN.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='GRN.php?page=".($page+1)."'>  Next </a>";   
                            }   
  
                            ?>    
                        </div> 

                        <div class="inline">   
                            <input id="page" type="number" min="1" max="<?php echo $total_pages?>" placeholder="<?php echo $page."/".$total_pages; ?>" required>   
                            <button onClick="go2Page();" class="btn" style="border: none;">Go</button>   
                        </div>
                </div>

                <section id="add">
                <div class="divide-2">
                    <div></div>
                    <div class="add">
                        <div class="heading"><h2>Add Good Receive Note for New Products</h2></div><br><hr><br>

                        <form method="POST" name="add_grn" enctype="multipart/form-data">
                        <div class="textimg">
                        <div>
                            <label>GRN Date&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&nbsp;&ensp;&nbsp;&ensp;&ensp;</label>
                            <input type="date" name="grn_date" id="grn_date" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>

                            <label>Purchase Order No&nbsp;&ensp;</label>
                            <input type="text" name="po_no" id="po_no" onkeypress="return validation(event)">
                            <br><br>

                            <label>Product Id&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="pid" id="pid" onkeypress="return validation(event)">
                            <br><br>

                            <label>Product Name&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="name" id="name">
                            <br><br>

                            <label>Quantity&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="qty" id="qty" onkeypress="return validation(event)">
                            <br><br>

                            <label>Buying Price&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="Bprice" id="Bprice" onkeypress="return validation(event)">
                            <br><br>

                            <label>Selling Price&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="Sprice" id="Sprice" onkeypress="return validation(event)">
                            <br><br><br>

                        </div>
                        <div>
                            <label>Category&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <select name="pcategory">
                                <option disabled selected> Select a Category</option> 
                                <?php 
                                $r = mysqli_query($link,"select * from category");

                                while ($rw=mysqli_fetch_array($r)) {
                                    
                                    echo "<option>".$rw["category_name"]."</option>"; 
                                }

                                ?> 
                            </select>
                            <br><br>

                            <label>Sub Category&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <select name="psubcategory">
                                <option disabled selected> Select a Sub category</option> 
                                <?php 
                                $r = mysqli_query($link,"select * from sub_category");

                                while ($rw=mysqli_fetch_array($r)) {
                                    
                                    echo "<option>".$rw["category_name"]."</option>"; 
                                }

                                ?> 
                            </select>
                            <br><br>

                            <label>Scale&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="scale" id="scale">
                            <br><br>

                            <label>Brand&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" name="brand" id="brand">
                            <br><br>

                            <label>Description&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="des" id="des">
                            <br><br>

                            <label>Product Image&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="file" name="pimage">
                            <br><br><br><br>

                            <input type="submit" name="submit_btn" value="ADD" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                            </div>
                        </form>
                        </div>
                        <?php
                        if(isset($_POST["submit_btn"]))
                        {
                            $Q = $_POST["qty"];
                            $intQ = floatval($Q);

                            $Q1 = $_POST["Bprice"];
                            $intQ1 = floatval($Q1);

                            $Q3 = $_POST["pid"];
                            $intQ3 = floatval($Q3);

                            $Q4 = $_POST["Sprice"];
                            $intQ4 = floatval($Q4);

                            //product image
                            $v1=rand(1,9);
                            $v2=rand(1,9);
   
                            $v3=$v1.$v2;
   
                            $fnm=$_FILES["pimage"]["name"];
                            $dst="../user/images/shop/".$v3.$fnm;
                            $dst1="images/shop/".$v3.$fnm;
                            move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);
                            //end product image

                            $querynew = "SELECT COUNT(*) FROM po where po_no = '$_POST[po_no]'";     
                            $rs_resultnew  = mysqli_query($link, $querynew );
                            $rownew = mysqli_fetch_row($rs_resultnew); 
                            $po = $rownew[0]; 

                            $querynew1 = "SELECT COUNT(*) FROM tbl_product where product_id = '$_POST[pid]'";     
                            $rs_resultnew1  = mysqli_query($link, $querynew1 );
                            $rownew1 = mysqli_fetch_row($rs_resultnew1); 
                            $product = $rownew1[0];

                            if($_POST["po_no"] == "" || $_POST["grn_date"] == "" || $_POST["pid"] == "" || $_POST["qty"] == "" || $_POST["Bprice"] == "" || $_POST["pcategory"] == "" || $_POST["brand"] == "" || $_POST["des"] == "" || $_POST["name"] == "" || $_POST["Sprice"] == "")
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Fields Can't be empty!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if($intQ3 < 1 || $intQ1 < 1 || $intQ < 1 || $intQ4 < 1)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Numeric fields error!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if($po == 0)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Invalid Purchase No!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if($product != 0)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Product is already exist!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if ($fnm == "") 
                            {
                                ?>
                                    <script type="text/javascript">
                                    swal({
                                        title: "Good Recieve Note",
                                        text: "Product Image Required!!!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "GRN.php";
                                    });
                                    </script>
                                <?php
                            }
                            else
                            {
 
                                    
                                    
                                $total =  floatval($_POST["qty"]) * floatval($_POST["Bprice"]);
                                mysqli_query($link,"insert into grn values('','$_POST[grn_date]','$_POST[po_no]','$_POST[pid]','$_POST[qty]','$_POST[Bprice]',$total)");
                                mysqli_query($link,"insert into tbl_product values('$_POST[pid]','$_POST[name]','$_POST[Sprice]','$_POST[qty]','$dst1','$_POST[des]','$_POST[pcategory]','$_POST[psubcategory]','$_POST[brand]','$_POST[scale]')");

                                ?>
                                <script type="text/javascript">
                                    swal({
                                        title: "Good Recieve Note",
                                        text: "GRN added successfully!!!",
                                        icon: "success"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                    });
                                </script>
                                <?php
                                
                            }
                        
                        
                        }
                        ?>
                    </div>
                    <br><br>
                    <div class="divide-2">
                    <div></div>
                    <div class="add">
                        <div class="heading"><h2>Add Good Receive Note for Existing Products</h2></div><br><hr><br>

                        <form method="POST" name="add_grn" enctype="multipart/form-data">
                        <div class="textimg">
                        <div>
                            <label>GRN Date&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&nbsp;&ensp;&nbsp;&ensp;&ensp;</label>
                            <input type="Date" name="grn_date" id="grn_date" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>

                            <label>Purchase Order No&nbsp;&ensp;</label>
                            <input type="text" name="po_no" id="po_no" onkeypress="return validation(event)">
                            <br><br><br>

                        </div>
                        <div>
                            <label>Product Id&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="pid" id="pid" onkeypress="return validation(event)">
                            <br><br>

                            <label>Quantity&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="qty" id="qty" onkeypress="return validation(event)">
                            <br><br><br>

                            <input type="submit" name="submit_btn2" value="ADD" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                            </div>
                        </form>
                        </div>
                        <?php
                        if(isset($_POST["submit_btn2"]))
                        {
                            $Q = $_POST["qty"];
                            $intQ = floatval($Q);

                            $Q3 = $_POST["pid"];
                            $intQ3 = floatval($Q3);


                            $querynew = "SELECT COUNT(*) FROM po where po_no = '$_POST[po_no]'";     
                            $rs_resultnew  = mysqli_query($link, $querynew );
                            $rownew = mysqli_fetch_row($rs_resultnew); 
                            $po = $rownew[0]; 

                            $querynew1 = "SELECT COUNT(*) FROM tbl_product where product_id = '$_POST[pid]'";     
                            $rs_resultnew1  = mysqli_query($link, $querynew1 );
                            $rownew1 = mysqli_fetch_row($rs_resultnew1); 
                            $product = $rownew1[0];

                            if($_POST["po_no"] == "" || $_POST["grn_date"] == "" || $_POST["pid"] == "" || $_POST["qty"] == "")
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Fields Can't be empty!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if($intQ3 < 1 || $intQ < 1)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Numeric fields error!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                             else if($po == 0)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Invalid Purchase No!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else if($product == 0)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Good Recieve Note",
                                        text: "Product doesn't exist!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                });
                                </script>
                                <?php
                            }
                            else
                            {


                                $result_price = mysqli_query($link, "select product_buying_price from grn where product_id = '$_POST[pid]' "); 
                                $row_price = mysqli_fetch_assoc($result_price); 
                                $price = $row_price['product_buying_price'];

                                $total =  floatval($_POST["qty"]) * floatval($price);
                                mysqli_query($link,"insert into grn values('','$_POST[grn_date]','$_POST[po_no]','$_POST[pid]','$_POST[qty]',$price,$total)");

                                $result_qty = mysqli_query($link, "select available_quantity from tbl_product where product_id = '$_POST[pid]' "); 
                                $row_qty = mysqli_fetch_assoc($result_qty); 
                                $qty = $row_qty['available_quantity'];

                                $qty = $qty + $_POST["qty"];
                                mysqli_query($link,"update tbl_product set available_quantity = '$qty' where product_id = '$_POST[pid]' ");

                                ?>
                                <script type="text/javascript">
                                    swal({
                                        title: "Good Recieve Note",
                                        text: "GRN added successfully!!!",
                                        icon: "success"
                                    }).then(function() {
                                    window.location = "GRN.php";
                                    });
                                </script>
                                <?php
     
                            }
                        
                        }
                        ?>
                    </div>
                    <div></div>
                </div>
            </section>
                            <script>   
                            function go2Page()   
                            {   
                                var page = document.getElementById("page").value;   
                                page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
                                window.location.href = 'GRN.php?page='+page;   
                            }   
                        </script>
            </div>
        </div>
    </div>
</body>
</html>



