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
                <li>
                    <a href="book.php">
                        <i class="fad fa-book"></i>
                        <div class="title">Books</div>
                    </a>
                </li>
                <li style="background-color: #444; ">
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
                $task_table = 'task';
                $getData = $firestore->collection($task_table)->document($id)->snapshot()->data();

                $tid = $getData['taskId'];
            ?>

            <div class="tables">
                
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Task #<?php echo $tid; ?></h2>
                    </div>
                    <table class="product">
                        <thead>
                            <td>#</td>
                            <td>Student</td>
                            <td>Submitted Date</td>
                            <td>Marks</td>
                        </thead>
                        <tbody>
                            <?php
                                $task_table = 'viewTask';
                                $fetch_taskData = $firestore->collection($task_table)->documents();
                                $i=1;
                                foreach($fetch_taskData as $key)
                                {
                                    $row = $key->data();
                                    echo "<tr>";
                                    if($tid == $row['taskId'])
                                    {
                                        echo "<td data-label='#'>"; echo $i++; echo "</td>";

                                        $userId = $row['studentId'];

                                        // Reference to the "students" collection
                                        $studentsRef = $firestore->collection('student');
                                        $query = $studentsRef->where('UID', '=', $userId)->limit(1);
                                        $querySnapshot = $query->documents();

                                        $username = null;
                                        // Check if the query returned any documents
                                        foreach ($querySnapshot as $documentSnapshot) {
                                            // Get the "username" field from the document
                                            $username = $documentSnapshot->get('username');
                                            break;
                                        }
                                        echo "<td data-label='Student'>"; echo $username; echo "</td>";
                                        echo "<td data-label='Submitted Date'>"; echo $row['submittedDate']; echo "</td>";
                                        echo "<td data-label='Marks'>"; echo $row['marks']; echo "</td>";
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



