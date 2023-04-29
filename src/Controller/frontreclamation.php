<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation2Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/frontreclamation')]
class frontreclamation extends AbstractController
{
    #[Route('/', name: 'app_reclamation_fronts', methods: ['GET', 'POST'])]
    public function front(EntityManagerInterface $entityManager,ReclamationRepository $ReclamationRepository,Request $request,PaginatorInterface $paginator): Response
        {
            $reclamations = $entityManager
                ->getRepository(Reclamation::class)
                ->findAll();
                /////////
    $back = null;
            
    if($request->isMethod('POST')){
        if ( $request->request->get('optionsRadios')){
            $SortKey = $request->request->get('optionsRadios');
            switch ($SortKey){
    
                case 'emailr':
                    $reclamations = $ReclamationRepository->SortByEmailr();
                    break;
    
    
            }
        }
        else
        {
            $type = $request->request->get('optionsearch');
            $value = $request->request->get('Search');
            switch ($type){
                case 'emailr':
                    $reclamations = $ReclamationRepository->findByemailr($value);
                    break;
    
    
            }
        }
    
        if ( $reclamations){
            $back = "success";
        }else{
            $back = "failure";
        }
    
    }

    $reclamations = $paginator->paginate(
            $reclamations, /* query NOT result */
            $request->query->getInt('page', 1),3);
        ////////
    
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
    #[Route('/stats', name: 'app_reclamation_stats', methods: ['GET', 'POST'])]
    public function stats(ReclamationRepository $ReclamationRepository): Response
    {
        $stats = $ReclamationRepository->countBynomr('nomr');

        return $this->render('reclamation/stats.html.twig', [
            'stats' => $stats,
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


