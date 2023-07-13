<?php

namespace kingstonenterprises\app\models;

use kingstonenterprises\app\fpdf\FPDF;

/**
 * PDF CLass
 */
class Pdf extends FPDF {
  
    // Page header
    function Header() {
          
        // Add logo to page
        $this->Image(__DIR__ . '/../../public/img/uneswa-logo.png',10,8,33);
          
        // Set font family to Arial bold 
        $this->SetFont('Helvetica','B',8);
          
        // Move to the right
        $this->Cell(80);
          
        // Header
        $this->Cell(100,10,'School Transcripts System',1,0,'C');
          
        // Line break
        $this->Ln(20);
    }
  
    // Page footer
    function Footer() {
          
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
          
        // Arial italic 8
        $this->SetFont('Arial','I',8);
          
        // Page number
        $this->Cell(0,10,'Page ' . 
            $this->PageNo() . '/{nb}',0,0,'C');
    }
}

  
?>