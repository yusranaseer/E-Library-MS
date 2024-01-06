
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

$user = $_SESSION["admin"];
$res= mysqli_query($link,"select * from admin_login where admin_ID = '$user' ");
while($row=mysqli_fetch_array($res))
{
    $uname= $row["username"];
    $pwd= $row["password"];
    $email= $row["email"];
    $image= $row["admin_img"]; 
}

$web= mysqli_query($link,"select * from website where id = 1 ");
while($row_web=mysqli_fetch_array($web))
{
    $name= $row_web["name"];
    $logo= $row_web["logo"];
}

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
    grid-template-columns: 2fr 1fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-3-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 0.5fr 2fr 0.5fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-3-by-3{
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 2fr;
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
input[type="password"]
{
    color: gray;
    background-color: transparent;
    border-color: transparent;
    border-bottom: 2px solid lightgray;
    height: 25px;
    width: 300px;
}
@media(max-width: 768px){
    .divide-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-3-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-3-by-3{
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
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
                    <a href="setting.php" style="background-color: #444;">
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
                    <div class="add">
                        <div class="heading"><h2>WEBSITE SETTINGS</h2></div><br><hr style="width: 100%;"><br>

                        <form method="POST" enctype="multipart/form-data">
                        <div class="textimg">
                            <div class="text">
                            <br><br>
                            <label>Website Name&ensp;&ensp;  </label>
                            <input type="text" name="name" value="<?php echo $name; ?>" style="width: 250px;">
                            <br><br>

                            <label>Website Logo&ensp;&ensp;&ensp;</label>
                            <input type="file" name="pimage">
                            <br><br>

                            </div>
                            <div class="img-box-update" style="width: 200px; height: 160px;">
                                <img src="img/Website/<?php echo $logo; ?>"/>
                            </div>
                        </div>
                            <br>
                            <input type="submit" name="submit_btn_web" value="UPDATE SETTINGS" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                        </form>
                        <?php
                        if(isset($_POST["submit_btn_web"]))
                        {
                            $fnm=$_FILES["pimage"]["name"];
                            
                            if($_POST["name"] == "")
                            {
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Website Name",
                                        text: "Website Name Can't be empty!!!",
                                        icon: "error"
                                    }).then(function() {
                                    window.location = "setting.php";
                                });
                                </script>
                                <?php
                            }
                            else
                            {
                                if($fnm=="")
                                {

                                    mysqli_query($link,"Update website set name='$_POST[name]' where id = 1");
                    
                                }
                                else
                                {
                                    $v1=rand(1,9);
                                    $v2=rand(1,9);
   
                                    $v3=$v1.$v2;
   
                                    $fnm=$_FILES["pimage"]["name"];
                                    $dst="img/Website/".$v3.$fnm;
                                    $dst1=$v3.$fnm;
                                    move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);
                
                
                                    mysqli_query($link,"Update website set logo='$dst1', name='$_POST[name]' where id = 1");
        
                                }
                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "Website Settings",
                                        text: "Settings updated!!!",
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
                <div class="add">
                    <div class="heading"><h2>ADD NEW MENU</h2></div><br><hr><br>

                        <form method="POST" name="add_PO" enctype="multipart/form-data">

                            <label>Menu Name </label><br>
                            <input type="text" name="mname" id="mname">
                            <br><br>

                            <label>Menu Link </label><br>
                            <input type="text" name="mlink" id="mlink">
                            <br><br>

                            <label>Menu Order </label><br>
                            <input type="text" name="morder" id="morder" onkeypress="return validation(event)">
                            <br><br>

                            <input type="submit" name="submit_menu1" value="ADD MENU" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; margin-top: 12px; cursor:pointer;">
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
                                        title: "User Menu",
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
                                        title: "User Menu",
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
                                $resultset = mysqli_query($link,"select * from menu where menu_order >= '$_POST[morder]'");
                                while($r = mysqli_fetch_array($resultset))
                                {
                                    $m_id = $r["menu_id"];
                                    mysqli_query($link,"update menu set menu_order = menu_order+1 where menu_id = '$m_id' ");
                                }
                                mysqli_query($link,"insert into menu values('','$_POST[morder]','$_POST[mname]','$_POST[mlink]','')");


                                ?>
                                <script type="text/javascript">
                                swal({
                                        title: "User Menu",
                                        text: "Menu added successfully!!!",
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

            </div>
            </div>
            <div class="tables">
                
                <div class="last-appointments">
                    <div class="heading">
                        <h2>User Menu</h2>
                    </div>
                    <table class="product">
                        <thead>
                            <td>Menu Order</td>
                            <td>Menu Name</td>
                            <td>Menu Link</td>
                            <td>Update</td>
                            <td>Delete</td>
                        </thead>
                        <tbody>
                <?php
                
                    $rs_result = mysqli_query ($link, "select * from menu order by menu_order" ); 
                    while($row=mysqli_fetch_array($rs_result))
                    {
                        $type = $row["type"];
                    echo "<tr>";
                    echo "<td>"; echo $row["menu_order"]; echo "</td>";
                    if($type == "")
                    {
                        echo "<td>"; echo $row["menu"]; echo "</td>";
                    }
                    else
                    {
                        echo "<td>"; echo $row["menu"]." (".$row["type"].")"; echo "</td>";
                    }
                    echo "<td>"; echo $row["menu_link"]; echo "</td>";
                    echo "<td>"; ?> <a href="editMenu.php?id=<?php echo $row["menu_id"]; ?>"> <i class="far fa-edit"></i> </a> <?php echo "</td>";
                    if($type == "")
                    {
                        echo "<td>"; ?> <a href="confirm_Delete.php?id=<?php echo $row["menu_id"]; ?>&name=menu"> <i class="far fa-trash-alt"></i> </a> <?php echo "</td>";
                    }
                    else
                    {
                        echo "<td>"; ?> <i class="far fa-trash-alt" style="background-color: black;"></i> <?php echo "</td>";
                    }
                    
                    echo "</tr>";
                    }
                    echo "</table>";
                ?>
                        </tbody>
                    </table>      
                </div>





            </div>
        </div>
    </div>
</body>



</html>



