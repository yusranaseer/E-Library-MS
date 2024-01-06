<?php
session_start();
include('dbcon.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="form.css">
    <script src="sweetalert.min.js"></script>
    <title>MEI | Admin - Verify Account</title>
  </head>
  <body>
    <section class="login">
        <div class="container py-5 text-center text-white screen">
            <div class="row no-gutters">
                <div class="col-lg-4">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="img/1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <p>"What is the value of libraries? Through lifelong learning, libraries can and do change lives, a point that cannot be overstated."</p>
                                <h5>by <span>admin</span></h5>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="img/2.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <p>"Libraries allow children to ask questions about the world and find the answers. And the wonderful thing is that once a child learns to use a library, the doors to learning are always open"</p>
                                <h5>by <span>admin</span></h5>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="img/3.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <p>"The only thing you absolutely have to know, is the location of the library"</p>
                                <h5>by <span>admin</span></h5>
                            </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 py-5 log">
                    <div class="row">
                        <div class="col-lg-7 mx-auto">
                            <h1><span>Verify</span> Code</h1>
                            <p>Put your verification code here</p>
                            <form class="pt-4" method="POST">
                                <div class="form-row py-2">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Verification Code" name="code">
                                    </div>
                                </div>
                                <button class="btn1 mb-3 mt-4" name="submit_btn">Submit Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    <?php
   
	if(isset($_POST["submit_btn"]))
	{			
		$id = $_GET["id"];

		if($_SESSION['code'] == $_POST['code'])
		{
			?>
        		<script type="text/javascript">
					window.location="pwd_reset.php?id=<?php echo $id; ?>";
        		</script>
        	<?php
			session_destroy();
		}
		else
		{
			?>
        		<script type="text/javascript">
					swal({
    					title: "Verification",
    					text: "Invalid Code. Try Again!!!",
    					icon: "error"
					}).then(function() {
    					window.location = "verify.php?id=<?php echo $id; ?>";
					});
        		</script>
        	<?php
		}

	}
	?>


</body>
</html>