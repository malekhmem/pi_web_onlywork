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
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function index(Request $request,EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $annoncef = $entityManager
            ->getRepository(Annoncef::class)
            ->findAll();
            if (count($annoncef)){
                $back = "success";
            }else{
                $back = "failure";
            }
            $annoncef = $paginator->paginate(
                $annoncef, /* query NOT result */
                $request->query->getInt('page', 1),
                3);


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
    
    #[Route('/pdf/{idf}', name: 'generator_service', methods:['GET'])]
    public function generatePdf(annoncef $annoncef)
{
    // Créer une instance de Dompdf
    $dompdf = new Dompdf();
    
    // Récupérer la vue Twig pour le produit
    $html = $this->renderView('pdf.html.twig', [
        'annoncef' => $annoncef
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
#[Route('/search/', name: 'app_annoncef_search', methods: ['GET', 'POST'])]
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $searchTerm = $request->request->get('search');
        $qb = $em->createQueryBuilder();
        $qb->select('e')
            ->from(Annoncef::class, 'e')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('e.emailf', ':searchTerm'),
                    $qb->expr()->like('e.nomf', ':searchTerm'),
                    $qb->expr()->like('e.adresse', ':searchTerm'),
                    // $qb->expr()->like('e.attribute2', ':searchTerm'),
                    // add more attributes as needed
                )
            )
            ->setParameter('searchTerm', '%' . $searchTerm . '%');

        $results = $qb->getQuery()->getResult();
        $html = $this->renderView('tableAnnoncef.html.twig', [
            'annoncef' => $results,
        ]);

        return new JsonResponse(['html' => $html]);
    }

}
