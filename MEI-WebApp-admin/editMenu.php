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
$res= mysqli_query($link,"select * from menu where menu_id=$id");
while($row=mysqli_fetch_array($res))
{
    $menu_name= $row["menu"];
    $menu_link= $row["menu_link"];
    $menu_order= $row["menu_order"];
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
    <script src="js/sweetalert.min.js"></script>
    <style type="text/css">
.divide-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
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
                <li style="background-color: #444;">
                    <a href="setting.php">
                        <i class="fas fa-cog"></i>
                        <div class="title">Settings</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            
            <?php include("topbar.php"); ?>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div class="tables">
                <div class="divide-3">
                    <div></div>
                    <div class="add">
                    <div class="heading"><h2>Update Menu</h2></div><br><hr><br>

                        <form method="POST" name="add_PO" enctype="multipart/form-data">

                            <label>Menu Name </label>
                            <input type="text" name="mname" id="mname" value="<?php echo $menu_name; ?>">
                            <br><br>

                            <label>Menu Link</label>
                            <input type="text" name="mlink" id="mlink" value="<?php echo $menu_link; ?>">
                            <br><br>

                            <label>Menu Order</label>
                            <input type="text" name="morder" id="morder" value="<?php echo $menu_order; ?>" onkeypress="return validation(event)">
                            <br><br>

                            <input type="submit" name="submit_menu1" value="UPDATE MENU" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                        </form>
                        <?php
                        if(isset($_POST["submit_menu1"]))
                        {

                            $q = "SELECT COUNT(*) FROM menu";     
                            $r = mysqli_query($link, $q);
                            $ro = mysqli_fetch_row($r);
                            $count = $ro[0] + 1;

                            $Q = $_POST["morder"];
                            $intOrder = intval($Q);
                            if($_POST["mname"] == "" || $_POST["mlink"] == "" || $_POST["morder"] == "")
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "User Menu Update",
                                        text: "Fields Can't be empty!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "setting.php";
                                });
                                </script>
                                <?php
                            }
                            else if($intOrder < 1 || $intOrder > $count)
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "User Menu Update",
                                        text: "Invalid Menu Order!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "setting.php";
                                });
                                </script>
                                <?php
                            }
                            else
                            { 
                                $resultset = mysqli_query($link,"select * from menu where menu_order <= '$_POST[morder]' and menu_order > '$menu_order'");
                                while($r = mysqli_fetch_array($resultset))
                                {
                                    $m_id = $r["menu_id"];
                                    mysqli_query($link,"update menu set menu_order = menu_order-1 where menu_id = $m_id ");
                                }

                                $resultset2 = mysqli_query($link,"select * from menu where menu_order <'$menu_order' and menu_order >= '$_POST[morder]'");
                                while($r2 = mysqli_fetch_array($resultset2))
                                {
                                    $m_id = $r2["menu_id"];
                                    mysqli_query($link,"update menu set menu_order = menu_order+1 where menu_id = $m_id");
                                }

                                mysqli_query($link,"update menu set menu = '$_POST[mname]', menu_link = '$_POST[mlink]', menu_order = '$_POST[morder]' where menu_id = $id");


                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "User Menu Update",
                                        text: "Menu updated successfully!!!",
                                        icon: "success"
                                    }).then(function() {
                                    window.location = "setting.php";
                                });
                                </script>
                                <?php
                            }
                        
                        
                        }
                        ?>
                    
                </div>
                <div></div>
            </div>
            </div>
        </div>
    </div>
</body>



</html>



