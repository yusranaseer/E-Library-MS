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

$id = $_GET["id"];
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
    grid-template-columns: 1fr 1fr 1fr;
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

            <?php
                $book_table = 'book';
                $getData = $firestore->collection($book_table)->document($id)->snapshot()->data();

                $bid = $getData['bookId'];
            ?>

            <div class="divide-3">
            <div class="add">
                <div class="heading"><h2>Edit & Update Book #<?php echo $bid ?></h2></div><br><hr style="width: 100%;"><br>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="divide-4">
                        <div class="add">

                            <div class="img-box-update">
                                <img src="<?=$getData['Image'];?>" />
                            </div>
                            <br><br>

                            <label>Image &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="file" name="image" id="image">

                            <br><br>
                            <input type="submit" name="update_book_image" value="UPDATE BOOK IMAGE" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">

                        </div>
                        <div class="add" style="padding-bottom:20px; padding-top:23px; ">
                            <label>Title &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?=$getData['Title'];?>" name="title" id="title" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>
                        
                            <label>Category &ensp;&ensp;&ensp;&nbsp;</label>
                            <select name="cat">
                                <option> <?php echo $getData['Category']; ?></option> 
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

                            <label>Author &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="text" value="<?=$getData['Author'];?>" name="author" id="author" style="width: 300px; border-bottom: 2px solid lightgray; border-top: none; border-right: none; border-left: none;">
                            <br><br>
                        
                            <label>Published year &nbsp;&ensp;</label>
                            <input type="text" name="year" id="year" value="<?=$getData['year'];?>" onkeypress="return validation(event)">
                            <br><br>

                            <input type="submit" name="update_book_details" value="UPDATE BOOK DETAILS" class="btn" style="border-color: transparent; margin-top:37px; width: 100%; font-weight: bold; cursor:pointer;">
                        </div>
                        <div class="add">

                            <div class="img-box-update">
                                <a href="<?=$getData['Link'];?>"><img src="img/pdf.png" /></a>
                            </div>
                            <br><br>

                            <label>Book &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</label>
                            <input type="file" name="pdfFile" id="pdfFile">

                            <br><br>
                            <input type="submit" name="update_book" value="UPDATE BOOK" class="btn" style="border-color: transparent; width: 100%; font-weight: bold; cursor:pointer;">
                        </div>
                        </div>
                    </form>
                        <?php
                        if(isset($_POST["update_book_details"]))
                        {

                            $title = $_POST['title'];
                            $cat = $_POST['cat'];
                            $author = $_POST['author'];
                            $year = $_POST['year'];

                            $updateData = [
                                'Title' => $title,
                                'Category' => $cat,
                                'Author' => $author,
                                'year' => $year
                            ];
                            $currentYear = date("Y");
                            $intyear = intval($year);

                            if($title == null || $cat == null || $author == null || $year == null || $intyear > $currentYear)
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid Input!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "edit.php?id=<?php echo $id; ?>";
                                        });
                                    </script>
                                <?php
                            }
                            else
                            {
                                $ref_table = 'book';
                                $bookUpdate_result = $firestore->collection($ref_table)->document($id)->set($updateData, ['merge' => true]);
                                if($bookUpdate_result)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Book Updated Succesfully!!!",
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
                                            text: "Error: couldn't updated the book!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "book.php";
                                        });
                                    </script>
                                    <?php
                                }
                            }
                                
                        }

                        if(isset($_POST["update_book_image"]))
                        {
                            $originalFileName = $_FILES['image']['name'];
                            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                            if($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg')
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid type for Book Image!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "edit.php?id=<?php echo $id; ?>";
                                            });
                                    </script>
                                    <?php
                            }
                            else
                            {
                                $bucket = $storage->bucket($bucketName);
                                //book image
                                $pdfFile1 = $_FILES['image'];

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

                                $updateData1 = [
                                    'Image' => $downloadURL1
                                ];

                                $ref_table1 = 'book';
                                $bookUpdate_result1 = $firestore->collection($ref_table1)->document($id)->set($updateData1, ['merge' => true]);
                                if($bookUpdate_result1)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Book Image Updated Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "edit.php?id=<?php echo $id; ?>";
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
                                            text: "Error: couldn't updated the book image!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "edit.php?id=<?php echo $id; ?>";
                                        });
                                        </script>
                                    <?php
                                }
                            }
                                
                        }

                        if(isset($_POST["update_book"]))
                        {

                            $originalFileName = $_FILES['pdfFile']['name'];
                            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                            if($extension != 'pdf')
                            {
                                ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Invalid type for Book File!!!",
                                            icon: "error"
                                        }).then(function() {
                                                window.location = "edit.php?id=<?php echo $id; ?>";
                                            });
                                    </script>
                                    <?php
                            }
                            else
                            {
                                //book start
                                $bucket = $storage->bucket($bucketName);
                                $pdfFile = $_FILES['pdfFile'];

                                // Generate a unique filename for the PDF file in Cloud Storage
                                $uniqueFileName = uniqid('books/') . $_FILES['pdfFile']['name'];

                                // Upload the PDF file to Cloud Storage
                                $object = $bucket->upload(file_get_contents($pdfFile['tmp_name']), [
                                    'name' => $uniqueFileName,
                                ]);

                                // Get the download URL for the uploaded file
                                $object->reload();
                                $expiration = new \DateTime('3030-12-31T23:59:59');
                                $downloadURL = $object->signedUrl($expiration);
                                //book end
                                
                                $filePath = $downloadURL;

                                $updateData2 = [
                                    'Link' => $filePath
                                ];

                                $ref_table2 = 'book';
                                $bookUpdate_result2 = $firestore->collection($ref_table2)->document($id)->set($updateData2, ['merge' => true]);
                                if($bookUpdate_result2)
                                {
                                    ?>
                                    <script type="text/javascript">
                                        swal({
                                            title: "Book",
                                            text: "Book Updated Succesfully!!!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location = "edit.php?id=<?php echo $id; ?>";
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
                                            text: "Error: couldn't updated the book!!!",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "edit.php?id=<?php echo $id; ?>";
                                        });
                                        </script>
                                    <?php
                                }
                            }  
                        }
                        ?>
            </div>
            
            </div>
        </div>
    </div>
</body>
</html>



