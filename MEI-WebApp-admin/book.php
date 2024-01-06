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

//firestore storage connection
use Google\Cloud\Storage\StorageClient;

$projectId = 'mecdb-ba6be';
$bucketName = 'mecdb-ba6be.appspot.com';

$storage = new StorageClient([
    'keyFilePath' => 'Keys/mecdb-ba6be-033d6216f407.json',
    'projectId' => $projectId,
]);
//end

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
  bottom: 180px;
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
                <li style="background-color: #444; ">
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
                <div class="divide-3">
                    <div class="add">
                        <div class="heading">
                            <h2>Books</h2>
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Book name">
                            
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

    <label for="Category"><b>Category Name</b></label>
    <input type="text" placeholder="Category" name="category">

    <input type="submit" name="add_cat" value="ADD" class="btn" style="border-color: transparent; width: 45%; font-weight: bold; cursor:pointer;">
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>
<?php
                        if(isset($_POST["add_cat"]))
                        {
                            $cat_table = 'category';
                            $total__cat_count = $firestore->collection($cat_table)->documents()->size();

                            $cat_id = $total__cat_count+1;
                            $category = $_POST['category'];

                            $catData = [
                                'categoryId' => $cat_id,
                                'Category' => $category
                            ];
 
                            if($category == null)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Category",
                                            text: "Empty Fields!!!",
                                            icon: "error"
                                        });
                                    </script>
                                <?php
                            }
                            else
                            {
                                $catRef_result = $firestore->collection($cat_table)->add($catData);
                                if($catRef_result)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Category",
                                            text: "Category Added Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "book.php";
                                        });
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Category",
                                            text: "Error: couldn't add the category!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "book.php";
                                            });
                                    </script>
                                    <?php
                                }
                            }
                        }
                        ?>

                    <table class="product" id="myTable">
                        <thead>
                            <td>Image</td>
                            <td>Title</td>
                            <td>Author</td>
                            <td>Category</td>
                            <td>Rating</td>
                            <td>Published Year</td>
                            <td>Actions</td>
                            <td>Status</td>
                            <td>Feedback</td>
                        </thead>
                        <tbody>
                            <?php
                                class Renderer {
                                    public function renderRow($index, $row, $docId, $firestoreManager) {
                                    echo "<tr>";
                                    echo "<td data-label='Image'>"; ?> <div class="img-box-small"><a href="<?php echo $row["Image"]; ?>"><img src="<?php echo $row["Image"]; ?>" /></a></div><?php  echo "</td>";
                                    echo "<td data-label='Title'>"; echo $row['Title']; echo "</td>";
                                    echo "<td data-label='Author'>"; echo $row['Author']; echo "</td>";
                                    echo "<td data-label='Category'>"; echo $row['Category']; echo "</td>";

                                    $Id = $row['bookId'];
                                    $table = 'feedback';
                                    $feedbackData = $firestoreManager->getSumAndCount($table,$Id);
                                    $total_rows = $feedbackData['totalRows'];
                                    $sum = $feedbackData['sum'];
                                    
                                    if($total_rows == 0)
                                    {
                                        $rate = 'not yet rated';
                                        echo "<td data-label='Rating'>"; echo $rate; echo "</td>";
                                    }
                                    else
                                    {
                                        $rate = $sum/$total_rows;
                                        echo "<td data-label='Rating'>"; echo $rate."<span style='color:lightgray;'> (".$total_rows.")</span>"; echo "</td>";
                                    }

                                    echo "<td data-label='Published Year'>"; echo $row['year']; echo "</td>";
                                    echo "<td data-label='Actions'>"; ?> 
                                        <a href="<?php echo $row["Link"]; ?>"> <i class="far fa-eye"></i> </a>
                                        <a href="edit.php?id=<?php echo $docId; ?>"> <i class="far fa-edit"></i> </a>
                                    <?php echo "</td>";
                                    if($row['status'] == "active")
                                    {
                                        echo "<td data-label='Status'>";?>
                                        <a href="confirmStatusChange.php?id=<?php echo $docId; ?>&name=book"><i class="fas fa-check-circle" style="font-size:24px;color:#51FF5E;"></i></a>
                                        <?php echo "</td>";
                                    }
                                    else
                                    {
                                        echo "<td data-label='Status'>"; ?>
                                        <a href="confirmStatusChange.php?id=<?php echo $docId; ?>&name=book"><i class='fas fa-ban' style='font-size:24px;color:#FF5151;'></i></a>
                                        <?php echo "</td>";
                                    } 
                                    echo "<td data-label='Feedback'>"; ?> 
                                        <a href="feedback.php?id=<?php echo $docId; ?>"> <i class='fas fa-angle-double-right' style='font-size:24px;color:crimson;'></i> </a>
                                    <?php echo "</td>";
                                    echo "</tr>";
                                    }
                                }

                                $ref_table = 'book';
                                $odering_column = 'bookId';
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
                            $total_records = $totalBookCount;  
                            echo "</br>";     
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);     
                            $pagLink = "";       
      
                            if($page>=2){   
                                echo "<a href='book.php?page=".($page-1)."'>  Prev </a>";   
                            }       
                   
                            for ($i=1; $i<=$total_pages; $i++) {   
                                if ($i == $page) {   
                                    $pagLink .= "<a class = 'active' href='book.php?page=".$i."'>".$i." </a>";   
                                 }               
                                else  {   
                                    $pagLink .= "<a href='book.php?page=".$i."'>".$i." </a>";     
                                }   
                            };     
                            echo $pagLink;   
  
                            if($page<$total_pages){   
                                echo "<a href='book.php?page=".($page+1)."'>  Next </a>";   
                            }   
  
                            ?>    
                        </div> 
                </div>
               
            </div>
            <div class="divide-3">
            <div class="add">
                <div class="heading"><h2>Add Books</h2><button class="open-button" onclick="openForm()">+Add Categories</button></div><br><hr style="width: 100%;"><br>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="divide-4">
                        <div class="add">
                            <label>Title &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="title" id="title" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>
                        
                            <label>Category &ensp;&ensp;&ensp;&nbsp;</label>
                            <select name="cat">
                                <option disabled selected> Select a Category</option> 
                                <?php 
                                    $cat_table = 'category';
                                    $fetch_category_names = $firestore->collection($cat_table)->documents();

                                    foreach($fetch_category_names as $catName)
                                    {
                                        $row = $catName->data();
                                        echo "<option>".$row['Category']."</option>";
                                    }
                                ?> 
                            </select>
                            <br><br>

                            <label>Image &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="file" name="image" id="image">
                            

                        </div>
                        <div class="add">
                            <label>Author &ensp;&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" name="author" id="author" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>
                        
                            <label>Published year &nbsp;&ensp;</label>
                            <input type="text" name="year" id="year" onkeypress="return validation(event)" maxlength="4">
                            <br><br>

                            <label>Book &ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="file" name="pdfFile" id="pdfFile">

                        </div>
                        </div>
                        <input type="submit" name="add_book" value="ADD BOOK" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                    </form>
                        <?php
                        if(isset($_POST["add_book"]))
                        {

                            $ref_table = 'book';
                            $total_count = $firestore->collection($ref_table)->documents()->size();

                            $id = $total_count+1;
                            $title = $_POST['title'];

                            if (isset($_POST['cat'])) 
                            {
                                $cat = $_POST['cat'];
                            } else {
                                $cat = null;
                            }

                            $author = $_POST['author'];
                            $year = $_POST['year'];
                            $pdfFile1 = $_FILES['image'];
                            $pdfFile = $_FILES['pdfFile'];

                            $currentYear = date("Y");
                            $intyear = intval($year);

                            if($title == null || $cat == null || $author == null || $year == null)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid Input!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "book.php";
                                            });
                                    </script>
                                <?php
                            }
                            else if($intyear > $currentYear || $intyear < 1950)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid Year!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "book.php";
                                            });
                                    </script>
                                <?php
                            }
                            else
                            {
                               
                                $originalFileName = $_FILES['image']['name'];
                                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                                $originalFileName1 = $_FILES['pdfFile']['name'];
                                $extension1 = pathinfo($originalFileName1, PATHINFO_EXTENSION);

                                if($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg')
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid type for Book Image!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "book.php";
                                            });
                                    </script>
                                    <?php
                                    
                                }
                                else if($extension1 != 'pdf')
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid type for Book File!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "book.php";
                                            });
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    //bucket
                                    $bucket = $storage->bucket($bucketName);
                                    //book image
                                    // Generate a unique filename for the PDF file in Cloud Storage
                                    $uniqueFileName1 = uniqid('img/') . $_FILES['image']['name'];

                                    // Upload the PDF file to Cloud Storage
                                    $object1 = $bucket->upload(file_get_contents($pdfFile1['tmp_name']), [
                                        'name' => $uniqueFileName1,
                                    ]);

                                    // Get the download URL for the uploaded file
                                    $object1->reload();
                                    $expiration = new \DateTime('3030-12-31T23:59:59');
                                    $downloadURL1 = $object1->signedUrl($expiration);
                                    //end book image

                                    // Generate a unique filename for the PDF file in Cloud Storage
                                    $uniqueFileName = uniqid('books/') . $_FILES['pdfFile']['name'];

                                    // Upload the PDF file to Cloud Storage
                                    $object = $bucket->upload(file_get_contents($pdfFile['tmp_name']), [
                                        'name' => $uniqueFileName,
                                    ]);

                                    // Get the download URL for the uploaded file
                                    $object->reload();
                                    $downloadURL = $object->signedUrl($expiration);

                                    $status = "active";
                                    $img = $downloadURL1;
                                    $filePath = $downloadURL;

                                    $bookData = [
                                        'bookId' => $id,
                                        'Title' => $title,
                                        'Category' => $cat,
                                        'Author' => $author,
                                        'year' => $year,
                                        'status' => $status,
                                        'Image' => $img,
                                        'Link' => $filePath
                                    ];

                                    $bookRef_result = $firestore->collection($ref_table)->add($bookData);
                                    if($bookRef_result)
                                    {
                                        ?>
                                        <script type="text/javascript">
                                            swal({
                                                title: "Book",
                                                text: "Book Added Succesfully!!!",
                                                icon: "success"
                                            }).then(function() {
                                                window.location = "book.php";
                                            });
                                        </script>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <script type="text/javascript">
                                            swal({
                                                title: "Book",
                                                text: "Error: couldn't add the book!!!",
                                                icon: "error"
                                            }).then(function() {
                                                window.location = "book.php";
                                            });
                                        </script>
                                        <?php
                                    }
                                }
                            
                                
                            }
                                
                        }
                        ?>
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
                        td = tr[i].getElementsByTagName("td")[1];
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



