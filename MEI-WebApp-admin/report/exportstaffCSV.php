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
      header('Content-Disposition: attachment; filename=staffs.csv');  

      $output = fopen("php://output", "w");  
      fputcsv($output, array('#', 'Id', 'Name', 'Address', 'Email', 'Contact No', 'Status', 'Username'));  

      $ref_table = 'staff';
      $fetch_refData =  $firestore->collection($ref_table)->orderBy('UId')->documents();
      $i=1;
      foreach($fetch_refData as $document)  
      {  
          $row = $document->data();
          fputcsv($output, array($i++, $row["UId"], $row["Name"], $row["Address"], $row["Email"], $row["Contact"], $row["Status"], $row["username"]));
      } 
      fclose($output);  
 }  
 ?> 