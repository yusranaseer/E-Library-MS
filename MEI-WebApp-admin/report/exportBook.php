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

require '../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

// Initialize Firestore
$firestore = new FirestoreClient([
    'keyFilePath' => '../Keys/mecdb-ba6be-033d6216f407.json',
    'projectId' => 'mecdb-ba6be',
]); 

$ref_table = 'book';
$fetch_refData =  $firestore->collection($ref_table)->orderBy('bookId')->documents();
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>ADMIN | Book Report</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:100%;">  
                <h3 align="center">Book Data</h3>                 
                <br />  
                <form method="post" action="exportbookCSV.php" align="center">  
                     <input type="submit" name="export" value="Export as CSV" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">#</th>  
                               <th width="20%">Name</th>  
                               <th width="10%">Author</th>  
                               <th width="5%">Category</th>  
                               <th width="30%">Link</th>  
                               <th width="10%">Published Year</th> 
                               <th width="10%">Status</th>
                               <th width="5%">Rating</th>
                               <th width="5%">Image</th>
                          </tr>  
                     <?php  
                     $i=1;
                     foreach($fetch_refData as $document)  
                     {  
                         $row = $document->data(); 
                     ?>  
                          <tr>  
                               <td><?php echo $i++; ?></td>  
                               <td><?php echo $row["Title"]; ?></td>  
                               <td><?php echo $row["Author"]; ?></td>  
                               <td><?php echo $row["Category"]; ?></td>                                 
                               <td><?php echo $row["Link"]; ?></td> 
                               <td><?php echo $row["year"]; ?></td> 
                               <td><?php echo $row["status"]; ?></td> 
                               <?php
                                   $task_table = 'feedback';
                                    $fetch_taskData = $firestore->collection($task_table)->documents();
                                    $total_rows = 0; $sum = 0;
                                    foreach($fetch_taskData as $key1)
                                    {
                                        $rw = $key1->data();
                                        if($row['bookId'] == $rw['bookId'])
                                        {
                                            $total_rows++;
                                            $sum = $sum+$rw['rating'];
                                        }
                                    }  
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
                               ?>
                               <td><div class="img-box-small"><a href="../<?php echo $row["Image"]; ?>"><img width="70px" height="50px" src="../<?php echo $row["Image"]; ?>" /></a></div></td>  
                          </tr>  
                     <?php       
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  