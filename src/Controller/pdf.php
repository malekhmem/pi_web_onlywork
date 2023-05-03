<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reclamation;
use App\Form\Reclamation2Type;

// ...

class pdf extends AbstractController
{
    public function pdfAction(): Response
    {
        // Get the data from your database
        $data = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Render the Twig template as HTML, passing the data to the template
        $html = $this->renderView('reclamation/pdf.html.twig', [
            'data' => $data,
        ]);

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Return the generated PDF as a response
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }
}
