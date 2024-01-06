<?php
include("dbcon.php"); 
$id = $_GET["id"];
$student_table = 'student';
$getData = $firestore->collection($student_table)->document($id)->snapshot()->data();
$sid = $getData['UID'];
$fname = $getData['First_Name'];
$lname = $getData['Last_Name'];
$uname = $getData['username'];
$addr = $getData['Address'];
$contact = $getData['Contact'];
$email = $getData['Email'];
$gender = $getData['Gender'];
$grade = $getData['Grade'];
$coins = $getData['coins'];
$img = $getData['img'];
$status = $getData['Status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- ===== ===== Custom Css ===== ===== -->
    <link rel="stylesheet" href="UserProfile-main/style1.css">
    <link rel="stylesheet" href="UserProfile-main/responsive.css">

    <!-- ===== ===== Remix Font Icons Cdn ===== ===== -->
    <link rel="stylesheet" href="fonts/remixicon.css">
    <style type="text/css">
        ul li h1::before {
  content: '✔';
  font-size: 15px;
  color: green;
  line-height: 1.7;
  padding-right: 10px;
}
    </style>
</head>

<body>
    <!-- ===== ===== Body Main-Background ===== ===== -->
    <span class="main_bg"></span>


    <!-- ===== ===== Main-Container ===== ===== -->
    <div class="container">

        <!-- ===== ===== Header/Navbar ===== ===== -->
        <header>
            <div class="brandLogo">
                <figure><img src="img/MEI_new.png" alt="logo" width="40px" height="40px"></figure>
                <span style="padding-bottom:5px;">STUDENT</span>
            </div>
        </header>


        <!-- ===== ===== User Main-Profile ===== ===== -->
        <section class="userProfile card">
            <div class="profile">
                <figure><img src="<?php echo $img; ?>" alt="profile" width="250px" height="250px"></figure>
            </div>
        </section>


        <!-- ===== ===== Work & Skills Section ===== ===== -->
        <section class="work_skills card">

            <!-- ===== ===== Work Contaienr ===== ===== -->
            <div class="work">
                <h1 class="heading">about</h1>
                <div class="primary">
                    <h1>Contact</h1>
                    <p>+94 <?php echo $contact; ?></p>
                </div>

                <div class="primary">
                    <h1>Email</h1>
                    <p><?php echo $email; ?></p>
                </div>

                <div class="primary">
                    <h1>Address</h1>
                    <p><?php echo $addr; ?></p>
                </div>
            </div>

            <!-- ===== ===== Skills Contaienr ===== ===== -->
            <div class="skills">
                <h1 class="heading">Technologies</h1>
                <ul>
                    <li style="--i:0">Android Emulator</li>
                    <li style="--i:1">Flutter</li>
                    <li style="--i:2">Web Development</li>
                    <li style="--i:3">Firebase DB</li>
                </ul>
            </div>
        </section>


        <!-- ===== ===== User Details Sections ===== ===== -->
        <section class="userDetails card">
            <div class="userName">
                <h1 class="name"><?php echo $fname; echo " "; echo $lname; ?></h1>
                <!--<div class="map">
                    <i class="ri-map-pin-fill ri"></i>
                    <span>New York, NY</span>
                </div>-->
                <p>(<?php echo $uname; ?>)</p>
            </div>

            <div class="rank">
                <h1 class="heading"><?php echo $gender; ?> Student</h1>
                <h1 class="heading">Grade <?php echo $grade; ?></h1>
                <h1 class="heading"><?php echo $coins; ?> Available onsite coins</h1>
                <?php
                    if($status == "active")
                    {
                        ?>
                        <h1 class="heading">Currently <span style="color:green;" class="heading"><?php echo $status; ?></span> status</h1>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h1 class="heading">Currently <span style="color:red;" class="heading"><?php echo $status; ?></span> status</h1>
                        <?php
                    }
                ?>
                
            </div>

        </section>


        <!-- ===== ===== Timeline & About Sections ===== ===== -->
        <section class="timeline_about card">
            <div class="tabs">
                <ul>

                    <li class="about active">
                        <i class="ri-user-3-fill ri"></i>
                        <span>ACHIEVEMENTS </span>
                    </li>
                </ul>
            </div>

            <div class="contact_Info">
                <ul>
                <?php

                    for($i = 1; $i <= 10; $i++)
                    {
                        if( ($i*100) <= $coins)
                        {
                            ?>
                                <li class="phone">
                                    <h1 class="label">Achieved the E-Library Level <?php echo $i; ?> Certificate</h1>
                                    <!--<span class="info">+11 234 567 890</span>-->
                                </li>
                            <?php
                        }
                    }

                 ?>
                
                </ul>
            </div>
        </section>
    </div>

</body>

</html>
