<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Evenement;

use App\Form\AnnoncesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnoncesRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


#[Route('/annonces')]
class AnnoncesController extends AbstractController
{ 
   
    #[Route("/malek", name: "list")]
    #ParamConverter("annonces", class="App\Entity\Annonces")
    public function getjson(EvenementRepository $repo, SerializerInterface $serializer, NormalizerInterface $normalizer)
    {
        $annonces = $repo->findAll();
        $annoncesNormalises = $normalizer->normalize($annonces, 'json', ['groups' => "Annonces"]);
        $json = $serializer->serialize($annoncesNormalises, 'json');
    
        return new Response($json, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
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

    

    #[Route('/statistique', name: 'stats')]
    public function stat()
        {
    
     $repository = $this->getDoctrine()->getRepository(Annonces::class);
    $annoncess = $repository->findAll();
    $em = $this->getDoctrine()->getManager();
    $data = array();
    $total=0;
    foreach ($annoncess as $annonces) {
        $evenements = $annonces->getEvenements();
        $num_evenements= count($evenements);
       
        $data[] = [$annonces->getNoms(), $num_evenements ];
        $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable(
        array_merge([['Noms', 'Nombre d evenements']], $data)
    );
    $pieChart->getOptions()->setTitle('Statistiques sur les evenements');
    $pieChart->getOptions()->setHeight(1000);
    $pieChart->getOptions()->setWidth(1400);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('green');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(30);
    }
    return $this->render('stats/stat.html.twig', array('piechart' => $pieChart));
}
    
    #[Route('/show_in_map/{ids}', name: 'app_annonces_map', methods: ['GET'])]
    public function Map( Annonces $ids,EntityManagerInterface $entityManager ): Response
    {

        $ids = $entityManager
            ->getRepository(Annonces::class)->findBy( 
                ['ids'=>$ids ]
            );
        return $this->render('annonces/api_arcgis.html.twig', [
            'annonces' => $ids,
        ]);
    }
    

    
    #[Route('/{ids}', name: 'app_annonces_deleteback', methods: ['POST'])]
    public function deleteback(Request $request,  Annonces $annonce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getIds(), $request->request->get('_token'))) {
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonces_back', [], Response::HTTP_SEE_OTHER);
    }
   
    #[Route('/', name: 'app_annonces_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $annonces = $entityManager
            ->getRepository(Annonces::class)
            ->findAll();
            $annonces = $paginator->paginate(
                $annonces, /* query NOT result */
                $request->query->getInt('page', 1),
                6
            );

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
