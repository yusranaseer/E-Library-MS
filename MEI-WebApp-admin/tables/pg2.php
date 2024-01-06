<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$output = "";
// retrive the value from ajax
 



if(isset($_POST['page'])){
		$data = $_POST['page'];
}else{
	$data = 1;
}

// not every time 1, passed parameter is retrived in data variable



// record per page is required because, get the pagination value 
//spiltted by dividing the record per page with total number of records
// and also limit the query, to display only one value

$record_per_page = 5;
$start_from = ($data-1)*$record_per_page;
 

$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT * FROM tbl_student ORDER BY student_id ASC LIMIT $start_from, $record_per_page";
$result = mysqli_query($conn, $sql);
$output .= "<table border='1' class='table table-bordered'><tr style='text-align:center'><th>Name</th><th>Phone</th></tr>";
 
 while($row = mysqli_fetch_assoc($result)) {
        $output .=  "<tr ><td style='text-align:center'>" . $row["student_name"]. "</td><td style='text-align:center'>  " . $row["student_phone"]. "</td></tr>";
 }
   $output.="</table><div align='center'>";


/* get all values from table */

$sql = "SELECT * FROM tbl_student";
$results = mysqli_query($conn, $sql);
$total_number_of_records =  mysqli_num_rows($results);

/* split the table into pages by having only 4 records per page */

$total_pages = CEIL($total_number_of_records /$record_per_page);
/* got the number of pages */

/* now increment the number start from one to total number of pages using for loop */
for($i = 1; $i<=$total_pages; $i++){
	$output.= "<span style='margin:0px 2px;padding:15px;background:black;color:white;cursor:pointer' class='pagination_value' id='".$i."'>".$i."</span>";
}

$output.="</div>";
echo $output;


















mysqli_close($conn);
?>
