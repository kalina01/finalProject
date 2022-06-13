<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\StudentType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/students')]
class StudentsController extends AbstractController
{
    #[Route('/', name: 'app_students_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('students/index.html.twig', [
            'users' => $userRepository->findByRole('ROLE_STUDENT'),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_students_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(StudentType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_students_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('students/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
