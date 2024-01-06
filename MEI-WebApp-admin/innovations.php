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
    <style type="text/css">
        input, button{   
        height: 34px;   
    }
    .nav2 {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #000000;
    }

    .nav2 li {
        float: left;
        border-right: 1px solid white;
    }

    .nav2 li a:hover {
        opacity: 0.8;
    }

    .nav2 li a {
        display: block;
        padding: 8px;
        color: white;
        text-decoration: none;
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
                <li style="background-color: #444; ">
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
                        <h2>Innovations</h2>
                        <ul class="nav2">
                        <li><a href="pendingInno.php" style="background-color: #077E8C; width: 100px; text-align: center; border-bottom: 4px solid black;">Pending</a></li>
                    </ul>
                    </div>
                    <table class="product">
                        <thead>
                            <td>#</td>
                            <td>Innovation</td>
                            <td>Submitted Date</td>
                            <td>Student</td>
                            <td>Status</td>
                            <td>View</td>
                        </thead>
                        <tbody>
                            <?php
                                 class Renderer {
                                    public function renderRow($index, $row, $docId, $firestoreManager) {
                                    echo "<tr>";
                                    echo "<td data-label='#'>"; echo $index; echo "</td>";
                                    echo "<td data-label='Innovation'>"; echo $row['Innovation']; echo "</td>";
                                    echo "<td data-label='Submitted Date'>"; echo $row['submitDate']; echo "</td>";
                                    
                                    $Id = $row['StudentId'];
                                    $ref_table = 'student';
                                    $columnName = 'UID';
                                    $username = $firestoreManager->getUsername($ref_table, $Id, $columnName);

                                    echo "<td data-label='Staff'>"; echo $username; echo "</td>";
                                    if($row['status'] == 'pending')
                                    {
                                        echo "<td data-label='Status'>"; ?> 
                                            <i class="fas fa-exclamation-triangle" style="font-size:24px;color:#c69035"></i>
                                        <?php echo "</td>";
                                    }
                                    else if($row['status'] == 'accepted')
                                    {
                                        echo "<td data-label='Status'>"; ?> 
                                            <i class="fas fa-check-circle" style="font-size:24px;color:#51FF5E"></i>
                                        <?php echo "</td>";
                                    }
                                    else
                                    {
                                        echo "<td data-label='Status'>"; ?> 
                                            <i class='fas fa-ban' style='font-size:24px;color:#FF5151'></i>
                                        <?php echo "</td>";
                                    }

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

                                $querySnapshot = $firestoreManager->getRecords($ref_table,$odering_column,$start_from,$per_page_record);
                                $i = 1;

                                foreach ($querySnapshot as $document) {
                                    $row = $document->data();
                                    $docId = $document->id();
                                    $Renderer->renderRow($i++, $row, $docId, $firestoreManager);
                                }
                            ?>
                        </tbody>
                    </table>
                        <div class="pagination">    
                            <?php  
                            $ref_table = 'innovation';
                            $firestoreManager = new FirestoreManager($firestore);
                            $total_records = $firestoreManager->getTotalCount($ref_table);
                            
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='innovations.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='innovations.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='innovations.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='innovations.php?page=".($page+1)."'>  Next </a>";   
                            }   
  
                            ?>    
                        </div> 
                </div>

            </div>
        </div>
    </div>
</body>
</html>



