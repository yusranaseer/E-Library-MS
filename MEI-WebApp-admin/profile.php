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

$user = $_SESSION['admin'];

$user_table = 'User';
$getData = $firestore->collection($user_table)->document($user)->snapshot()->data();

$uid = $getData['userID'];
$pwd = $getData['password'];

$ref_table = 'Admin';
$fetch_refData = $firestore->collection($ref_table)->documents();
foreach($fetch_refData as $key)
{
    $row = $key->data();
    $docId = $key->id();
    if($uid == $row['UID'])
    {
        $name = $row['Name'];
        $email = $row['Email'];
        $contact = $row['Contact'];
        $ID = $docId;
    }
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
                <li>
                    <a href="report.php">
                        <i class="fad fa-clipboard-list"></i>
                        <div class="title">Reports</div>
                    </a>
                </li>
                <li style="background-color: #444;">
                    <a href="profile.php">
                        <i class="fas fa-cog"></i>
                        <div class="title">Profile</div>
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
                        <div class="heading"><h2>ADMIN PROFILE</h2></div><br><hr style="width: 100%;"><br>

                        <form method="POST" enctype="multipart/form-data" style="padding-top:31px;">
                        <div class="textimg">
                            <div class="text">

                            <label>Admin Name&ensp;&ensp;&ensp;&ensp;  </label>
                            <input type="text" name="name" value="<?php echo $name; ?>" style="width: 250px;">
                            <br><br>

                            <label>Admin Contact&ensp;&ensp;&nbsp;  </label>
                            <input type="text" name="contact" onkeypress="return validation(event)" value="<?php echo $contact; ?>" style="width: 250px;" maxlength="10">
                            <br><br>

                            <label>Admin Email&ensp;&ensp;&ensp;&ensp;&nbsp;</label>
                            <input type="text" name="email" value="<?php echo $email; ?>" style="width: 250px;">
                            <br><br>

                            </div>

                        </div>
                            <br>
                            <input type="submit" name="submit_btn" value="UPDATE PROFILE" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                        </form>
                        <?php
                        if(isset($_POST["submit_btn"]))
                        {

                            $admin_name = $_POST['name'];
                            $admin_contact = $_POST['contact'];
                            $admin_email = $_POST['email'];

                            $updateData = [
                                'Name' => $admin_name,
                                'Email' => $admin_email,
                                'Contact' => $admin_contact
                            ];

                            if($admin_name == null || $admin_contact == null || $admin_email == null)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Admin Profile",
                                            text: "Empty Fields!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "profile.php";
                                        });
                                    </script>
                                <?php
                            }
                            else
                            {
                                $ref_table = 'Admin';
                                $adminUpdate_result = $firestore->collection($ref_table)->document($ID)->set($updateData, ['merge' => true]);
                                if($adminUpdate_result)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Admin Profile",
                                            text: "Profile Updated Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "profile.php";
                                        });
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Admin Profile",
                                            text: "Error: couldn't updated the profile!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "profile.php";
                                        });
                                    </script>
                                    <?php
                                }
                            }
                        }
                        ?>
                        
                </div>
                <div class="add">
                    <div class="heading"><h2>CHANGE PASSWORD</h2></div><br><hr style="width: 100%; color: lightgray;"><br>

                    <form method="POST" enctype="multipart/form-data">

                        <label>Current Password  </label><br>
                        <input type="password" name="c_pwd">
                        <br><br>

                        <label>New Password </label><br>
                        <input type="password" name="n_pwd">
                        <br><br>

                        <label>Re-Enter Password</label><br>
                        <input type="password" name="re_pwd">
                        <br><br>

                        <input type="submit" name="change_btn" value="CHANGE PASSWORD" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; margin-top: 12px; cursor:pointer;">
                    </form>
                        <?php
                        if(isset($_POST["change_btn"]))
                        {

                            $current_pwd = $_POST['c_pwd'];
                            $new_pwd = $_POST['n_pwd'];
                            $re_pwd = $_POST['re_pwd'];

                            $verify = password_verify($current_pwd,$pwd);
                            if($verify)
                            {
                                if($new_pwd == $re_pwd && $new_pwd != null)
                                {
                                    $encrypt_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

                                    $updateUserData = [
                                        'password' => $encrypt_pwd
                                    ];
                                    
                                    $ref_table1 = 'User';
                                    $userUpdate_result = $firestore->collection($ref_table1)->document($user)->set($updateUserData, ['merge' => true]);

                                    if($userUpdate_result)
                                    {
                                        ?>
                                            <script type="text/javascript">
                                                swal({
                                                    title: "Admin Profile",
                                                    text: "Password Updated Succesfully!!!",
                                                    icon: "success"
                                                }).then(function() {
                                                    window.location = "profile.php";
                                                });
                                            </script>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <script type="text/javascript">
                                                swal({
                                                    title: "Admin Profile",
                                                    text: "Error: couldn't updated the password!!!",
                                                    icon: "error"
                                                }).then(function() {
                                                    window.location = "profile.php";
                                                });
                                            </script>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script type="text/javascript">
                                            swal({
                                                title: "Admin Profile",
                                                text: "Password not matched or Invalid input!!!",
                                                icon: "error"
                                            }).then(function() {
                                                window.location = "profile.php";
                                            });
                                        </script>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Admin Profile",
                                            text: "User Authetication Failed!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "profile.php";
                                        });
                                    </script>
                                <?php
                            }
                        }
                        ?>
                        
                </div>
            </div>

            </div>
        </div>
    </div>
</body>



</html>



