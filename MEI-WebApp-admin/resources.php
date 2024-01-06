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

$per_page_record = 5;             
if (isset($_GET["page"])) {    
      $page  = $_GET["page"];    
 }    
 else {    
       $page=1;    
 }    
     
$start_from = (($page-1) * $per_page_record)+1;   

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
        width: 150px;
    }

    .divide-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-4 {
    width: 100%;
    display: grid;
    grid-template-columns: 1.5fr 1.5fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
    @media(max-width: 1500px){
        .divide-3 {
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
.divide-4 {
    width: 100%;
    display: grid;
    grid-template-columns: 3fr;
    grid-gap: 20px;
    align-items: self-start;
    padding: 0 20px 20px 20px;
}
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
                <li style="background-color: #444; ">
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
            <?php include("resourceCard.php"); ?>

            <div class="tables">
                <div class="divide-3">
                    <div class="add">
                        <div class="heading">
                            <h2>Practicles</h2>
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Name">
                            <button class="open-button" onclick="openForm()">+Add Practicles</button>
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

    <label for="Category"><b>Name</b></label>
    <input type="text" placeholder="Name" name="name">

    <label for="Category"><b>Grade</b></label>
    <input type="text" placeholder="Grade" name="grade" onkeypress="return validation(event)">

    <label for="Category"><b>Link</b></label>
    <input type="text" placeholder="Link" name="link">

    <input type="submit" name="add_practicles" value="ADD" class="btn" style="border-color: transparent; width: 45%; font-weight: bold; cursor:pointer;">
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>
<?php
                        if(isset($_POST["add_practicles"]))
                        {
                            $practicle_table = 'practicle';

                            $name = $_POST['name'];
                            $grade = $_POST['grade'];
                            $practicle = $_POST['link'];

                            $practicleData = [
                                'name' => $name,
                                'grade' => $grade,
                                'practicle' => $practicle
                            ];
                            $intgrade = intval($grade);
                            if($name == null || $grade == null || $practicle == null)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Practicle",
                                            text: "Empty Fields!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "resources.php";
                                        });
                                    </script>
                                <?php
                            }
                            else if($intgrade < 6 || $intgrade > 13)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Practicle",
                                            text: "Grade should be 6 to 13!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "resources.php";
                                        });
                                    </script>
                                <?php
                            }
                            else
                            {
                                $practicleRef_result = $firestore->collection($practicle_table)->add($practicleData);
                                if($practicleRef_result)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Practicle",
                                            text: "Practicle Added Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "resources.php";
                                        });
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Practicle",
                                            text: "Error: couldn't add the practicle!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "resources.php";
                                        });
                                    </script>
                                    <?php
                                }
                            }
                        }
                        ?>

                    <table class="product" id="myTable">
                        <thead>
                            <td>Name</td>
                            <td>Grade</td>
                            <td>Actions</td>
                        </thead>
                        <tbody>
                            <?php
                                class Renderer {
                                    public function renderRow($index, $row, $docId, $firestoreManager) {
                                    echo "<tr>";

                                    echo "<td data-label='Name'>"; echo $row['name']; echo "</td>";
                                    echo "<td data-label='Grade'>"; echo $row['grade']; echo "</td>";
                                    echo "<td data-label='Actions'>"; ?> 
                                        <a href="<?php echo $row["practicle"]; ?>" target="_blank"> <i class="far fa-eye"></i> </a>
                                        <a href="deleteConfirm.php?id=<?php echo $docId; ?>&name=practicle"> <i class="far fa-trash-alt"></i> </a>
                                    <?php echo "</td>";

                                    echo "</tr>";
                                    }
                                }

                                $ref_table = 'practicle';
                                $odering_column = 'grade';
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
                            $total_records = $totalPracCount;  
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='resources.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='resources.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='resources.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='resources.php?page=".($page+1)."'>  Next </a>";   
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
                        td = tr[i].getElementsByTagName("td")[0];
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



