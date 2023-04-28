<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PosteRepository;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use App\Entity\PdfGeneratorService;
use App\Service\SendMail;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/poste')]
class PosteController extends AbstractController
{
    #[Route('/statscategorie', name: 'stats_categorie', methods: ['GET', 'POST'])]
public function statsCategorie(PosteRepository $posteRepository): Response
{
    $stats = $posteRepository->countByCategorie();
    
    return $this->render('stats_categorie.html.twig', [
        'stats' => $stats
    ]);
}

  
    #[Route('/afficherback', name: 'app_poste_afficherback', methods: ['GET','POST'])]
    public function afficherback(EntityManagerInterface $entityManager,PosteRepository $PosteRepository,Request $request): Response
    {
        $postes = $entityManager
            ->getRepository(Poste::class)
            ->findAll();
            /////////
$back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'nomp':
                $postes = $PosteRepository->SortByNomp();
                break;

            case 'domaine':
                $postes = $PosteRepository->SortByDomaine();
                break;

            case 'emailp':
                $postes = $PosteRepository->SortByEmail();
                break;


        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'nomp':
                $postes = $PosteRepository->findBynomp($value);
                break;

            case 'domaine':
                $postes = $PosteRepository->findByDomaine($value);
                break;

            case 'emailp':
                $postes = $PosteRepository->findByemail($value);
                break;


        }
    }

    if ( $postes){
        $back = "success";
    }else{
        $back = "failure";
    }
}
    ////////

        return $this->render('poste/afficherback.html.twig', [
            'postes' => $postes,
        ]);
    }
   
    #[Route('/{idp}/d', name: 'app_poste_deleteback', methods: ['POST'])]
    public function deleteback(Request $request, Poste $poste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('deleteback'.$poste->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($poste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_poste_afficherback', [], Response::HTTP_SEE_OTHER);
    }

   
    #[Route('/', name: 'app_poste_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,PaginatorInterface $paginator,Request $request): Response
    {
        $postes = $entityManager
            ->getRepository(Poste::class)
            ->findAll();
            if (count($postes)){
                $back = "success";
            }else{
                $back = "failure";
            }
            $postes = $paginator->paginate(
                $postes, /* query NOT result */
                $request->query->getInt('page', 1),
                3);
        return $this->render('poste/index.html.twig', [
            'postes' => $postes,
        ]);
    }

    #[Route('/{idp}', name: 'app_poste_delete', methods: ['POST'])]
    public function delete(Request $request, Poste $poste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($poste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
    }
   
   
    #[Route('/new/a', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($poste);
            $entityManager->flush();
            $entityManager->flush();
            $this->addFlash(
                'info',
                'Post successfully added !'
            );
            $email = $poste->getEmailp();
            $mailer = new SendMail();
            $mailer->sendEmail($email, "poste ajoutée avec succées !", "prière de rester joignable"); 
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
        
    }

    #[Route('/{idp}', name: 'app_poste_show', methods: ['GET'])]
    public function show(Poste $poste): Response
    {
        return $this->render('poste/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    #[Route('/{idp}/edit', name: 'app_poste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Poste $poste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('poste/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }
    #[Route('/qr/{idp}', name: 'app_poste_qr')]
    public function qr($idp,PosteRepository $rep)
    {
        $dd=$rep->find($idp);
        if (!$dd) {
            throw $this->createNotFoundException('poste not found');
        }
        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data("email :".$dd->getEmailp())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->labelText("")
            ->labelAlignment(new LabelAlignmentCenter())
            ->labelMargin(new Margin(15, 5, 5, 5))
            ->build();
        
        $namePng = uniqid('', true) . '.png';
        $result->saveToFile($this->getParameter('images_directory').$namePng);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$namePng.'"');
        $response->setContent (file_get_contents($this->getParameter('images_directory').$namePng));
        return $response;
    }

   /* #[Route('/pdf/poste', name: 'generator_service')]
    public function pdfService(): Response
    { 
        $poste= $this->getDoctrine()
        ->getRepository(Poste::class)
        ->findAll();

   

        $html =$this->renderView('pdf.html.twig', ['poste' => $poste]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }*/
    #[Route('/pdf/{idp}', name: 'generator_service', methods:['GET'])]
    public function generatePdf(Poste $poste)
{
    // Créer une instance de Dompdf
    $dompdf = new Dompdf();
    
    // Récupérer la vue Twig pour le produit
    $html = $this->renderView('pdf.html.twig', [
        'poste' => $poste
    ]);

    // Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Rendre le document PDF
    $dompdf->render();

    // Retourner le document PDF comme réponse
    $response = new Response();
    $response->headers->set('Content-Type', 'application/pdf');
    $response->setContent($dompdf->output());
    

    return $response;
}
    
}
