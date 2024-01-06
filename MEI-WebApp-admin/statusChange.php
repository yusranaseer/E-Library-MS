<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/sweetalert.min.js"></script>
</head>
<body>

<?php
include("dbcon.php");   
$id = $_GET["id"];
$name = $_GET["name"];
if($name == "book")
{
	$book_table = 'book';
    $getData = $firestore->collection($book_table)->document($id)->snapshot()->data();

    $bid = $getData['bookId'];
    $currentStatus = $getData['status'];
    $newStatus = ($currentStatus === 'active') ? 'deactive' : 'active';

    $updateData = [
        'status' => $newStatus
    ];

    $firestore->collection($book_table)->document($id)->set($updateData, ['merge' => true]);


	?>
	<script type="text/javascript">
    swal({
        title: "Book",
        text: "Book #<?php echo $bid; ?> status updated successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "book.php";
    });
	</script>
	<?php
}
else if($name == "student")
{
	$student_table = 'student';
    $getData = $firestore->collection($student_table)->document($id)->snapshot()->data();

    $sid = $getData['UID'];
    $currentStatus = $getData['Status'];
    $newStatus = ($currentStatus === 'active') ? 'deactive' : 'active';

    $updateData = [
        'Status' => $newStatus
    ];

    $firestore->collection($student_table)->document($id)->set($updateData, ['merge' => true]);


	?>
	<script type="text/javascript">
    swal({
        title: "Student",
        text: "Student #<?php echo $sid; ?> status updated successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "student.php";
    });
	</script>
	<?php
}
else if($name == "staff")
{
    $staff_table = 'staff';
    $getData = $firestore->collection($staff_table)->document($id)->snapshot()->data();

    $sid = $getData['UId'];
    $currentStatus = $getData['Status'];
    $newStatus = ($currentStatus === 'active') ? 'deactive' : 'active';

    $updateData = [
        'Status' => $newStatus
    ];

    $firestore->collection($staff_table)->document($id)->set($updateData, ['merge' => true]);


	?>
	<script type="text/javascript">
    swal({
        title: "Staff",
        text: "Staff #<?php echo $sid; ?> status updated successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "staff.php";
    });
	</script>
	<?php
}
else if($name == "innoAccept")
{
    $inno_table = 'innovation';
    $getData = $firestore->collection($inno_table)->document($id)->snapshot()->data();

    $iid = $getData['innoId'];
    $sid = $getData['StudentId'];
    $newStatus = 'accepted';

    $updateData = [
        'status' => $newStatus
    ];

    $firestore->collection($inno_table)->document($id)->set($updateData, ['merge' => true]);
 
    $student_table = 'student';
    $email = '';
    $querySnapshot = $firestore->collection($student_table)->where('UID', '=', $sid)->documents();
    foreach ($querySnapshot as $document) {
        $row = $document->data();
        $docId = $document->id();

        $coins = $row['coins'] + 50;
        $email = $row['Email'];

        $updateCoins = [
            'coins' => $coins
        ];

        $firestore->collection($student_table)->document($docId)->set($updateCoins, ['merge' => true]);
    }

	?>
	<script type="text/javascript">
    swal({
        title: "Pending Innovations",
        text: "Innovation #<?php echo $iid; ?> Accepted successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "sendInnoMail.php?email=<?php echo $email; ?>";
    });
	</script>
	<?php
}
else if($name == "innoReject")
{
    $inno_table = 'innovation';
    $getData = $firestore->collection($inno_table)->document($id)->snapshot()->data();

    $iid = $getData['innoId'];
    $newStatus = 'rejected';

    $updateData = [
        'status' => $newStatus
    ];

    $firestore->collection($inno_table)->document($id)->set($updateData, ['merge' => true]);


	?>
	<script type="text/javascript">
    swal({
        title: "Pending Innovations",
        text: "Innovation #<?php echo $iid; ?> Rejected successfully!!!",
        icon: "success"
    }).then(function() {
        window.location = "pendingInno.php";
    });
	</script>
	<?php
}
?>
</body>
</html>