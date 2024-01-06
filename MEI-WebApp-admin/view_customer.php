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
$res= mysqli_query($link,"select * from cus_details where Customer_ID =$id");
while($row=mysqli_fetch_array($res))
{
    $f_name= $row["firstName"];
    $l_name= $row["lastName"];
    $num= $row["contact_number"];
    $email= $row["email"];
    $home= $row["HomeNo"]; 
    $street= $row["street"];
    $city= $row["city"]; 
    $country= $row["country"]; 
    $postal= $row["postalcode"]; 
    $user= $row["username"]; 
    $coins= $row["insite_coins"]; 

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
    grid-template-columns: 0.75fr 1.5fr 0.75fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
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
                <li style="background-color: #444;">
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
                        <div class="heading"><h2>View Customer Details</h2></div><br><hr style="width: 100%;"><br>

                        <form method="POST" enctype="multipart/form-data">

                            <label>Customer Id&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="name" value="<?php echo $id; ?>" readonly>
                            <br><br>

                            <label>First Name&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="name" value="<?php echo $f_name; ?>" readonly>
                            <br><br>

                            <label>Last Name&ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;</label>
                            <input type="text"  value="<?php echo $l_name; ?>" readonly>
                            <br><br>

                            <label>Contact Number&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text"  value="<?php echo $num; ?>" readonly>
                            <br><br>

                            <label>Email&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" value="<?php echo $email; ?>" readonly>
                            <br><br>

                            <label>Home no&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text"  value="<?php echo $home; ?>" readonly>
                            <br><br>

                            <label>Street&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?php echo $street; ?>" readonly>
                            <br><br>

                            <label>City&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?php echo $city; ?>" readonly>
                            <br><br>

                            <label>Country&ensp;&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" value="<?php echo $country; ?>" readonly>
                            <br><br>

                            <label>Postalcode&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?php echo $postal; ?>" readonly>
                            <br><br>

                            <label>Username&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" value="<?php echo $user; ?>" readonly>
                            <br><br>

                            <label>Insite Coins&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?php echo $coins; ?>" readonly>
                            <br><br>

                            <a href="user.php" class="btn" style="font-weight: bold; padding: 10px;">Back</a>
                        </form>
                </div>
                <div></div>
            </div>
            </div>
        </div>
    </div>
</body>



</html>



