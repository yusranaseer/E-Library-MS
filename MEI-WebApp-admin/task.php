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
            <?php include("cards.php"); ?>

            <div class="tables">
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Task</h2>
                    </div>
                    <table class="product">
                        <thead>
                            <td>#</td>
                            <td>Task</td>
                            <td>Due Date</td>
                            <td>Staff</td>
                            <td>Grade</td>
                            <td>Total Submissions</td>
                            <td>View Question</td>
                            <td>View Submissions</td>
                        </thead>
                        <tbody>
                            <?php
                                 class Renderer {
                                    public function renderRow($index, $row, $docId, $firestoreManager) {
                                    echo "<tr>";
                                    echo "<td data-label='#'>"; echo $index; echo "</td>";
                                    echo "<td data-label='Task'>"; echo $row['Task']; echo "</td>";
                                    echo "<td data-label='Due Date'>"; echo $row['dueDate']; echo "</td>";
                                    
                                    $Id = $row['staffId'];
                                    $ref_table = 'staff';
                                    $columnName = 'UId';
                                    $username = $firestoreManager->getUsername($ref_table, $Id, $columnName);

                                    echo "<td data-label='Staff'>"; echo $username; echo "</td>";
                                    echo "<td data-label='Grade'>"; echo $row['grade']; echo "</td>";

                                    $Id = $row['taskId'];
                                    $table = 'viewTask';
                                    $taskData = $firestoreManager->getSumAndCount($table,$Id);
                                    $total_rows = $taskData['totalRows'];  

                                    echo "<td data-label='Total Submissions'>"; echo $total_rows; echo "</td>";
                                    echo "<td data-label='View Task'>"; ?> 
                                        <a href="<?php echo $row['question']; ?>"> <i class="far fa-eye"></i> </a>
                                    <?php echo "</td>";
                                    echo "<td data-label='View Submissions'>"; ?> 
                                        <a href="viewtask.php?id=<?php echo $docId; ?>"> <i class="far fa-angle-double-right" style="color: green;"></i> </a>
                                    <?php echo "</td>";
                                    echo "</tr>";
                                    }
                                }
                                
                                $ref_table = 'task';
                                $odering_column = 'taskId';
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
                            $ref_table = 'task';
                            $firestoreManager = new FirestoreManager($firestore);
                            $total_records = $firestoreManager->getTotalCount($ref_table);
                            
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='task.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='task.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='task.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='task.php?page=".($page+1)."'>  Next </a>";   
                            }   
  
                            ?>    
                        </div> 
                </div>

            </div>
        </div>
    </div>
</body>
</html>



