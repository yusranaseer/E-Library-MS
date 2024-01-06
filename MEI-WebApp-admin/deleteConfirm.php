<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/sweetalert.min.js"></script>
</head>
<body>

<?php

$id = $_GET["id"];
$name = $_GET["name"];

?>
<script type="text/javascript">
 swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!!!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) 
  {
    window.location = "deleteResources.php?id=<?php echo $id ?>&name=<?php echo $name ?>";
  } else 
  {<?php
    if($name == "practicle")
    {?>
        window.location = "resources.php";
        <?php
    }
    else if($name == "past")
    {?>
        window.location = "past.php";
        <?php
    }
    else if($name == "news")
    {?>
        window.location = "news.php";
        <?php
    }
    ?>
  }
});
</script>

</body>
</html>