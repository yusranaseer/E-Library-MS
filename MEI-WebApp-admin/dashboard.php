
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
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <?php include("admin_logo.php"); ?>
                <li style="background-color: #444; ">
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
                        <h2>Latest Books</h2>
                    </div>
                    <table class="appointments">
                        <thead>
                            <td>#</td>
                            <td>Image</td>
                            <td>Title</td>
                            <td>Category</td>
                            <td>View</td>
                        </thead>
                        <tbody>
                        <?php

                                class BookRenderer {
                                    public function renderBookRow($index, $row) {
                                        echo "<tr>";
                                        echo "<td>{$index}</td>";
                                        echo "<td data-label='Image'><div class='img-box-small'><a href='{$row["Image"]}'><img src='{$row["Image"]}' /></a></div></td>";
                                        echo "<td data-label='Title'>{$row['Title']}</td>";
                                        echo "<td>{$row['Category']}</td>";
                                        echo "<td data-label='Actions'><a href='{$row["Link"]}'><i class='far fa-eye'></i></a></td>";
                                        echo "</tr>";
                                    }
                                }
                                $ref_table = 'book';
                                $odering_column = 'bookId';
                                $firestoreManager = new FirestoreManager($firestore);
                                $bookRenderer = new BookRenderer();

                                $querySnapshot = $firestoreManager->getRecentActiveBooks($ref_table,10,$odering_column);
                                $i = 1;

                                foreach ($querySnapshot as $document) {
                                    $row = $document->data();
                                    $bookRenderer->renderBookRow($i++, $row);
                                }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="doctor-visiting">
                    <div class="heading">
                        <h2>Innovation Short View</h2>
                    </div>
                    <table class="visiting">
                        <thead>
                            <td>#</td>
                            <td>Name</td>
                            <td>View</td>
                        </thead>
                        <tbody>
                            <?php
                                 class Renderer {
                                    public function renderRow($index, $row, $docId, $firestoreManager) {
                                    echo "<tr>";
                                    echo "<td data-label='#'>"; echo $index; echo "</td>";
                                    echo "<td data-label='Innovation'>"; echo $row['Innovation']; echo "</td>";

                                    echo "<td data-label='View'>"; ?> 
                                        <a href="<?php echo $row['product']; ?>"> <i class="far fa-eye"></i> </a>
                                    <?php echo "</td>";
                                    echo "</tr>";
                                    }
                                }
                                
                                $ref_table = 'innovation';
                                $odering_column = 'innoId';
                                $firestoreManager = new FirestoreManager($firestore);
                                $Renderer = new Renderer();

                                $querySnapshot = $firestoreManager->getRecentActiveInnos($ref_table,10,$odering_column);
                                $i = 1;

                                foreach ($querySnapshot as $document) {
                                    $row = $document->data();
                                    $docId = $document->id();
                                    $Renderer->renderRow($i++, $row, $docId, $firestoreManager);
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



