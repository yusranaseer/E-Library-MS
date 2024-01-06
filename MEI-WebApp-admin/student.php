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
include("pagination.php");   
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
        input, button{   
        height: 34px;   
    }
    .open-button {
  background-color: crimson;
  color: white;
  border: none;
  cursor: pointer;
  width: 150px;
}

.clickable-row {
  cursor: pointer;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 100;
  right: 150px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}


/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: black;
  border-color: transparent;
  margin-top: 10px;
  width: 45%
}
    #myInput {
        background-image: url('img/search.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        padding: 6px 20px 0px 40px;
        border: transparent;
    }
    @media(max-width: 768px){
    thead{
        display: none;
    }
    tbody, tr, td{
        display: block;
        width: 100%;
    }
    tr{
        margin-bottom: 15px;
    }
     tbody tr td{
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
     td:before{
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: 600;
        font-size: 14px;
        text-align: left;
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
                <li style="background-color: #444; ">
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
            <?php include("cards.php"); ?>

            <div class="tables">
                
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Student Details</h2>
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for student first name">
                        <button class="open-button" onclick="openForm()">Add Students</button>
                    </div>

                        <script>
                            function openForm() {
                                document.getElementById("myForm").style.display = "block";
                            }

                            function closeForm() {
                                document.getElementById("myForm").style.display = "none";
                            }
                        </script>

                        <div class="form-popup" id="myForm">
                            <form method="POST" class="form-container">
                                <h1></h1>

                                <label for="Category"><b>No of new students</b></label>
                                <input type="text" placeholder="no of new students" name="new_count" onkeypress="return validation(event)">

                                <input type="submit" name="add_students" value="ADD" class="btn" style="border-color: transparent; width: 45%; font-weight: bold; cursor:pointer;">
                                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                            </form>
                        </div>

                        <?php
                        if(isset($_POST["add_students"]))
                        {
                            $student_table = 'student';
                            $total__student_count = $firestore->collection($student_table)->documents()->size();
                            $count_start = $total__student_count+1;

                            $user_table = 'User';
                            $total__user_count = $firestore->collection($user_table)->documents()->size();
                            $newuid = $total__user_count+1;

                            $new_count = $_POST['new_count'];
                            $newcount = intval($new_count);
                            $count_end = $total__student_count+$newcount;

                            if($new_count == null || $newcount < 1)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Student",
                                            text: "Invalid Input!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "student.php";
                                        });
                                    </script>
                                <?php
                            }
                            else
                            {
                                $c=0;
                                for ($i = $count_start; $i <= $count_end; $i++) {
                                
                                    $uid = $newuid;
                                    $pwd = 'student';
                                    $encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    
                                    $userData = [
                                        'userID' => $uid,
                                        'password' => $encrypt_pwd
                                    ];
    
                                    $fname= "";
                                    $lname= "";
                                    $status='active';
                                    $gender="";
                                    $grade=0;
                                    $email="";
                                    $contact=0;
                                    $addr="";
                                    $uname = 'STU'.$i;
                                    $coins = 0;
                                    $img = 'https://storage.googleapis.com/mecdb-ba6be.appspot.com/img/653d00641b0e5images.png?GoogleAccessId=firebase-adminsdk-6p8xw%40mecdb-ba6be.iam.gserviceaccount.com&Expires=33481897199&Signature=esyU4g8dJ1GkdiAdx2rSZEbfb2KIploYKRdgeuPaBivQkS59TQ7Eyjie6Wgq5W0IV1YbIBX%2Fyuecy9kla17QkPirZybXolgwlcBXekj4X5UFKH%2BDd3G%2BXzGp8KqkJQFfDWsOxdUkL2SUQJJR%2FyYxif1vzSA%2BGIncwa8vaPqdnO6gQ8Z8emanXFdUoLw1QifTkKsT816ArWQdPhn9Ruhjd1GfYsCwRKmAnOPR2GB3tWPexQbf4gEJlofUqYaepkYgONegpfw2WAvV7OiEC4ByS2iK5N6qvA%2B5r2lNFbySMAXc7sirBeVo0GpCCqsnh5ZIc8XSe1ZN5EN5al%2BH07dHpQ%3D%3D&generation=1698496615446960';
    
                                    $studentData = [
                                        'UID' => $uid,
                                        'First_Name' => $fname,
                                        'Last_Name' => $lname,
                                        'username' => $uname,
                                        'Email' => $email,
                                        'Contact' => $contact,
                                        'Address' => $addr,
                                        'Status' => $status,
                                        'Gender' => $gender,
                                        'Grade' => $grade,
                                        'coins' => $coins,
                                        'img' => $img                               
                                    ];
    
                                    $userRef_result = $firestore->collection($user_table)->add($userData);
                                    $firestore->collection($student_table)->add($studentData);
                                    if($userRef_result)
                                    {
                                        $c++;
                                    }
                                    $newuid++;
                                    
                                }
                                
                                if($c != 0)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Student",
                                            text: "Students Added Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "student.php";
                                        });
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Student",
                                            text: "Error: couldn't add the Students!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "student.php";
                                        });
                                    </script>
                                    <?php
                                }
                            }
                        }
                        ?>
                    <table class="product" id="myTable">
                        <thead>
                            <td>#</td>
                            <td>Image</td>
                            <td>User Name</td>
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Email</td>
                            <td>Contact</td>
                            <td>Gender</td>
                            <td>Grade</td>
                            <td><i class="fab fa-bitcoin" style="font-size:24px;color:#FFD700"></i></td>
                            <td>Status</td>
                        </thead>
                        <tbody>
                            <?php
                                class Renderer {
                                    public function renderRow($index, $row, $docId) {
                                    ?>
                                    <tr class="clickable-row" data-href="viewStudent.php?id=<?php echo $docId; ?>">
                                    <?php
                                    echo "<td data-label='#'>"; echo $index; echo "</td>";
                                    echo "<td data-label='Image'>"; ?> <div class="img-box-small"><a href="<?php echo $row['img']; ?>"><img src="<?php echo $row['img']; ?>" /></a></div><?php  echo "</td>";
                                    echo "<td data-label='User Name'>"; echo $row['username']; echo "</td>";
                                    if($row['First_Name'] == null && $row['Last_Name'] == null && $row['Email'] == null && $row['Contact'] == 0 && $row['Address'] == null && $row['Gender'] == null && $row['Grade'] == 0 )
                                    {
                                        echo "<td colspan='6' style='text-align:center;'>"; echo "The Details has been not yet updated"; echo "</td>";
                                    }
                                    else
                                    {
                                        echo "<td data-label='First Name'>"; echo $row['First_Name']; echo "</td>";
                                        echo "<td data-label='Last Name'>"; echo $row['Last_Name']; echo "</td>";
                                        echo "<td data-label='Email'>"; echo $row['Email']; echo "</td>";
                                        echo "<td data-label='Contact'>"; echo $row['Contact']; echo "</td>";
                                        //echo "<td data-label='Address'>"; echo $row['Address']; echo "</td>";
                                        echo "<td data-label='Gender'>"; echo $row['Gender']; echo "</td>";
                                        echo "<td data-label='Grade'>"; echo $row['Grade']; echo "</td>";
                                    }
                                    echo "<td data-label='Coins'>"; echo $row['coins']; echo "</td>";
                                    
                                    if($row['Status'] == "active")
                                    {
                                        echo "<td data-label='Status'>";?>
                                        <a href="confirmStatusChange.php?id=<?php echo $docId; ?>&name=student"><i class="fas fa-check-circle" style="font-size:24px;color:#51FF5E"></i></a>
                                        <?php echo "</td>";
                                    }
                                    else
                                    {
                                        echo "<td data-label='Status'>"; ?>
                                        <a href="confirmStatusChange.php?id=<?php echo $docId; ?>&name=student"><i class='fas fa-ban' style='font-size:24px;color:#FF5151'></i></a>
                                        <?php echo "</td>";
                                    } 
                                    echo "</tr>";
                                    }
                                }
                                
                                $ref_table = 'student';
                                $odering_column = 'UID';
                                $firestoreManager = new FirestoreManager($firestore);
                                $Renderer = new Renderer();

                                $querySnapshot = $firestoreManager->getRecords($ref_table,$odering_column,$start_from,$per_page_record);
                                $i = 1;

                                foreach ($querySnapshot as $document) {
                                    $row = $document->data();
                                    $docId = $document->id();
                                    $Renderer->renderRow($i++, $row, $docId);
                                }
                            ?>

                            <script>
                                const rows = document.querySelectorAll('.clickable-row');
                                rows.forEach(row => {
                                    row.addEventListener('click', () => {
                                    const link = row.getAttribute('data-href');
                                        if (link) {
                                            window.location.href = link;
                                        }
                                    });
                                });
                            </script>

                        </tbody>
                    </table>
                        <div class="pagination">    
                            <?php  
                            $total_records = $totalStudentCount;   
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='student.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='student.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='student.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='student.php?page=".($page+1)."'>  Next </a>";   
                            }   
  
                            ?>    
                        </div> 
                </div>
            </div>

            <script>
                function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[3];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
                }
            </script>

        </div>
    </div>
</body>
</html>



