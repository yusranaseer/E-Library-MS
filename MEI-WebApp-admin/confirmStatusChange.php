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
  text: "Do you really wanna change the status???",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) 
  {
    window.location = "statusChange.php?id=<?php echo $id ?>&name=<?php echo $name ?>";
  } else 
  {<?php
    if($name == "book")
    {?>
        window.location = "book.php";
        <?php
    }
    else if($name == "student")
    {?>
        window.location = "student.php";
        <?php
    }
    else if($name == "staff")
    {?>
        window.location = "staff.php";
        <?php
    }
    else if($name == "innoAccept" || $name == "innoReject")
    {?>
        window.location = "pendingInno.php";
        <?php
    }
    ?>
  }
});
</script>

</body>
</html>