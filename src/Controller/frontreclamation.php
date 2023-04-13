<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation2Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frontreclamation')]
class frontreclamation extends AbstractController
{
    #[Route('/', name: 'app_reclamation_fronts', methods: ['GET'])]
    public function fronts(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/fronts.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/news', name: 'app_reclamation_news', methods: ['GET', 'POST'])]
    public function news(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_fronts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/news.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idr}', name: 'app_reclamation_shows', methods: ['GET'])]
    public function shows(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/shows.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idr}/edits', name: 'app_reclamation_edits', methods: ['GET', 'POST'])]
    public function edits(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_fronts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edits.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idr}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdr(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_fronts', [], Response::HTTP_SEE_OTHER);
    }
}
