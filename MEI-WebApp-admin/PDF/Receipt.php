<?php

require('fpdf184/fpdf.php');

$pdf = new FPDF();

$pdf->AddPage();

require '../vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

// Initialize Firestore
$firestore = new FirestoreClient([
    'keyFilePath' => '../Keys/mecdb-ba6be-033d6216f407.json',
    'projectId' => 'mecdb-ba6be',
]); 

$tablename = $_GET["name"];
$Ref = $firestore->collection($tablename);
$Snapshot = $Ref->documents();
$total_count = $Snapshot->size();

if($tablename == 'book')
{
	$activeRef = $firestore->collection($tablename)->where('status', '=', 'active');
	$activeSnapshot = $activeRef->documents();
	$active_total_count = $activeSnapshot->size();

	$deactiveRef = $firestore->collection($tablename)->where('status', '=', 'deactive');
	$deactiveSnapshot = $deactiveRef->documents();
	$deactive_total_count = $deactiveSnapshot->size();
}
else
{
	$activeRef = $firestore->collection($tablename)->where('Status', '=', 'active');
	$activeSnapshot = $activeRef->documents();
	$active_total_count = $activeSnapshot->size();

	$deactiveRef = $firestore->collection($tablename)->where('Status', '=', 'deactive');
	$deactiveSnapshot = $deactiveRef->documents();
	$deactive_total_count = $deactiveSnapshot->size();
}

//
$pdf->SetFont('Arial', 'B', 14);

$pdf->Image('../img/MEI_new.png',80,5,50,50);
$pdf->Cell(59	,5,'',0,1);
$pdf->Cell(59	,5,'',0,1);
$pdf->Cell(59	,5,'',0,1);
$pdf->Cell(59	,5,'',0,1);
$pdf->Cell(190	,5,'',0,1);
$pdf->Cell(190	,5,'',0,1);
$pdf->Cell(59	,5,'',0,1);
$pdf->Cell(59	,5,'',0,1);

$pdf->Cell(59	,5,'REPORT NAME : '.$tablename,0,1);
$pdf->Cell(59	,5,'',0,1);

//
$pdf->SetFont('Arial','',10);

if($tablename == 'book')
{
		//$pdf->Cell(110	,5,$rowcus["HomeNo"].', '.$rowcus["street"].', ',0,0);
		$pdf->Cell(40	,5,'Total Books',0,0);
		$pdf->Cell(50	,5,': '.$total_count,0,1);//end of line
	
		//$pdf->Cell(110	,5,$rowcus["city"].', '.$rowcus["country"].', ',0,0);
		$pdf->Cell(40	,5,'Active Books',0,0);
		$pdf->Cell(50	,5,': '.$active_total_count,0,1);//end of line
	
		//$pdf->Cell(110	,5,$rowcus["postalcode"].', ',0,0);
		$pdf->Cell(40	,5,'Deactive Books',0,0);
		$pdf->Cell(50	,5,': '.$deactive_total_count,0,1);//end of line
	
		//$pdf->Cell(110	,5,'0'.$rowcus["contact_number"],0,0);
		//$pdf->Cell(40	,5,'Customer Name',0,0);
		//$pdf->Cell(50	,5,': '.$rowcus["firstName"]." ".$rowcus["lastName"],0,1);//end of line
}
else if($tablename == 'staff')
{
	//$pdf->Cell(110	,5,$rowcus["HomeNo"].', '.$rowcus["street"].', ',0,0);
	$pdf->Cell(40	,5,'Total Staffs',0,0);
	$pdf->Cell(50	,5,': '.$total_count,0,1);//end of line

	//$pdf->Cell(110	,5,$rowcus["city"].', '.$rowcus["country"].', ',0,0);
	$pdf->Cell(40	,5,'Active Staffs',0,0);
	$pdf->Cell(50	,5,': '.$active_total_count,0,1);//end of line

	//$pdf->Cell(110	,5,$rowcus["postalcode"].', ',0,0);
	$pdf->Cell(40	,5,'Deactive Staffs',0,0);
	$pdf->Cell(50	,5,': '.$deactive_total_count,0,1);//end of line

	//$pdf->Cell(110	,5,'0'.$rowcus["contact_number"],0,0);
	//$pdf->Cell(40	,5,'Customer Name',0,0);
	//$pdf->Cell(50	,5,': '.$rowcus["firstName"]." ".$rowcus["lastName"],0,1);//end of line
}
else
{
	//$pdf->Cell(110	,5,$rowcus["HomeNo"].', '.$rowcus["street"].', ',0,0);
	$pdf->Cell(40	,5,'Total Students',0,0);
	$pdf->Cell(50	,5,': '.$total_count,0,1);//end of line

	//$pdf->Cell(110	,5,$rowcus["city"].', '.$rowcus["country"].', ',0,0);
	$pdf->Cell(40	,5,'Active Students',0,0);
	$pdf->Cell(50	,5,': '.$active_total_count,0,1);//end of line

	//$pdf->Cell(110	,5,$rowcus["postalcode"].', ',0,0);
	$pdf->Cell(40	,5,'Deactive Students',0,0);
	$pdf->Cell(50	,5,': '.$deactive_total_count,0,1);//end of line

	//$pdf->Cell(110	,5,'0'.$rowcus["contact_number"],0,0);
	//$pdf->Cell(40	,5,'Customer Name',0,0);
	//$pdf->Cell(50	,5,': '.$rowcus["firstName"]." ".$rowcus["lastName"],0,1);//end of line
}


//

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
/*
//invoice contents
$pdf->SetFont('Arial','B',10);

$pdf->Cell(25	,5,'Product ID',1,0);
$pdf->Cell(79	,5,'Product Name',1,0);
$pdf->Cell(31	,5,'Product Price',1,0,'R');
$pdf->Cell(21	,5,'Quantity',1,0,'R');
$pdf->Cell(33	,5,'Amount',1,1,'R');//end of line

$pdf->SetFont('Arial','',10);

//Numbers are right-aligned so we give 'R' after new line parameter

$rs_order = mysqli_query($link, "select order_id from payment_details where Bill_no = $id");
$rw_order = mysqli_fetch_row($rs_order);
$order = $rw_order[0];

$rsproduct = mysqli_query($link, "select * from tbl_product where product_id in (select product_id from order_product where order_id = $order)");
while($rowproduct = mysqli_fetch_array($rsproduct))
{
	$pdf->Cell(25	,5,$rowproduct["product_id"],1,0);
	$pdf->Cell(79	,5,$rowproduct["product_name"],1,0);
	$pdf->Cell(31	,5,number_format($rowproduct["product_price"]),1,0,'R');
	
	$rs = mysqli_query($link, "select * from order_product where order_id = (select order_id from payment_details where Bill_no = $id) and product_id = $rowproduct[product_id]");
	while($row = mysqli_fetch_array($rs))
	{
		$pdf->Cell(21	,5,$row["qty"],1,0,'R');
		$pdf->Cell(33	,5,number_format($row["total"]),1,1,'R');//end of line
	}
}

$pdf->SetFont('Arial','',10);

$rs_total = mysqli_query($link, "select total from payment_details where Bill_no = $id");
$rw_total = mysqli_fetch_row($rs_total);
$total = $rw_total[0];

$rs_discount = mysqli_query($link, "select discount from payment_details where Bill_no = $id");
$rw_discount = mysqli_fetch_row($rs_discount);
$discount = $rw_discount[0];

$rs_net_total = mysqli_query($link, "select net_total from payment_details where Bill_no = $id");
$rw_net_total = mysqli_fetch_row($rs_net_total);
$net_total = $rw_net_total[0];

$pdf->Cell(130	,5,'',0,1);
$pdf->Cell(130	,5,'',0,1);
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(26	,5,'Subtotal',0,0);
$pdf->Cell(33	,5,number_format($total),0,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(26	,5,'Discount',0,0);
$pdf->Cell(33	,5,number_format($discount),0,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(26	,5,'Total',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(33	,5,number_format($net_total),0,1,'R');//end of line

$pdf->SetLineWidth(1);
  $pdf->Line(10,45,200,45);

$pdf->SetLineWidth(1);
  $pdf->Line(10,95,200,95);

$pdf->SetLineWidth(1);
  $pdf->Line(10,290,200,290);
*/
$pdf->Output();
?>