<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnoncesRepository;

#[Route('/annonces')]
class AnnoncesController extends AbstractController
{
    #[Route('/afficherback', name: 'app_annonces_back', methods: ['GET','POST'])]
    public function backafficher(EntityManagerInterface $entityManager,AnnoncesRepository $AnnoncesRepository,Request $request): Response
    {
        $annonces = $entityManager
            ->getRepository(Annonces::class)
            ->findAll();
/////////
$back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'noms':
                $annonces = $AnnoncesRepository->SortByNoms();
                break;

            case 'adresses':
                $annonces = $AnnoncesRepository->SortByAdresse();
                break;

            case 'emails':
                $annonces = $AnnoncesRepository->SortByEmail();
                break;


        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'noms':
                $annonces = $AnnoncesRepository->findBynoms($value);
                break;

            case 'adresses':
                $annonces = $AnnoncesRepository->findByadresse($value);
                break;

            case 'emails':
                $annonces = $AnnoncesRepository->findByemail($value);
                break;


        }
    }

    if ( $annonces){
        $back = "success";
    }else{
        $back = "failure";
    }
}
    ////////
        return $this->render('annonces/afficherback.html.twig', [
            'annonces' => $annonces,
        ]);
    }
    #[Route('/', name: 'app_annonces_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $annonces = $entityManager
            ->getRepository(Annonces::class)
            ->findAll();

        return $this->render('annonces/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
   
   

    #[Route('/new', name: 'app_annonces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonces/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }
    #[Route('/{ids}', name: 'app_annonces_deleteback', methods: ['POST'])]
    public function deleteback(Request $request, Annonces $annonce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('deleteback'.$annonce->getIds(), $request->request->get('_token'))) {
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonces_back', [], Response::HTTP_SEE_OTHER);
    }
    

    #[Route('/{ids}', name: 'app_annonces_show', methods: ['GET'])]
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{ids}/edit', name: 'app_annonces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonces $annonce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonces/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{ids}', name: 'app_annonces_delete', methods: ['POST'])]
    public function delete(Request $request, Annonces $annonce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getIds(), $request->request->get('_token'))) {
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
