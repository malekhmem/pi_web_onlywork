<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use App\Entity\PdfGeneratorService;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/afficherback', name: 'app_evenement_afficherback', methods: ['GET','POST'])]
    public function afficherback(EntityManagerInterface $entityManager ,EvenementRepository $EvenementRepository,Request $request): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
/////////
$back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'nomss':
                $evenements = $EvenementRepository->SortByNomss();
                break;

            case 'titre':
                $evenements = $EvenementRepository->SortByTitre();
                break;

            case 'description':
                $evenements = $EvenementRepository->SortByDescription();
                break;


        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'nomss':
                $evenements = $EvenementRepository->findBynomss($value);
                break;

            case 'titre':
                $evenements = $EvenementRepository->findBytitre($value);
                break;

            case 'desription':
                $evenements = $EvenementRepository->findBydescription($value);
                break;


        }
    }

    if ( $evenements){
        $back = "success";
    }else{
        $back = "failure";
    }
}
    ////////
        return $this->render('evenement/afficherback.html.twig', [
            'evenements' => $evenements,
        ]);
    }
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,NotifierInterface $notifier): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $file = $evenement->getImagee();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImagee($filename);

            
            $entityManager->persist($evenement);
            $titre = $form->get('titre')->getData();
            $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findBy(['titre'=>$titre]);
            if (empty($evenements)) 
           {
            $entityManager->flush();
            $notifier->send(new Notification('Evenemet ajouté avec succées  ', ['browser']));
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $notifier->send(new Notification('Evenemet exist deja  ', ['browser']));
            return $this->redirectToRoute('app_evenement_new', [], Response::HTTP_SEE_OTHER);

        }
    }
        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{ide}', name: 'app_evenement_deletteback', methods: ['POST'])]
    public function deletteback(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('deletteback'.$evenement->getIde(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_afficherback', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

   

    #[Route('/{ide}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{ide}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $evenement->getImagee();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImagee($filename);

            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{ide}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIde(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pdf/evenement', name: 'generator_service')]
    public function pdfEvenement(): Response
    { 
        $evenement= $this->getDoctrine()
        ->getRepository(Evenement::class)
        ->findAll();

   

        $html =$this->renderView('pdf/index.html.twig', ['evenement' => $evenement]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }
    
}
