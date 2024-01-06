<?php

require('fpdf184/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {

        $imagePath = '../img/certificate/bg.png'; 
        $this->Image($imagePath, 0, 0, 210, 297);
    }

    function Footer()
    {

    }
}

// Create a new PDF instance
$pdf = new PDF();
$pdf->AddPage();

// Add title
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 120, 'Certificate of Achievement', 0, 1, 'C');
$pdf->SetY($pdf->GetY() - 45);
// Add recipient's name and other information
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0, 20, 'This is to certify that', 0, 1, 'C');
$pdf->Cell(0, 20, 'Aththas Rizwan', 0, 1, 'C');
$pdf->Cell(0, 20, 'has successfully completed', 0, 1, 'C');
$pdf->Cell(0, 20, '1st Level of Reading', 0, 1, 'C');
$pdf->Cell(0, 20, 'on July 27, 2023', 0, 1, 'C');

// Save or output the PDF
//$pdf->Output('certificate.pdf', 'D');
$pdf->Output();
?>

