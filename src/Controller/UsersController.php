<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UsersController extends AbstractController
{
    #[Route('/{id}', name: 'app_users_deletteback', methods: ['POST'])]
    public function deletteback(Request $request, Users $user, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('deletteback'.$user->getId(), $request->request->get('_token'))) {
        $entityManager->remove($user);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_users_afficherback', [], Response::HTTP_SEE_OTHER);
}
#[Route('/afficherback/a', name: 'app_users_afficherback', methods: ['GET'])]
public function afficherback(EntityManagerInterface $entityManager): Response
{
    $user = $entityManager
    ->getRepository(users::class)
    ->findAll();
    return $this->render('users/afficherback.html.twig', [
        'users' => $users,
    ]);
}
    #[Route('/', name: 'app_users_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }






    #[Route('/test', name: 'app_test', methods: ['GET'])]
    public function test(UsersRepository $usersRepository): Response
    {
        return $this->render('users/test.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }






    #[Route('/new', name: 'app_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UsersRepository $usersRepository): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->save($user, true);

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->save($user, true);

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
   

}
