<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeController extends AbstractController
{
    #[Route(['/home', '/'], name: 'app_home')]
    public function index(PictureRepository $pictureRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'pictures' => $pictureRepository->findBy(array(), orderBy: ['id' => 'DESC']),
        ]);
    }

    #[Route('/pictures/new', methods: ['GET', 'POST'])]
    public function new(Request $request, PictureRepository $pictureRepository,
                        SluggerInterface $slugger): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                $file->move(
                    'pictures',
                    $newFilename
                );
                $picture->setName($newFilename);
                $pictureRepository->add($picture, true);
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('home/new.html.twig', [
            'form' => $form,
        ]);
    }
}
