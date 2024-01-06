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

$ref_table = 'staff';
$fetch_refData =  $firestore->collection($ref_table)->orderBy('UId')->documents();
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>ADMIN | Staff Report</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:70%;">  
                <h3 align="center">Staffs Data</h3>                 
                <br />  
                <form method="post" action="exportstaffCSV.php" align="center">  
                     <input type="submit" name="export" value="Export as CSV" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="2.5%">#</th>  
                               <th width="12.5%">Name</th> 
                               <th width="27.5%">Address</th> 
                               <th width="27.5%">Email</th>  
                               <th width="7.5%">Contact No</th> 
                               <th width="7.5%">Status</th> 
                               <th width="10%">Username</th>  
                          </tr>  
                     <?php  
                     $i=1;
                     foreach($fetch_refData as $document)  
                     {  
                         $row = $document->data();
                     ?>  
                          <tr>  
                               <td><?php echo $i++; ?></td>  
                               <td><?php echo $row["Name"]; ?></td>  
                               <td><?php echo $row["Address"]; ?></td>  
                               <td><?php echo $row["Email"]; ?></td>  
                               <td><?php echo $row["Contact"]; ?></td> 
                               <td><?php echo $row["Status"]; ?></td> 
                               <td><?php echo $row["username"]; ?></td>  
                          </tr>  
                     <?php       
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  