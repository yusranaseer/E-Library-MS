<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/sweetalert.min.js"></script>
</head>
<body>
<?php
$link = mysqli_connect("localhost","root","");
mysqli_select_db($link,"online_shopping");
$id = $_GET["id"];

$rs = mysqli_query($link, "select menu_order from menu where menu_id = $id");
$row = mysqli_fetch_row($rs);
$menu_order = $row[0];

$rs_new = mysqli_query($link, "select * from menu where menu_order > $menu_order");
while($rownew = mysqli_fetch_array($rs_new))
{
	$menu_id = $rownew["menu_id"];
	mysqli_query($link,"update menu set menu_order = menu_order-1 where menu_id = $menu_id");
}

mysqli_query($link, "delete from menu where menu_id = $id");
?>

<script type="text/javascript">
    swal({
        title: "Menu",
        text: "Menu deleted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "setting.php";
    });
</script>

</body>
</html>