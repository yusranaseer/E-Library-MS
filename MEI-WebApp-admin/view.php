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
$id = $_GET["id"];
$res= mysqli_query($link,"select * from tbl_product where product_id=$id");
while($row=mysqli_fetch_array($res))
{
    $p_name= $row["product_name"];
    $price= $row["product_price"];
    $p_quantity= $row["available_quantity"];
    $product_image= $row["product_image"];
    $category= $row["category"]; 
    $sub_category= $row["sub_category"];
    $des= $row["description"]; 
    $brand= $row["brand"]; 
    $scale= $row["scale"]; 

}

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
    <style type="text/css">
.divide-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 0.25fr 2.5fr 0.25fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.textimg
{
    width: 100%;
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
@media(max-width: 768px){
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
                <li style="background-color: #444;">
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
                    <a href="GRN.php">
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
            <br><br><br><br><br>

            <div class="tables">
                <div class="divide-3">
                    <div></div>
                    <div class="add">
                        <div class="heading"><h2>View Products</h2></div><br><hr style="width: 100%;"><br>

                        <form method="POST" enctype="multipart/form-data">
                        <div class="textimg">
                            <div class="text">

                            <label>Product Id &ensp;&ensp;&ensp;&ensp;&ensp;  </label>
                            <input type="text" name="name" value="<?php echo $id; ?>" readonly>
                            <br><br>

                            <label>Product Name &ensp;   </label>
                            <input type="text" name="name" value="<?php echo $p_name; ?>" readonly>
                            <br><br>

                            <label>Product Price &ensp;&ensp;&nbsp;</label>
                            <input type="text"  value="<?php echo $price; ?>" readonly>
                            <br><br>

                            <label>Quantity &ensp;&ensp;&ensp; &ensp; &ensp; &nbsp;</label>
                            <input type="text"  value="<?php echo $p_quantity; ?>" readonly>
                            <br><br>

                            <label>Category &ensp;&ensp;&ensp; &ensp; &ensp; </label>
                            <input type="text" value="<?php echo $category; ?>" readonly>
                            <br><br>

                            <label>Sub category&ensp;&ensp;&ensp; </label>
                            <input type="text"  value="<?php echo $sub_category; ?>" readonly>
                            <br><br>

                            <label>Scale &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; &ensp; &nbsp;</label>
                            <input type="text" value="<?php echo $scale; ?>" readonly>
                            <br><br>

                            <label>Brand &ensp;&ensp;&ensp;&ensp;&ensp; &ensp; &ensp; &nbsp;</label>
                            <input type="text" value="<?php echo $brand; ?>" readonly>
                            <br><br>

                            <label>Description &ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" value="<?php echo $des; ?>" readonly>
                            <br><br>

                            </div>
                            <div class="img-box-update">
                                <img src="../user/<?php echo $product_image;?>" />
                            </div>
                        </div>
                            <br><br>
                            <a href="product.php" class="btn" style="font-weight: bold; padding: 10px;">Back</a>
                        </form>
                </div>
                <div></div>
            </div>
            </div>
        </div>
    </div>
</body>



</html>



