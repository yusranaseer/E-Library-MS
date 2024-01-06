 <?php  
 //pagination.php  
 $connect = mysqli_connect("localhost", "root", "", "test");  
 $record_per_page = 3;  
 $page = '';  
 $output = '';  

 if(isset($_POST["page"]))  
 {  
      $page = $_POST["page"];  
 }  
 else  
 {  
      $page = 1;  
 }  
 


 $start_from = ($page - 1)*$record_per_page;  
 
  $query = "SELECT * FROM tbl_student ORDER BY student_id ASC LIMIT $start_from, $record_per_page";  
   $result = mysqli_query($connect, $query);  
 $output .= "  
      <table class='table table-bordered'>  
           <tr>  
                <th width='50%' style='text-align:center'>Name</th>  
                <th width='50%' style='text-align:center'>Phone</th>  
           </tr>  
 ";  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '  
           <tr>  
                <td style="text-align:center">'.$row["student_name"].'</td>  
                <td style="text-align:center">'.$row["student_phone"].'</td>  
           </tr>  
      ';  
 }  

 $output .= '</table><br /><div align="center">';  
 
// regular, retrive data from database start from 1 with only 5 data using limit
 
 $page_query = "SELECT * FROM tbl_student ORDER BY student_id DESC";  

// all data retrived from table
 $page_result = mysqli_query($connect, $page_query);  
 
// got the total number of records 
 $total_records = mysqli_num_rows($page_result);  
 
 $total_pages = ceil($total_records/$record_per_page);  
 // got the page number by getting all values and divide it by record_per_page
 
 // display the splitted value in span tag using for loop
 for($i=1; $i<=$total_pages; $i++)  
 {  
      $output .= "<span  class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
 }  
 
 $output .= '</div><br /><br />';  
 echo $output;  
 ?>  


