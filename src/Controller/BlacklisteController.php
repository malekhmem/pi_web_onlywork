<?php

namespace App\Controller;

use App\Entity\Blacklist;
use App\Form\BlacklistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlacklisteRepository;
use Knp\Component\Pager\PaginatorInterface;



#[Route('/blackliste')]
class BlacklisteController extends AbstractController
{
    #[Route('/', name: 'app_blackliste_index', methods: ['GET', 'POST'])]
    public function index(EntityManagerInterface $entityManager,BlacklisteRepository $BlacklisteRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $blacklists = $entityManager
            ->getRepository(Blacklist::class)
            ->findAll();

        $back = null;
                
        if($request->isMethod('POST')){
            if ( $request->request->get('optionsRadios')){
                $SortKey = $request->request->get('optionsRadios');
                switch ($SortKey){
                    case 'descb':
                        $blacklists = $BlacklisteRepository->SortBydescb();
                        break;
        
        
                }
            }
            else
            {
                $type = $request->request->get('optionsearch');
                $value = $request->request->get('Search');
                switch ($type){
                    case 'descb':
                        $blacklists = $BlacklisteRepository->findBydescb($value);
                        break;
        
        
                }
            }
        
            if ( $blacklists){
                $back = "success";
            }else{
                $back = "failure";
            }
        }
            ////////
            $blacklists = $paginator->paginate(
                $blacklists,
                $request->query->getInt('page', 1),
                3
            );
        return $this->render('blackliste/index.html.twig', [
            'blacklists' => $blacklists,
        ]);
    }

    #[Route('/new', name: 'app_blackliste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blacklist = new Blacklist();
        $form = $this->createForm(BlacklistType::class, $blacklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blacklist);
            $entityManager->flush();

            return $this->redirectToRoute('app_blackliste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blackliste/new.html.twig', [
            'blacklist' => $blacklist,
            'form' => $form,
        ]);
    }

    #[Route('/{idb}', name: 'app_blackliste_show', methods: ['GET'])]
    public function show(Blacklist $blacklist): Response
    {
        return $this->render('blackliste/show.html.twig', [
            'blacklist' => $blacklist,
        ]);
    }

    #[Route('/{idb}/edit', name: 'app_blackliste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blacklist $blacklist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlacklistType::class, $blacklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blackliste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blackliste/edit.html.twig', [
            'blacklist' => $blacklist,
            'form' => $form,
        ]);
    }

    #[Route('/{idb}', name: 'app_blackliste_delete', methods: ['POST'])]
    public function delete(Request $request, Blacklist $blacklist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blacklist->getIdb(), $request->request->get('_token'))) {
            $entityManager->remove($blacklist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blackliste_index', [], Response::HTTP_SEE_OTHER);
    }
}
