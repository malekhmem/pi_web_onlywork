<?php
// src/Service/PdfGeneratorService.php
namespace App\Entity;

use TCPDF;

class PdfGeneratorService
{
    public function generatePdf($html)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
      
$image_file = 'public/assettB/img/logo.png';
$pdf->Image($image_file, 10, 10, '', '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf->Output('document.pdf', 'S');
    }
}

