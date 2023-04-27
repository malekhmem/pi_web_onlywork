<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\MaterielRepository;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use MercurySeries\FlashyBundle\FlashyNotifier;


#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/afficherback', name: 'app_materiel_afficherback', methods: ['GET','POST'])]
    public function afficherback(EntityManagerInterface $entityManager,MaterielRepository $MaterielRepository,Request $request): Response
    {
        $materiel = $entityManager
            ->getRepository(Materiel::class)
            ->findAll();
            $back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'nomm':
                $materiel = $MaterielRepository->SortByNomm();
                break;

            case 'marque':
                $materiel = $MaterielRepository->SortByMarque();
                break;

            case 'prix':
                $materiel = $MaterielRepository->SortByPrix();
                break;


        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'nomm':
                $materiel = $MaterielRepository->findBynomm($value);
                break;

            case 'marque':
                $materiel = $MaterielRepository->findBymarque($value);
                break;

            case 'prix':
                $materiel = $MaterielRepository->findByprix($value);
                break;


        }
    }

    if ( $materiel){
        $back = "success";
    }else{
        $back = "failure";
    }
}
        return $this->render('materiel/afficherback.html.twig', [
            'materiel' => $materiel,
        ]);
    }
    #[Route('/{idm}', name: 'app_materiel_deleteback', methods: ['POST'])]
    public function deleteback(Request $request, Materiel $materiel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiel->getIdm(), $request->request->get('_token'))) {
            $entityManager->remove($materiel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_materiel_afficherback', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/', name: 'app_materiel_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $materiel = $entityManager
            ->getRepository(Materiel::class)
            ->findAll();

        return $this->render('materiel/index.html.twig', [
            'materiel' => $materiel,
        ]);
    }
    #[Route('/{idm}', name: 'app_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiel->getIdm(), $request->request->get('_token'))) {
            $entityManager->remove($materiel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
    }
   
    #[Route('/new/n', name: 'app_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $materiel->setImage($newFilename);
            }
            $entityManager->persist($materiel);
            $entityManager->flush();
            $this->addFlash(
                'info',
                'Materiel successfully added !');
            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        
        return $this->renderForm('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{idm}', name: 'app_materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel): Response
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    #[Route('/{idm}/edit', name: 'app_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiel $materiel, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $materiel->setImage($newFilename); 
         } $entityManager->flush();

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }



}
