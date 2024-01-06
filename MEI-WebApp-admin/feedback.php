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
$id= $_GET["id"];
include("dbcon.php");   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produc.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style type="text/css">
        input, button{   
        height: 34px;   
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
                <li style="background-color: #444;">
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
            <br><br><br><br><br>

            <?php
                $task_table = 'book';
                $getData = $firestore->collection($task_table)->document($id)->snapshot()->data();

                $bid = $getData['bookId'];
            ?>

            <div class="tables">
                
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Feedbacks for book #<?php echo $bid; ?></h2>
                    </div>
                    <table class="product">
                        <thead>
                            <td>#</td>
                            <td>User Name</td>
                            <td>User Type</td>
                            <td>Feedback</td>
                            <td>Rating</td>
                        </thead>
                        <tbody>
                            <?php
                                $task_table1 = 'feedback';
                                $fetch_taskData1 = $firestore->collection($task_table1)->documents();
                                $i=1;
                                foreach($fetch_taskData1 as $key)
                                {
                                    $row = $key->data();
                                    echo "<tr>";
                                    if($bid == $row['bookId'])
                                    {
                                        echo "<td data-label='#'>"; echo $i++; echo "</td>";

                                        $userId = $row['userId'];

                                        // Reference to the "students" collection
                                        $studentsRef = $firestore->collection('student');
                                        $query = $studentsRef->where('UID', '=', $userId)->limit(1);
                                        $querySnapshot = $query->documents();

                                        $username = null;
                                        $type = 'Student';
                                        // Check if the query returned any documents
                                        foreach ($querySnapshot as $documentSnapshot) {
                                            // Get the "username" field from the document
                                            $username = $documentSnapshot->get('username');
                                            break;
                                        }

                                        // Output the username if found
                                        if ($username == null) 
                                        {
                                            $studentsRef = $firestore->collection('staff');
                                            $query = $studentsRef->where('UId', '=', $userId)->limit(1);
                                            $querySnapshot = $query->documents();

                                            // Check if the query returned any documents
                                            foreach ($querySnapshot as $documentSnapshot) {
                                                // Get the "username" field from the document
                                                $username = $documentSnapshot->get('username');
                                                break;
                                            }
                                            $type = 'Staff';
                                        }

                                        echo "<td data-label='User ID'>"; echo $username; echo "</td>";
                                        echo "<td data-label='User ID'>"; echo $type; echo "</td>";
                                        echo "<td data-label='Feedback'>"; echo $row['feedback']; echo "</td>";
                                        echo "<td data-label='Rating'>"; echo $row['rating']; echo "</td>";
                                    }
                                }                                       
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



