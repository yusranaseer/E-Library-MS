<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/sweetalert.min.js"></script>
</head>
<body>



<?php
$link=mysqli_connect("localhost","root","");
mysqli_select_db($link,"online_shopping");
$id=$_GET["id"];
mysqli_query($link,"delete from category where category_id= $id ");
?>

<script type="text/javascript">
    swal({
        title: "Category",
        text: "Category deleted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "category.php";
    });
</script>
</body>
</html>