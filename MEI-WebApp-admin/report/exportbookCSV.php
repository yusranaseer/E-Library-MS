 <?php  
 require '../vendor/autoload.php';
 use Google\Cloud\Firestore\FirestoreClient;
 
 // Initialize Firestore
 $firestore = new FirestoreClient([
     'keyFilePath' => '../Keys/mecdb-ba6be-033d6216f407.json',
     'projectId' => 'mecdb-ba6be',
 ]); 

 if(isset($_POST["export"]))  
 {  
      $link=mysqli_connect("localhost","root","");
      mysqli_select_db($link,"online_shopping");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=books.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('#', 'Id', 'Title', 'Author', 'Category', 'Link', 'Published Year', 'Status', 'Rating'));  

      $ref_table = 'book';
      $fetch_refData =  $firestore->collection($ref_table)->documents();
      $i=1;
      foreach($fetch_refData as $document)  
      {  
          $row = $document->data();

     
          $task_table = 'feedback';
          $fetch_taskData = $firestore->collection($task_table)->orderBy('bookId')->documents();
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
          }
          else
          {
               $rating = $sum/$total_rows;
               $rate = $rating."(".$total_rows.")";
          }


          fputcsv($output, array($i++, $row["bookId"], $row["Title"], $row["Author"], $row["Category"], $row["Link"], $row["year"], $row["status"], $rate ));
      }  
      fclose($output);  
 }  
 ?> 