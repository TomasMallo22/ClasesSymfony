<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(PostRepository $repoPost): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'post' => $repoPost->findHomeRandom()
        ]);
    }

    #[Route('/about', name: 'about_page')]
    public function showAbout(): Response
    {
        return $this->render('home_page/about.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}
