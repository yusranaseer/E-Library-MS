<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <title>MEI | Home</title>
  <style type="text/css">
    #hero{
  background-image: url(./img/bgnew.jpg);
  background-size: cover;
  background-position: top center;
  position: relative;
  z-index: 1;
}
  </style>
</head>
<body>

  <!-- Header Section  -->
  <section id="header">
    <div class="header container">
      <div class="nav-bar">
        <div class="brand">
          <a href=""><h1><span>M</span>E<span>I</span></h1></a>
        </div>
        <div class="nav-list">
          <div class="hamburger"><div class="bar"></div></div>
          <ul>
            <li><a href="#hero" data-after=""></a></li>
            <li><a href="" data-after=""></a></li>
            <li><a href="" data-after=""></a></li>
            <li><a href="" data-after=""></a></li>
            <li><a href="admin_login.php" data-after="Admin Login">Admin Login</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- End of Header Section  -->

  <!-- Hero Section  -->
  <section id="hero">
    <div class="hero container">
      <div>
        <h1>MERCY <span></span></h1>
        <h1>EDUCATIONAL <span></span></h1>
        <h1>INSTITUTE<span></span></h1>
      </div>
    </div>
  </section>
  <!-- End Hero Section  -->

  <!-- Footer Section -->
 <?php include("footer.php") ?>
  <!-- End Footer Section -->
  <script type="text/javascript" src="home.js"></script>
</body>
</html>