<?php

namespace App\Controller;

use App\Entity\Annoncef;
use App\Form\AnnoncefType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annoncef')]
class AnnoncefController extends AbstractController
{
    #[Route('/', name: 'app_annoncef_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $annoncefs = $entityManager
            ->getRepository(Annoncef::class)
            ->findAll();

        return $this->render('annoncef/index.html.twig', [
            'annoncefs' => $annoncefs,
        ]);
    }
    #[Route('/afficherback', name: 'app_annoncef_afficherback', methods: ['GET'])]
    public function afficherback(EntityManagerInterface $entityManager): Response
    {
        $annoncefs = $entityManager
            ->getRepository(Annoncef::class)
            ->findAll();
        return $this->render('annoncef/afficherback.html.twig', [
            'annoncefs' => $annoncefs,
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
    #[Route('/new', name: 'app_annoncef_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annoncef = new Annoncef();
        $form = $this->createForm(AnnoncefType::class, $annoncef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annoncef);
            $entityManager->flush();

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

    #[Route('/{idf}', name: 'app_annoncef_delete', methods: ['POST'])]
    public function delete(Request $request, Annoncef $annoncef, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncef->getIdf(), $request->request->get('_token'))) {
            $entityManager->remove($annoncef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annoncef_index', [], Response::HTTP_SEE_OTHER);
    }

}
