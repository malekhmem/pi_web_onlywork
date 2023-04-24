<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;

#[Route('/categorie')]
class CategorieController extends AbstractController
{
 
    #[Route('/{idc}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdc(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }


    
   
    #[Route('/new/o', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{idc}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{idc}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    
    #[Route('/', name: 'app_categorie_index', methods: ['GET', 'POST'])]
    public function index(EntityManagerInterface $entityManager,CategorieRepository $CategorieRepository,Request $request): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();
            /////////
$back = null;
        
if($request->isMethod("POST")){
    if ( $request->request->get('optionsRadios')){
        $SortKey = $request->request->get('optionsRadios');
        switch ($SortKey){
            case 'nomc':
                $categories = $CategorieRepository->SortByNomc();
                break;



        }
    }
    else
    {
        $type = $request->request->get('optionsearch');
        $value = $request->request->get('Search');
        switch ($type){
            case 'nomc':
                $categories = $CategorieRepository->findBynomc($value);
                break;


        }
    }

    if ( $categories){
        $back = "success";
    }else{
        $back = "failure";
    }
}
    ////////
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
  
    // #[Route('/afficherback', name: 'app_categorie_afficherback', methods: ['GET', 'POST'])]
    // public function afficherback(EntityManagerInterface $entityManager,CategorieRepository $CategorieRepository,Request $request): Response
    // {
    //     $categories = $entityManager
    //         ->getRepository(Categorie::class)
    //         ->findAll();
    //     return $this->render('categorie/index.html.twig', [
    //         'categories' => $categories,
    //     ]);
    // }
   
 
}
