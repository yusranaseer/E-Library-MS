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

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=students.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('#', 'Id', 'First Name', 'Last Name', 'Contact No', 'Email', 'Address', 'Gender', 'Grade', 'Status', 'Username'));  

      $ref_table = 'student';
      $fetch_refData =  $firestore->collection($ref_table)->orderBy('UID')->documents();
      $i=1;
      foreach($fetch_refData as $document)  
      {  
          $row = $document->data();
          fputcsv($output, array($i++, $row["UID"], $row["First_Name"], $row["Last_Name"], $row["Contact"], $row["Email"], $row["Address"], $row["Gender"], $row["Grade"], $row["Status"], $row["username"]));
      }  
      fclose($output);  
 }  
 ?> 