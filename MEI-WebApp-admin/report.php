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
include("dbcon.php");  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dash.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <title>Admin panel</title>
    <style type="text/css">
        .fa-print{
    background: #ed5564;
    }
    </style>
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
                    <a href="book.php">
                        <i class="fad fa-book"></i>
                        <div class="title">Books</div>
                    </a>
                </li>
                <li>
                    <a href="task.php">
                        <i class="fad fa-clipboard-list-check"></i>
                        <div class="title">Tasks</div>
                    </a>
                </li>
                <li>
                    <a href="student.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Student Details</div>
                    </a>
                </li>
                <li>
                    <a href="staff.php">
                        <i class="fas fa-user-circle"></i>
                        <div class="title">Staff Details</div>
                    </a>
                </li>
                <li>
                    <a href="resources.php">
                        <i class="fas fa-cart-arrow-down"></i>
                        <div class="title">Resources</div>
                    </a>
                </li>
                <li>
                    <a href="innovations.php">
                        <i class="fas fa-hand-holding-usd"></i>
                        <div class="title">Innovations</div>
                    </a>
                </li>
                <li style="background-color: #444; ">
                    <a href="report.php">
                        <i class="fad fa-clipboard-list"></i>
                        <div class="title">Reports</div>
                    </a>
                </li>
                <li>
                    <a href="profile.php">
                        <i class="fas fa-cog"></i>
                        <div class="title">Profile</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            
            <?php include("topbar.php"); ?>
            <?php include("cards.php"); ?>
            
            <div class="tables">
                <!--<div class="last-appointments">
                    <div class="heading">
                        <h2>Reports</h2>
                    </div>
                    <table class="appointments">
                        <thead>
                            <td>Report Name</td>
                            <td>Report</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Student Report</td>
                                <td> <a href="PDF/Receipt.php?name=student"><i style="padding: 5px 50px 5px 50px;" class="far fa-print"></i></a></td>
                            </tr>
                            <tr>
                                <td>Book Report</td>
                                <td> <a href="PDF/Receipt.php?name=book"><i style="padding: 5px 50px 5px 50px;" class="far fa-print"></i></a></td>
                            </tr>
                            <tr>
                                <td>Staff Report</td>
                                <td> <a href="PDF/Receipt.php?name=staff"><i style="padding: 5px 50px 5px 50px;" class="far fa-print"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>-->
                <div class="doctor-visiting">
                    <div class="heading">
                        <h2>Reports</h2>
                    </div>
                    <table class="visiting">
                        <thead>
                            <td>Report</td>
                            <td>Print</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Student Details</td>
                                <td><a href="report/exportStudent.php"> <i class="far fa-print"></i></a></td>
                            </tr>
                            <tr>
                                <td>Book Details</td>
                                <td><a href="report/exportBook.php"> <i class="far fa-print"></i></a></td>
                            </tr>
                            <tr>
                                <td>Staff Details</td>
                                <td><a href="report/exportStaff.php"> <i class="far fa-print"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>



