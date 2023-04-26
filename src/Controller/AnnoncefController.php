<?php

namespace App\Controller;

use App\Entity\Annoncef;
use App\Form\AnnoncefType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnoncefRepository;
use App\Entity\PdfGeneratorService;
use App\Service\SendMail;


#[Route('/annoncef')]
class AnnoncefController extends AbstractController
{   #[Route('/afficherback', name: 'app_annoncef_afficherback', methods: ['GET','POST'])]
    public function afficherback(EntityManagerInterface $entityManager,AnnoncefRepository $AnnoncefRepository,Request $request): Response
    {
        $annoncef = $entityManager
            ->getRepository(Annoncef::class)
            ->findAll();
           
$back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'nomf':
                $annoncef = $AnnoncefRepository->SortByNomf();
                break;

            case 'adresse':
                $annoncef = $AnnoncefRepository->SortByAdresse();
                break;

            case 'emailf':
                $annoncef = $AnnoncefRepository->SortByEmail();
                break;


        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'nomf':
                $annoncef = $AnnoncefRepository->findBynomf($value);
                break;

            case 'adresse':
                $annoncef = $AnnoncefRepository->findByadresse($value);
                break;

            case 'emailf':
                $annoncef = $AnnoncefRepository->findByemail($value);
                break;


        }
    }

    if ( $annoncef){
        $back = "success";
    }else{
        $back = "failure";
    }
}
        return $this->render('annoncef/afficherback.html.twig', [
            'annoncef' => $annoncef,
        ]);
    }
    #[Route('/{idf}', name: 'app_annoncef_deleteback', methods: ['POST'])]
    public function deleteback(Request $request, Annoncef $annoncef, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncef->getIdf(), $request->request->get('_token'))) {
            $entityManager->remove($annoncef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annoncef_afficherback', [], Response::HTTP_SEE_OTHER);
    }
    
    
    #[Route('/', name: 'app_annoncef_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $annoncef = $entityManager
            ->getRepository(Annoncef::class)
            ->findAll();

        return $this->render('annoncef/index.html.twig', [
            'annoncef' => $annoncef,
        ]);
    }
    #[Route('/{idf}', name: 'app_annoncef_delete', methods: ['POST'])]
    public function delete(Request $request, Annoncef $annoncef, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncef->getIdf(), $request->request->get('_token'))) {
            $entityManager->remove($annoncef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annoncef_index', [], Response::HTTP_SEE_OTHER);
    }
    

    #[Route('/new/na', name: 'app_annoncef_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , AnnoncefRepository $annoncefRepository): Response
    {
        $annoncef = new Annoncef();
        $form = $this->createForm(AnnoncefType::class, $annoncef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annoncef);
            //$annoncefRepository->sms();
            $entityManager->flush();
            $email = $annoncef->getEmailf();
            $mailer = new SendMail();
            $mailer->sendEmail($email, "Only work", "merci pour nous faire confiance ! votre annonce est ajouté avec succés");
            return $this->redirectToRoute('app_annoncef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoncef/new.html.twig', [
            'annoncef' => $annoncef,
            'form' => $form,
        ]);
    }

    #[Route('/{idf}', name: 'app_annoncef_show', methods: ['GET'])]
    public function show(Annoncef $annoncef): Response
    {
        return $this->render('annoncef/show.html.twig', [
            'annoncef' => $annoncef,
        ]);
    }

    #[Route('/{idf}/edit', name: 'app_annoncef_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annoncef $annoncef, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnoncefType::class, $annoncef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annoncef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoncef/edit.html.twig', [
            'annoncef' => $annoncef,
            'form' => $form,
        ]);
    }
#[Route('/pdf/annoncef', name: 'generator_service')]
    public function pdfService(): Response
    { 
        $annoncef= $this->getDoctrine()
        ->getRepository(Annoncef::class)
        ->findAll();

   

        $html =$this->renderView('pdf.html.twig', ['annoncef' => $annoncef]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }


}
