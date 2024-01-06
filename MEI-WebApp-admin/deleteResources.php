<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/sweetalert.min.js"></script>
</head>
<body>

<?php

include("dbcon.php"); 

$id = $_GET["id"];
$name = $_GET["name"];
if($name == "practicle")
{
    $table = 'practicle';
	$firestore->collection($table)->document($id)->delete();
	?>
	<script type="text/javascript">
    swal({
        title: "Practicle",
        text: "deleted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "resources.php";
    });
	</script>
	<?php
}
else if($name == "past")
{
	$table = 'pastpaper';
    $firestore->collection($table)->document($id)->delete();
	?>
	<script type="text/javascript">
    swal({
        title: "Pastpaer",
        text: "deleted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "past.php";
    });
	</script>
	<?php
}
else if($name == "news")
{
	$table = 'newspaper';
    $firestore->collection($table)->document($id)->delete();
	?>
	<script type="text/javascript">
    swal({
        title: "Newspaper",
        text: "deleted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "news.php";
    });
	</script>
	<?php
}

?>
</body>
</html>