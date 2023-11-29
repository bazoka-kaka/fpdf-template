<?php

require_once __DIR__ . '/fpdf/fpdf.php';

class PDF extends FPDF
{
  // Load data
  function LoadData($file)
  {
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach ($lines as $line)
      $data[] = explode(';', trim($line));
    return $data;
  }

  // Better table
  function ImprovedTable($header, $data)
  {
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for ($i = 0; $i < count($header); $i++)
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $this->Ln();
    // Data
    foreach ($data as $row) {
      $this->Cell($w[0], 6, $row[0], 'LR');
      $this->Cell($w[1], 6, $row[1], 'LR');
      $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
      $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
      $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

  // Page footer
  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
  }
}

$pdf = new PDF('L');
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
$data = $pdf->LoadData(__DIR__ . '/fpdf/tutorial/countries.txt');
$pdf->AddPage();
// Heading Main Title
$pdf->Image('logo.png', 11, 11, 30);
$pdf->Cell(32);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, 'Training Center');
$pdf->Cell(0, 10, 'STATISTICS REPORT', 0, 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 3, 'Printed in ' . date("Y-m-d") . ' at ' . date("H:i:s") . ' by Yehezkiel Wiradhika');
$pdf->Ln(7);
// Add Filters
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(110, 5, "Department: Management Information System");
$pdf->Cell(0, 5, "Gender: All");
$pdf->Ln(7);
$pdf->Cell(110, 5, "Section: Application");
$pdf->Cell(0, 5, "Grade: IV");
$pdf->Ln(7);
$pdf->Cell(0, 5, "Subsection: Programming");
$pdf->Ln(10);
// Add Table
$pdf->SetFont('Arial', '', 14);
$pdf->ImprovedTable($header, $data);
$pdf->Output();
